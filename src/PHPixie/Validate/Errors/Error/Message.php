<?php

namespace PHPixie\Validate\Errors\Error;

/**
 * Class Message
 * @package PHPixie\Validate\Errors\Error
 */
class Message extends \PHPixie\Validate\Errors\Error
{
    /**
     * @var string
     */
    protected $message;

    /**
     * Message constructor.
     * @param $message string
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'message';
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->message;
    }
}