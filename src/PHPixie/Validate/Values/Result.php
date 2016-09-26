<?php

namespace PHPixie\Validate\Values;

use PHPixie\Validate\Errors;
use PHPixie\Validate\Values;

/**
 * Class Result
 * @package PHPixie\Validate\Values
 */
class Result
{
    /**
     * @var Values
     */
    protected $values;
    /**
     * @var Errors
     */
    protected $errorBuilder;

    /**
     * @var array
     */
    protected $errors       = array();
    /**
     * @var array
     */
    protected $fieldResults = array();

    /**
     * Result constructor.
     * @param $values Values
     * @param $errorBuilder Errors
     */
    public function __construct($values, $errorBuilder)
    {
        $this->values       = $values;
        $this->errorBuilder = $errorBuilder;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function fieldResults()
    {
        return $this->fieldResults;
    }

    /**
     * @param $name string
     * @return Result
     */
    public function field($name)
    {
        if(!array_key_exists($name, $this->fieldResults)) {
            $this->fieldResults[$name] = $this->values->result();
        }
        
        return $this->fieldResults[$name];
    }

    /**
     * @param $name string
     * @param $result Result
     */
    public function setFieldResult($name, $result)
    {
        $this->fieldResults[$name] = $result;
    }

    /**
     * @return array
     */
    public function invalidFieldResults()
    {
        $invalidResults = array();
        
        foreach($this->fieldResults() as $field => $result) {
            if(!$result->isValid()) {
                $invalidResults[$field] = $result;
            }
        }
        
        return $invalidResults;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if(!empty($this->errors)) {
            return false;
        }
        
        return count($this->invalidFieldResults()) === 0;
    }

    /**
     * @return Result
     */
    public function addEmptyValueError()
    {
        return $this->addError(
            $this->errorBuilder->emptyValue()
        );
    }

    /**
     * @param $filterName string
     * @return Result
     */
    public function addFilterError($filterName)
    {
        return $this->addError(
            $this->errorBuilder->filter($filterName)
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
     * @param $customType string
     * @param null|string $stringValue
     * @return Result
     */
    public function addCustomError($customType, $stringValue = null)
    {
        return $this->addError(
            $this->errorBuilder->custom($customType, $stringValue)
        );
    }

    /**
     * @return Result
     */
    public function addArrayTypeError()
    {
        return $this->addError(
            $this->errorBuilder->arrayType()
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
     * @param $error Errors\Error\ValueType\Scalar
     * @return $this
     */
    public function addError($error)
    {
        $this->errors[]= $error;
        return $this;
    }

    /**
     * @param $extraKeys
     */
    public function addIvalidKeysError($extraKeys){}

    /**
     * @param $a
     * @param $b
     * @param $c
     */
    public function addArrayCountError($a,$b,$c){}
}
