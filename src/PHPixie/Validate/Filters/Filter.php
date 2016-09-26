<?php

namespace PHPixie\Validate\Filters;

/**
 * Class Filter
 * @package PHPixie\Validate\Filters
 */
class Filter
{
    /**
     * @var Registry
     */
    protected $filters;
    /**
     * @var
     */
    protected $name;
    /**
     * @var array
     */
    protected $parameters;

    /**
     * Filter constructor.
     * @param $filters Registry
     * @param $name string
     * @param array $parameters
     */
    public function __construct($filters, $name, $parameters = array())
    {
        $this->filters   = $filters;
        $this->name      = $name;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function check($value)
    {
        return $this->filters->callFilter(
            $this->name,
            $value,
            $this->parameters
        );
    }
}
