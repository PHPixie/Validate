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
     * @covers ::validate
     * @covers ::<protected>
     */
    public function testValidate()
    {
        $result = $this->quickMock('\PHPixie\Validate\Result');
        $this->method($this->builder, 'result', $result, array(), 0);
        
        $this->method($this->rule, 'validate', null, array('pixie', $result), 0);
        $this->assertSame($result, $this->validator->validate('pixie'));
    }
}
