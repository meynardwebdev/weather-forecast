<?php

namespace App\Api;

interface WeatherForecastApiInterface
{
    /**
     * @param string $apiEndpoint
     * @return mixed
     */
    public function fetchWeatherForecast(string $apiEndpoint);
}
