<?php

namespace PHPixie\Validate\Errors;

class Error
{
    protected $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    public function message()
    {
        return $this->message;
    }
}