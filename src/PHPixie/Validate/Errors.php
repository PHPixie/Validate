<?php

namespace PHPixie\Validate;

class Errors
{
    public function error($type, $stringValue = null)
    {
        return new Errors\Error\Implementation($type, $stringValue);
    }
    
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
    
    public function arrayType()
    {
        return new Errors\Error\ValueType\ArrayType();
    }
    
    public function scalarType()
    {
        return new Errors\Error\ValueType\Scalar();
    }
}