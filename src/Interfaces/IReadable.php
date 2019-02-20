<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Resources\BaseResource;

interface IReadable
{
    /**
     * Get resource with values from API.
     *
     * @param int $id
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function get(int $id);
    /**
     * Fetch values from API into this resource.
     *
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public function fetch();
}