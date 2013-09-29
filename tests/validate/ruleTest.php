<?php

class Rule_Test extends PHPUnit_Framework_TestCase {
	
	protected $ruleset;
	protected $pixie;
	protected $rule;
	
	public function setUp() {
		$this->pixie = new \PHPixie\Pixie;
		$this->ruleset = $this->getMock('\PHPixie\Validate\Ruleset', array('validate'));
		$this->ruleset
					->expects($this->any())
					->method('validate')
					->will($this->onConsecutiveCalls(
						true, true, false
					));
		$this->rule = new \PHPixie\Validate\Rule($this->ruleset, 'test');
	}
	
	public function testValidate(){
		$this->assertEquals(true, $this->rule->validate('test', null));
		$rule = new \PHPixie\Validate\Rule($this->ruleset, '!test');
		$this->assertEquals(false, $rule-> validate('test', null));
		$this->assertEquals(false, $this->rule->validate('test', null));
	}
	
	public function testParams() {
		$this->ruleset
				->expects($this->any())
				->method('validate')
				->with('test', array(1,2), 'one', null);
		$this->rule->params(array(1,2));
		$this->assertEquals(true, $this->rule->validate(null, 'one'));
	}
	
}