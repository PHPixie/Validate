<?php

namespace PHPixie\Tests\Validate\Values;

/**
 * @coversDefaultClass \PHPixie\Validate\Values\Result
 */ 
class ResultTest extends \PHPixie\Test\Testcase
{
    protected $values;
    protected $errors;
    protected $result;
    
    public function setUp()
    {
        $this->values = $this->quickMock('\PHPixie\Validate\Values');
        $this->errors = $this->quickMock('\PHPixie\Validate\Errors');
        
        $this->result = new \PHPixie\Validate\Values\Result(
            $this->values,
            $this->errors
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
}