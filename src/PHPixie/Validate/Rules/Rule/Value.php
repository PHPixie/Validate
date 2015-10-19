<?php

namespace PHPixie\Validate\Rules\Rule;

abstract class Value implements \PHPixie\Validate\Rules\Rule
{
    protected $rulesBuilder;
    protected $isRequired = false;
    
    
    public function required($isRequired = true)
    {
        $this->isRequired = $isRequired;
    }
    
    public function callback($callback)
    {
        $rule = $this->ruleBuilder->callback($callback);
        $this->addRule($rule);
    }
    
    public function validate($value, $result)
    {
        $isEmpty = in_array($value, array(null, ''), true);
        
        if($isEmpty) {
            if(!this->isRequired) {
                $result->emptyError();
            }
            return;
        }
        
        $this->validateValue($value, $result);
        
        foreach($this->rules as $rule) {
            $rule->validate($value, $result);
        }
    }
    
    protected function validateValue($value, $result);
}