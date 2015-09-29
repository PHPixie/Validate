<?php

namespace PHPixie\Validate\Rules;

abstract class Rule
{
    protected $conditions   = array();
    protected $throwOnError = false;
    protected $errorMessage = null;
    
    public function addCondition($rule)
    {
        $this->conditions[]= $rule;
        return $this;
    }
    
    public function validate($sliceData)
    {
        
    }
    
    public function throwOnError($throwOnError = true)
    {
        $this->throwOnError = $throwOnError;
    }
    
    public function errorMessage($message)
    {
        $this->errorMessage = $errorMessage;
    }
}