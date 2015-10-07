<?php

namespace PHPixie\Tests\Validate;

/**
 * @coversDefaultClass \PHPixie\Validate\Conditions
 */ 
class ConditionsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    
    protected $conditions;
    
    protected $filters;
    
    public function setUp()
    {
        $this->builder = $this->quickMock('\PHPixie\Validate\Builder');
        
        $this->conditions = new \PHPixie\Validate\Conditions($this->builder);
        
        $this->filters = $this->quickMock('\PHPixie\Validate\Filters');
        $this->method($this->builder, 'filters', $this->filters, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::field
     * @covers ::<protected>
     */
    public function testField()
    {
        $condition = $this->conditions->field('pixie');
        $class = '\PHPixie\Validate\Conditions\Condition\Field';
        $this->assertInstance($condition, $class, array(
            'field'         => 'pixie',
            'filterBuilder' => $this->filters
        ));
    }
    
    /**
     * @covers ::callback
     * @covers ::<protected>
     */
    public function testCallback()
    {
        $callback = array('pixie', 'trixie');
        
        $condition = $this->conditions->callback($callback);
        $class = '\PHPixie\Validate\Conditions\Condition\Callback';
        $this->assertInstance($condition, $class, array(
            'callback' => $callback
        ));
    }
    
    /**
     * @covers ::isValid
     * @covers ::<protected>
     */
    public function testIsValid()
    {
        $class = '\PHPixie\Validate\Conditions\Condition\IsValid';
        
        $condition = $this->conditions->isValid('pixie');
        $this->assertInstance($condition, $class, array(
            'field' => 'pixie'
        ));
        
        $condition = $this->conditions->isValid();
        $this->assertInstance($condition, $class, array(
            'field' => null
        ));
    }
    
    /**
     * @covers ::container
     * @covers ::<protected>
     */
    public function testContainer()
    {
        $container = $this->conditions->container();
        $class = '\PHPixie\Validate\Conditions\Container';
        $this->assertInstance($container, $class, array(
            'conditionBuilder' => $this->conditions
        ));
    }
}