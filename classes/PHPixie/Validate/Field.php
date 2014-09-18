<?php
namespace PHPixie\Validate;

/**
 * Validates a single field based on a set of rules and conditions.
 *
 * @package    Validate
 */
class Field {

	/**
	 * Pixie Dependency Container
	 * @var \PHPixie\Pixie
	 */
	protected $pixie;
	
	/**
	 * Custom error message
	 * @var string
	 */
	protected $custom_error;
	
	/**
	 * Rules to validate the field against
	 * @var array
	 */
	protected $rules = array();
	
	/**
	 * Conditions for field validation.
	 * If they are not met the validation rules will not be applied
	 * @var array
	 */
	protected $conditions = array();
	
	/**
	 * Errors encountered during validation
	 * @var array
	 */
	public $errors = array();
	
	/**
	 * Whether to throw an exception if the field is not valid
	 * @var boolean
	 */
	protected $throw_on_error = false;

	/**
	 * Whether to apply this group only if previous were valid
	 * @var boolean
	 */
	public $only_if_valid = false;
	
	/**
	 * Initializes the Field
	 *
	 * @param   \PHPixie\Pixie $pixie Pixie dependency container
	 * @param   string $name Name of the field to validate
	 * @param   boolean $only_if_valid Marks this Field to only be processed if previous
	 *                                 definitions of this field were valid
	 */

	public function __construct($pixie, $name, $only_if_valid = false) {
		$this->pixie = $pixie;
		$this->name = $name;
		$this->only_if_valid = $only_if_valid;
	}
	
	/**
	 * Adds a rule to the field.
	 * $type Must be the name of one of the methods in the ruleset.
	 * If it starts with '!' than the rule will be inversed,
	 * meaning it will be considered valid if it doesn't validate 
	 * and invalid if it does.
	 *
	 * @param    string $type Rule type
	 * @param    mixed $p, ... rule parmeters
	 * @return   \PHPixie\Validate\Field Returns self
	 * @see \PHPixie\Validate\Ruleset
	 */
	public function rule($type) {
		$rule = $this->pixie-> validate->rule($type);
		$rule-> params(array_slice(func_get_args(), 1));
		
		$this->rules[] = $rule;
		return $this;
	}
	
	/**
	 * Adds multiple rules to the field
	 * Rules added using this method must not require additional parameters.
	 *
	 * @param    string $type,... Rule types to add
	 * @return   \PHPixie\Validate\Field Returns self
	 * @see \PHPixie\Validate\Ruleset
	 * @see rule()
	 */
	public function rules() {
		foreach(func_get_args() as $type)
			$this->rule($type);
		return $this;
	}
	
	/**
	 * Creates and adds a condition to the field. 
	 * A condition is a Field instance that has to validate in order
	 * for the rules in this Field to apply.
	 *
	 * @param    string $field Name of the field for the condition
	 * @return   \PHPixie\Validate\Field Returns added condition
	 */
	public function condition($field) {
		$condition = $this->pixie->validate->field($field);
		$this->conditions[] = $condition;
		return $condition;
	}
	
	/**
	 * Sets a custom error message for this Field.
	 * If the custom error is specified for a field it will be the only member of the errors() array,
	 * and if throw_on_error() has been called on the field it will be the message of the thrown Exception
	 *
	 * @param    string $custom_error Custom error message
	 * @return   \PHPixie\Validate\Field Returns self
	 * @see throw_on_error()
	 */
	public function error($custom_error) {
		$this->custom_error = $custom_error;
		return $this;
	}
	
	/**
	 * Instructs the field to throw an exception if it is not valid.
	 * Instead of additionally call error() to set a message for the exception you can pass it here
	 *
	 * @param    string $custom_error Optional custom error message
	 * @return   \PHPixie\Validate\Field Returns self
	 * @see error()
	 */
	public function throw_on_error($custom_error = null) {
		if ($custom_error)
			$this->error($custom_error);
		$this->throw_on_error = true; 
		return $this;
	}
	
	/**
	 * Checks if this field definition is valid.
	 * The field is considered valid if any of the conditions are invalid
	 * or when all the rules added to the field are valid.
	 * Errors encountered during validation can be accesed via $field->errors
	 *
	 * @param   \PHPixie\Validate\Validator $validator Validator this field belongs to
	 * @return   boolean If the field is valid
	 * @throws   \Exception If an error occured and throw_on_error() has been called on this field
	 */
	public function validate($validator) {
		$this->errors = array();
		
		foreach($this->conditions as $condition)
			if (!$condition->validate($validator)) 
				return true;
		
		foreach($this->rules as $rule)
			if (!$rule->validate($validator, $this->name)) {
				$error = $this->custom_error ? $this->custom_error : $rule->type;
				$this->errors[] = $error;
				if ($this->throw_on_error)
					throw new \Exception($error);
					
				if ($this->custom_error)
					return false;
			}
			
		return empty($this->errors);
	}
	
}
