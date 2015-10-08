<?php

namespace PHPixie\Validate\Conditions;

class Container
{
    protected $conditionBuilder;
    protected $conditions = array();
    
    public function __construct($conditionBuilder)
    {
        $this->conditionBuilder = $conditionBuilder;
    }
    
    public function check($sliceData)
    {
        foreach($this->conditions as $condition) {
            if(!$condition->check($sliceData)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function field($name, $parameter)
    {
        $condition = $this->conditionBuilder->field($name);
        
        if(is_callable($parameter)) {
            $parameter($condition);
        
        }elseif(is_array($parameter)) {
            $condition->filters($parameter);
        
        }else{
            $arguments = array_slice(func_get_args(), 2);
            $condition->filter($parameter, $arguments);
        }
        
        return $this->addCondition($condition);
    }
    
    public function subarray($field, $parameter)
    {
        $valueCondition = $this->conditionBuilder->value();
        
        if(is_callable($parameter)) {
            $parameter($valueCondition);
        
        }elseif(is_array($parameter)) {
            $valueCondition->filters($parameter);
        
        }else{
            $arguments = array_slice(func_get_args(), 2);
            $valueCondition->filter($parameter, $arguments);
        }
        
        $condition = $this->subarrayCondition($field, $valueCondition);
    }
    
    public function addField($name)
    {
        $condition = $this->conditionBuilder->field($name);
        $this->addCondition($condition);
        return $condition;
    }
    
    public function callback($callback)
    {
        $condition = $this->conditionBuilder->callback($callback);
        return $this->addCondition($condition);
    }
    
    public function isValid($field = null)
    {
        $condition = $this->conditionBuilder->isValid($field);
        return $this->addCondition($condition);
    }
    
    public function isNotValid($field = null)
    {
        return $this->addIsValid($field, true);
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