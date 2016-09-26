<?php

namespace PHPixie\Validate\Rules\Rule;

use PHPixie\Validate\Results\Result;
use PHPixie\Validate\Rules;

/**
 * Class Data
 * @package PHPixie\Validate\Rules\Rule
 */
abstract class Data implements \PHPixie\Validate\Rules\Rule
{
    /**
     * @var Rules
     */
    protected $rules;

    /**
     * Data constructor.
     * @param $rules
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param null|callable $callback
     * @return Value
     */
    protected function buildValue($callback = null)
    {
        $rule = $this->rules->value();
        if($callback !== null) {
            $callback($rule);
        }

        return $rule;
    }

    /**
     * @param $value array|object
     * @param $result Result
     */
    public function validate($value, $result)
    {
        if(!is_array($value) && !is_object($value)) {
            $result->addDataTypeError();
            return;
        }
        
        $value = (array) $value;
        $this->validateData($result, $value);
    }

    /**
     * @param $result Result
     * @param $value array
     * @return mixed
     */
    abstract protected function validateData($result, $value);
}
