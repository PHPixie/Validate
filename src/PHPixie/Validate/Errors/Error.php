<?php

namespace PHPixie\Validate\Errors;

/**
 * Class Error
 * @package PHPixie\Validate\Errors
 */
abstract class Error
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }

    /**
     * @return string
     */
    abstract public function type();

    /**
     * @return string
     */
    abstract public function asString();
}