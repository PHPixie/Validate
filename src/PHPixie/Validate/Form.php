<?php

namespace PHPixie\Validate;

use PHPixie\Validate\Results\Result\Root as RootResult;
use PHPixie\Validate\Results\Result\Root;

class Form
{
    /** @var  Validator */
    protected $validator;

    /** @var RootResult|null */
    protected $result = null;

    /**
     * @param Validator $validator
     */
    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function submit($data)
    {
        $this->result = $this->validator->validate($data);
        return $this->result->isValid();
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->result !== null;
    }

    /**
     * @return Root
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * @return bool|null
     */
    public function isValid()
    {
        if($this->result === null) {
            return null;
        }

        return $this->result->isValid();
    }

    /**
     * @return array|null|object
     */
    public function data()
    {
        if($this->result === null) {
            return null;
        }

        return $this->result->getValue();
    }

    public function isFieldValid()
    {
        if($this->result === null) {
            return null;
        }

        $this->result->isValid();
    }

    /**
     * @param $field
     * @param null $default
     * @return mixed
     */
    public function fieldValue($field, $default = null)
    {
        if($this->result === null) {
            return $default;
        }

        return $this->result->getPathValue($field);
    }

    /**
     * @param $field
     * @return null|Errors\Error
     */
    public function fieldError($field)
    {
        if($this->result === null) {
            return null;
        }

        return $this->result->getPathError($field);
    }

    public function resultError()
    {
        if($this->result === null) {
            return null;
        }

        return $this->result->firstError();
    }

    public function __get($name)
    {
        return $this->fieldValue($name);
    }
}