<?php
namespace PHPixie;

/**
 * Validation Module for PHPixie
 *
 * This module is not included by default, install it using Composer
 * by adding
 * <code>
 * 		"phpixie/validate": "2.*@dev"
 * </code>
 * to your requirement definition. Or download it from
 * https://github.com/dracony/PHPixie-validate
 * 
 * To enable it add it to your Pixie class' modules array:
 * <code>
 * 		protected $modules = array(
 * 			//Other modules ...
 * 			'validate' => '\PHPixie\Validate',
 * 		);
 * </code>
 *
 * Methods of this class can be used to quickly validate a value. 
 * If you need to validate an array of values against different rules
 * use the Validator class.
 *
 * @see \PHPixie\Validate\Validator
 * @link https://github.com/dracony/PHPixie-validate Download this module from Github
 * @package    Validate
 */
class Validate {
	
	/**
	 * Pixie Dependancy Container
	 * @var \PHPixie\Pixie
	 */
	public $pixie;
	
	public function __construct($pixie) {
		$this->pixie = $pixie;
	}
	
	/**
	 * Creates a Validator instance and intializes it with input data
	 *
	 * @param   array  $input  Associative array of fields and values
	 * @return  \PHPixie\Validate\Validator   Initialized Validator object
	 */
	public function get($input=array()) {
		return new \PHPixie\Validate\Validator($this->pixie, $input);
	}

	/**
	 * Checks if the value is not empty
	 *
	 * @param   mixed  $val  Value to check
	 * @return  bool 
	 */
	public function filled($val) {
		return !empty($val);
	}
	
	/**
	 * Checks if the value consists of letters only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function alpha($val) {
		return (bool) preg_match('/^\pL++$/uD', $val);
	}

	/**
	 * Checks if the value consists of numbers only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function numeric($val) {
		return (bool)preg_match('#^[0-9]*$#',$val);
	}
	
	/**
	 * Checks if the value consists of letters and numbers only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function alpha_numeric($val) {
		return (bool) preg_match('/^[\pL\pN]++$/uD', $val);
	}
	
	/**
	 * Checks if the value is a valid url slug. 
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function slug($val) {
		return (bool) preg_match('/^[\pL\pN\-]++$/uD', $val);
	}
	
	/**
	 * Checks if the value is a decimal number
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function decimal($val) {
		return (bool) preg_match('/^[0-9]+(?:\.[0-9]+)?$/D', $val);
	}
	
	
	/**
	 * Checks if the value is a phone number
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function phone($val) {
		return (bool)preg_match('#^[0-9\(\)\+ \-]*$#',$val);
	}
	
	/**
	 * Checks if the value is larger or equal to $min
	 * and smaller or equal to $max.
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $min  Minimum allowed value
	 * @param   string  $min  Maximum allowed value
	 * @return  bool 
	 */
	public function between($val, $min, $max) {
		return ($val>=$min && $val<=$max);
	}
	
	/**
	 * Checks if the value matches a regular expression
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $regexp  Regular expression to test with
	 * @return  bool 
	 */
	public function matches($val,$regexp){
		return (bool)preg_match($regexp,$val);
	}
	
	/**
	 * Checks if the value is an URL
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function url($val){
		return (bool)preg_match('~^
			[-a-z0-9+.]++://
			(?!-)[-a-z0-9]{1,63}+(?<!-)
			(?:\.(?!-)[-a-z0-9]{1,63}+(?<!-)){0,126}+
			(?::\d{1,5}+)?
			(?:/.*)?
			$~iDx', $val);
	}
	
	/**
	 * Checks if the value is an email
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public function email($val) {
		return (bool) preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++
			(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+
			@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})
			(?::\d++)?$/iDx', $val);
	}
	
	/**
	 * Checks if the character length is more or equal to $min
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $min  Minimum characters
	 * @return  bool 
	 */
	public function min_length($val, $min) {
		return strlen(utf8_decode($val))>=$min;
	}
	
	/**
	 * Checks if the character length is less or equal to $max
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $min  Maximum characters
	 * @return  bool 
	 */
	public function max_length($val, $max) {
		return strlen(utf8_decode($val))<=$max;
	}
	
	/**
	 * Checks if the character length is equal to $length
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $length  Number of characters
	 * @return  bool 
	 */
	public function length($val, $length) {
		return strlen(utf8_decode($val))<=$length;
	}
	
	/**
	 * Checks if the value is in the $allowed array
	 *
	 * @param   string  $val  Value to check
	 * @param   array  $allowed  Array of allowed values
	 * @return  bool 
	 */
	public function in($val,$allowed) {
		return in_array($val,$allowed);
	}
	
	/**
	 * Checks if the value equals to $allowed
	 *
	 * @param   mixed  $val  Value to check
	 * @param   mixed  $allowed  Value to compare with
	 * @return  bool 
	 */
	public function equals($val,$allowed) {
		return $val==$allowed;
	}
	
	/**
	 * Calls passed $func function with the value as an argument.
	 * Good for validating using an inline function.
	 *
	 * @param   mixed     $val  Value to check
	 * @param   callable  $func  Function to call
	 * @return  bool 
	 */
	public function func($val,$func) {
		return call_user_func($func, $val);
	}
}
