<?php
namespace PHPixie {

/**
 * Validation Module for PHPixie
 *
 * This module is not included by default, download it here:
 *
 * https://github.com/dracony/PHPixie-validate
 * 
 * To enable it add 'validate' to modules array in /application/config/core.php.
 *
 * This module allows you to validate input data against a set of rules.
 * <code>
 *	 Validate::factory($this->request->post())
 *	 
 *		//Username must be filled
 *		->rule('username', 'filled')
 *		
 *		//Password must be filled and have a minimum
 *		//of 6 characters
 *		->rule('password', array(
 *			'filled',
 *			array('min_length',6)
 *		)
 *	 ->valid();
 * </code>
 *
 * All rules except 'filled' will return true for empty values. You have to add
 * the 'filled' rule to make a field required.
 * 
 * You can apply the NOT logic to a rule by using '!' e.g. '!filled'.
 * Calling the errors() method will return a list of rules each field did not meet.
 * You can specify a different identifier for an unmatched rule like this:
 * <code>
 *  //if username is left empty the errors array will contain 
 *  //'was_left_empty' identifier for this field
 *	$v->rule('username', array('filled',null,'was_left_empty');
 * </code>
 *
 * If you specify more than one rule set per field it will be considered valid
 * if ANY of those match. This allows for some complex logic when combined with
 * conditional rules.
 * <code>
 *  //'height' value must be between 3 and 8 
 *	//If the 'type' value is 'fairy'
 *  $v->rule('height', array(
 * 			array('between', array(3, 8))
 *  	),array(
 *			array('type', array(
 *				array('equals', 'fairy')
 *			))
 *		)
 *	);
 *	
 *	//Or 'height' can be between 1 and 3
 *	//If the 'type' is 'pixie'
 *  $v->rule('height', array(
 * 			array('between', array(1, 3))
 *  	),array(
 *			array('type', array(
 *				array('equals', 'pixie')
 *			))
 *		)
 *	);
 * </code>
 *
 * 
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
		 * @return  Validator   Initialized Validate object
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
}