<?php

namespace PHPixie\Tests\Validate\Conditions;

/**
 * @coversDefaultClass \PHPixie\Validate\Conditions\Container
 */ 
class ContainerTest extends \PHPixie\Test\Testcase
{
    protected $conditions;
    
    protected $container;
    
    public function setUp()
    {
        $this->conditions = $this->quickMock('\PHPixie\Validate\Conditions');
        
        $this->container = new \PHPixie\Validate\Conditions\Container($this->conditions);
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::callback
     * @covers ::<protected>
     */
    public function testCallback()
    {
        $condition = $this->quickMock('\PHPixie\Validate\Conditions\Condition\Callback');
        
        $callback = 'pixie';
        $this->method($this->conditions, 'callback', $condition, array($callback), 0);
        
        $this->assertSame($this->container, $this->container->callback($callback));
        $this->assertSame(array($condition), $this->container->conditions());
    }
    
    /**
     * @covers ::addField
     * @covers ::<protected>
     */
    public function testAddField()
    {
        $condition = $this->prepareField('pixie');
        $this->assertSame($condition, $this->container->addField('pixie'));
    }
    
    /**
     * @covers ::field
     * @covers ::<protected>
     */
    public function testField()
    {
        $conditions = array();
        
        $condition = $this->prepareField('pixie');
        $conditions[]= $condition;
        
        $self = $this;
        $callable = function($parameter) use($self, $condition) {
            $self->assertSame($condition, $parameter);
        };
        
        $result = $this->container->field('pixie', $callable);
        $this->assertSame($this->container, $result);
        
        $condition = $this->prepareField('trixie');
        $conditions[]= $condition;
        
        $array = array('trixie');
        $this->method($condition, 'filters', null, array($array), 0);
        
        $result = $this->container->field('trixie', $array);
        $this->assertSame($this->container, $result);
        
        foreach(array(false, true) as $withParams) {
            $condition = $this->prepareField('blum');
            $conditions[]= $condition;
            
            $params = $withParams ? array(5, 4) : array();
            $this->method($condition, 'filter', null, array('rule', $params), 0);
            
            $arguments = array_merge(array('blum', 'rule'), $params);
            $result = call_user_func_array(array($this->container, 'field'), $arguments);
            $this->assertSame($this->container, $result);
        }
        
        $this->assertSame($conditions, $this->container->conditions());
    }
    
    protected function prepareField($field)
    {
        $condition = $this->quickMock('\PHPixie\Validate\Conditions\Condition\Field');
        $this->method($this->conditions, 'field', $condition, array($field), 0);
        return $condition;
    }
    
    /**
     * @covers ::addCondition
     * @covers ::conditions
     * @covers ::<protected>
     */
    public function testConditions()
    {
        $conditions = $this->prepareConditions();
        $this->assertSame($conditions, $this->container->conditions());
    }
    
    /**
     * @covers ::check
     * @covers ::<protected>
     */
    public function testCheck()
    {
        $sliceData  = $this->quickMock('\PHPixie\Slice\Data');
        $conditions = $this->prepareConditions();
        
        foreach(array(true, false) as $expects) {
            foreach($conditions as $key => $condition) {
                if(!$expects && $key > 3) {
                    continue;
                }
                
                $isValid = $expects || $key !== 3;
                $this->method($condition, 'check', $isValid, array($sliceData), 0);
            }
            
            $this->assertSame($expects, $this->container->check($sliceData));
        }
    }
    
    protected function prepareConditions()
    {
        $conditions = array();
        
        for($i=0; $i<5; $i++) {
            $condition = $this->quickMock('\PHPixie\Validate\Conditions\Condition');
            $this->container->addCondition($condition);
            $conditions[]= $condition;
        }
        
        return $conditions;
    }
}