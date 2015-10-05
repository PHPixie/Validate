<?php

namespace PHPixie\Validate\Rules\Rule;

class Conditional implements \PHPixie\Validate\Rules\Rule
{
    protected $conditions;
    
    public function __construct($conditions)
    {
        $this->conditions = $conditions;
    }
    
    public function conditions()
    {
        return $this->conditions;
    }
    
    
}