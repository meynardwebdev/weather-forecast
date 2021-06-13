<?php

namespace App\Api;

use App\Traits\ApiTrait;

class WorldWeatherOnline
{
    use ApiTrait;

    /** @var string */
    private $apiKey = '3c81a92f124a4d8fa5991350211006';

    /** @var WeatherForecastApiInterface */
    private $client;

    /** @var string */
    private $endpoint = 'https://api.worldweatheronline.com/premium/v1/weather.ashx';

    /**
     * WorldWeatherOnline constructor.
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
            'key' => $this->apiKey,
            'q' => $city . ',' . $country,
            'format' => 'json',
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
            'temperature' => $data->data->current_condition[0]->temp_C,
        ];
    }
}