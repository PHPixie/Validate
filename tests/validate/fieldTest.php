<?php

class Fieldset_Test extends PHPUnit_Framework_TestCase {
	
	protected $pixie;
	protected $rule;
	protected $validator;
	protected $conditions;
	
	public function setUp() {
		$this->pixie = $this->getMock('\PHPixie\Pixie');
		$this->pixie-> validate = $this->getMock('\PHPixie\Validate', array('rule','field'), array(), '', false);
		$this->validator = $this->getMock('\PHPixie\Validate\Validator', array(),array(),'',false);
		$this->rule = $this->getRule('one', true);
		$this->pixie-> validate
							->expects($this->any())
							->method('rule')
							->will($this->onConsecutiveCalls(
								$this->rule,
								$this->getRule('two', false),
								$this->getRule('three', false)
							));
		$this->conditions = array(
								$this->getCondition(true),
								$this->getCondition(false)
							);
		$this->pixie-> validate
							->expects($this->any())
							->method('field')
							->will($this->onConsecutiveCalls(
								$this->conditions[0],
								$this->conditions[1]
							));
		$this->field = new \PHPixie\Validate\Field($this->pixie, 'test', true);
	}
	
	public function testAttributes() {
		$this->assertEquals('test', $this->field->name);
		$this->assertEquals(true, $this->field->only_if_valid);
	}
	
	public function testRule() {
		$this->rule
			->expects($this->any())
            ->method('params')
            ->with ($this->equalTo(array(1, 2)));
		$this->field->rule('one', 1, 2);
	}
	
	public function testRules() {
		$this->field->rules('one', 'two');
		$rules = $this->readAttribute($this->field, 'rules');
		$this->assertEquals('one', $rules[0]->type);
		$this->assertEquals('two', $rules[1]->type);
	}
	
	public function testCondition() {
		$this->field->condition('test');
		$this->field->condition('test');
		$conditions = $this->readAttribute($this->field, 'conditions');
		$this->assertEquals($this->conditions[0], $conditions[0]);
		$this->assertEquals($this->conditions[1], $conditions[1]);
	}
	
	public function testError() {
		$this->field->error('test');
		$this->assertAttributeEquals('test', 'custom_error', $this->field);
	}
	
	public function testThrow() {
		$this->field->throw_on_error();
		$this->assertAttributeEquals(true, 'throw_on_error', $this->field);
	}
	
	public function testValidateTrue() {
		$this->field->rule('one');
		$this->assertEquals(true, $this->field->validate($this->validator));
		$this->assertEquals(true, empty($this->field->errors));
	}
	
	public function testValidateFalse() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->assertEquals(false, $this->field->validate($this->validator));
		$this->assertEquals('two', current($this->field->errors));
		$this->assertEquals(1, count($this->field->errors));
	}
	
	public function testValidateConditionTrue() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->field->condition('test');
		$this->assertEquals(false, $this->field->validate($this->validator));
		$this->assertEquals('two', current($this->field->errors));
		$this->assertEquals(1, count($this->field->errors));
	}
	
	
	public function testValidateConditionFalse() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->field->condition('test');
		$this->field->condition($this->getCondition(false));
		$this->assertEquals(true, $this->field->validate($this->validator));
		$this->assertEquals(true, empty($this->field->errors));
	}
	
	public function testCustomError() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->field
			->error('pixie')
			->condition('test');
		$this->assertEquals(false, $this->field->validate($this->validator));
		$this->assertEquals('pixie', current($this->field->errors));
		$this->assertEquals(1, count($this->field->errors));
	}
	
	public function testThrownException() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->field
			->error('pixie')
			->throw_on_error()
			->condition('test');
		$exception = false;
		try {
			$this->field->validate($this->validator);
		}catch (Exception $e) {
			$exception = $e->getMessage();
		}
		$this->assertEquals('pixie', $exception);
	}
	
	public function testThrownExceptionShortcut() {
		$this->field->rule('one');
		$this->field->rule('two');
		$this->field
			->throw_on_error('pixie')
			->condition('test');
		$exception = false;
		try {
			$this->field->validate($this->validator);
		}catch (Exception $e) {
			$exception = $e->getMessage();
		}
		$this->assertEquals('pixie', $exception);
	}
	
	public function testValidateAll() {
		$field = new \PHPixie\Validate\Field($this->pixie, 'test', false);
		$field->rule('one');
		$field->rule('two');
		$field->rule('three');
		$this->assertEquals(false, $field->validate($this->validator));
		$this->assertEquals('two', current($field->errors));
		$this->assertEquals('three', end($field->errors));
		$this->assertEquals(2, count($field->errors));
	}
	
	public function testValidateAllCustom() {
		$field = new \PHPixie\Validate\Field($this->pixie, 'test', false);
		$field->rule('one');
		$field->rule('two');
		$field->rule('three');
		$field->error('pixie');
		$this->assertEquals(false, $field->validate($this->validator));
		$this->assertEquals('pixie', current($field->errors));
		$this->assertEquals(1, count($field->errors));
	}
	
	public function testValidateAllException() {
		$field = new \PHPixie\Validate\Field($this->pixie, 'test', false);
		$field->rule('one');
		$field->rule('two');
		$field->rule('three');
		$field->error('pixie')->throw_on_error();
		$exception = false;
		try {
			$field->validate($this->validator);
		}catch (Exception $e) {
			$exception = $e->getMessage();
		}
		$this->assertEquals('pixie', $exception);
	}
	
	protected function getCondition($val) {
		$condition = $this->getMock('\PHPixie\Validate\Field', array('validate'),array(), '',false);
		$condition
				->expects($this->any())
				->method('validate')
				->with($this->validator)
				->will($this->returnValue($val));
		return $condition;
	}
	
	protected function getRule($type, $val){
		$rule = $this->getMock('\PHPixie\Validate\Rule',array('validate', 'params'),array(), '',false);
		$rule
				->expects($this->any())
				->method('validate')
				->with('test', $this->validator)
				->will($this->returnValue($val));
			
		$rule->type = $type;
		return $rule;
	}
	
}