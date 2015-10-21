<?php

namespace PHPixie\Validate\Rules\Rule\Structure;

class Document implements \PHPixie\Validate\Rules\Rule
{
    protected $rules;
    
    protected $keyRule;
    protected $itemRule;
    
    public function __construct($rules)
    {
        $this->rules = $rules;
    }
    
    public function key($callback = null)
    {
        $this->addKey($callback);
        return $this;
    }
    
    public function addKey($callback = null)
    {
        $rule = $this->rules->value();
        if($callback !== null) {
            $callback($rule);
        }
        
        $this->setKeyRule($rule);
        return $rule;
    }
    
    public function item($callback = null)
    {
        $this->addItem($callback);
        return $this;
    }
    
    public function addItem($callback = null)
    {
        $rule = $this->rules->value();
        if($callback !== null) {
            $callback($rule);
        }
        
        $this->setItemRule($rule);
        return $rule;
    }
    
    public function setKeyRule($rule)
    {
        $this->keyRule = $rule;
        return $this;
    }
    
    public function setItemRule($rule)
    {
        $this->itemRule = $rule;
        return $this;
    }
    
    public function keyRule()
    {
        return $this->keyRule;
    }
    
    public function itemRule()
    {
        return $this->itemRule;
    }
    
    public function validate($value, $result)
    {
        if(!is_array($value)) {
            $result->addArrayTypeError();
            return;
        }
        
        foreach($value as $key => $item) {
            $itemResult = $result->field($key);
            
            if($this->keyRule !== null) {
                $this->keyRule->validate($key, $fieldResult);
            }
            
            if($this->itemRule !== null) {
                $this->itemRule->validate($item, $fieldResult);
            }
        }
    }
}