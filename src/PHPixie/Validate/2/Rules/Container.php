<?php

namespace PHPixie\Validate\Rules;

class Container
{
    protected $ruleBuilder;
    protected $rules = array();
    
    public function __construct($ruleBuilder)
    {
        $this->ruleBuilder = $ruleBuilder;
    }
    
    public function field($name, $parameter)
    {
        $rule = $this->buildField($name);
        
        if(is_callable($parameter)) {
            $parameter($rule);
        
        }elseif(is_array($parameter)) {
            $rule->filters($parameter);
        
        }else{
            $arguments = array_slice(func_get_args(), 2);
            $rule->filter($parameter, $arguments);
        }
        
        return $this->addRule($rule);
    }
    
    public function subarray($field, $parameter)
    {
        $valueCondition = $this->conditions->value();
        
        if(is_callable($parameter)) {
            $parameter($rule);
        
        }elseif(is_array($parameter)) {
            $rule->filters($parameter);
        
        }else{
            $arguments = array_slice(func_get_args(), 2);
            $rule->filter($parameter, $arguments);
        }
    }
    
    public function subdocument($field, $parameter)
    {
        $valueCondition = $this->conditions->value();
        
        if(is_callable($parameter)) {
            $parameter($rule);
        
        }elseif(is_array($parameter)) {
            $rule->filters($parameter);
        
        }else{
            $arguments = array_slice(func_get_args(), 2);
            $rule->filter($parameter, $arguments);
        }
    }
    
    protected function blaField($name, $parameter)
    {
        $value = $this-
    }
    
    public function conditional($conditionCallback = null, $ruleCallback = null)
    {
        $rule = $this->ruleBuilder->conditional();
        
        if($conditionalCallback !== null) {
            $conditionalCallback($rule->conditionContainer());
        }
        
        if($ruleCallback !== null) {
            $ruleCallback($rule->ruleContainer());
        }
    }
    
    public function addConditional()
    {
        $condition = $this->conditionBuilder->conditional();
        $this->addRule($rule);
        return $rule;
    }
    
    public function addField($name)
    {
        $condition = $this->conditionBuilder->field($name);
        $this->addRule($rule);
        return $rule;
    }
    
    protected function buildField($name)
    {
        $condition = $this->conditionBuilder->field($name);
        return $this->ruleBuilder->field($condition);
    }
    
    public function callback($callback)
    {
        $condition = $this->conditionBuilder->callback($callback);
        return $this->addCondition($condition);
    }
    
    public function addRule($condition)
    {
        $this->rules[]= $condition;
        return $this;
    }
    
    public function rules()
    {
        return $this->rules;
    }
    
    public function validate()
    {
    
    }
}