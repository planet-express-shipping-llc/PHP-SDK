<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Resources\BaseResource;

interface IDeletableCollection
{
    /**
     * Delete a whole resource collection.
     *
     * @return BaseResource[]|null
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function deleteAll();
}