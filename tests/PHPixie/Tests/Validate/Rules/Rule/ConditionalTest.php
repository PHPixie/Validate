<?php

namespace PHPixie\Tests\Validate\Rules\Rule;

/**
 * @coversDefaultClass \PHPixie\Validate\Rules\Rule\Conditional
 */ 
class ConditionalTest extends \PHPixie\Test\Testcase
{
    protected $conditionContainer;
    protected $ruleContainer;
    
    protected $rule;
    
    public function setUp()
    {
        $this->conditionContainer = $this->quickMock('\PHPixie\Validate\Conditions\Container');
        $this->ruleContainer = $this->quickMock('\PHPixie\Validate\Rules\Container');
        
        $this->rule = new \PHPixie\Validate\Rules\Rule\Conditional(
            $this->conditionContainer,
            $this->ruleContainer
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
     * @covers ::conditionContainer
     * @covers ::<protected>
     */
    public function testConditionContainer()
    {
        $this->assertSame($this->conditionContainer, $this->rule->conditionContainer());
    }
    
    /**
     * @covers ::ruleContainer
     * @covers ::<protected>
     */
    public function testRuleContainer()
    {
        $this->assertSame($this->ruleContainer, $this->rule->ruleContainer());
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
    
    protected function validateTest($isValid)
    {
        $sliceData = $this->quickMock('\PHPixie\Slice\Data');
        $result    = $this->quickMock('\PHPixie\Validate\Result');
        
        $this->method($this->conditionContainer, 'check', $isValid, array($sliceData, $result), 0);
        
        if($isValid) {
            $this->method($this->ruleContainer, 'validate', null, array($sliceData, $result), 0);
        }
        
        $this->rule->validate($sliceData, $result);
    }
}