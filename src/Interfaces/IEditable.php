<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Resources\BaseResource;

interface IEditable
{
    /**
     * Edit resource by ID with given parameters.
     *
     * @param int $id
     * @param array $params
     * @return BaseResource
     * @throws ConnectionException
     * @throws ApiException
     */
    public static function edit(int $id, array $params);
    /**
     * Edit resource with parameters stored in this object.
     *
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public function update();
}