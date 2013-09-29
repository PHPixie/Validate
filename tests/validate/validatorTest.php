<?php
class Validator_Test extends PHPUnit_Framework_TestCase {
	
	protected $validator;
	
	public function setUp() {
		$this->pixie = new \PHPixie\Pixie;
		$this->pixie-> validate = $this->getMock('\PHPixie\Validate',array('field'),array($this->pixie));
		$this->pixie-> validate
							->expects($this->any())
							->method('field')
							->will($this->onConsecutiveCalls(
								$this->getField('one', true, array()),
								$this->getField('two', false, array('numeric')),
								$this->getField('one', false, array('alpha')),
								$this->getField('two', false, array('alpha'))
							));
		$this->validator = new \PHPixie\Validate\Validator($this->pixie, array(
			'one' => true,
			'two' => true,
			'three' => true,
			'four' => true
		));
	}
	
	public function testGet_Field() {
		$this->assertEquals(true, $this->validator->get('one'));
		$this->assertEquals(null, $this->validator->get('five'));
		$this->assertEquals(5, $this->validator->get('five', 5));
	}
	
	public function testInput() {
		$input = array(
			'one_fairy' => true,
			'two_fairies' => true,
			'three_fairies' => true,
			'four_fairies' => true
		);
		
		$this->validator->valid();
		$this->assertAttributeEquals(true, 'processed', $this->validator);
		$this->validator->input($input);
		$this->assertAttributeEquals($input, 'input', $this->validator);
		$this->assertAttributeEquals(false, 'processed', $this->validator);
	}
	
	public function testField() {
		$fields = array(
			$this->validator->field('one'),
			$this->validator->field('two')
		);
		$this->assertAttributeEquals($fields, 'fields', $this->validator);
	}
	
	public function testValid() {
		$this->validator->field('one');
		$this->assertEquals(true, $this->validator->valid());
		$this->assertEquals(array(), $this->validator->errors());
	}

	public function testInvalid() {
		$this->validator->field('one');
		$this->validator->field('two');
		$this->assertEquals(false, $this->validator->valid());
		$errors = $this->validator->errors();
		$this->assertEquals(array('numeric'), $errors['two']);
	}
	
	public function testInvalidMultiple() {
		$this->validator->field('one');
		$this->validator->field('two');
		$this->validator->field('one');
		$this->validator->field('two');
		$this->assertEquals(false, $this->validator->valid());
		$errors = $this->validator->errors();
		$this->assertEquals(array('alpha'), $errors['one']);
		$this->assertEquals(array('numeric', 'alpha'), $errors['two']);
	}
	
	public function testOnlyIfValid() {
		$this->validator->field('one');
		$this->validator->field('two');
		$this->validator->field('one')->only_if_valid=true;
		$this->validator->field('two')->only_if_valid=true;
		$this->assertEquals(false, $this->validator->valid());
		$errors = $this->validator->errors();
		$this->assertEquals(array('alpha'), $errors['one']);
		$this->assertEquals(array('numeric'), $errors['two']);
	}

	protected function getField($name, $val, $errors) {
		$field = $this->getMock('\PHPixie\Validate\Field', array('validate'), array($this->pixie, $name));
		$field
			->expects($this->any())
			->method('validate')
			->will($this->returnValue($val));
		$field->errors = $errors;
		return $field;
	}
}