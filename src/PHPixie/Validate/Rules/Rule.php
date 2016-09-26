<?php

namespace PHPixie\Validate\Rules;

use PHPixie\Validate\Results\Result;

/**
 * Interface Rule
 * @package PHPixie\Validate\Rules
 */
interface Rule
{
    /**
     * @param $value mixed
     * @param $result Result
     * @return mixed
     */
    public function validate($value, $result);
}
