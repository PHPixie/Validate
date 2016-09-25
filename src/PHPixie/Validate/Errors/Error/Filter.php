<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class Filter
 * @package PHPixie\Validate\Errors\Error
 */
class Filter extends \PHPixie\Validate\Errors\Error
{
    /**
     * @var string
     */
    protected $filter;
    /**
     * @var array
     */
    protected $parameters;

    /**
     * Filter constructor.
     * @param $filter string
     * @param array $parameters
     */
    public function __construct($filter, $parameters = array())
    {
        $this->filter     = $filter;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'filter';
    }

    /**
     * @return string
     */
    public function filter()
    {
        return $this->filter;
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return "Value did not pass filter '{$this->filter}'";
    }
}
