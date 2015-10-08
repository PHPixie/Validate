<?php

namespace PHPixie\Validate\Rules;

abstract class Rule
{
    protected $throwOnError = false;
    protected $errorMessage = null;
    
    public function throwOnError($throwOnError)
    {
        $this->throwOnError = $throwOnError;
        return $this;
    }
    
    public function errorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }
    
    public function validate($configData, $result)
    {
        
    }
}