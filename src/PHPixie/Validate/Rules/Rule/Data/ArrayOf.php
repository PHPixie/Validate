<?php

namespace PHPixie\Validate\Rules\Rule\Data;

use PHPixie\Validate\Results;
use PHPixie\Validate\Rules\Rule;

/**
 * Class ArrayOf
 * @package PHPixie\Validate\Rules\Rule\Data
 */
class ArrayOf extends \PHPixie\Validate\Rules\Rule\Data
{
    /**
     * @var null|integer
     */
    protected $minCount = null;
    /**
     * @var null|integer
     */
    protected $maxCount = null;

    /**
     * @var Rule
     */
    protected $keyRule;
    /**
     * @var Rule
     */
    protected $itemRule;

    /**
     * @param $minCount integer
     * @return $this
     */
    public function minCount($minCount)
    {
        $this->minCount = $minCount;
        return $this;
    }

    /**
     * @param $maxCount integer
     * @return $this
     */
    public function maxCount($maxCount)
    {
        $this->maxCount = $maxCount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinCount()
    {
        return $this->minCount;
    }

    /**
     * @return int|null
     */
    public function getMaxCount()
    {
        return $this->maxCount;
    }

    /**
     * @param null|callable $callback
     * @return $this
     */
    public function key($callback = null)
    {
        $this->valueKey($callback);
        return $this;
    }

    /**
     * @param null|callable $callback
     * @return mixed
     */
    public function valueKey($callback = null)
    {
        $rule = $this->buildValue($callback);
        $this->setKeyRule($rule);
        return $rule;
    }

    /**
     * @param $rule Rule
     * @return $this
     */
    public function setKeyRule($rule)
    {
        $this->keyRule = $rule;
        return $this;
    }

    /**
     * @return Rule
     */
    public function keyRule()
    {
        return $this->keyRule;
    }

    /**
     * @param null|callable $callback
     * @return $this
     */
    public function item($callback = null)
    {
        $this->valueItem($callback);
        return $this;
    }

    /**
     * @param null|callable $callback
     * @return Rule
     */
    public function valueItem($callback = null)
    {
        $rule = $this->buildValue($callback);
        $this->setItemRule($rule);
        return $rule;
    }

    /**
     * @param $rule Rule
     * @return $this
     */
    public function setItemRule($rule)
    {
        $this->itemRule = $rule;
        return $this;
    }

    /**
     * @return Rule
     */
    public function itemRule()
    {
        return $this->itemRule;
    }

    /**
     * @param $result Results\Result
     * @param $value array
     * @return array
     */
    public function validateData($result, $value)
    {
        $count = count($value);
        $min = $this->minCount;
        $max = $this->maxCount;
        
        if($min !== null && $count < $min || $max !== null && $count > $max) {
            $result->addItemCountError($count, $min, $max);
        }
        
        if($this->itemRule === null && $this->keyRule === null) {
            return array();
        }
        
        foreach($value as $key => $item) {
            $itemResult = $result->field($key);

            if($this->keyRule !== null) {
                $this->keyRule->validate($key, $itemResult);
            }

            if($this->itemRule !== null) {
                $this->itemRule->validate($item, $itemResult);
            }
        }
    }
}
