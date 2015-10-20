<?php

namespace PHPixie\Validate\Rules\Rule\Structure;

class Document implements \PHPixie\Validate\Rules\Rule
{
    protected $rules;
    
    protected $fieldRules = array();
    protected $allowExtraFields = false;
    
    public function __construct($rules)
    {
        $this->rules = $rules;
    }
    
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
        $this->addField($field, $callback);
        return $this;
    }
    
    public function addField($field, $callback = null)
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
    
    public function validate($value, $result)
    {
        $resultAt = 0;
        
        if(!is_array($value)) {
            $result->addArrayTypeError();
            return;
        }
        
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