<?php

namespace PHPixie\Validate\Rules\Rule\Value;

class Document extends \PHPixie\Validate\Rules\Rule\Value
{
    protected $rules;
    protected $fieldRules = array();
    
    public function __construct($rules)
    {
        $this->rules = $rules;
    }
    
    public function value($field, $parameter)
    {
        $this->valueField($field, $parameter);
        return $this;
    }
    
    public function document($field, $parameter)
    {
        $this->documentField($field, $parameter);
        return $this;
    }
    
    public function arrayOf($field, $parameter)
    {
        $this->arrayOfField($field, $parameter);
        return $this;
    }
    
    public function valueField($field, $parameter)
    {
        $rule = $this->rules->buildValue($parameter);
        return $this->addFieldRule($field, $rule);
    }
    
    public function documentField($field)
    {
        $rule = $this->rules->buildDocument($parameter);
        return $this->addFieldRule($field, $rule);
    }
    
    public function arrayOfField($field)
    {
        $rule = $this->rules->buildArrayOf($parameter);
        return $this->addFieldRule($field, $rule);
    }
    
    public function addFieldRule($field, $rule)
    {
        if(!array_key_exists($field, $this->fieldRules)) {
            $this->fieldRules[$field] = array();
        }
        
        $this->fieldRules[$field][]= $rule;
        return $rule;
    }
    
    public function validateValue()
    {
        if(!is_array($array)) {
            $result->error($this->errors->notArray());
        }
        
        foreach($this->fieldRules as $field => $rules) {
            $fieldResult = $result->field($field);
            foreach($rules as $rule) {
                $rule->validate($array[$key], $fieldResult);
            }
        }
    }
}