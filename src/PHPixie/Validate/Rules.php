<?php

namespace PHPixie\Validate;

/**
 * Class Rules
 * @package PHPixie\Validate
 */
class Rules
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Rules constructor.
     * @param $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param $callback string
     * @return Rules\Rule\Callback
     */
    public function callback($callback)
    {
        return new Rules\Rule\Callback($callback);
    }

    /**
     * @return Rules\Rule\Value
     */
    public function value()
    {
        return new Rules\Rule\Value($this);
    }

    /**
     * @return Rules\Rule\Filter
     */
    public function filter()
    {
        return new Rules\Rule\Filter(
            $this->builder->filters()
        );
    }

    /**
     * @return Rules\Rule\Data\Document
     */
    public function document()
    {
        return new Rules\Rule\Data\Document($this);
    }

    /**
     * @return Rules\Rule\Data\ArrayOf
     */
    public function arrayOf()
    {
        return new Rules\Rule\Data\ArrayOf($this);
    }
}
