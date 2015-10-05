<?php

namespace PHPixie\Validate\Filters;

class Filter
{
    protected $filters;
    protected $name;
    protected $arguments;
    
    public function __construct($filters, $name, $arguments = array())
    {
        $this->filters   = $filters;
        $this->name      = $name;
        $this->arguments = $arguments;
    }
    
    public function check($value)
    {
        return $this->filters->callFilter(
            $this->name,
            $value,
            $this->arguments
        );
    }
}