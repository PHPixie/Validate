<?php

namespace PHPixie\Validate\Rules\Rule;

abstract class Data implements \PHPixie\Validate\Rules\Rule
{
    protected $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    protected function buildValue($callback = null)
    {
        $rule = $this->rules->value();
        if($callback !== null) {
            $callback($rule);
        }

        return $rule;
    }

    public function validate($value, $result)
    {
        if(!is_array($value)) {
            $result->addArrayTypeError();
            return;
        }

        $this->validateData($value, $result);
    }

    abstract protected function validateData($value, $result);
}
