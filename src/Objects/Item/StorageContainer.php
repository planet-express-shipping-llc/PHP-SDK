<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Item;

use PlanetExpress\Objects\BaseObject;

class StorageContainer extends BaseObject
{
    /**
     * Container ID
     * @var int
     */
    public $id;
    /**
     * Amount in container
     * @var int
     */
    public $amount;
}