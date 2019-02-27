<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Item;

use PlanetExpress\Objects\BaseObject;

class DeclarationItem extends BaseObject
{
    /**
     * Item description
     * @var string
     */
    public $name;
    /**
     * Quantity in package
     * @var int
     */
    public $quantity;
    /**
     * Declared value
     * @var float
     */
    public $value;
    /**
     * Origin country
     * @var string
     */
    public $origin;
    /**
     * Battery identifier
     * @var string
     */
    public $battery;
}