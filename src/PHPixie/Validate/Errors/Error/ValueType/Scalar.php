<?php

namespace PHPixie\Validate\Errors\Error\ValueType;

/**
 * Class Scalar
 * @package PHPixie\Validate\Errors\Error\ValueType
 */
class Scalar extends \PHPixie\Validate\Errors\Error\ValueType
{
    /**
     * @return string
     */
    public function valueType()
    {
        return 'scalar';
    }

    /**
     * @return string
     */
    public function asString()
    {
        return "Value is not scalar";
    }
}
