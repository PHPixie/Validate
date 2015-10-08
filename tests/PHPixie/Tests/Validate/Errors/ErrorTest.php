<?php

namespace PHPixie\Tests\Validate\Errors;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error
 */ 
class ErrorTest extends \PHPixie\Test\Testcase
{
    protected $message = 'trixie';
    
    public function setUp()
    {
        $this->error = $this->error();
    }
    
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::message
     * @covers ::<protected>
     */
    public function testMessage()
    {
        $this->assertSame($this->message, $this->error->message());
    }
    
    protected function error()
    {
        return new \PHPixie\Validate\Errors\Error($this->message);
    }
}