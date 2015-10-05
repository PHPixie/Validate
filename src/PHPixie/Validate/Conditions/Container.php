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
        
        }elseif(!is_array($parameter)) {
            $condition->addFilters($parameter);
        
        }else{
            $arguments = array_slice($arguments, 2, func_get_args());
            $condition->addFilter($parameter, $arguments);
        }
        
        return $this->addCondition($condition);
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