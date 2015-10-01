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
    
    public function validate($sliceData)
    {
        $value = $sliceData->get();
        foreach($this->filters as $filter) {
            if(!$filter->validate($value)) {
                return $this->errors()->field();
            }
        }
    }
    
    public function filter($name, $parameters = array(), $negate = true)
    {
        $filter = $this->filterBuilder->filter($name, $arguments, $negate);
        $this->filters[]= $filter;
        return $this;
    }
    
    public function __call($method, $arguments)
    {
        return $this->filter($method, $arguments);
    }
}