<?php

namespace PHPixie\Tests\Validate\Errors\Error;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\Filter
 */ 
class FilterTest extends \PHPixie\Tests\Validate\Errors\ErrorTest
{
    protected $type   = 'filter';
    protected $filter = 'email';
    
    /**
     * @covers ::filter
     * @covers ::<protected>
     */
    public function testFilter()
    {
        $this->assertSame($this->filter, $this->error->filter());
    }
    
    protected function prepareAsString()
    {
        return "{$this->type}-{$this->filter}";
    }
        
    protected function error()
    {
        return new \PHPixie\Validate\Errors\Error\Filter($this->filter);
    }
}