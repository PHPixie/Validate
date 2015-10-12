<?php

namespace PHPixie\Validate;

class Errors
{
    public function error($type, $stringValue = null)
    {
        return new Errors\Error\Implementation($type, $stringValue);
    }
    
    public function required()
    {
        return new Errors\Error\Required();
    }
    
    public function filter($name)
    {
        return new Errors\Error\Filter($name);
    }
    
    public function message($message)
    {
        return new Errors\Error\Message($message);
    }
    
    public function notArray()
    {
        return new Errors\Error\DataType\NotArray();
    }
    
    public function notScalar()
    {
        return new Errors\Error\DataType\NotScalar();
    }
}