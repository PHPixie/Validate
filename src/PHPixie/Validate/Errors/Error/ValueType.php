<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class ValueType
 * @package PHPixie\Validate\Errors\Error
 */
abstract class ValueType extends \PHPixie\Validate\Errors\Error
{
    /**
     * @return string
     */
    public function type()
    {
        return 'valueType';
    }

    /**
     * @return string
     */
    abstract public function valueType();
}
