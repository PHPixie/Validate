<?php

namespace PHPixie\Validate\Results;

use PHPixie\Validate\Errors;
use PHPixie\Validate\Results;

/**
 * Class Result
 * @package PHPixie\Validate\Results
 */
abstract class Result
{
    /**
     * @var Results
     */
    protected $results;
    /**
     * @var Errors
     */
    protected $errorBuilder;

    /**
     * @var array
     */
    protected $errors = array();
    /**
     * @var array
     */
    protected $fields = array();

    /**
     * Result constructor.
     * @param $results Results
     * @param $errorBuilder Errors
     */
    public function __construct($results, $errorBuilder)
    {
        $this->results      = $results;
        $this->errorBuilder = $errorBuilder;
    }

    /**
     * @param $field string
     * @return mixed
     */
    public function field($field)
    {
        if(!array_key_exists($field, $this->fields)) {
            $result = $this->buildFieldResult($field);
            $this->fields[$field] = $result;
        }
        
        return $this->fields[$field];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
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

    /**
     * @return bool
     */
    public function isValid()
    {
        if(!empty($this->errors)) {
            return false;
        }
        
        return count($this->invalidFields()) === 0;
    }

    /**
     * @return Result
     */
    public function addEmptyValueError($message = null)
    {
        return $this->addError(
            $this->errorBuilder->emptyValue($message)
        );
    }

    /**
     * @param $filter string
     * @param array $arguments
     * @return Result
     */
    public function addFilterError($filter, $arguments = array())
    {
        return $this->addError(
            $this->errorBuilder->filter($filter, $arguments)
        );
    }

    /**
     * @param $message string
     * @return Result
     */
    public function addMessageError($message)
    {
        return $this->addError(
            $this->errorBuilder->message($message)
        );
    }

    /**
     * @param $type string
     * @param null|string $stringValue
     * @return Result
     */
    public function addCustomError($type, $stringValue = null)
    {
        return $this->addError(
            $this->errorBuilder->custom($type, $stringValue)
        );
    }

    /**
     * @return Result
     */
    public function addDataTypeError()
    {
        return $this->addError(
            $this->errorBuilder->dataType()
        );
    }

    /**
     * @return Result
     */
    public function addScalarTypeError()
    {
        return $this->addError(
            $this->errorBuilder->scalarType()
        );
    }

    /**
     * @param $count integer
     * @param $minCount integer
     * @param null|integer $maxCount
     * @return Result
     */
    public function addItemCountError($count, $minCount, $maxCount = null)
    {
        return $this->addError(
            $this->errorBuilder->itemCount($count, $minCount, $maxCount)
        );
    }

    /**
     * @param $fields array
     * @return Result
     */
    public function addInvalidFieldsError($fields)
    {
        return $this->addError(
            $this->errorBuilder->invalidFields($fields)
        );
    }

    /**
     * @param $error
     * @return $this
     */
    public function addError($error)
    {
        $this->errors[]= $error;
        return $this;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
    
    public function firstError()
    {
        if(!isset($this->errors[0])) {
            return null;
        }
        
        return $this->errors[0];
    }

    /**
     * @return mixed
     */
    abstract public function getValue();
    abstract protected function buildFieldResult($field);
}
