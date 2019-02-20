<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Resources\BaseResource;

interface IDeletable
{
    /**
     * Delete a resource by ID.
     *
     * @param int $id
     * @return BaseResource|null
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function delete(int $id);
    /**
     * Deletes resource stored in this object.
     *
     * @return BaseResource|null
     * @throws ApiException
     * @throws ConnectionException
     */
    public function remove();
}