<?php

namespace PHPixie\Tests\Validate\Conditions\Condition;

/**
 * @coversDefaultClass \PHPixie\Validate\Conditions\Condition\Callback
 */ 
class CallbackTest extends \PHPixie\Test\Testcase
{
    protected $callback;
    protected $condition;
    
    public function setUp()
    {
        $this->callback = function ($sliceData) {
            return $sliceData->get('value') === 5;
        };
        
        $this->condition = new \PHPixie\Validate\Conditions\Condition\Callback(
            $this->callback
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
        foreach(array(true, false) as $isValid) {
            $sliceData = $this->quickMock('\PHPixie\Slice\Data');
            $value = $isValid ? 5 : 6;
            $this->method($sliceData, 'get', $value, array(), 0);
            
            $result = $this->condition->validate($sliceData);
            $this->assertSame($isValid, $result);
        }
    }
}