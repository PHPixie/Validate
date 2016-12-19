<?php

namespace PHPixie\Validate\Rules\Rule;

/**
 * Class Callback
 * @package PHPixie\Validate\Rules\Rule
 */
class Callback implements \PHPixie\Validate\Rules\Rule
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * Callback constructor.
     * @param $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param $value
     * @param $result
     */
    public function validate($value, $result)
    {
        $callback = $this->callback;
        $return = $callback($result, $value);
        if($return !== null) {
            $result->addMessageError($return);
        }
    }
}
