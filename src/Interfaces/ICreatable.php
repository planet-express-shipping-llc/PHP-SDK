<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Resources\BaseResource;

interface ICreatable
{
    /**
     * Create resource with given parameters.
     *
     * @param array $params
     * @return BaseResource
     * @throws ConnectionException
     * @throws ApiException
     */
    public static function create(array $params);

    /**
     * Create resource with parameters stored in this object.
     *
     * @return BaseResource
     * @throws ConnectionException
     * @throws ApiException
     */
    public function insert();
}