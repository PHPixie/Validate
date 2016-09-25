<?php

namespace PHPixie\Validate\Rules\Rule\Data;

use PHPixie\Validate\Results\Result;
use PHPixie\Validate\Results\Result\Field;
use PHPixie\Validate\Rules\Rule;

/**
 * Class Document
 * @package PHPixie\Validate\Rules\Rule\Data
 */
class Document extends \PHPixie\Validate\Rules\Rule\Data
{
    /**
     * @var array
     */
    protected $fieldRules = array();
    /**
     * @var bool
     */
    protected $allowExtraFields = false;

    /**
     * @param bool $allowExtraFields
     * @return $this
     */
    public function allowExtraFields($allowExtraFields = true)
    {
        $this->allowExtraFields = $allowExtraFields;
        return $this;
    }

    /**
     * @return bool
     */
    public function extraFieldsAllowed()
    {
        return $this->allowExtraFields;
    }

    /**
     * @param $field Field
     * @param null|callable $callback
     * @return $this
     */
    public function field($field, $callback = null)
    {
        $this->valueField($field, $callback);
        return $this;
    }

    /**
     * @param $field string
     * @param null|callable $callback
     * @return \PHPixie\Validate\Rules\Rule\Value
     */
    public function valueField($field, $callback = null)
    {
        $rule = $this->buildValue($callback);
        $this->setFieldRule($field, $rule);
        return $rule;
    }

    /**
     * @param $field string
     * @param $rule Rule
     * @return $this
     */
    public function setFieldRule($field, $rule)
    {
        $this->fieldRules[$field] = $rule;
        return $this;
    }

    /**
     * @return array
     */
    public function fieldRules()
    {
        return $this->fieldRules;
    }

    /**
     * @param $field string
     * @return Rule|null
     */
    public function fieldRule($field)
    {
        if(!array_key_exists($field, $this->fieldRules)) {
            return null;
        }
        
        return $this->fieldRules[$field];
    }

    /**
     * @param $result Result
     * @param $value Rule\Value
     */
    protected function validateData($result, $value)
    {
        if(!$this->allowExtraFields) {
            $extraFields = array_diff(
                array_keys($value),
                array_keys($this->fieldRules)
            );

            if(!empty($extraFields)) {
                $result->addInvalidFieldsError($extraFields);
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
