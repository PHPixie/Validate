<?php

namespace PHPixie\Validate;

class Conditions
{
    protected $builder;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function field($name)
    {
        return new Conditions\Condition\Field(
            $this->builder->filters(),
            $name
        );
    }
    
    public function callback($callback)
    {
        return new Conditions\Condition\Callback($callback);
    }
    
    public function container()
    {
        return new Conditions\Container($this);
    }
}