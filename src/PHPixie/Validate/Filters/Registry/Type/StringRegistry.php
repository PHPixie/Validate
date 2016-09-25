<?php

namespace PHPixie\Validate\Filters\Registry\Type;

/**
 * Class StringRegistry
 * @package PHPixie\Validate\Filters\Registry\Type
 */
class StringRegistry extends \PHPixie\Validate\Filters\Registry\Implementation
{
    /**
     * @return array
     */
    public function filters()
    {
        return array(
            'length',
            'minLength',
            'maxLength',
            'lengthBetween'
        );
    }

    /**
     * @param $value string
     * @param $length integer
     * @return bool
     */
    public function length($value, $length)
    {
        return $this->getLength($value) === $length;
    }

    /**
     * @param $value string
     * @param $minLength integer
     * @return bool
     */
    public function minLength($value, $minLength)
    {
        return $this->getLength($value) >= $minLength;
    }

    /**
     * @param $value string
     * @param $maxLength integer
     * @return bool
     */
    public function maxLength($value, $maxLength)
    {
        return $this->getLength($value) <= $maxLength;
    }

    /**
     * @param $value string
     * @param $minLength integer
     * @param $maxLength integer
     * @return bool
     */
    public function lengthBetween($value, $minLength, $maxLength)
    {
        $length = $this->getLength($value);
        return ($length >= $minLength && $length <= $maxLength);
    }

    /**
     * @param $string string
     * @return int
     */
    protected function getLength($string)
    {
        return strlen(utf8_decode($string));
    }
}