<?php

namespace PHPixie\Tests\Validate\Errors\Error;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\ArrayCount
 */
class ArrayCountTest extends \PHPixie\Tests\Validate\Errors\ErrorTest
{
    protected $type = 'arrayCount';
    
    protected $minCount = 3;
    protected $maxCount = 6;
    protected $count    = 5;
        
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructNoMinMax()
    {
        $this->assertException(function() {
            new \PHPixie\Validate\Errors\Error\ArrayCount(5);
        }, '\PHPixie\Validate\Exception');
    }
    
    /**
     * @covers ::count
     * @covers ::minCount
     * @covers ::maxCount
     * @covers ::<protected>
     */
    public function testAttributes()
    {
        foreach(array('count', 'minCount', 'maxCount') as $name) {
            $this->assertSame($this->$name, $this->error->$name());
        }
    }
    
    protected function prepareAsString()
    {
        return $this->type;
    }
        
    protected function error()
    {
        return new \PHPixie\Validate\Errors\Error\ArrayCount(
            $this->count,
            $this->minCount,
            $this->maxCount
        );
    }
}
