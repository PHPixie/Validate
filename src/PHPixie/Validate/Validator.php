<?php

namespace PHPixie\Validate;

use PHPixie\Validate\Results\Result\Root;
use PHPixie\Validate\Rules\Rule;

class Validator
{
    protected $results;
    protected $rule;
    
    public function __construct($results, $rule)
    {
        $this->results = $results;
        $this->rule    = $rule;
    }

    /**
     * @return Rule
     */
    public function rule()
    {
        return $this->rule;
    }

    /**
     * @param $value
     * @return Root
     */
    public function validate($value)
    {
        $result = $this->results->root($value);
        $this->rule->validate($value, $result);
        return $result;
    }
}
