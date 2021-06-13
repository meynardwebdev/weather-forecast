<?php

namespace App\Controller;

use App\Api\OpenWeatherMap;
use App\Api\WorldWeatherOnline;
use App\Entity\WeatherForecast;
use App\Form\WeatherForecastType;
use App\Repository\CountryRepository;
use App\Repository\WeatherForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherForecastController extends AbstractController
{
    /** @var AdapterInterface */
    private $cache;

    /** @var CountryRepository */
    private $countryRepository;

    /** @var WeatherForecastRepository */
    private $weatherForecastRepository;

    /**
     * WeatherForecastController constructor.
     * @param WeatherForecastRepository $weatherForecastRepository
     * @param CountryRepository $countryRepository
     * @param AdapterInterface $cache
     */
    public function __construct(
        WeatherForecastRepository $weatherForecastRepository,
        CountryRepository $countryRepository,
        AdapterInterface $cache
    ) {
        $this->cache = $cache;
        $this->countryRepository = $countryRepository;
        $this->weatherForecastRepository = $weatherForecastRepository;
    }

    /**
     * @param Request $request
     * @param OpenWeatherMap $openWeatherMap
     * @param WorldWeatherOnline $worldWeatherOnline
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function index(Request $request, OpenWeatherMap $openWeatherMap, WorldWeatherOnline $worldWeatherOnline): Response
    {
        $newWeatherForecast = new WeatherForecast();
        $form = $this->createForm(WeatherForecastType::class, $newWeatherForecast);
        $form->handleRequest($request);

        if ("POST" === $request->getMethod()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();
                $city = $formData->getCity();
                $country = $formData->getCountry();
                $cacheKey = str_replace(' ', '', $city) . $country->getIsoCode() . (new \DateTime())->format('Ymd');
                $item = $this->cache->getItem($cacheKey);

                if (!$item->isHit()) {
                    $openWeatherMapTemp = $openWeatherMap->getWeatherForecast($city, $country->getName());
                    $worldWeatherOnlineTemp = $worldWeatherOnline->getWeatherForecast($city, $country->getName());
                    $averageTemp = ($openWeatherMapTemp['temperature'] + $worldWeatherOnlineTemp['temperature']) / 2;

                    // save weather forecast result
                    $this->weatherForecastRepository->saveWeatherForecast($city, $country, $averageTemp);

                    // cache result
                    $item->set($averageTemp);
                    $item->expiresAfter(new \DateInterval('P1D')); // expires after one day
                    $this->cache->save($item);
                } else {
                    $averageTemp = $item->get();
                }
            }
        }

        return $this->render('weather_forecast/index.html.twig', [
            'title' => 'Weather Forecast',
            'form' => $form->createView(),
            'city' => $city ?? null,
            'country' => isset($country) ? $country->getName() : '',
            'temperature' => $averageTemp ?? 0,
        ]);
    }
}
