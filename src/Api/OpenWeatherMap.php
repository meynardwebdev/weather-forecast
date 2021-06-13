<?php

namespace App\Api;

use App\Traits\ApiTrait;

class OpenWeatherMap
{
    use ApiTrait;

    /** @var string */
    private $apiKey = 'ab51387db2027f2b24c539579edd63b7';

    /** @var WeatherForecastApiInterface */
    private $client;

    /** @var string */
    private $endpoint = 'https://api.openweathermap.org/data/2.5/weather';

    /**
     * OpenWeatherMap constructor.
     * @param WeatherForecastApiInterface $weatherForecastApi
     */
    public function __construct(WeatherForecastApiInterface $weatherForecastApi)
    {
        $this->client = $weatherForecastApi;
    }

    /**
     * @param string $city
     * @param string $country
     * @return array
     */
    public function getWeatherForecast(string $city, string $country): array
    {
        $apiEndpoint = $this->buildApiEndpoint($this->endpoint, [
            'appid' => $this->apiKey,
            'q' => $city . ',' . $country,
            'units' => 'metric',
        ]);

        return $this->toArray($this->client->fetchWeatherForecast($apiEndpoint));
    }

    /**
     * @param mixed $data
     * @return array
     */
    private function toArray($data): array
    {
        return [
            'source' => get_class(),
            'temperature' => $data->main->temp,
        ];
    }
}