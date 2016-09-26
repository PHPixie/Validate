<?php

namespace PHPixie\Validate\Errors\Error\Data;

/**
 * Class ItemCount
 * @package PHPixie\Validate\Errors\Error\Data
 */
class ItemCount extends \PHPixie\Validate\Errors\Error
{
    /**
     * @var integer
     */
    protected $count;
    /**
     * @var integer
     */
    protected $minCount;
    /**
     * @var integer
     */
    protected $maxCount;

    /**
     * ItemCount constructor.
     * @param $count integer
     * @param $minCount integer
     * @param null|integer $maxCount
     * @throws \PHPixie\Validate\Exception
     */
    public function __construct($count, $minCount, $maxCount = null)
    {
        if($minCount === null && $maxCount === null) {
            throw new \PHPixie\Validate\Exception("Neither minimum nor maximum count specified.");
        }
        
        $this->count = $count;
        $this->minCount   = $minCount;
        $this->maxCount   = $maxCount;
    }

    /**
     * @return integer
     */
    public function minCount()
    {
        return $this->minCount;
    }

    /**
     * @return integer
     */
    public function maxCount()
    {
        return $this->maxCount;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'itemCount';
    }

    /**
     * @return string
     */
    public function asString()
    {
        $prefix = "Item count {$this->count} is not ";
        if($this->minCount !== null && $this->maxCount !== null) {
            return $prefix."between {$this->minCount} and $this->maxCount";
        }
        
        if($this->maxCount === null) {
            return $prefix."greater or equal to {$this->minCount}";
        }
        
        return $prefix."less or equal to {$this->maxCount}";
    }
    
}
