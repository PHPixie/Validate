<?php

namespace PHPixie\Validate\Conditions\Condition;

class Field implements \PHPixie\Validate\Conditions\Condition
{
    protected $filterBuilder;
    protected $field;
    protected $filters = array();
    
    public function __construct($filterBuilder, $field)
    {
        $this->filterBuilder = $filterBuilder;
        $this->field         = $field;
    }
    
    public function check($sliceData)
    {
        
        return $this->checkData($sliceData) === null;
    }
    
    public function checkData($sliceData)
    {
        $value = $sliceData->get($this->field);
        $isEmpty = $value === null || $value === '';
        
        if($this->assertFilled && $isEmpty) {
            return 'filled';
        }
        
        if($this->assertEmpty && !$isEmpty) {
            return 'empty';
        }
        
        if(!$isEmpty) {
            foreach($this->filters as $filter) {
                if(!$filter->check($value)) {
                    return $filter->name();
                }
            }
        }
    }
    
    public function filled()
    {
        $this->assertFilled = true;
        return $this;
    }
    
    public function _empty()
    {
        $this->assertEmpty = true;
        return $this;
    }
    
    public function getAssertFilled()
    {
        return $this->assertFilled;
    }
    
    public function getAssertEmpty()
    {
        return $this->assertEmpty;
    }
    
    public function filters($filters)
    {
        foreach($filters as $key => $value) {
            if(is_numeric($key)) {
                $name       = $value;
                $parameters = array();
            
            }else{
                $name       = $key;
                $parameters = $value;
            }
            
            $this->addFilter($name, $parameters);
        }
        
        return $this;
    }
    
    public function filter($name, $parameters = array())
    {
        $this->addFilter($name, $parameters);
        return $this;
    }
    
    public function getFilters()
    {
        return $this->filters;
    }
    
    protected function addFilter($name, $parameters)
    {
        $filter = $this->filterBuilder->filter(
            $name,
            $parameters
        );
        
        $this->filters[]= $filter;
    }
    
    public function __call($method, $arguments)
    {
        if($method === 'empty') {
            return $this->_empty();
        }
        
        return $this->filter($method, $arguments);
    }
}

