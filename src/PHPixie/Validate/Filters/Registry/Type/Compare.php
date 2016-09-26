<?php

namespace PHPixie\Validate\Filters\Registry\Type;

/**
 * Class Compare
 * @package PHPixie\Validate\Filters\Registry\Type
 */
class Compare extends \PHPixie\Validate\Filters\Registry\Implementation
{
    /**
     * @return array
     */
    public function filters()
    {
        return array(
            'min',
            'max',
            'greater',
            'less',
            'between',
            'equals',
            'in'
        );
    }

    /**
     * @param $value integer
     * @param $min integer
     * @return bool
     */
    public function min($value, $min)
    {
        return $value >= $min;
    }

    /**
     * @param $value integer
     * @param $max integer
     * @return bool
     */
    public function max($value, $max)
    {
        return $value <= $max;
    }

    /**
     * @param $value integer
     * @param $min integer
     * @return bool
     */
    public function greater($value, $min)
    {
        return $value > $min;
    }

    /**
     * @param $value integer
     * @param $max integer
     * @return bool
     */
    public function less($value, $max)
    {
        return $value < $max;
    }

    /**
     * @param $value integer
     * @param $min integer
     * @param $max integer
     * @return bool
     */
    public function between($value, $min, $max)
    {
        return ($value >= $min && $value <= $max);
    }

    /**
     * @param $value integer
     * @param $allowed integer
     * @return bool
     */
    public function equals($value, $allowed)
    {
        return $value === $allowed;
    }

    /**
     * @param $value integer
     * @param $allowed array
     * @return bool
     */
    public function in($value, $allowed)
    {
        return in_array($value, $allowed, true);
    }
}