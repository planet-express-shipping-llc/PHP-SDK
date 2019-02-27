<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use ArrayObject;
use PlanetExpress\Clients\CurlClient;
use PlanetExpress\Configurator;
use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Exceptions\InvalidArgumentException;
use PlanetExpress\Interfaces\IClient;
use PlanetExpress\Objects\BaseObject;
use PlanetExpress\Objects\ClientResponse;
use PlanetExpress\Objects\Resource\Link;
use PlanetExpress\Objects\Resource\Meta;

/**
 * Serves as base class for all module classes.
 * @package PlanetExpress\Resources
 */
abstract class BaseResource extends BaseObject
{
    const IGNORED_PROPERTIES = [
        'id',
        'messages',
        'meta',
        'links',
    ];

    /**
     * Resource ID
     * @var int|null
     */
    public $id;
    /**
     * Non-error messages (notices) from API
     * @var ArrayObject
     */
    public $messages;
    /**
     * Metadata, such as API version, module, action, etc.
     * @var Meta
     */
    public $meta;
    /**
     * HATEOAS links
     * @var Link[]
     */
    public $links;

    /**
     * BaseResource constructor.
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    /* REQUEST ------------------------------------------------------------------------------------------------------ */

    /**
     * @return IClient
     */
    protected static function getClient(): IClient
    {
        return new CurlClient();
    }

    /**
     * @return string
     * @throws ConnectionException
     */
    protected static function getTokenHeader(): string
    {
        $token = Configurator::getToken();

        if (!$token) {
            $class = Configurator::class;
            throw new ConnectionException("No API token available (see '{$class}')");
        }

        return "Authorization: Bearer {$token}";
    }

    /**
     * @param string $resource
     * @param int|null $id
     * @param string $subresource
     * @param int|null $subId
     * @return string
     */
    protected static function getRequestUrl(string $resource, int $id = null, string $subresource = null, int $subId = null): string
    {
        $base = Configurator::getBaseUrl();
        $version = Configurator::getVersion();

        $url = "{$base}/{$version}/{$resource}";
        $id && $url = "{$url}/{$id}";
        $subresource && $url = "{$url}/{$subresource}";
        $subId && $url = "{$url}/{$subId}";

        return $url;
    }

    /**
     * @param ClientResponse $response
     * @throws ApiException
     * @throws ConnectionException
     */
    protected static function handleErrorResponse(ClientResponse $response)
    {
        if (!$response->validResponse) {
            throw new ConnectionException("Invalid API response", $response->code);
        }

        if ($response->code >= 400 && $response->code < 600) {
            foreach ($response->response['errors'] as $error) {
                throw new ConnectionException($error, $response->code);
            }

            throw new ConnectionException("No error message provided", $response->code);
        }

        foreach ($response->response['errors'] as $error) {
            throw new ApiException($error, $response->code);
        }
    }

    /**
     * @param string $method
     * @param string $resource
     * @param int|null $id
     * @param string|null $subresource
     * @param int|null $subId
     * @param array $params
     * @return ClientResponse
     * @throws ApiException
     * @throws ConnectionException
     */
    protected static function request(string $method, string $resource, int $id = null, string $subresource = null, int $subId = null, array $params = []): ClientResponse
    {
        $headers[] = static::getTokenHeader();
        $response = static::getClient()->request($method, static::getRequestUrl($resource, $id, $subresource, $subId), $headers, $params);

        static::handleErrorResponse($response);

        return $response;
    }

    /* RESPONSE ----------------------------------------------------------------------------------------------------- */

    /**
     * Parse API response into instance(s) of this class.
     *
     * @param ClientResponse $response
     * @return static|static[]
     */
    protected static function fromResponse(ClientResponse $response)
    {
        $payload = $response->response->payload;
        $objects = $response->response->collection ? $payload : (count($payload) ? [$payload] : []);
        $result = [];

        foreach ($objects as $object) {
            $obj = new static;
            $result[] = self::objectFromResponse($obj, $response, \PlanetExpress\Objects\ArrayObject::from($object));
        }

        return count($result) == 1 ? current($result) : $result;
    }

    /**
     * Refresh this instance with meta information, messages and payload from response.
     *
     * @param ClientResponse $response
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function refresh(ClientResponse $response)
    {
        if ($response->response->collection) {
            throw new InvalidArgumentException("Cannot refresh object from a collection");
        }

        self::objectFromResponse($this, $response, $response->response->payload);
        return $this;
    }

    /**
     * Assert valid resource ID.
     * @throws InvalidArgumentException
     */
    protected function assertId()
    {
        if (!is_int($this->id) || $this->id <= 0) {
            throw new InvalidArgumentException("Resource ID is not set or invalid");
        }
    }

    /**
     * Fill in meta information, messages and payload into object and handle subclasses.
     *
     * @param BaseObject $object
     * @param ClientResponse $response
     * @param $values
     * @return BaseObject
     */
    private static function objectFromResponse(BaseObject $object, ClientResponse $response, $values)
    {
        $object->messages = $response->response->messages;
        $object->meta = Meta::from($response->response);
        $object->links = new ArrayObject();

        foreach ($values as $key => $value) {
            $key = static::toCamelCase($key);

            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        static::handleSubclasses($object, static::SUBCLASSES + ['links' => Link::class]);

        return $object;
    }
}