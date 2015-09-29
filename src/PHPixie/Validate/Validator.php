<?php

class Validator
{
    protected $currentRule;
    
    public function field($name)
    {
        $condition = $this->conditions->field($name);
        $rule = $this->builder->rule($rule);
    }
    
    public function endRule()
    {
        $this->rule = null;
    }
    
    public function errorMessage($name)
    {
        $this->requireCurrentRule()->errorMessage($name);
        return $this;
    }
    
    public function throwOnError($throwOnError = true)
    {
        $this->requireCurrentRule()->throwOnError($throwOnError);
        return $this;
    }
    
    public function currentRule()
    {
        return $this->currentRule();
    }
    
    public function requireCurrentRule()
    {
        if($this->currentRule !== null) {
            return $this->currentRule;
        }
        
        throw new \Exception();
    }
}