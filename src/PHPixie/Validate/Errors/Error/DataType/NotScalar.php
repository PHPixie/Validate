<?php

namespace PHPixie\Validate\Errors\Error\DataType;

class NotScalar extends \PHPixie\Validate\Errors\DataType
{
    public function dataType()
    {
        return 'scalar';
    }
}