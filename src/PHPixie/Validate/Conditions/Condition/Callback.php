<?php

namespace PHPixie\Validate\Conditions\Condition;

class Callback implements \PHPixie\Validate\Conditions\Condition
{
    protected $callback;
    
    public function __construct($callback)
    {
        $this->callback = $callback;
    }
    
    public function validate($sliceData)
    {
        $callback = $this->callback;
        return $callback($sliceData);
    }
}