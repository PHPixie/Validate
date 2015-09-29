<?php

namespace PHPixie\Validate\Filters;

class Filter
{
    protected $name;
    protected $parameters;
    
    public function __construct($name, $parameters)
    {
        $this->name       = $name;
        $this->parameters = $parameters;
    }
}