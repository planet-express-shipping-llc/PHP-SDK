<?php declare(strict_types=1);

namespace PlanetExpress\Objects;

use PlanetExpress\Exceptions\InvalidArgumentException;
use stdClass;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use PlanetExpress\Exceptions\MemberAccessException;
use Traversable;

/**
 * Serves as base for all data containing objects.
 * @package PlanetExpress\Objects
 */
abstract class BaseObject extends stdClass implements ArrayAccess, Countable, IteratorAggregate
{
    protected const SUBCLASSES = [];

    /* STATIC ------------------------------------------------------------------------------------------------------- */

    /**
     * @param array|Traversable $values
     * @return static
     */
    public static function from($values)
    {
        $obj = new static;

        if (!static::isTraversable($values)) {
		    $type = gettype($values);
		    throw new InvalidArgumentException("Values have to be array|\Traversable, '{$type}' given");
        }

        foreach ($values as $key => $value) {
            $key = self::toCamelCase($key);

            if (property_exists($obj, (string) $key)) {
                $obj->$key = $value;
            }
        }

        static::handleSubclasses($obj, static::SUBCLASSES);

        return $obj;
    }

    /**
     * Transform given keys in object into subclasses based on supplied mask.
     *
     * @param BaseObject $object
     * @param array $classes
     * @return array|\Traversable
     */
    protected static function handleSubclasses($object, array $classes)
    {
        foreach ($classes as $key => $class) {
            if (isset($object->$key) && self::isTraversable($object->$key) && isset($classes[$key])) {
                $class = $classes[$key];
                $recursion = is_array($class);

                if ($recursion) {
                    // Traversable value with subclasses
                    $object->$key = static::handleSubclasses($object->$key, $class);
                } else {
                    if (!is_a($class, BaseObject::class, true)) {
                        continue;
                    }

                    if (static::isIndexed($object->$key)) {
                        // Integer keys = subclass[]
                        foreach ($object->$key as $subKey => $subValue) {
                            $object->$key->$subKey = $class::from($object->$key->$subKey);
                        }
                    } else {
                        // String keys = subclass
                        $object->$key = $class::from($object->$key);
                    }
                }
            }
        }

        return $object;
    }

    /**
     * @param mixed $values
     * @return bool
     */
    public static function isTraversable($values): bool
    {
        return is_array($values) || $values instanceof \Traversable;
    }

    /**
     * @param mixed $values
     * @return bool
     */
    public static function isIndexed($values) {
        if (!self::isTraversable($values)) {
            return false;
        }

        foreach ($values as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert string to camelCase.
     *
     * @param string $value
     * @param bool $upper UpperCamelCase?
     * @return string
     */
    public static function toCamelCase(string $value, bool $upper = false): string
    {
        static $cache = [];

        if (isset($cache[$value])) {
            return $cache[$value];
        }

        return $cache[$value] = preg_replace_callback('/(^|_)([a-zA-Z0-9])/', function ($matches) use ($upper) {
            if ($matches[1]) {
                return strtoupper($matches[2]);
            } else {
                return $upper ? strtoupper($matches[2]) : strtolower($matches[2]);
            }
        }, $value);
    }

    /* MAGIC -------------------------------------------------------------------------------------------------------- */

    /**
     * @param string $name
     * @param string $value
     * @throws MemberAccessException
     */
    public function __set($name, $value)
    {
        throw new MemberAccessException("Property '{$name}' does not exist or is not accessible");
    }

    /**
     * @param string $name
     * @throws MemberAccessException
     */
    public function __get($name)
    {
        throw new MemberAccessException("Property '{$name}' does not exist or is not accessible");
    }

    /**
     * @param $name
     * @throws MemberAccessException
     */
    public function __unset($name)
    {
        throw new MemberAccessException("Property '{$name}' does not exist or is not accessible");
    }

    /* ARRAY ACCESS ------------------------------------------------------------------------------------------------- */

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /* COUNTABLE ---------------------------------------------------------------------------------------------------- */

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count(get_object_vars($this));
    }

    /* ITERATOR AGGREGATE ------------------------------------------------------------------------------------------- */

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }
}