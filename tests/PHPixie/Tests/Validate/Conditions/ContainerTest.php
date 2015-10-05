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