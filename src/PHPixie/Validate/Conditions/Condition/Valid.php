<?php

namespace PHPixie\Validate\Conditions\Condition;

class Valid implements \PHPixie\Validate\Conditions\Condition
{
    protected $negate;
    protected $field;
    
    public function __construct($negate = false, $field = null)
    {
        $this->negate = $negate;
        $this->field  = $field;
    }
    
    public function check($sliceData, $result)
    {
        if($this->field === null) {
            $isValid = $result->isValid();
        
        }else{
            $isValid = $result->isFieldValid($this->field);
        }
        
        return !($isValid xor $this->negate);
    }
}