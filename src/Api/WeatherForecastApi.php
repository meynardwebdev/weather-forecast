<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class WeatherForecastApi implements WeatherForecastApiInterface
{
    /** @var HttpClientInterface */
    private $client;

    /**
     * WeatherForecastApi constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $apiEndpoint
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Exception
     */
    public function fetchWeatherForecast(string $apiEndpoint)
    {
        $response = $this->client->request('GET', $apiEndpoint);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getContent());
        } else {
            throw new \Exception("Invalid API request.");
        }
    }
}
