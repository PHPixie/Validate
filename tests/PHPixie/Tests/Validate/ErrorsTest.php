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
    
    /**
     * @covers ::error
     * @covers ::<protected>
     */
    public function testError()
    {
        $class = '\PHPixie\Validate\Errors\Error\Implementation';
        
        $error = $this->errors->error('pixie', 'trixie');
        $this->assertInstance($error, $class, array(
            'type'        => 'pixie',
            'stringValue' => 'trixie'
        ));
        
        $error = $this->errors->error('pixie');
        $this->assertInstance($error, $class, array(
            'type'        => 'pixie',
            'stringValue' => null
        ));
    }
    
    /**
     * @covers ::emptyValue
     * @covers ::<protected>
     */
    public function testEmptyValue()
    {
        $this->assertInstance(
            $this->errors->emptyValue(),
            '\PHPixie\Validate\Errors\Error\EmptyValue'
        );
    }
    
    /**
     * @covers ::filter
     * @covers ::<protected>
     */
    public function testFilter()
    {
        $error = $this->errors->filter('pixie');
        $this->assertInstance($error, '\PHPixie\Validate\Errors\Error\Filter', array(
            'filter' => 'pixie'
        ));
    }
    
    /**
     * @covers ::message
     * @covers ::<protected>
     */
    public function testMessage()
    {
        $error = $this->errors->message('pixie');
        $this->assertInstance($error, '\PHPixie\Validate\Errors\Error\Message', array(
            'message' => 'pixie'
        ));
    }
    
    /**
     * @covers ::arrayType
     * @covers ::<protected>
     */
    public function testArrayType()
    {
        $this->assertInstance(
            $this->errors->arrayType(),
            '\PHPixie\Validate\Errors\Error\ValueType\ArrayType'
        );
    }
    
    /**
     * @covers ::scalarType
     * @covers ::<protected>
     */
    public function testScalarType()
    {
        $this->assertInstance(
            $this->errors->scalarType(),
            '\PHPixie\Validate\Errors\Error\ValueType\Scalar'
        );
    }
}