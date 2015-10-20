<?php

namespace PHPixie\Tests\Validate\Rules\Rule\Structure;

/**
 * @coversDefaultClass \PHPixie\Validate\Rules\Rule\Structure\Document
 */ 
class DocumentTest extends \PHPixie\Tests\Validate\Rules\RuleTest
{
    protected $rules;
    
    protected $document;
    
    protected function setUp()
    {
        $this->rules = $this->quickMock('\PHPixie\Validate\Rules');
        $this->document = $this->document();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::allowExtraFields
     * @covers ::extraFieldsAllowed
     * @covers ::<protected>
     */
    public function testAllowExtraFields()
    {
        $this->assertSame(false, $this->document->extraFieldsAllowed());
        
        $this->assertSame($this->document, $this->document->allowExtraFields());
        $this->assertSame(true, $this->document->extraFieldsAllowed());
        
        $this->assertSame($this->document, $this->document->allowExtraFields(false));
        $this->assertSame(false, $this->document->extraFieldsAllowed());
    }
    
    /**
     * @covers ::setFieldRule
     * @covers ::fieldRules
     * @covers ::<protected>
     */
    public function testFieldRules()
    {
        $rules = array();
        for($i=0; $i<2; $i++) {
            $rule = $this->getRule();
            $rules['pixie'.$i]= $rule;
            $result = $this->document->setFieldRule('pixie'.$i, $rule);
            $this->assertSame($this->document, $result);
        }
        
        $this->assertSame($rules, $this->document->fieldRules());
    }
    
    /**
     * @covers ::field
     * @covers ::addField
     * @covers ::<protected>
     */
    public function testField()
    {
        $this->fieldTest(false, false);
        $this->fieldTest(false, true);
        $this->fieldTest(true, false);
        $this->fieldTest(true, true);
    }
    
    protected function fieldTest($isAdd, $withCallback)
    {
        $rule = $this->quickMock('\PHPixie\Validate\Rules\Rule\Value');
        $this->method($this->rules, 'value', $rule, array(), 0);
        
        if($isAdd) {
            $method = 'addField';
            $expect = $rule;
        }else{
            $method = 'field';
            $expect = $this->document;
        }
        
        $args = array();
        if($withCallback) {
            $args[]= $this->ruleCallback($rule);
        }
        
        $this->assertRuleBuilder($method, $args, $rule, $isAdd);
    }
    
    protected function assertRuleBuilder($method, $args, $rule, $isAdd)
    {
        $expect = $isAdd ? $rule : $this->document;
        
        array_unshift($args, 'pixie');
        $result = call_user_func_array(array($this->document, $method), $args);
        $this->assertSame($expect, $result);
        
        $rules = $this->document->fieldRules();
        $this->assertSame($rule, end($rules));
        $this->assertSame('pixie', key($rules)); 
    }
    
    /**
     * @covers ::validate
     * @covers ::<protected>
     */
    public function testValidate()
    {
        $this->validateTest(false);
        
        $this->validateTest(true, false, false);
        $this->validateTest(true, true, false);
        $this->validateTest(true, false, true);
        $this->validateTest(true, true, true);
    }
    
    protected function validateTest($isArray, $allowExtraFields = false, $withExtraFields = false)
    {
        $this->document = $this->document();
        list($value, $result) = $this->prepareValidateTest(
            $isArray,
            $allowExtraFields,
            $withExtraFields
        );
        $this->document->validate($value, $result);
    }
    
    protected function prepareValidateTest($isArray, $allowExtraFields, $withExtraFields)
    {
        $result = $this->getResultMock();
        $resultAt = 0;
        
        if(!$isArray) {
            $this->method($result, 'addArrayTypeError', null, array(), $resultAt++);
            return array(5, $result);
        }
        
        $values = array();
        
        $this->document->allowExtraFields($allowExtraFields);
        
        $extraKeys = array('stella', 'blum');
        
        if($withExtraFields) {
            $values = array_fill_keys($extraKeys, 1);
        }else{
            $values = array();
        }
        
        if(!$allowExtraFields && $withExtraFields) {
            $this->method($result, 'addIvalidKeysError', null, array($extraKeys), $resultAt++);
        }
        
        $rules  = array();        
        foreach(array('fairy', 'pixie', 'trixie') as $name) {
            $rule = $this->getRule();
            $rules[$name] = $rule;
            $this->document->setFieldRule($name, $rule);
            
            $fieldResult = $this->getResultMock();
            $this->method($result, 'field', $fieldResult, array($name), $resultAt++);
            if($name !== 'trixie') {
                $value = $name.'Value';
                $values[$name] = $value;
            }else{
                $value = null;
            }
            
            $this->method($rule, 'validate', null, array($value, $fieldResult), 0);
        }
        
        return array($values, $result);
    }
    
    protected function getResultMock()
    {
        return $this->quickMock('\PHPixie\Validate\Values\Result');
    }
    
    protected function document()
    {
        return new \PHPixie\Validate\Rules\Rule\Structure\Document(
            $this->rules
        );
    }
}