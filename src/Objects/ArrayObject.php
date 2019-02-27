<?php declare(strict_types=1);

namespace PlanetExpress\Objects;

use PlanetExpress\Exceptions\InvalidArgumentException;

/**
 * Servers as wrapper for arrays.
 * @package PlanetExpress\Objects\Item
 */
class ArrayObject extends BaseObject
{
    /**
     * @param array|\Traversable $values
     * @param bool $recursive Wrap recursively?
     * @return static
     * @throws InvalidArgumentException
     */
	public static function from($values, bool $recursive = true)
	{
		$obj = new static;

		if (!static::isTraversable($values)) {
		    $type = gettype($values);
		    throw new InvalidArgumentException("ArrayObject expect array|\Traversable, '{$type}' given");
        }

		foreach ($values as $key => $value) {
			if ($recursive && static::isTraversable($value)) {
				$obj->$key = static::from($value, true);
			} else {
				$obj->$key = $value;
			}
		}

		return $obj;
	}

    /**
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($offset == null) {
            // [] operator, insert after highest numeric index
            $indices = array_filter(array_keys(get_object_vars($this)), 'is_numeric');

            $offset = empty($indices) ? 0 : max($indices) + 1;
        }

        parent::offsetSet($offset, $value);
    }
}