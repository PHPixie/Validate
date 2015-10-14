<?php

namespace PHPixie\Tests\Validate\Errors\Error;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\Implementation
 */ 
class ImplementationTest extends \PHPixie\Tests\Validate\Errors\ErrorTest
{
    protected $type        = 'pixie';
    protected $stringValue = 'fairy';
    
    protected function prepareAsString()
    {
        return $this->stringValue;
    }
    
    /**
     * @covers ::asString
     * @covers ::<protected>
     */
    public function testAsStringNoValue()
    {
        $this->error = new \PHPixie\Validate\Errors\Error\Implementation(
            $this->type
        );
        
        $this->assertSame($this->type, $this->error->asString());
    }
    
    protected function error()
    {
        return new \PHPixie\Validate\Errors\Error\Implementation(
            $this->type,
            $this->stringValue
        );
    }
}