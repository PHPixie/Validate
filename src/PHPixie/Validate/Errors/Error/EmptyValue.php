<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class EmptyValue
 * @package PHPixie\Validate\Errors\Error
 */
class EmptyValue extends \PHPixie\Validate\Errors\Error
{
    /**
     * @return string
     */
    public function type()
    {
        return 'empty';
    }

    /**
     * @return string
     */
    public function asString()
    {
        return "Value is empty";
    }
}
