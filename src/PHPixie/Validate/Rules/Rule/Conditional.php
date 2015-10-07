<?php

namespace PHPixie\Validate\Rules\Rule;

class Conditional implements \PHPixie\Validate\Rules\Rule
{
    protected $conditionContainer;
    
    public function __construct($conditionContainer)
    {
        $this->conditionContainer = $conditionContainer;
    }
    
    public function conditions()
    {
        return $this->conditionContainer;
    }
    
    public function validate($sliceData)
    {
        if(!$this->conditionContainer->check($sliceData)) {
            return;
        }
        
        return $this->ruleContainer->validate()
    }
}