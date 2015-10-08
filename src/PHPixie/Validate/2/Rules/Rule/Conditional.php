<?php

namespace PHPixie\Validate\Rules\Rule;

class Conditional extends \PHPixie\Validate\Rules\Rule
{
    protected $conditionContainer;
    protected $ruleContainer;
    
    public function __construct($conditionContainer, $ruleContainer)
    {
        $this->conditionContainer = $conditionContainer;
        $this->ruleContainer      = $ruleContainer;
    }
    
    public function conditionContainer()
    {
        return $this->conditionContainer;
    }
    
    public function ruleContainer()
    {
        return $this->ruleContainer;
    }
    
    public function validate($sliceData, $result)
    {
        if($this->conditionContainer->check($sliceData, $result)) {
            $this->ruleContainer->validate($sliceData, $result);
        }
    }
}