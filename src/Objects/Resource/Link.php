<?php declare(strict_types=1);

namespace PlanetExpress\Objects\Resource;

use PlanetExpress\Objects\BaseObject;

/**
 * HATEOAS link.
 * @see https://restfulapi.net/hateoas/
 * @package PlanetExpress\Objects
 */
class Link extends BaseObject
{
    /**
     * URL
     * @var string
     */
    public $href;
    /**
     * Link name
     * @var string
     */
    public $rel;
    /**
     * HTTP method.
     * @var string
     */
    public $type;
}