<?php

namespace PHPixie\Validate\Errors\Error\Data;

/**
 * Class InvalidFields
 * @package PHPixie\Validate\Errors\Error\Data
 */
class InvalidFields extends \PHPixie\Validate\Errors\Error
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * InvalidFields constructor.
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'invalidFields';
    }

    /**
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return 'Invalid Fields: '.implode(', ',$this->fields);
    }
}
