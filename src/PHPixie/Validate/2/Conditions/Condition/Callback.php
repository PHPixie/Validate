<?php

namespace PHPixie\Validate\Conditions\Condition;

class Callback implements \PHPixie\Validate\Conditions\Condition
{
    protected $callback;
    
    public function __construct($callback)
    {
        $this->callback = $callback;
    }
    
    public function check($sliceData)
    {
        $callback = $this->callback;
        return $callback($sliceData);
    }
}