<?php

namespace PHPixie\Validate\Errors\Error;

abstract class ValueType extends \PHPixie\Validate\Errors\Error
{
    public function type()
    {
        return 'valueType';
    }
    
    public function asString()
    {
        return $this->valueType();
    }
    
    abstract public function valueType();
}