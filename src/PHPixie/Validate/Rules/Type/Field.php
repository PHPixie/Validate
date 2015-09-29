<?php

class Field
{
    protected $field;
    protected $filters;
    
    public function __construct($field)
    {
        $this->field = $field;
    }
    
    public function addFilter($name, $arguments = array())
    {
        $this->filters[]= $this->filterBuilder->filter(
            $name,
            $arguments
        );
    }
    
    public function validate($value)
    {
        foreach($this->filters as $filter) {
            if(!$this->filterBuilder->validate($filter, $value)) {
                return $this->errors->filter($field, $filter, $value);
            }
        }
        
        return null;
    }
    
    public function __call($method, $name)
    {
        return $this->addFilter($name, $arguments);
    }
}