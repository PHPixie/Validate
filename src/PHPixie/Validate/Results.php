<?php

namespace PHPixie\Validate;

use PHPixie\Validate\Results\Result\Root;

/**
 * Class Results
 * @package PHPixie\Validate
 */
class Results
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Results constructor.
     * @param $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param $value array|object
     * @return Results\Result\Root
     */
    public function root($value)
    {
        return new Results\Result\Root(
            $this,
            $this->builder->errors(),
            $value
        );
    }

    /**
     * @param $root Root
     * @param $path string
     * @return Results\Result\Field
     */
    public function field($root, $path)
    {
        return new Results\Result\Field(
            $this,
            $this->builder->errors(),
            $root,
            $path
        );
    }
}
