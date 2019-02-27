<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Order;

use PlanetExpress\Objects\BaseObject;
use PlanetExpress\Objects\Resource\Link;

class OrderItem extends BaseObject
{
    protected const SUBCLASSES = [
        'links' => Link::class,
    ];

    protected const IGNORED_PROPERTIES = [
        'links'
    ];

    /**
     * OrderItem constructor.
     * @param int|null $itemId
     * @param int|null $quantity
     * @param string|null $note
     */
    public function __construct(int $itemId = null, int $quantity = null, string $note = null)
    {
        $this->itemId = $itemId;
        $this->quantity = $quantity;
        $this->note = $note;
    }

    /**
     * Storage item ID
     * @var int
     */
    public $itemId;
    /**
     * Quantity ordered
     * @var int
     */
    public $quantity;
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