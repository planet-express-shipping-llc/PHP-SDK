<?php declare(strict_types=1);

namespace PlanetExpress\Objects;

/**
 * Represents response from API client.
 * @package PlanetExpress\Objects
 */
class ClientResponse extends BaseObject
{
    /**
     * @var int
     */
    public $code;
    /**
     * @var ArrayObject
     */
    public $headers;
    /**
     * @var string
     */
    public $rawResponse = '';
    /**
     * @var ArrayObject
     */
    public $response;
    /**
     * @var bool
     */
    public $validResponse = true;

    /**
     * ClientResponse constructor.
     * @param int $code
     * @param string $rawResponse
     * @param array $headers
     * @throws \PlanetExpress\Exceptions\InvalidArgumentException
     */
    public function __construct(int $code, string $rawResponse, array $headers = [])
    {
        try {
            $this->response = ArrayObject::from(json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            $this->response = new ArrayObject();
            $this->validResponse = false;
        }

        $this->code = $code;
        $this->rawResponse = $rawResponse;
        $this->headers = ArrayObject::from($headers);
    }

    /**
     * Parse HTTP headers.
     * @param string $rawHeaders
     * @return array
     */
    public static function parseHeaders(string $rawHeaders): array
    {
        $headers = array_filter(preg_split('~\R~', $rawHeaders));
        $result = [];

        foreach ($headers as $header) {
            if (empty($result)) {
                $result['Request'] = $header;
            } elseif (strstr($header, ':')) {
                [$name, $value] = explode(':', $header, 2);
                $result[$name] = trim($value);
            }
        }

        return $result;
    }
}