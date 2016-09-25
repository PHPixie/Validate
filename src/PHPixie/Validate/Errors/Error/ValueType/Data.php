<?php

namespace PHPixie\Validate\Errors\Error\ValueType;

/**
 * Class Data
 * @package PHPixie\Validate\Errors\Error\ValueType
 */
class Data extends \PHPixie\Validate\Errors\Error\ValueType
{
    /**
     * @return string
     */
    public function valueType()
    {
        return 'data';
    }

    /**
     * @return string
     */
    public function asString()
    {
        return "Value is neither object nor array";
    }
}
