<?php

namespace PHPixie\Validate\Conditions\Condition;

class Field implements \PHPixie\Validate\Conditions\Condition
{
    protected $field;
    protected $filters = array();
    
    public function __construct($field, $filters)
    {
        $this->field   = $field;
        $this->filters = $filters;
    }
    
    public function buildFilter($field, $arguments = array())
    {
        $filter = $this->builder->filter($field, $arguments);
        $this->filters[]= $filter;
        return $this;
    }
    
    public function __call($method, $arguments)
    {
        return $this->buildFilter($method, $arguments);
    }
    
    public function validate($sliceData)
    {
        $value = $sliceData->get($this->field);
        
        if(in_array($value, array(null, ''))) {
            if(!$this->isRequired) {
                return array();
            }
            
            return $this->error();
        }
        
        foreach($this->filters as $filter) {
            $error = $filter->check($value);
        }
        
        
    }
}