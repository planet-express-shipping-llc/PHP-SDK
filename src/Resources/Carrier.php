<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Interfaces\IReadable;
use PlanetExpress\Interfaces\IReadableCollection;

class Carrier extends BaseResource implements IReadable, IReadableCollection
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
     * @return Carrier
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function get(int $id)
    {
        return self::fromResponse(self::request('GET', 'carrier', $id));
    }

    /**
     * Fetch values from API into this resource.
     *
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public function fetch()
    {
        $this->assertId();
        return self::refresh(self::request('GET', 'carrier',  $this->id));
    }

    /**
     * Get all available resources.
     *
     * @return Carrier[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll()
    {
        return self::fromResponse(self::request('GET', 'carrier'));
    }
}