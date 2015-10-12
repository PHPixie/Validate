<?php

namespace PHPixie\Tests\Validate\Errors\Error;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\Required
 */ 
class RequiredTest extends \PHPixie\Tests\Validate\Errors\ErrorTest
{
    protected $type = 'required';
    
    protected function prepareAsString()
    {
        return $this->type;
    }
        
    protected function error()
    {
        return new \PHPixie\Validate\Errors\Error\Required();
    }
}