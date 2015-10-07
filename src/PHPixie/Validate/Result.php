<?php

namespace PHPixie\Validate;

class Result
{
    protected $errors = array();
    protected $fieldErrors = array();
    
    public function addError($error)
    {
        if($error instanceof \PHPixie\Validate\Errors\Error\Field) {
            $this->fieldErrors[$error->field()] = $error;
        }
        
        $this->errors[] = $error;
    }
    
    public function fieldErrors($field)
    {
        if(array_key_exists($field, $this->fieldErrors)) {
            return $this->fieldErrors[$field];
        }
        
        return array();
    }
    
    public function isFieldValid($field)
    {
        $errors = $this->fieldErrors($field);
        return empty($errors);
    }
    
    public function errors()
    {
        return $this->errors;
    }
    
    public function isValid()
    {
        return empty($this->errors);
    }
}