<?php
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
	 * The input array being validate
	 * @var    array
	 * @access public
	 */
	public $input;
	
	/**
	 * Roule groups defined using  rule()
	 * @var    array
	 * @access protected
	 */
	protected $_groups = array();
	
	/**
	 * Custom rule functions added in the config file
	 * @var    array
	 * @access public
	 */
	protected $_rules = array();
	
	/**
	 * Errors after validation
	 * @var    array
	 * @access public
	 */
	protected $_errors = null;
	

	/**
	 * Creates a Validate instance and intializes it with input data
	 *
	 * @param   array  $input  Associative array of fields and values
	 * @return  Validate   Initialized Validate object
	 */
	protected function __construct($input=array()){
		$this->input = $input;
		$this->_rules = Config::get('validate.rules');
	}
	
	/**
	 * Adds a rule group for validation.
	 *
	 * The $rules parameter can be one of the following:
	 * <code>
	 *	 
	 *	//A string identifying a single rule
	 *	->rule('username', 'filled') 		
	 *	//An array of rules
	 *	->rule('username', array(
	 *		'filled',
	 *		'email'
	 *	)) 		
	 *	//Each rule inside the rules array can be an array
	 *	//with rule name, rule parameters and error identifier as
	 *	//its values
	 *	->rule('username', array(
	 *		'filled',
	 *		array('between',array(4,8),'is_not_in_range')
	 *	))
	 * </code>
	 *
	 * @param   string  $field  Field to apply the rule group to
	 * @param   mixed   $rules  Rules for this field
	 * @param   array   $conditions An array of rules that must match for this rule set to be applied
	 * @return  Validate   Returns self
	 */
	public function rule($field,$rules,$conditions=array()){
		$this->_groups[] = array($field, $rules,$conditions);
		return $this;
	}
	
	/**
	 * Validates the input data
	 *
	 */
	protected function validate() {
		if($this->_errors === null)
			$this->_errors=$this->validate_groups($this->_groups);
	}
	
	/**
	 * Validates a set of rule groups
	 *
	 * @param   array  $groups  An array of rule groups to validate
	 * @return  array  An array of errors for each field
	 */
	protected function validate_groups($groups) {
		$valid_fields = array();
		$errors = array();
		foreach($groups as $group) {
			$field = $group[0];
			
			//Skip fields that are already valid
			if (in_array($field, $valid_fields))
				continue;
			
			//Skip the group if the conditions set for it
			//are not met
			if (!empty($group[2]))
				if (count($this->validate_groups($group[2]))>0)
					continue;
			
			$group_errors = $this->validate_rules($field,$group[1]);
		
			if (empty($group_errors)) {
				$valid_fields[] = $field;
				
				//If the field is validated by a rule, remove the errors
				//associated with this field				
				if(isset($errors[$field]))
					unset($errors[$field]);
					
			} else{
				if (!isset($errors[$field]))
					$errors[$field] = array();
				$errors[$field]=array_unique(array_merge($errors[$field],$group_errors));
			}
			
		}
		return $errors;
	}
	
	/**
	 * Validates a set of rules against a field
	 *
	 * @param   string $field  A field to validate against
	 * @param   array  $rules  An array of rules to validate
	 * @return  array  An array of errors for this field
	 * @throw   Exception If the rule specified does not exist
	 */
	protected function validate_rules($field,$rules){
		$errors = array();
		
		if (!is_array($rules))
			$rules = array($rules);
			
		foreach($rules as $rule) {
		
			if (!is_array($rule))
				$rule = array($rule);
			
			$params = Misc::arr($rule, 1, array());
			if (!is_array($params))
				$params = array($params);
			$value = Misc::arr($this->input, $field, null);
			array_unshift($params,$value);
			$not = false;
			$func = $rule[0];
			if (substr($func, 0, 1) == '!') {
				$not  = true;
				$func = substr($func, 1);
			}
			
			if (!Validate::filled($value) && $func != 'filled')
				continue;
			if (isset($this->_rules[$func])) {
				$func=$this->_rules[$func];
			}elseif(method_exists($this, $func)) {
				$func=array($this,$func);
			}else
				throw new Exception("A rule method '{$func}' does not exist.");
				
			$passed = call_user_func_array($func, $params);
			if ($not)
				$passed = !$passed;
			
			if (!$passed)
				$errors[] = isset($rule[2])?$rule[2]:$rule[0];
		}
		return $errors;
	}
	
	/**
	 * Checks if the input is valid
	 *
	 * @return  bool  If the the input is valid
	 */
	public function valid() {
		$this->validate();
		return empty($this->errors);
	}
	
	/**
	 * Returns errors for each field
	 *
	 * @return  array  An array of errors for each field
	 */
	public function errors() {
		$this->validate();
		return $this->_errors;
	}
	
	/**
	 * Sets new input array
	 *
	 * @param   array  $input  New input array
	 * @return  Validate  Returns self
	 */
	public function input($input) {
		$this->input = $input;
		$this->_errors = null;
		return $this;
	}
	
	/**
	 * Creates a Validate instance and intializes it with input data
	 *
	 * @param   array  $input  Associative array of fields and values
	 * @return  Validate   Initialized Validate object
	 */
	public static function factory($input=array()) {
		return new Validate($input);
	}
	
	/**
	 * Checks if the value is not empty
	 *
	 * @param   mixed  $val  Value to check
	 * @return  bool 
	 */
	public static function filled($val) {
		return !empty($val);
	}
	
	/**
	 * Checks if the value consists of letters only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function alpha($val) {
		 return (bool) preg_match('/^\pL++$/uD', $val);
	}

	/**
	 * Checks if the value consists of numbers only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function numeric($val) {
		return (bool)preg_match('#^[0-9]*$#',$val);
	}
	
	/**
	 * Checks if the value consists of letters and numbers only
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function alpha_numeric($val) {
		return (bool) preg_match('/^[\pL\pN]++$/uD', $val);
	}
	
	
	/**
	 * Checks if the value is a decimal number
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function decimal($val) {
		return (bool) preg_match('/^[0-9]+(?:\.[0-9]+)?$/D', $val);
	}
	
	
	/**
	 * Checks if the value is a phone number
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function phone($val) {
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
	public static function between($val, $min, $max) {
		return ($val>=$min && $val<=$max);
	}
	
	/**
	 * Checks if the value matches a regular expression
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $regexp  Regular expression to test with
	 * @return  bool 
	 */
	public static function matches($val,$regexp){
		return (bool)preg_match($regexp,$val);
	}
	
	/**
	 * Checks if the value is an URL
	 *
	 * @param   string  $val  Value to check
	 * @return  bool 
	 */
	public static function url($val){
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
	public static function email($val) {
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
	public static function min_length($val, $min) {
		return strlen(utf8_decode($val))>=$min;
	}
	
	/**
	 * Checks if the character length is less or equal to $max
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $min  Maximum characters
	 * @return  bool 
	 */
	public static function max_length($val, $max) {
		return strlen(utf8_decode($val))<=$max;
	}
	
	/**
	 * Checks if the character length is equal to $length
	 *
	 * @param   string  $val  Value to check
	 * @param   string  $length  Number of characters
	 * @return  bool 
	 */
	public static function length($val, $length) {
		return strlen(utf8_decode($val))<=$length;
	}
	
	/**
	 * Checks if the value is in the $allowed array
	 *
	 * @param   string  $val  Value to check
	 * @param   array  $allowed  Array of allowed values
	 * @return  bool 
	 */
	public static function in($val,$allowed) {
		return in_array($val,$allowed);
	}
	
	/**
	 * Checks if the value equals to $allowed
	 *
	 * @param   mixed  $val  Value to check
	 * @param   mixed  $allowed  Value to compare with
	 * @return  bool 
	 */
	public static function equals($val,$allowed) {
		return $val==$allowed;
	}
	
	/**
	 * Checks if the value is the same as the field with name
	 * $key is. E.g. to check if password confirmation field is same
	 * as password field.
	 *
	 * @param   mixed  $val  Value to check
	 * @param   mixed  $key  Field to comparw with
	 * @return  bool 
	 */
	public function same_as($val,$key) {
		return $val==Misc::arr($this->input,$key,null);
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