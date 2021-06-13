<?php

namespace App\Traits;

trait ApiTrait
{
    /**
     * @param string $endpoint
     * @param array $query
     * @return string
     */
    public function buildApiEndpoint(string $endpoint, array $query): string
    {
        return $endpoint . '?' . http_build_query($query);
    }
}