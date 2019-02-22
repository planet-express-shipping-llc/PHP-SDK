<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Item;

use PlanetExpress\Objects\BaseObject;

class Declaration extends BaseObject
{
    const SUBCLASSES = [
        'items' => DeclarationItem::class,
    ];

    /**
     * Declaration category (Merchandise x Gift)
     * @var string
     */
    public $category;
    /**
     * Declaration items
     * @var DeclarationItem[]
     */
    public $items;
}