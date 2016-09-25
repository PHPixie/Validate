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
                $result->addFilterError(
                    $filter->name(),
                    $filter->parameters()
                );
                break;
            }
        }
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
