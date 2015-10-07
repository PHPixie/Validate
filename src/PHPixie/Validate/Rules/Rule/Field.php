<?php

namespace PHPixie\Validate\Rules\Rule;

class Field extends \PHPixie\Validate\Rules\Rule
{
    protected $condition;
    
    public function __construct($condition)
    {
        $this->condition = $condition;
    }
    
    public function validate($sliceData, $result)
    {
        $error = $this->condition->getError($sliceData);
        
        if($error === null) {
            return;
        }
        
        if($this->errorMessage !== null) {
            $error = $this->errorMessage;
        }
        
        $field = $condition->field();
        
        if($this->throwOnError) {
            throw new \PHPixie\Validate\Exception("Invalid field '$field': $error");
        }
        
        $error = $this->errors->field($field, $this->errorMessage);
        $result->addError($error);
    }
    
    public function filled()
    {
        $this->condition->filled();
        return $this;
    }
    
    public function _empty()
    {
        $this->condition->_empty();
        return $this;
    }
    
    public function filters($filters)
    {
        $this->condition->filters($filters);
        return $this;
    }
    
    public function filter($name, $parameters = array())
    {
        $this->condition->filter($name, $parameters);
        return $this;
    }
    
    public function __call($method, $arguments)
    {
        if($method === 'empty') {
            return $this->_empty();
        }
        
        return $this->filter($method, $arguments);
    }
}