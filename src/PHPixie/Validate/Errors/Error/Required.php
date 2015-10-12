<?php

namespace PHPixie\Validate\Errors\Error;

class Required extends \PHPixie\Validate\Errors\Error
{
    public function type()
    {
        return 'required';
    }
    
    public function asString()
    {
        return $this->type();
    }
}