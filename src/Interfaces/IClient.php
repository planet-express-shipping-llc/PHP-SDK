<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Objects\ClientResponse;

/**
 * Performs HTTP request from API.
 * @package PlanetExpress\Clients
 */
interface IClient
{
    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return ClientResponse
     */
    public function request(string $method, string $url, array $headers = [], array $params = []): ClientResponse;
}