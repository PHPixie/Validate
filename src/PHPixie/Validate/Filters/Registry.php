<?php

namespace PHPixie\Validate\Filters;

/**
 * Interface Registry
 * @package PHPixie\Validate\Filters
 */
interface Registry
{
    /**
     * @param $name string
     * @param $value
     * @param $arguments array
     * @return mixed
     */
    public function callFilter($name, $value, $arguments);

    /**
     * @return array
     */
    public function filters();
}