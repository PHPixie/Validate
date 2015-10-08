<?php

namespace PHPixie\Validate\Conditions\Condition;

class IsValid implements \PHPixie\Validate\Conditions\Condition
{
    protected $field;
    
    public function __construct($field = null)
    {
        $this->field = $field;
    }
    
    public function check($sliceData, $result = 25)
    {
        if($this->field !== null) {
            return $result->isFieldValid($this->field);
        }
        
        return $result->isValid();
    }
}