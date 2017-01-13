<?php

namespace PHPixie\Validate;

use PHPixie\Validate\Rules\Rule;

/**
 * Class Validator
 * @package PHPixie\Validate
 */
class Validator
{
    /**
     * @var Results
     */
    protected $results;
    /**
     * @var Rule\Value
     */
    protected $rule;

    /**
     * Validator constructor.
     * @param $results Results
     * @param $rule Rule\Value
     */
    public function __construct($results, $rule)
    {
        $this->results = $results;
        $this->rule    = $rule;
    }

    /**
     * @return Rule\Value
     */
    public function rule()
    {
        return $this->rule;
    }

    /**
     * @param $value array|object
     * @return Results\Result\Root
     */
    public function validate($value)
    {
        $result = $this->results->root($value);
        $this->rule->validate($value, $result);
        return $result;
    }
}
