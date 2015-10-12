<?php

namespace PHPixie\Tests\Validate;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors
 */ 
class ErrorsTest extends \PHPixie\Test\Testcase
{
    protected $errors;
    
    public function setUp()
    {
        $this->errors = new \PHPixie\Validate\Errors();
    }
    
    public function testRequired()
    {
        
    }
}