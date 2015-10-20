<?php

namespace PHPixie\Tests\Validate\Rules\Rule;

class Callback{
    public function __invoke()
    {
        
    }
}

/**
 * @coversDefaultClass \PHPixie\Validate\Rules\Rule\Value
 */ 
class ValueTest extends \PHPixie\Test\Testcase
{
    protected $rules;
    protected $value;
    
    public function setUp()
    {
        $this->rules = $this->quickMock('\PHPixie\Validate\Rules');
        $this->value = $this->value();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::required
     * @covers ::isRequired
     * @covers ::<protected>
     */
    public function testRequired()
    {
        $this->assertSame(false, $this->value->isRequired());
        
        $this->assertSame($this->value, $this->value->required());
        $this->assertSame(true, $this->value->isRequired());
        
        $this->assertSame($this->value, $this->value->required(false));
        $this->assertSame(false, $this->value->isRequired());
    }
    
    /**
     * @covers ::addRule
     * @covers ::rules
     * @covers ::<protected>
     */
    public function testRules()
    {
        $rules = array();
        for($i=0; $i<2; $i++) {
            $rule = $this->getRule();
            $rules[]= $rule;
            $this->assertSame($this->value, $this->value->addRule($rule));
        }
        
        $this->assertSame($rules, $this->value->rules());
    }
    
    /**
     * @covers ::arrayOf
     * @covers ::addArrayOf
     * @covers ::<protected>
     */
    public function testArrayOf()
    {
        $this->arrayOfTest(false, false);
        $this->arrayOfTest(false, true);
        $this->arrayOfTest(true, false);
        $this->arrayOfTest(true, true);
    }
    
    protected function arrayOfTest($isAdd, $withCallback)
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule\Structure\ArrayOf');
        $this->method($this->rules, 'arrayOf', $rule, array(), 0);
        
        if($isAdd) {
            $method = 'addArrayOf';
            $expect = $rule;
        }else{
            $method = 'arrayOf';
            $expect = $this->value;
        }
        
        $args = array();
        if($withCallback) {
            $args[]= $this->ruleCallback($rule);
        }
        
        $this->assertRuleBuilder($method, $args, $rule, $isAdd);
    }
    
    /**
     * @covers ::document
     * @covers ::addDocument
     * @covers ::<protected>
     */
    public function testDocument()
    {
        $this->documentTest(false, false);
        $this->documentTest(false, true);
        $this->documentTest(true, false);
        $this->documentTest(true, true);
    }
    
    protected function documentTest($isAdd, $withCallback)
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule\Structure\Document');
        $this->method($this->rules, 'document', $rule, array(), 0);
        
        if($isAdd) {
            $method = 'addDocument';
            $expect = $rule;
        }else{
            $method = 'document';
            $expect = $this->value;
        }
        
        $args = array();
        if($withCallback) {
            $args[]= $this->ruleCallback($rule);
        }
        
        $this->assertRuleBuilder($method, $args, $rule, $isAdd);
    }
    
    /**
     * @covers ::filter
     * @covers ::addFilter
     * @covers ::<protected>
     */
    public function testFilter()
    {
        $this->filterTest(false, null);
        $this->filterTest(false, 'string');
        $this->filterTest(true, 'callback');
        $this->filterTest(true, 'array');
    }
    
    protected function filterTest($isAdd, $argumentType)
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule\Filter');
        $this->method($this->rules, 'filter', $rule, array(), 0);
        
        if($isAdd) {
            $method = 'addFilter';
            $expect = $rule;
        }else{
            $method = 'filter';
            $expect = $this->value;
        }
        
        $args = array();
        
        if($argumentType === 'string') {
            $args[]= 'pixie';
            $this->method($rule, 'filter', null, array('pixie'), 0);
            
        }elseif($argumentType === 'callback') {
            $args[]= $this->ruleCallback($rule);
            
        }elseif($argumentType === 'array') {
            $args[]= array('pixie');
            $this->method($rule, 'filters', null, array(array('pixie')), 0);
        }
        
        $this->assertRuleBuilder($method, $args, $rule, $isAdd);
    }
    
    /**
     * @covers ::addFilter
     * @covers ::<protected>
     */
    public function testAddFilterException()
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule\Filter');
        $this->method($this->rules, 'filter', $rule, array(), 0);
        
        $value = $this->value;
        $this->assertException(function() use($value) {
            $value->addFilter(new \stdClass());
        }, '\PHPixie\Validate\Exception');
    }
    
    protected function assertRuleBuilder($method, $args, $rule, $isAdd)
    {
        $expect = $isAdd ? $rule : $this->value;
        
        $result = call_user_func_array(array($this->value, $method), $args);
        $this->assertSame($expect, $result);
        
        $rules = $this->value->rules();
        $this->assertSame($rule, end($rules));    
    }
    
    /**
     * @covers ::validate
     * @covers ::<protected>
     */
    public function testValidate()
    {
        $this->validateTest(false);
        $this->validateTest(true);
        $this->validateTest(true, true);
    }
    
    protected function validateTest($isEmpty = false, $isRequired = false)
    {
        $this->value = $this->value();
        
        if($isRequired) {
            $this->value->required();
        }
        
        $rules = array();
        for($i=0; $i<2; $i++) {
            $rule = $this->getRule();
            $rules[]= $rule;
            $this->value->addRule($rule);
        }
        
        $value  = $isEmpty ? '' : 5;
        $result = $this->quickMock('\PHPixie\Validate\Values\Result');
        
        if($isEmpty) {
            if($isRequired) {
                $this->method($result, 'addEmptyValueError', null, array(), 0);
            }
        }else{
            foreach($rules as $rule) {
                $this->method($rule, 'validate', null, array($value, $result), 0);
                $this->method($rule, 'validate', null, array($value, $result), 0);
            }
        }
        
        $this->value->validate($value, $result);
    }
    
    protected function ruleCallback($rule)
    {
        $callback = $this->quickMock('\PHPixie\Tests\Validate\Rules\Rule\Callback');
        $this->method($callback, '__invoke', null, array($rule), 0);
        return $callback;
    }
    
    protected function getRule()
    {
        return $this->quickMock('\PHPixie\Validate\Rules\Rule');   
    }
    
    protected function value()
    {
        return new \PHPixie\Validate\Rules\Rule\Value(
            $this->rules
        );
    }
}