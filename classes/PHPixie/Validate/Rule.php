<?php
namespace PHPixie\Validate;

/**
 * Rule for field validation
 *
 * @package    Validate
 */
class Rule{
	
	/**
	 * Custom error message
	 * @var string
	 */
	public $type;
	
	/**
	 * Ruleset to validate against
	 * @var \PHPixie\Validate\Ruleset
	 */
	public $ruleset;
	
	/**
	 * Array of rule parameters
	 * @var array
	 */
	protected $params = array();
	
	/**
	 * Whether to inverse the rule.
	 * @var boolean
	 */
	protected $inverse = false;
	
	/**
	 * Initializes the Field
	 *
	 * @param   \PHPixie\Validate\Ruleset $ruleset Ruleset to validate against
	 * @param   string $type Rule type. If it starts with '!' than the rule will be inversed,
	 *                                  meaning it will be considered valid if it doesn't validate 
	 *                                  and invalid if it does.
	 */
	public function __construct($ruleset, $type) {
		$this->ruleset = $ruleset;
		$this->type = $type;
		if (substr($this->type, 0, 1) == '!') {
			$this->inverse = true;
			$this->type = substr($this->type, 1);
		}
	}
	
	/**
	 * Sets parameters for the rule
	 * @param   array $params Array of rule parameters
	 * @return \PHPixie\Validate\Rule Returns self
	 */
	public function params($params) {
		$this->params = $params;
		return $this;
	}
	
	/**
	 * Validates the rule against a field.
	 *
	 * @param   \PHPixie\Validate\Validator $validator Validator the validated field belongs to
	 * @param   string $field Field to validate
	 * @return boolean If the rule matches the field
	 */
	public function validate($validator, $field) {
		return !$this->inverse == $this->ruleset->validate($this->type, $this->params, $field, $validator);
	}
	
}