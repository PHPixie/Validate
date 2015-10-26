<?php

namespace PHPixie\Validate;

class Validator
{
    protected $builder;
    protected $rule;
    
    public function __construct($builder, $rule)
    {
        $this->builder = $builder;
        $this->rule    = $rule;
    }
    
    public function rule()
    {
        return $this->rule;
    }
    
    public function validate($value, $result = null)
    {
        if($result === null) {
            $result = $this->builder->result();
        }
        $this->rule->validate($value, $result);
        return $result;
    }
}
