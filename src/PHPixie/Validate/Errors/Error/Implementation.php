<?php

namespace PHPixie\Validate\Errors\Error;

class Implementation extends \PHPixie\Validate\Errors\Error
{
    protected $type;
    protected $stringValue;
    
    public function __construct($type, $stringValue = null)
    {
        $this->type        = $type;
        $this->stringValue = $stringValue;
    }
    
    public function type()
    {
        return $this->type;
    }
    
    public function asString()
    {
        if($this->stringValue === null) {
            return $this->type;
        }
        
        return $this->stringValue;
    }
}