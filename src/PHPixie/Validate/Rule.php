<?php

namespace PHPixie\Validate;

class Rule
{
    protected $condition;
    protected $conditions;
    
    public function __construct($condition)
    {
        $this->condition = $condition;
    }
    
    public function addCondition($condition)
    {
        $this->conditions[]= $condition;
    }
    
    public function validate($sliceData)
    {
        foreach($this->conditions as $condition) {
            $result = $condition->validate($sliceData);
            if(!empty($result)) {
                return array();
            }
        }
        
        $result = $this->condition->validate($sliceData);
        if(empty($result)) {
            return null;
        }
        
        if($this->errorMessage !== null) {
            $error = $this->validate->error($this->errorMessage);
        }else{
            $error = current($result);
        }
        
        if($this->throwOnError) {
            throw new \PHPixie\Validate\Exception($error->message());
        }
    }
    
    public function message($message)
    {
        $this->errorMessage = $message;
        return $this;
    }
    
    public function throwOnError($throw = false)
    {
        $this->throwOnError = $throw;
        return $this;
    }
}