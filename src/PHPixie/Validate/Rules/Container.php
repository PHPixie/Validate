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
    
    public function addCondition($condition)
    {
        $this->conditions[]= $condition;
        return $this;
    }
    
    public function conditions()
    {
        return $this->conditions;
    }
}