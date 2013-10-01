<?php
namespace PHPixie\Validate;

/**
 * Reusable array validator. Allows you to validate input data against a set of rules.
 *
 * To use it add fields and rules to validate data against.
 * <code>
 *     $validator = $pixie-> validate-> get($data);
 *     $validator->field('username')
 *                  ->rules('filled', 'alpha_numeric');
 *		
 *     $validator->field('password')
 *                  ->rule('filled')
 *                  ->rule('min_length', 8);
 *				
 *     $validator->field('password_confirm')
 *                  ->rule('filled')
 *                  ->rule('same_as', 'password');
 *     $valid = $vaalidator->valid();
 * </code>
 * @package    Validate
 */
class Validator{
	
	/**
	 * Pixie Dependancy Container
	 * @var \PHPixie\Pixie
	 */
	public $pixie;
	
	/**
	 * Pixie Dependancy Container
	 * @var \PHPixie\Validate\Ruleset
	 */
	public $ruleset;
	
	/**
	 * The input array being validate
	 * @var    array
	 * @access public
	 */
	protected $input;
	
	/**
	 * Array of field definitions
	 * @var array
	 */
	protected $fields = array();
	
	/**
	 * Errors found during validation
	 * @var    array
	 */
	protected $errors = array();
	
	/**
	 * Whether the input has already been processed
	 * @var    boolean
	 */
	protected $processed = false;

	/**
	 * Creates a Validator instance and intializes it with input data
	 *
	 * @param   \PHPixie\Pixie $pixie Pixie dependency container
	 * @param   array  $input  Associative array of fields and values
	 */
	public function __construct($pixie, $input = array()) {
		$this->pixie = $pixie;
		$this->input = $input;
	}
	
	/**
	 * Validates the input data
	 *
	 * @return void
	 */
	protected function validate() {
		if($this->processed)
			return;
		
		foreach($this->fields as $field) {
			if ($field->only_if_valid && isset($this->errors[$field->name]))
				continue;
				
			if (!$field->validate($this)) {
				if (!isset($this->errors[$field->name]))
					$this->errors[$field->name] = array();
				$this->errors[$field->name] = array_merge($this->errors[$field->name], $field->errors);
			}
		}
		
		$this->processed = true;
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
	 * @return  array  An associative array of errors for each field
	 */
	public function errors() {
		$this->validate();
		return $this->errors;
	}
	
	/**
	 * Sets a new input array
	 *
	 * @param   array  $input  New input array
	 * @return  \PHPixie\Validate\Validator  Returns self
	 */
	public function input($input) {
		$this->input = $input;
		$this->errors = array();
		$this->processed = false;
		return $this;
	}
	
	/**
	 * Gets a field value
	 *
	 * @param   string $field Field name
	 * @param   mixed  $default Default value to return
	 * @return  mixed  Field value
	 */	
	public function get($field, $default = null) {
		return $this->pixie->arr($this->input, $field, $default);
	}
	
	/**
	 * Adds a field definition
	 *
	 * @param   string $name
	 * @return  \PHPixie\Validate\Field Added field
	 * @param   boolean $only_if_valid Marks this Field to only be processed if previous
	 *                                 definitions of this field were valid
	 */
	public function field($name, $only_if_valid = false) {
		$field = $this->pixie->validate->field($name, $only_if_valid);
		$this->fields[] = $field;
		return $field;
	}
	
}
