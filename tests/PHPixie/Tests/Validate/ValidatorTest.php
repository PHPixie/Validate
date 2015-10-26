<?php

namespace PHPixie\Tests\Validate;

/**
 * @coversDefaultClass \PHPixie\Validate\Validator
 */
class ValidatorTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    protected $rule;
    
    public function setUp()
    {
        $this->builder = $this->quickMock('\PHPixie\Validate\Builder');
        $this->rule    = $this->quickMock('\PHPixie\Validate\Rules\Rule');
        
        $this->validator = new \PHPixie\Validate\Validator(
            $this->builder,
            $this->rule
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
     * @covers ::rule
     * @covers ::<protected>
     */
    public function tetsRule()
    {
        $this->assertSame($this->rule, $this->validator->rule());
    }
    
    /**
     * @covers ::validate
     * @covers ::<protected>
     */
    public function testValidate()
    {
        $this->validateTest(false);
        $this->validateTest(true);
    }
    
    protected function validateTest($withResult)
    {
        $result = $this->quickMock('\PHPixie\Validate\Result');
        
        $args = array('pixie');
        if($withResult) {
            $args[]= $result;
        }else{
            $this->method($this->builder, 'result', $result, array(), 0);
        }
        
        $this->method($this->rule, 'validate', null, array('pixie', $result), 0);
        
        $return = call_user_func_array(array($this->validator, 'validate'), $args);
        $this->assertSame($result, $return);
    }
}
