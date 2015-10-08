<?php

namespace PHPixie\Validate\Validators\Validator;

class Document
{
    protected $validators = array();
    protected $validatorFields = array();
    
    public function value($field, $callback = null)
    {
        $value = $this->validators->value();
        if($callback) {
            $callback($value);
        }
        
        $this->addFieldValidator($field, $value);
    }
    
    public function subdocument($field, $callback = null)
    {
        $value = $this->validators->document();
        if($callback) {
            $callback($value);
        }
        
        $this->addFieldValidator($field, $value);
    }
    
    public function subarray($field, $callback = null)
    {
        $subarray = $this->validators->subarray();
        if($callback) {
            $callback($subarray);
        }
        
        $this->addFieldValidator($field, $value);
    }
    
    public function document($field, $callback = null)
    {
        $value = $this->validators->document();
        if($callback) {
            $callback($value);
        }
        
        $this->addFieldValidator($field, $value);
    }
    
    protected function addFieldValidator($field, $validator)
    {
        $this->validators[]= $validator;
        
        $key = count($this->validators)-1;
        $this->validatorFields[$key] = $field;
    }
    
    public function callback($callback)
    {
        $callback = $this->validators->callback($callback);
        $this->validators[]= $callback;
    }
    
    public function validate($sliceData, $result, $rootResult)
    {
        foreach($this->validators as $key => $validator) {
            if(array_key_exists($key, $this->validatorFields)) {
                $field = $this->validatorFields[$key];
                $value = $sliceData->get($field);
                $validatorResult = $result->field($field);
            }else{
                $value = $sliceData;
                $validatorResult = $result;
            }
            
            $validator->validate($sliceData, $validatorResult, $rootResult);
        }
    }
