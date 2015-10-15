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
    
    /**
     * @covers ::addEmptyValueError
     * @covers ::addFilterError
     * @covers ::addMessageError
     * @covers ::addCustomError
     * @covers ::addArrayTypeError
     * @covers ::addScalarTypeError
     * @covers ::addError
     * @covers ::errors
     * @covers ::<protected>
     */
    public function testAddErrors()
    {
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\EmptyValue');
        $this->method($this->errors, 'emptyValue', end($errors), array(), 0);
        $this->result->addEmptyValueError();
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\Filter');
        $this->method($this->errors, 'filter', end($errors), array('pixie'), 0);
        $this->result->addFilterError('pixie');
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\Message');
        $this->method($this->errors, 'message', end($errors), array('pixie'), 0);
        $this->result->addMessageError('pixie');
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\Custom');
        $this->method($this->errors, 'custom', end($errors), array('pixie', 'trixie'), 0);
        $this->result->addCustomError('pixie', 'trixie');
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\Custom');
        $this->method($this->errors, 'custom', end($errors), array('pixie', null), 0);
        $this->result->addCustomError('pixie');
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\ValueType\ArrayType');
        $this->method($this->errors, 'arrayType', end($errors), array(), 0);
        $this->result->addArrayTypeError();
        
        $errors[] = $this->quickMock('\PHPixie\Validate\Errors\Error\ValueType\ScalarType');
        $this->method($this->errors, 'scalarType', end($errors), array(), 0);
        $this->result->addScalarTypeError();
        
        $errors[] = $this->abstractMock('\PHPixie\Validate\Errors\Error');
        $this->result->addError(end($errors));
        
        $this->assertSame($errors, $this->result->errors());
    }
    
    /**
     * @covers ::field
     * @covers ::setField
     * @covers ::fieldResults
     * @covers ::<protected>
     */
    public function testField()
    {
        $results = array();
        
        $result = $this->resultMock();
        $this->method($this->values, 'result', $result, array(), 0);
        $results['pixie'] = $result;
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($result, $this->result->field('pixie'));
        }

        $result = $this->resultMock();
        $this->result->setFieldResult('trixie', $result);
        $results['trixie'] = $result;
        
        $this->assertSame($result, $this->result->field('trixie'));
        $this->assertSame($results, $this->result->fieldResults());
    }
    
    /**
     * @covers ::invalidFieldResults
     * @covers ::<protected>
     */
    public function testInvalidFieldResuls()
    {
        $expect = array();
        
        foreach(array('pixie', 'trixie', 'fairy') as $name) {
            $result = $this->resultMock();
            $this->result->setFieldResult($name, $result);
            
            $isValid = $name === 'pixie';
            $this->method($result, 'isValid', $isValid, array(), 0);
            
            if(!$isValid) {
                $expect[$name] = $result;
            }
        }
        
        $this->assertSame($expect, $this->result->invalidFieldResults());
    }
    
    protected function resultMock()
    {
        return $this->quickMock('\PHPixie\Validate\Values\Result');
    }
}