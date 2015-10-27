<?php

namespace PHPixie\Validate\Errors\Error;

class Filter extends \PHPixie\Validate\Errors\Error
{
    protected $filter;
    
    public function __construct($filter)
    {
        $this->filter = $filter;
    }
    
    public function type()
    {
        return 'filter';
    }
    
    public function filter()
    {
        return $this->filter;
    }
    
    public function asString()
    {
        return $this->filter;
    }
}
