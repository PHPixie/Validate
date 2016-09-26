<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class Custom
 * @package PHPixie\Validate\Errors\Error
 */
class Custom extends \PHPixie\Validate\Errors\Error
{
    /**
     * @var string
     */
    protected $count;
    /**
     * @var string
     */
    protected $stringValue;

    /**
     * Custom constructor.
     * @param $customType string
     * @param $stringValue null|string
     */
    public function __construct($customType, $stringValue = null)
    {
        $this->customType  = $customType;
        $this->stringValue = $stringValue;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'custom';
    }

    /**
     * @return string
     */
    public function customType()
    {
        return $this->customType;
    }

    /**
     * @return string
     */
    public function asString()
    {
        if($this->stringValue === null) {
            return $this->customType;
        }
        
        return $this->stringValue;
    }
}
