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
        $responseHeaders = [];
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLINFO_HEADER_OUT => true,
        ];

        switch (strtolower(trim($method))) {
            case 'post':
                $options[CURLOPT_POST] = 1;
                $options[CURLOPT_POSTFIELDS] = $params;
                break;

            case 'get':
                $options[CURLOPT_HTTPGET] = 1;
                if ($params) {
                    $params = http_build_query($params);
                    $url = "{$url}?{$params}";
                }
                break;

            default:
                $options[CURLOPT_CUSTOMREQUEST] = strtoupper(trim($method));
        }

        $curl = curl_init($url);
        curl_setopt_array($curl, $options);

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