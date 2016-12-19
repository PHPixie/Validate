<?php

namespace PHPixie\Tests;

class ValidateCallback{
    public function __invoke()
    {
        
    }
}

/**
 * @coversDefaultClass \PHPixie\Validate
 */
class ValidateTest extends \PHPixie\Test\Testcase
{
    protected $validate;
    
    protected $builder;
    
    public function setUp()
    {
        $this->validate = $this->getMockBuilder('\PHPixie\Validate')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->builder = $this->quickMock('\PHPixie\Validate\Builder');
        $this->method($this->validate, 'buildBuilder', $this->builder, array(), 0);
        
        $this->validate->__construct();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::buildBuilder
     * @covers ::<protected>
     */
    public function testBuildBuilder()
    {
        $this->validate = new \PHPixie\Validate();
        
        $builder = $this->validate->builder();
        $this->assertInstance($builder, '\PHPixie\Validate\Builder');
    }
    
    /**
     * @covers ::builder
     * @covers ::<protected>
     */
    public function testBuilder()
    {
        $this->assertSame($this->builder, $this->validate->builder());
    }
    
    /**
     * @covers ::rules
     * @covers ::<protected>
     */
    public function testRules()
    {
        $rules = $this->prepareRules();
        $this->assertSame($rules, $this->validate->rules());
    }

    protected function prepareRules($at = 0)
    {
        $rules = $this->quickMock('\PHPixie\Validate\Rules');
        $this->method($this->builder, 'rules', $rules, array(), $at);
        return $rules;
    }
}
