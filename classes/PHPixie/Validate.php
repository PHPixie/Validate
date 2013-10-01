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
	 * Pixie Dependency Container
	 * @var \PHPixie\Pixie
	 */
	public $pixie;
	
	/**
	 * Ruleset instance
	 * @var \PHPixie\Validate\Ruleset
	 */
	protected $ruleset;
	
	/**
	 * Initializes the Validation module
	 *
	 * @param   \PHPixie\Pixie $pixie Pixie dependency container
	 */
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
	 * Returns an instance of the ruleset
	 *
	 * @return  \PHPixie\Validate\Ruleset  Ruleset instance
	 */
	public function ruleset() {
		if ($this->ruleset === null)
			$this->ruleset = $this->build_ruleset();
			
		return $this->ruleset;
	}

	/**
	 * Builds a Ruleset instance
	 *
	 * @return  \PHPixie\Validate\Ruleset  Ruleset instance
	 */
	public function build_ruleset() {
		return new \PHPixie\Validate\Ruleset();
	}

	/**
	 * Creates a Field instance
	 *
	 * @param   string $name Name of the field to validate
	 * @param   boolean $only_if_valid Marks this Field to only be processed if previous
	 *                                 definitions of this field were valid
	 * @return  \PHPixie\Validate\Field Field instance
	 */
	public function field($name) {
		return new \PHPixie\Validate\Field($this->pixie, $name);
	}
	
	/**
	 * Creates a Rule instance
	 *
	 * @param   array  $input  Associative array of fields and values
	 * @return  \PHPixie\Validate\Rule   Validator Rule
	 */
	public function rule($type) {
		return new \PHPixie\Validate\Rule($this->ruleset(), $type);
	}

}
