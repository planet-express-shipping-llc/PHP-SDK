<?php declare(strict_types=1);

namespace PlanetExpress;

use PlanetExpress\Exceptions\InvalidArgumentException;

class Configurator
{
    const LIVE_API_BASE = 'https://app.planetexpress.com/api';
    const SANDBOX_API_BASE = 'https://sandbox.planetexpress.com/api';

    /**
     * @var string
     */
    protected static $token;
    /**
     * @var string
     */
    protected static $version = 'v1';
    /**
     * @var bool
     */
    protected static $sandboxMode = false;
    /**
     * @var string
     */
    protected static $baseUrl = self::LIVE_API_BASE;

    /**
     * @return string
     */
    public static function getToken(): ?string
    {
        return self::$token;
    }

    /**
     * @param string $token
     * @return static
     */
    public static function setToken(string $token)
    {
        self::$token = trim($token);
        return new static;
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return self::$version;
    }

    /**
     * @param int $version
     * @return static
     * @throws InvalidArgumentException
     */
    public static function setVersion(int $version)
    {
        if ($version <= 0) {
            throw new InvalidArgumentException("Invalid version number, version has to be higher than zero");
        }
        self::$version = "v{$version}";
        return new static;
    }

    /**
     * @return bool
     */
    public static function isSandboxMode(): bool
    {
        return self::$sandboxMode;
    }

    /**
     * @param bool $sandboxMode
     * @return static
     */
    public static function setSandboxMode(bool $sandboxMode)
    {
        self::$sandboxMode = $sandboxMode;
        self::$baseUrl = $sandboxMode ? self::SANDBOX_API_BASE : self::LIVE_API_BASE;

        return new static;
    }

    /**
     * @param string $baseUrl
     * @return static
     */
    public static function setBaseUrl(string $baseUrl)
    {
        trigger_error("You are setting API base URL, are you sure you know what you are doing?");

        self::$baseUrl = $baseUrl;
        return new static;
    }

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }


}
