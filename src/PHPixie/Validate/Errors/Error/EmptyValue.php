<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class EmptyValue
 * @package PHPixie\Validate\Errors\Error
 */
class EmptyValue extends \PHPixie\Validate\Errors\Error
{
    protected $errorMessage;

    public function __construct($errorMessage = null)
    {
        $this->errorMessage = $errorMessage;
    }

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
        if($this->errorMessage !== null) {
            return $this->errorMessage;
        }

        return "Value is empty";
    }
}
