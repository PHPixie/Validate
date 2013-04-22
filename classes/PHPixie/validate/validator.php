<?php
namespace PHPixie\Validate {

/**
 * Reusable array validator. Allows you to validate input data against a set of rules.
 * <code>
 *	 $pixie->validate->get($this->request->post())
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
 * All rules except 'filled' will be considered valid for empty values. You have to add
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
 * @package    Validate
 */
	class Validator{
		
		/**
		 * Pixie Dependancy Container
		 * @var \PHPixie\Pixie
		 */
		public $pixie;
		
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
		 */
		public function __construct($pixie, $input = array()) {
			$this->pixie = $pixie;
			$this->input = $input;
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
		 * @return  \PHPixie\Validate\Validator   Returns self
		 */
		public function rule($field,$rules,$conditions=array()){
			$this->_groups[] = array($field, $rules,$conditions);
			return $this;
		}
		
		/**
		 * Validates the input data
		 *
		 * @return void
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
		 */
		protected function validate_rules($field,$rules){
			$errors = array();
			
			if (!is_array($rules))
				$rules = array($rules);
				
			foreach($rules as $rule) {
			
				if (!is_array($rule))
					$rule = array($rule);
				
				$params = $this->pixie->arr($rule, 1, array());
				if (!is_array($params))
					$params = array($params);
				$value = $this->pixie->arr($this->input, $field, null);
				array_unshift($params,$value);
				$not = false;
				$func = $rule[0];
				if (substr($func, 0, 1) == '!') {
					$not  = true;
					$func = substr($func, 1);
				}
				
				if (!$this->pixie->validate->filled($value) && $func != 'filled')
					continue;
				
				if (method_exists($this, "rule_{$func}")) {
					$func = array($this, "rule_{$func}");
				}else{
					$func = array($this->pixie->validate, $func);
				}
				
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
			return empty($this->_errors);
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
		 * @return  \PHPixie\Validate\Validator  Returns self
		 */
		public function input($input) {
			$this->input = $input;
			$this->_errors = null;
			return $this;
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
		protected function rule_same_as($val,$key) {
			return $val==$this->pixie->arr($this->input,$key,null);
		}
		
	}
}