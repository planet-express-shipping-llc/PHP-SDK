<?php declare(strict_types=1);

namespace PlanetExpress\Interfaces;

interface IArrayConvertible
{
    /**
     * @param bool $recursive
     * @return array
     */
    public function toArray(bool $recursive = true): array;
}