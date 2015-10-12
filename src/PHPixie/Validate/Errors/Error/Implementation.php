<?php

namespace PHPixie\Validate\Errors\Error;

class Implementation extends \PHPixie\Validate\Errors\Error
{
    protected $type;
    protected $stringValue;
    
    public function __construct($type, $stringValue)
    {
        $this->type        = $type;
        $this->stringValue = $stringValue;
    }
    
    public function asString()
    {
        return $this->stringValue;
    }
}