<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Interfaces\IReadableCollection;
use PlanetExpress\Interfaces\IReadable;

class Address extends BaseResource implements IReadable, IReadableCollection
{
    /**
     * Address requires either first name + last name or company name
     * @var string|null
     */
    public $firstName;
    /**
     * Address requires either first name + last name or company name
     * @var string|null
     */
    public $lastName;
    /**
     * Address requires either first name + last name or company name
     * @var string|null
     */
    public $companyName;
    /**
     * @var string
     */
    public $addressLine1;
    /**
     * @var string|null
     */
    public $addressLine2;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $zip;
    /**
     * @var string
     */
    public $countryName;
    /**
     * @var string
     */
    public $countryIso;
    /**
     * @var string
     */
    public $stateName;
    /**
     * @var string
     */
    public $stateIso;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string|null
     */
    public $taxId;

    /**
     * Get all available resources with values from API.
     *
     * @return Address[]
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function getAll()
    {
        return self::fromResponse(self::request('GET', 'address'));
    }

    /**
     * Get resource with values from API.
     *
     * @param int $id
     * @return Address
     * @throws ApiException
     * @throws ConnectionException
     */
    public static function get(int $id)
    {
        return self::fromResponse(self::request('GET', 'address', $id));
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
        return $this->refresh(self::request('GET', 'address', $this->id));
    }
}