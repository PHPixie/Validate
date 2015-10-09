<?php

namespace PHPixie\Validate\Rules\Rule;

class Value implements \PHPixie\Validate\Rules\Rule
{
    protected $filterBuilder;
    protected $filters = array();
    
    public function __construct($filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
    }
    
    public function filter($name, $parameters = array())
    {
        $this->addFilter($name, $parameters);
        return $this;
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
    
    protected function addFilter($name, $parameters)
    {
        $filter = $this->filterBuilder->filter(
            $name,
            $parameters
        );
        
        $this->filters[]= $filter;
    }
    
    public function getFilters()
    {
        return $this->filters;
    }
    
    public function validateValue($array, $result)
    {
        foreach($this->filters as $filter) {
            if(!$filter->check($value)) {
                $result->filterError($filter);
                break;
            }
        }
    }
    
    public function __call($method, $arguments)
    {
        return $this->filter($method, $arguments);
    }
}