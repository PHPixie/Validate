<?php
class Validate_Test extends PHPUnit_Framework_TestCase {
	
	protected $validate;
	
	public function setUp() {
		$this->pixie = new \PHPixie\Pixie;
		$this->validate = new \PHPixie\Validate($this->pixie);
	}
	
	public function testGet(){
		$input = array(
			'one_fairy' => true,
			'two_fairies' => true,
			'three_fairies' => true,
			'four_fairies' => true
		);
		$validator = $this->validate->get($input);
		$this->assertEquals('PHPixie\Validate\Validator',get_class($validator));
		$this->assertAttributeEquals($input, 'input', $validator);
	}
	
	public function testRule() {
		$rule = $this->validate->rule('numeric');
		$this->assertEquals('PHPixie\Validate\Rule',get_class($rule));
		$this->assertEquals('numeric', $rule->type);
	}
	
	public function testField() {
		$field = $this->validate->field('one');
		$this->assertEquals('PHPixie\Validate\Field',get_class($field));
		$this->assertEquals('one', $field->name);
	}
	
	public function testBuild_Ruleset() {
		$ruleset = $this->validate->build_ruleset();
		$this->assertEquals('PHPixie\Validate\Ruleset',get_class($ruleset));
	}
	
	public function testRuleset() {
		$ruleset = $this->validate->ruleset();
		$this->assertEquals('PHPixie\Validate\Ruleset', get_class($ruleset));
		$this->assertEquals(true, $ruleset === $this->validate->ruleset());
	}
	
}