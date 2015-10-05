<?php

namespace PHPixie\Tests\Validate\Filters;

/**
 * @coversDefaultClass \PHPixie\Validate\Filters\Filter
 */ 
class FilterTest extends \PHPixie\Test\Testcase
{
    protected $filters;
    protected $name      = 'pixie';
    protected $arguments = array('trixie');
    
    public function setUp()
    {
        $this->filters = $this->quickMock('\PHPixie\Validate\Filters');
        
        $this->filter = new \PHPixie\Validate\Filters\Filter(
            $this->filters,
            $this->name,
            $this->arguments
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::check
     * @covers ::<protected>
     */
    public function testCheck()
    {
        foreach(array(true, false) as $result) {
            $this->method($this->filters, 'callFilter', $result, array($this->name, 5, $this->arguments), 0);
            $this->assertSame($result, $this->filter->check(5));
        }
    }

}