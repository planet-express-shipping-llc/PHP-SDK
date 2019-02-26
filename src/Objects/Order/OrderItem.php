<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Order;

use PlanetExpress\Objects\BaseObject;
use PlanetExpress\Objects\Resource\Link;

class OrderItem extends BaseObject
{
    protected const SUBCLASSES = [
        'links' => Link::class,
    ];

    /**
     * Storage item ID
     * @var int
     */
    public $itemId;
    /**
     * Amount ordered
     * @var int
     */
    public $amount;
    /**
     * Item note
     * @var string|null
     */
    public $note;
    /**
     * Order item links
     * @var Link[]
     */
    public $links;
}