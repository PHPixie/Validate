<?php

namespace PHPixie\Validate\Rules\Rule;

class Callback implements \PHPixie\Validate\Rules\Rule
{
    protected $callback;
    
    public function __construct($callback)
    {
        $this->callback = $callback;
    }
    
    public function validate($result)
    {
        $value = $result->getValue();
        
        $callback = $this->callback;
        $callback($result, $value);
    }
}
