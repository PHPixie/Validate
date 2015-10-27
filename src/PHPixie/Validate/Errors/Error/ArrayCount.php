<?php

namespace PHPixie\Validate\Errors\Error;

class ArrayCount extends \PHPixie\Validate\Errors\Error
{
    protected $count;
    protected $minCount;
    protected $maxCount;
    
    public function __construct($count, $minCount, $maxCount = null)
    {
        if($minCount === null && $maxCount === null) {
            throw new \PHPixie\Validate\Exception("Neither minimum nor maximum count specified.");
        }
        
        $this->count = $count;
        $this->minCount   = $minCount;
        $this->maxCount   = $maxCount;
    }
    
    public function minCount()
    {
        return $this->minCount;
    }
    
    public function maxCount()
    {
        return $this->maxCount;
    }
    
    public function count()
    {
        return $this->count;
    }
    
    public function type()
    {
        return 'arrayCount';
    }
    
    public function asString()
    {
        return $this->type();
    }
    
}
