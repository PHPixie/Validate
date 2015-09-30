<?php

namespace PHPixie\Validate\Conditions;

class Container
{
    protected $conditionBuilder;
    protected $conditions = array();
    
    public function check($sliceData)
    {
        foreach($this->conditions as $condition) {
            if(!$condition->check($sliceData)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function field($name)
    {
        $condition = $this->conditionBuilder->field($name);
        return $this->addCondition($condition);
    }
    
    public function compare($field, $operator, $targetField)
    {
        $condition = $this->conditionBuilder->compare(
            $field,
            $operator,
            $targetField
        );
        
        return $this->addCondition($condition);
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
}