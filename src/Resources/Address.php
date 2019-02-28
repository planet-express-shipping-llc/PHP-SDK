<?php declare(strict_types=1);

namespace PlanetExpress\Resources;

use PlanetExpress\Exceptions\ApiException;
use PlanetExpress\Exceptions\ConnectionException;
use PlanetExpress\Interfaces\ICreatable;
use PlanetExpress\Interfaces\IReadable;
use PlanetExpress\Interfaces\IReadableCollection;

class Address extends BaseResource implements IReadable, IReadableCollection, ICreatable
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
     * Address constructor.
     * @param int|null $id
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $companyName
     * @param string|null $addressLine1
     * @param string|null $addressLine2
     * @param string|null $city
     * @param string|null $zip
     * @param string|null $countryIso
     * @param string|null $stateIso
     * @param string|null $phone
     * @param string|null $taxId
     */
    public function __construct(?int $id = null, string $firstName = null, string $lastName = null, string $companyName = null, string $addressLine1 = null, string $addressLine2 = null, string $city = null, string $zip = null, string $countryIso = null, string $stateIso = null, string $phone = null, string $taxId = null)
    {
        parent::__construct($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->companyName = $companyName;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->zip = $zip;
        $this->countryIso = $countryIso;
        $this->stateIso = $stateIso;
        $this->phone = $phone;
        $this->taxId = $taxId;
    }

    /* GET ---------------------------------------------------------------------------------------------------------- */

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
     * @return Address
     * @throws ApiException
     * @throws ConnectionException
     */
    public function fetch()
    {
        $this->assertId();
        return $this->refresh(self::request('GET', 'address', $this->id));
    }

    /* POST --------------------------------------------------------------------------------------------------------- */

    /**
     * Create resource with given parameters.
     *
     * @param array $params
     * @return Address
     * @throws ConnectionException
     * @throws ApiException
     */
    public static function create(array $params)
    {
        return self::fromResponse(self::request('POST', 'address', null, null, null, $params));
    }

    /**
     * Create resource with parameters stored in this object.
     *
     * @return Address
     * @throws ConnectionException
     * @throws ApiException
     */
    public function insert()
    {
        return self::refresh(self::request('POST', 'address', null, null, null, $this->toArray()));
    }
}