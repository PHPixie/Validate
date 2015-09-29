<?php

namespace PHPixie\Validate;

class Result
{
    protected $errors;
    
    public function __construct($errors = array())
    {
        $this->errors = $errors;
    }
    
    public function errors()
    {
        $this->errors();
    }
    
    public function isValid()
    {
        return empty($this->errors);
    }
}