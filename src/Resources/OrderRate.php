<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Exceptions\InvalidArgumentException;
use PlanetExpress\Interfaces\IReadable;
use PlanetExpress\Interfaces\IReadableCollection;

class OrderRate extends BaseResource implements IReadable, IReadableCollection
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $service;
    /**
     * @var string
     */
    public $estimatedDelivery;
    /**
     * @var bool
     */
    public $tracking;
    /**
     * @var string
     */
    public $trackingNote;

    /**
     * Get resource with values from API.
     *
     * @param int $id
     * @param array $params
     * @return OrderRate
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function get(int $id, array $params = [])
    {
        return self::fromResponse(self::request('GET', 'order-rate', $id, null, null, $params));
    }

    /**
     * Fetch values from API into this resource.
     */
    public function fetch()
    {
        throw new InvalidArgumentException("This resource cannot be fetched");
    }

    /**
     * Get all available resources.
     *
     * @param array $params
     * @return OrderRate[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll(array $params = [])
    {
        return self::fromResponse(self::request('GET', 'order-rate', null, null, null, $params));
    }
}