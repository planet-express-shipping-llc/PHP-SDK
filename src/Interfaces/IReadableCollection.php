<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Objects\BaseObject;

interface IReadableCollection
{
    /**
     * Get all available resources.
     *
     * @return BaseObject[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll();
}