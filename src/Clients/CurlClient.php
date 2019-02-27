<?php declare(strict_types=1);

namespace PlanetExpress\Clients;

use PlanetExpress\Interfaces\IClient;
use PlanetExpress\Objects\ClientResponse;

/**
 * cURL implementation of IClient
 * @package PlanetExpress\Clients
 */
class CurlClient implements IClient
{
    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return ClientResponse
     */
    public function request(string $method, string $url, array $headers = [], array $params = []): ClientResponse
    {

        $method = strtoupper(trim($method));

        // Options
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        // Method & body
        if ($method == 'GET') {
            $options[CURLOPT_HTTPGET] = 1;
            if ($params) {
                $params = http_build_query($params);
                $url = "{$url}?{$params}";
            }
        } else {
            $headers[] = 'Content-Type: application/json';
            $options[CURLOPT_POSTFIELDS] = json_encode($params);

            if ($method == 'POST') {
                $options[CURLOPT_POST] = 1;
            } else {
                $options[CURLOPT_CUSTOMREQUEST] = $method;
            }
        }

        // Headers
        $options[CURLOPT_HTTPHEADER] = $headers;

        $responseHeaders = [];
        $curl = curl_init($url);
        curl_setopt_array($curl, $options);

        // Response headers
        curl_setopt($curl, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $name = strtolower(trim($header[0]));
            if (!array_key_exists($name, $responseHeaders))
                $responseHeaders[$name] = [trim($header[1])];
            else
                $responseHeaders[$name][] = trim($header[1]);

            return $len;
        });

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        return new ClientResponse($info['http_code'], $response, $responseHeaders);
    }
}