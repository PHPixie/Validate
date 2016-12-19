<?php

namespace PHPixie\Validate\Rules\Rule;

use PHPixie\Validate\Builder;
use PHPixie\Validate\Filters;
use PHPixie\Validate\Results\Result;

/**
 * Class Filter
 * @package PHPixie\Validate\Rules\Rule
 */
class Filter implements \PHPixie\Validate\Rules\Rule
{
    /**
     * @var Filters
     */
    protected $filterBuilder;
    /**
     * @var array
     */
    protected $filters = array();

    /**
     * @var string
     */
    protected $customErrorType;
    
    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * Filter constructor.
     * @param $filterBuilder
     */
    public function __construct($filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @param $name string
     * @param array $parameters
     * @return $this
     */
    public function filter($name, $parameters = array())
    {
        $this->addFilter($name, $parameters);
        return $this;
    }

    /**
     * @param $filters array
     * @return $this
     */
    public function filters($filters)
    {
        foreach($filters as $key => $value) {
            if(is_numeric($key)) {
                $name       = $value;
                $parameters = array();

            }else{
                $name       = $key;
                $parameters = $value;
            }
            
            $this->addFilter($name, $parameters);
        }

        return $this;
    }

    /**
     * @param $name string
     * @param $parameters array
     */
    protected function addFilter($name, $parameters)
    {
        $filter = $this->filterBuilder->filter(
            $name,
            $parameters
        );

        $this->filters[]= $filter;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param $value
     * @param $result Result
     */
    public function validate($value, $result)
    {
        if(!is_scalar($value)) {
            $result->addScalarTypeError();
            return;
        }
        
        foreach($this->filters as $filter) {
            if(!$filter->check($value)) {
                $this->addError($result, $filter);
                break;
            }
        }
    }
    
    protected function addError($result, $filter)
    {
        if($this->customErrorType !== null) {
            $result->addCustomError($this->customErrorType, $this->errorMessage);
            return;
        }
        
        if($this->errorMessage !== null) {
            $result->addMessageError($this->errorMessage);
            return;
        }
        
        $result->addFilterError(
            $filter->name(),
            $filter->parameters()
        );
    }

    /**
     * @param string $customType
     * @param string $stringValue
     * @return $this
     */
    public function customError($customType, $stringValue = null)
    {
        $this->customErrorType = $customType;
        $this->errorMessage = $stringValue;
        return $this;
    }
    
    /**
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->errorMessage = $message;
        return $this;
    }

    /**
     * @param $method string
     * @param $arguments array
     * @return Filter
     */
    public function __call($method, $arguments)
    {
        return $this->filter($method, $arguments);
    }
}
