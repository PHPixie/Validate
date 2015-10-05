<?php

namespace PHPixie\Validate\Conditions;

interface Condition
{
    public function check($sliceData);
}