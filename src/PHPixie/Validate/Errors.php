<?php

namespace PHPixie\Validate;

/**
 * Class Errors
 * @package PHPixie\Validate
 */
class Errors
{
    /**
     * @param string $message
     * @return Errors\Error\EmptyValue
     */
    public function emptyValue($message = null)
    {
        return new Errors\Error\EmptyValue($message);
    }

    /**
     * @param $name string
     * @param array $arguments
     * @return Errors\Error\Filter
     */
    public function filter($name, $arguments = array())
    {
        return new Errors\Error\Filter($name, $arguments);
    }

    /**
     * @param $message string
     * @return Errors\Error\Message
     */
    public function message($message)
    {
        return new Errors\Error\Message($message);
    }

    /**
     * @param $customType string
     * @param $stringValue null|string
     * @return Errors\Error\Custom
     */
    public function custom($customType, $stringValue = null)
    {
        return new Errors\Error\Custom($customType, $stringValue);
    }

    /**
     * @return Errors\Error\ValueType\Data
     */
    public function dataType()
    {
        return new Errors\Error\ValueType\Data();
    }

    /**
     * @return Errors\Error\ValueType\Scalar
     */
    public function scalarType()
    {
        return new Errors\Error\ValueType\Scalar();
    }

    /**
     * @param $fields array
     * @return Errors\Error\Data\InvalidFields
     */
    public function invalidFields($fields)
    {
        return new Errors\Error\Data\InvalidFields($fields);
    }

    /**
     * @param $count string
     * @param $minCount string
     * @param $maxCount null|string
     * @return Errors\Error\Data\ItemCount
     */
    public function itemCount($count, $minCount, $maxCount = null)
    {
        return new Errors\Error\Data\ItemCount($count, $minCount, $maxCount);
    }
}
