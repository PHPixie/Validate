<?php

namespace PHPixie\Validate\Filters\Registry;

/**
 * Class Implementation
 * @package PHPixie\Validate\Filters\Registry
 */
abstract class Implementation implements \PHPixie\Validate\Filters\Registry
{
    /**
     * @param string $name
     * @param $value
     * @param array $arguments
     * @return mixed
     * @throws \PHPixie\Validate\Exception
     */
    public function callFilter($name, $value, $arguments)
    {
        if(!in_array($name, $this->filters(), true)) {
            throw new \PHPixie\Validate\Exception("Filter $name does not exist");
        }
        
        array_unshift($arguments, $value);
        return call_user_func_array(array($this, $name), $arguments);
    }

    /**
     * @return mixed
     */
    abstract public function filters();
}