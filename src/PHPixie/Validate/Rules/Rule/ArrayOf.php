<?php

namespace PHPixie\Validate\Rules\Rule;

class ArrayOf
{
    protected $rules;
    
    protected $keyValueRule;
    protected $itemRule;
    
    public function __construct($rules)
    {
        $this->rules = $rules;
    }
    
    public function value($parameter)
    {
        $this->valueItem($parameter);
        return $this;
    }
    
    public function document($parameter)
    {
        $this->documentItem($parameter);
        return $this;
    }
    
    public function arrayOf($parameter)
    {
        $this->arrayOfItem($parameter);
        return $this;
    }
    
    public function keyValue($parameter)
    {
        $rule = $this->keyValueRule();
        return $this;
    }
    
    public function valueItem($parameter)
    {
        $rule = $this->rules->buildArrayOf($parameter);
        return $this->setItemRule($rule);
    }
    
    public function documentItem($parameter)
    {
        $rule = $this->rules->buildArrayOf($parameter);
        return $this->setItemRule($rule);
    }
    
    public function arrayOfItem($parameter)
    {
        $rule = $this->rules->buildArrayOf($parameter);
        return $this->setItemRule($rule);
    }
    
    public function keyValue()
    {
        $this->keyRule = $this->rules->buildValue($parameter);
        return $this->keyRule;
    }
    
    public function keyRule()
    {
        return $this->keyRule;
    }
    
    public function itemRule()
    {
        return $this->itemRule();
    }
    
    public function setItemRule($itemRule)
    {
        $this->itemRule = $itemRule;
        return $this;
    }
    
    public function validateValue($array, $result)
    {
        if(!is_array($array)) {
            $result->error($this->errors->notArray());
        }
        
        if($this->keyRule === null && $this->itemRule === null) {
            return;
        }
        
        foreach($keys as $key) {
            $itemResult = $result->field($key);
            
            if($this->keyRule !== null) {
                $this->keyRule->validate($key, $itemResult);
            }
            
            if($this->valueRule !== null) {
                $this->keyRule->validate($array[$key], $itemResult);
            }
        }
    }
}