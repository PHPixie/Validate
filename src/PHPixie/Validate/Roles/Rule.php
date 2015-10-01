<?php

namespace PHPixie\Validate\Rules;

abstract class Rule
{
    protected $conditions   = array();
    
    protected $throwOnError = false;
    protected $errorMessage = null;
    
    public function requiredConditions()
    {
        if($this->requiredConditions === null) {
            $this->requiredConditions = $this->conditionBuilder->container();
        }
        
        return $this->requiredConditions;
    }
    
    public function condition()
    {
        return $this->condition;
    }
    
    
}