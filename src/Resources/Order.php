<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Interfaces\IDeletable;
use PlanetExpress\Interfaces\IEditable;
use PlanetExpress\Interfaces\IReadable;
use PlanetExpress\Interfaces\IReadableCollection;
use PlanetExpress\Objects\Order\OrderItem;

class Order extends BaseResource implements IReadable, IReadableCollection, IEditable, IDeletable
{
    protected const SUBCLASSES = [
        'items' => OrderItem::class,
    ];

    public const IGNORED_PROPERTIES = [
        'trackingNumber',
        'trackingUrl',
        'carrier',
        'status',
    ];

    /**
     * Order preferred carrier ID
     * @var int
     */
    public $carrierId;
    /**
     * Order recipient address
     * @var int
     */
    public $addressId;
    /**
     * Order status
     * @var string
     */
    public $status;
    /**
     * Order preferred carrier name
     * @var string
     */
    public $carrier;
    /**
     * Insurance selected?
     * @var bool
     */
    public $insurance;
    /**
     * Promotional inserts selected?
     * @var bool
     */
    public $promotionalInserts;
    /**
     * Order note
     * @var string|null
     */
    public $note;
    /**
     * Order tracking number.
     * @var string|null
     */
    public $trackingNumber;
    /**
     * Order tracking url.
     * @var string|null
     */
    public $trackingUrl;
    /**
     * Order items
     * @var OrderItem[]
     */
    public $items;

    /* GET ---------------------------------------------------------------------------------------------------------- */

    /**
     * Get resource with values from API.
     *
     * @param int $id
     * @return Order
     * @throws \PlanetExpress\Exceptions\ApiException
     * @throws \PlanetExpress\Exceptions\ConnectionException
     */
    public static function get(int $id)
    {
        return self::fromResponse(self::request('GET', 'order', $id));
    }

    /**
     * Get all available resources with values from API.
     *
     * @return Order[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll()
    {
        return self::fromResponse(self::request('GET', 'order'));
    }

    /**
     * Get order tracking info from API.
     *
     * @param int $id
     * @return Order
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getTracking(int $id)
    {
        return self::fromResponse(self::request('GET', 'order', $id, 'tracking'));
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
        return $this->refresh(self::request('GET', 'order', $this->id));
    }

    /**
     * Fetch tracking info from API into this resource.
     *
     * @return $this
     * @throws ApiException
     * @throws ConnectionException
     */
    public function fetchTracking()
    {
        $this->assertId();
        return $this->refresh(self::request('GET', 'order', $this->id, 'tracking'));
    }

    /* PUT ---------------------------------------------------------------------------------------------------------- */

    /**
     * Edit resource by ID with given parameters.
     *
     * @param int $id
     * @param array $params
     * @return BaseResource
     * @throws ConnectionException
     * @throws ApiException
     */
    public static function edit(int $id, array $params)
    {
        return self::fromResponse(self::request('PUT', 'order', $id, null, null, $params));
    }

    /**
     * Edit resource with parameters stored in this object.
     *
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public function update()
    {
        $this->assertId();
        $this->refresh(self::request('PUT', 'order', $this->id, null, null, $this->toArray()));
        return $this;
    }

    /* DELETE ------------------------------------------------------------------------------------------------------- */

    /**
    /**
     * Delete a resource by ID.
     *
     * @param int $id
     * @return BaseResource
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function delete(int $id)
    {
        return self::fromResponse(self::request('DELETE', 'order', $id));
    }

    /**
     * Deletes resource stored in this object.
     *
     * @return BaseResource|null
     * @throws ApiException
     * @throws ConnectionException
     */
    public function remove()
    {
        $this->assertId();
        return $this->refresh(self::request('DELETE', 'order', $this->id));
    }
}