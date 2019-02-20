<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Resource;

use PlanetExpress\Objects\BaseObject;

class Meta extends BaseObject
{
    /**
     * Request HTTP method
     * @var string
     */
    public $method;
    /**
     * Request HTTP code.
     * @var int
     */
    public $code;
    /**
     * Requested API version
     * @var string
     */
    public $version;
    /**
     * Requested API resource
     * @var string
     */
    public $resource;
    /**
     * Requested API subresource
     * @var string
     */
    public $subresource;
}