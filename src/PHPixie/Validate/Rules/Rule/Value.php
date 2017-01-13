<?php

namespace PHPixie\Validate\Rules\Rule;

use PHPixie\Validate\Results\Result;
use PHPixie\Validate\Rules;

/**
 * Class Value
 * @package PHPixie\Validate\Rules\Rule
 */
class Value implements \PHPixie\Validate\Rules\Rule
{
    /**
     * @var Rules
     */
    protected $ruleBuilder;

    /**
     * @var bool
     */
    protected $isRequired = false;

    /**
     * @var string
     */
    protected $requiredErrorMessage = null;

    /**
     * @var array
     */
    protected $rules      = array();

    /**
     * Value constructor.
     * @param $ruleBuilder Rules
     */
    public function __construct($ruleBuilder)
    {
        $this->ruleBuilder = $ruleBuilder;
    }

    /**
     * @param string $errorMessage
     * @return $this
     */
    public function required($errorMessage = null)
    {
        $this->isRequired = true;
        $this->requiredErrorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param null|callable $callback
     * @return $this
     */
    public function arrayOf($callback = null)
    {
        $this->addArrayOf($callback);
        return $this;
    }

    /**
     * @param null|callable $callback
     * @return Data\ArrayOf
     */
    public function addArrayOf($callback = null)
    {
        $rule = $this->ruleBuilder->arrayOf();
        if($callback !== null) {
            $callback($rule);
        }
        
        $this->addRule($rule);
        return $rule;
    }

    /**
     * @param null|callable $callback
     * @return $this
     */
    public function document($callback = null)
    {
        $this->addDocument($callback);
        return $this;
    }

    /**
     * @param null|callable $callback
     * @return Data\Document
     */
    public function addDocument($callback = null)
    {
        $rule = $this->ruleBuilder->document();
        if($callback !== null) {
            $callback($rule);
        }
        
        $this->addRule($rule);
        return $rule;
    }

    /**
     * @param null|mixed  $parameter
     * @param null|string $message
     * @param null|string $customErrorType
     * @return $this
     */
    public function filter($parameter = null, $message = null, $customErrorType = null)
    {
        $rule = $this->addFilter($parameter);
        $rule->customError($customErrorType, $message);
        return $this;
    }

    /**
     * @param null|mixed $parameter
     * @return Filter
     */
    public function addFilter($parameter = null)
    {
        $rule = $this->ruleBuilder->filter();
        $this->applyFilterParameter($rule, $parameter);
        
        $this->addRule($rule);
        return $rule;
    }

    /**
     * @param $callback string
     * @return Value
     */
    public function callback($callback)
    {
        $rule = $this->ruleBuilder->callback($callback);
        return $this->addRule($rule);
    }

    /**
     * @param $filterRule Filter
     * @param $parameter mixed
     * @throws \PHPixie\Validate\Exception
     */
    protected function applyFilterParameter($filterRule, $parameter)
    {
        if($parameter === null) {
            return;
        }
        
        if(is_string($parameter)) {
            $filterRule->filter($parameter);
            
        }elseif(is_callable($parameter)) {
            $parameter($filterRule);
            
        }elseif(is_array($parameter)) {
            $filterRule->filters($parameter);
            
        }else{
            $type = gettype($parameter);
            throw new \PHPixie\Validate\Exception("Invalid filter definition '$type'");
        }
    }

    /**
     * @param $rule Rules\Rule
     * @return $this
     */
    public function addRule($rule)
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * @param $value mixed
     * @param $result Result
     */
    public function validate($value, $result)
    {
        $isEmpty = in_array($value, array(null, ''), true);
        
        if($isEmpty) {
            if($this->isRequired) {
                $result->addEmptyValueError($this->requiredErrorMessage);
            }
            return;
        }
        
        foreach($this->rules() as $rule) {
            $rule->validate($value, $result);
        }
    }
}
