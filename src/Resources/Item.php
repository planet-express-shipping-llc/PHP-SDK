<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Interfaces\IReadableCollection;
use PlanetExpress\Interfaces\IReadable;
use PlanetExpress\Objects\Item\Declaration;
use PlanetExpress\Objects\Item\StorageContainer;

class Item extends BaseResource implements IReadable, IReadableCollection
{
    const SUBCLASSES = [
        'declaration' => Declaration::class,
        'containers' => StorageContainer::class,
    ];

    /**
     * Item SKU (unique identifier)
     * @var string
     */
    public $sku;
    /**
     * Item description
     * @var string
     */
    public $name;
    /**
     * Battery type contained in the item
     * @var string|null
     */
    public $battery;
    /**
     * Item value
     * @var float
     */
    public $price;
    /**
     * Is item a package containing other items?
     * @var bool
     */
    public $isPackage;
    /**
     * Item length (null if not available)
     * @var float|null
     */
    public $length;
    /**
     * Item width (null if not available)
     * @var float|null
     */
    public $width;
    /**
     * Item height (null if not available)
     * @var float|null
     */
    public $height;
    /**
     * Item weight (null if not available)
     * @var float|null
     */
    public $weight;
    /**
     * Creation date (in ISO 8601 format)
     * @var string
     */
    public $validFrom;
    /**
     * Deletion date (null if not deleted) (in ISO 8601 format)
     * @var string|null
     */
    public $validTo;
    /**
     * Total amount stored
     * @var int
     */
    public $totalAmount;
    /**
     * Storage container breakdown
     * @var StorageContainer[]
     */
    public $containers;
    /**
     * Item customs declaration (for items that are a package).
     * @var Declaration
     */
    public $declaration;

    /**
     * Get all available resources with values from API.
     *
     * @return Item[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll()
    {
        return self::fromResponse(self::request('GET', 'item'));
    }

    /**
     * Get resource with values from API.
     *
     * @param int $id
     * @return Item
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function get(int $id)
    {
        return self::fromResponse(self::request('GET','item', $id));
    }

    /**
     * Fetch values from API into this resource.
     *
     * @return $this
     * @throws ApiException
     * @throws ConnectionException
     */
    public function fetch()
    {
        $this->assertId();
        return $this->refresh(self::request('GET', 'item', $this->id));
    }
}