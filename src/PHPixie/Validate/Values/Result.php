<?php

namespace PHPixie\Validate\Values;

class Result
{
    protected $values;
    protected $errors;
    
    public function __construct($values, $errors)
    {
        $this->values = $values;
        $this->errors = $errors;
    }
    
    public function errors()
    {
        return $this->errors;
    }
    
    public function fieldResults()
    {
        return $this->fieldResults;
    }
    
    public function invalidFieldResults()
    {
        $invalidFields = array();
        
        foreach($this->fieldResults() as $field => $result) {
            if(!$result->isValid()) {
                $invalidFields[$field] = $result;
            }
        }
        
        return $invalidFields;
    }
    
    public function isValid()
    {
        if(!empty($this->errors)) {
            return false;
        }
        
        return count($this->invalidFields()) === 0;
    }
    
    public function addFilterError($filterName)
    {
    
    }
    
    public function addMessageError()
    {
    
    }
    
    public function addError()
    {
    
    }
    
    public function addEmptyError()
    {
        
    }
    
    public function addArrayTypeError()
    {
        
    }
    
    public function addScalarTypeError()
    {
        
    }
}