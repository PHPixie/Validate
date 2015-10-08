<?php

namespace PHPixie\Validate;

class Validator
{
    protected $ruleContainer;
    
    public function __construct($ruleContainer)
    {
    
    }
    
    public function validate($data)
    {
        if($data instanceof \PHPixie\Slice\Data) {
        
        }
    }
}