<?php

namespace PHPixie\Validate\Results;

abstract class Result
{
    protected $results;
    protected $errorBuilder;
    
    protected $errors = array();
    protected $fields = array();
    
    public function __construct($results, $errorBuilder)
    {
        $this->results      = $results;
        $this->errorBuilder = $errorBuilder;
    }
    
    public function field($field)
    {
        if(!array_key_exists($field, $this->fields)) {
            $result = $this->buildFieldResult($field);
            $this->fields[$field] = $result;
        }
        
        return $this->fields[$field];
    }
    
    public function fields()
    {
        return $this->fields;
    }
    
    public function invalidFields()
    {
        $invalidFields = array();
        
        foreach($this->fields() as $field => $result) {
            if(!$result->isValid()) {
                $invalidFields[$field] = $result;
            }
        }
        
        return $invalidFields;
    }
    
    public function isValid()
    {
        if(!empty($this->errors)) {
            return false;
        }
        
        return count($this->invalidFields()) === 0;
    }
    
    public function addEmptyValueError()
    {
        return $this->addError(
            $this->errorBuilder->emptyValue()
        );
    }
    
    public function addFilterError($filter)
    {
        return $this->addError(
            $this->errorBuilder->filter($filter)
        );
    }
    
    public function addMessageError($message)
    {
        return $this->addError(
            $this->errorBuilder->message($message)
        );
    }
    
    public function addCustomError($type, $stringValue = null)
    {
        return $this->addError(
            $this->errorBuilder->custom($type, $stringValue)
        );
    }
    
    public function addArrayTypeError()
    {
        return $this->addError(
            $this->errorBuilder->arrayType()
        );
    }
    
    public function addDocumentTypeError()
    {
        return $this->addError(
            $this->errorBuilder->documentType()
        );
    }
    
    public function addScalarTypeError()
    {
        return $this->addError(
            $this->errorBuilder->scalarType()
        );
    }
    
    public function addArrayCountError($count, $minCount, $maxCount = null)
    {
        return $this->addError(
            $this->errorBuilder->arrayCount($count, $minCount, $maxCount)
        );
    }
    
    public function addError($error)
    {
        $this->errors[]= $error;
        return $this;
    }
    
    public function errors()
    {
        return $this->errors;
    }
    
    abstract public function getValue();
    abstract protected function buildFieldResult($field);
}
