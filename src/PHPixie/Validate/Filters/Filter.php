<?php

namespace PHPixie\Validate\Filters;

class Filter
{
    protected $filters;
    protected $name;
    protected $arguments;
    protected $negate = false;
    
    public function __construct($filters, $name, $arguments = array(), $negate = false)
    {
        $this->filters   = $filters;
        $this->name      = $name;
        $this->arguments = $arguments;
        $this->negate    = $negate;
    }
    
    public function check($value)
    {
        $result = $this->filters->callFilter(
            $this->name,
            $value,
            $this->arguments
        );
        
        return ($result xor $this->negate);
    }
}