<?php

namespace PHPixie\Validate\Rules\Rule\Data;

class Document extends \PHPixie\Validate\Rules\Rule\Data
{
    protected $fieldRules = array();
    protected $allowExtraFields = false;

    public function allowExtraFields($allowExtraFields = true)
    {
        $this->allowExtraFields = $allowExtraFields;
        return $this;
    }

    public function extraFieldsAllowed()
    {
        return $this->allowExtraFields;
    }

    public function field($field, $callback = null)
    {
        $this->fieldValue($field, $callback);
        return $this;
    }

    public function valueField($field, $callback = null)
    {
        $rule = $this->rules->value();
        if($callback !== null) {
            $callback($rule);
        }

        $this->setFieldRule($field, $rule);
        return $rule;
    }

    public function setFieldRule($field, $rule)
    {
        $this->fieldRules[$field] = $rule;
        return $this;
    }

    public function fieldRules()
    {
        return $this->fieldRules;
    }

    public function fieldRule($field)
    {

    }

    protected function validateData($value, $result)
    {
        if(!$this->allowExtraFields) {
            $extraFields = array_diff(
                array_keys($value),
                array_keys($this->fieldRules)
            );

            if(!empty($extraFields)) {
                $result->addIvalidKeysError($extraFields);
            }
        }

        foreach($this->fieldRules as $field => $rule) {
            if(array_key_exists($field, $value)) {
                $fieldValue = $value[$field];

            }else{
                $fieldValue = null;
            }

            $fieldResult = $result->field($field);
            $rule->validate($fieldValue, $fieldResult);
        }
    }
}
