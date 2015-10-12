<?php

namespace PHPixie\Validate\Errors\Error;

abstract class DataType extends \PHPixie\Validate\Errors\Error
{
    public function type()
    {
        return 'dataType';
    }
    
    public function asString()
    {
        return 'not'.ucfirst($this->dataType());
    }
    
    abstract public function dataType();
}