<?php

namespace PHPixie\Tests\Validate;

/**
 * @coversDefaultClass \PHPixie\Validate\Builder
 */
class BuilderTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    
    public function setUp()
    {
        $this->builder = new \PHPixie\Validate\Builder();
    }
    
    /**
     * @covers ::errors
     * @covers ::<protected>
     */
    public function testErrors()
    {
        $this->instanceTest('errors');
    }
    
    /**
     * @covers ::filters
     * @covers ::<protected>
     */
    public function testFilters()
    {
        $this->instanceTest('filters');
    }
    
    /**
     * @covers ::rules
     * @covers ::<protected>
     */
    public function testRules()
    {
        $this->instanceTest('rules');
    }
    
    /**
     * @covers ::result
     * @covers ::<protected>
     */
    public function testResult()
    {
        $result = $this->builder->result();
        $this->assertInstance($result, '\PHPixie\Validate\Result', array(
            'builder' => $this->builder
        ));
    }
    
    /**
     * @covers ::validator
     * @covers ::<protected>
     */
    public function testValidator()
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule');
        $result = $this->builder->validator($rule);
        
        $this->assertInstance($result, '\PHPixie\Validate\Validator', array(
            'builder' => $this->builder,
            'rule'    => $rule,
        ));
    }
    
    protected function instanceTest($name, $attributes = array())
    {
        $instance = $this->builder->$name();
        $class    = '\PHPixie\Validate\\'.ucfirst($name);
        
        $this->assertInstance($instance, $class, $attributes);
        $this->assertSame($instance, $this->builder->$name());
    }
}
