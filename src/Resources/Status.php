<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

/**
 * Provides information about API itself.
 * @package PlanetExpress\Resources
 */
class Status extends BaseResource
{
    /**
     * @return int
     * @throws \PlanetExpress\Exceptions\ConnectionException
     * @throws \PlanetExpress\Exceptions\ApiException
     */
   public static function get(): int
   {
        return self::request('GET', 'status')->code;
   }
}