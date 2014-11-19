<?php
class RulesetTest extends PHPUnit_Framework_TestCase {
	

	protected $ruleset;
	public function setUp() {
		$this->ruleset = new \PHPixie\Validate\Ruleset;
	}
	
	/**
     * @covers PHPixie\Validate::filled
     * @todo   Implement testFilled().
     */
    public function testRule_Filled()
    {
        $this->assertEquals(true, $this->ruleset->rule_filled('aaaa'));
		$this->assertEquals(false,$this->ruleset->rule_filled(null));
    }

    /**
     * @covers PHPixie\Validate::alpha
     * @todo   Implement testAlpha().
     */
    public function testRule_Alpha()
    {
       $this->assertEquals(true, $this->ruleset->rule_alpha('aaaa'));
	   $this->assertEquals(false,$this->ruleset->rule_alpha('aaaa1'));
    }

    /**
     * @covers PHPixie\Validate::numeric
     * @todo   Implement testNumeric().
     */
    public function testRule_Numeric()
    {
        $this->assertEquals(true, $this->ruleset->rule_numeric(1111));
		$this->assertEquals(false,$this->ruleset->rule_numeric('a1'));
    }

    /**
     * @covers PHPixie\Validate::numeric_neg
     * @todo   Implement testNumeric_neg().
     */
    public function testRule_Numeric_neg()
    {
        $this->assertEquals(true, $this->ruleset->rule_numeric_neg(1111));
	$this->assertEquals(false,$this->ruleset->rule_numeric_neg('a1'));
        $this->assertEquals(true, $this->ruleset->rule_numeric_neg(-1111));
	$this->assertEquals(false,$this->ruleset->rule_numeric_neg('-a1'));
    }

    /**
     * @covers PHPixie\Validate::alpha_numeric
     * @todo   Implement testAlpha_numeric().
     */
    public function testRule_Alpha_numeric()
    {
        $this->assertEquals(true, $this->ruleset->rule_alpha_numeric('d3d3'));
		$this->assertEquals(false,$this->ruleset->rule_alpha_numeric('ddd--'));
    }

    /**
     * @covers PHPixie\Validate::slug
     */
    public function testRule_Slug()
    {
        $this->assertEquals(true, $this->ruleset->rule_slug('d3-d3'));
		$this->assertEquals(false,$this->ruleset->rule_slug('ddd -'));
    }
	
    /**
     * @covers PHPixie\Validate::decimal
     * @todo   Implement testDecimal().
     */
    public function testRule_Decimal()
    {
        $this->assertEquals(true, $this->ruleset->rule_decimal(3));
		$this->assertEquals(true, $this->ruleset->rule_decimal(3.5));
		$this->assertEquals(false,$this->ruleset->rule_decimal('3a'));
    }
	
    /**
     * @covers PHPixie\Validate::decimal_neg
     * @todo   Implement testDecimal_neg().
     */
    public function testRule_Decimal_neg()
    {
        $this->assertEquals(true, $this->ruleset->rule_decimal_neg(3));
	$this->assertEquals(true, $this->ruleset->rule_decimal_neg(3.5));
	$this->assertEquals(false,$this->ruleset->rule_decimal_neg('3a'));
        $this->assertEquals(true, $this->ruleset->rule_decimal_neg(-3));
	$this->assertEquals(true, $this->ruleset->rule_decimal_neg(-3.5));
	$this->assertEquals(false,$this->ruleset->rule_decimal_neg('-3a'));
    }

    /**
     * @covers PHPixie\Validate::phone
     * @todo   Implement testPhone().
     */
    public function testRule_Phone()
    {
		$this->assertEquals(true, $this->ruleset->rule_phone('093 115 22 10'));
		$this->assertEquals(false,$this->ruleset->rule_phone('3a'));
    }

    /**
     * @covers PHPixie\Validate::between
     * @todo   Implement testBetween().
     */
    public function testRule_Between()
    {
        $this->assertEquals(true, $this->ruleset->rule_between(3,1,5));
		$this->assertEquals(false, $this->ruleset->rule_between(7,1,5));
    }

    /**
     * @covers PHPixie\Validate::matches
     * @todo   Implement testMatches().
     */
    public function testRule_Matches()
    {
        $this->assertEquals(true, $this->ruleset->rule_matches('aaaa','/^[a-z]*$/'));
		$this->assertEquals(false, $this->ruleset->rule_matches('aaaa1','/^[a-z]*$/'));
    }

    /**
     * @covers PHPixie\Validate::url
     * @todo   Implement testUrl().
     */
    public function testRule_Url()
    {
        $this->assertEquals(true, $this->ruleset->rule_url('http://google.com'));
		$this->assertEquals(false, $this->ruleset->rule_url('11google.com'));
    }

    /**
     * @covers PHPixie\Validate::email
     * @todo   Implement testEmail().
     */
    public function testRule_Email()
    {
        $this->assertEquals(true, $this->ruleset->rule_email('test@test.com'));
		$this->assertEquals(false, $this->ruleset->rule_email('test'));
    }

    /**
     * @covers PHPixie\Validate::min_length
     * @todo   Implement testMin_length().
     */
    public function testRule_Min_length()
    {
        $this->assertEquals(true, $this->ruleset->rule_min_length('12321',4));
		$this->assertEquals(false, $this->ruleset->rule_min_length('123',4));
    }

    /**
     * @covers PHPixie\Validate::max_length
     * @todo   Implement testMax_length().
     */
    public function testRule_Max_length()
    {
        $this->assertEquals(true, $this->ruleset->rule_max_length('123',4));
		$this->assertEquals(false, $this->ruleset->rule_max_length('123124',4));
    }

    /**
     * @covers PHPixie\Validate::length
     * @todo   Implement testLength().
     */
    public function testRule_Length()
    {
        $this->assertEquals(true, $this->ruleset->rule_max_length('123',4));
		$this->assertEquals(false, $this->ruleset->rule_max_length('123124',4));
    }

    /**
     * @covers PHPixie\Validate::in
     * @todo   Implement testIn().
     */
    public function testRule_In()
    {
		$this->assertEquals(true, $this->ruleset->rule_in('1',array(1,2)));
		$this->assertEquals(false, $this->ruleset->rule_in('1',array(3,2)));
    }

    /**
     * @covers PHPixie\Validate::equals
     * @todo   Implement testEquals().
     */
    public function testRule_Equals()
    {
		$this->assertEquals(true, $this->ruleset->rule_equals('1','1'));
		$this->assertEquals(false, $this->ruleset->rule_equals('1','2'));
    }

    /**
     * @covers PHPixie\Validate::callback
     * @todo   Implement testCallback().
     */
    public function testRule_Callback()
    {
        $this->assertEquals(true, $this->ruleset->rule_callback('1', function($val) {
			return $val == 1;
		}, null, null));
		$this->assertEquals(false, $this->ruleset->rule_callback('2', function($val) {
			return $val == 1;
		}, null, null));
    }
	
	public function testRule_Same_As()
    {
		$validator = $this->getMock('\PHPixie\Validate\Validator', array('get'), array(), '', false);
		$validator
			->expects($this->any())
			->method('get')
			->will($this->returnValue(1));
		$this->assertEquals(true, $this->ruleset->rule_same_as('1','one',$validator));
		$this->assertEquals(false, $this->ruleset->rule_same_as('2','two',$validator));
    }
	
	public function testValidate()
    {
		$validator = $this->getMock('\PHPixie\Validate\Validator', array('get'), array(), '', false);
		$validator
			->expects($this->any())
			->method('get')
			->will($this->returnValue(1));
		$this->assertEquals(true, $this->ruleset->validate('equals', array(1), 'one', $validator));
		$this->assertEquals(false, $this->ruleset->validate('equals', array(2), 'one', $validator));
		$this->assertEquals(true, $this->ruleset->validate('same_as', array('one'), 'one', $validator));
		$this->assertEquals(true, $this->ruleset->validate('filled', array(), 'one', $validator));
		
		$validator = $this->getMock('\PHPixie\Validate\Validator', array('get'), array(), '', false);
		$validator
			->expects($this->any())
			->method('get')
			->will($this->returnValue(''));
		$this->assertEquals(true, $this->ruleset->validate('equals', array(1), 'one', $validator));
		$this->assertEquals(false, $this->ruleset->validate('filled', array(), 'one', $validator));
    }
	
	

}
