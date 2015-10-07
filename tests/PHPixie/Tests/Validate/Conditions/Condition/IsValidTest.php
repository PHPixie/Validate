<?php

namespace PHPixie\Tests\Validate\Conditions\Condition;

/**
 * @coversDefaultClass \PHPixie\Validate\Conditions\Condition\IsValid
 */ 
class ValidTest extends \PHPixie\Test\Testcase
{
    protected $field = 'pixie';
    
    public function setUp()
    {
        $this->condition = $this->condition($this->field);
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::check
     * @covers ::<protected>
     */
    public function testCheck()
    {
        foreach(array(false, true) as $withField) {
            foreach(array(false, true) as $isValid) {
                $this->checkTest($withField, $isValid);
                break;
            }
        }
    }
    
    protected function checkTest($withField, $isValid)
    {
        if($withField) {
            $condition = $this->condition;
        }else{
            $condition = $this->condition();
        }
        
        $sliceData = $this->quickMock('\PHPixie\Slice\Data');
        $result    = $this->quickMock('\PHPixie\Validate\Result');
        
        if($withField) {
            $this->method($result, 'isFieldValid', $isValid, array($this->field), 0);
        }else{
            $this->method($result, 'isValid', $isValid, array(), 0);
        }
        
        $result = $condition->check($sliceData, $result);
        $this->assertSame($isValid, $result);    
    }
    
    protected function condition($field = null)
    {
        return new \PHPixie\Validate\Conditions\Condition\IsValid($field);
    }
}