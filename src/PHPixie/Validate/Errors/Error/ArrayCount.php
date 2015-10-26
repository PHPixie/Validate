<?php

namespace PHPixie\Validate\Errors\Error;

class ArrayCount extends \PHPixie\Validate\Errors\Error
{
    protected $count;
    protected $min;
    protected $max;
    
    public function __construct($count, $min = null, $max = null)
    {
        if($min === null && $max === null) {
            throw new \PHPixie\Validate\Exception("Neither minimum nor maximum count specified.");
        }
        
        $this->min = $min;
        $this->max = $max;
    }
    
    public function min()
    {
        return $this->min;
    }
    
    public function max()
    {
        return $this->max;
    }
    
    public function count()
    {
        return $this->count;
    }
    
    public function type()
    {
        return 'count';
    }
    
    public function asString()
    {
        return $this->type();
    }
    
}
