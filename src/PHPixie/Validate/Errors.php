<?php

namespace PHPixie\Validate;

class Errors
{
    public function emptyValue()
    {
        return new Errors\Error\EmptyValue();
    }
    
    public function filter($name)
    {
        return new Errors\Error\Filter($name);
    }
    
    public function message($message)
    {
        return new Errors\Error\Message($message);
    }
    
    public function custom($customType, $stringValue = null)
    {
        return new Errors\Error\Custom($customType, $stringValue);
    }
    
    public function arrayCount($count, $minCount = null, $maxCount = null)
    {
        return new Errors\Error\ArrayCount($count, $minCount, $maxCount);
    }

    public function arrayType()
    {
        return new Errors\Error\ValueType\ArrayType();
    }
    
    public function scalarType()
    {
        return new Errors\Error\ValueType\Scalar();
    }
}
