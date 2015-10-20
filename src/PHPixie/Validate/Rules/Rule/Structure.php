<?php

namespace PHPixie\Validate\Rules\Rule;

class Value implements \PHPixie\Validate\Rules\Rule
{
    protected $rulesBuilder;
    
    protected $isRequired = false;
    protected $rules      = array();
    
    public function __construct($rulesBuilder)
    {
        $this->rulesBuilder = $rulesBuilder;
    }
    
    public function required($isRequired = true)
    {
        $this->isRequired = $isRequired;
        return $this;
    }
    
    public function isRequired()
    {
        return $this->isRequired;
    }
    
    public function addRule($rule)
    {
        $this->rules[] = $rule;
        return $this;
    }
    

    
    public function rules()
    {
        return $this->rules;    
    }
    
    public function validate($value, $result = null)
    {
        $isEmpty = in_array($value, array(null, ''), true);
        
        if($isEmpty) {
            if($this->isRequired) {
                $result->addEmptyValueError();
            }
            return;
        }
        
        foreach($this->rules() as $rule) {
            $rule->validate($value, $result);
        }
    }
}