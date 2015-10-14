<?php

namespace PHPixie\Tests\Validate\Errors\Error\ValueType;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\ValueType\Scalar
 */ 
class ScalarTest extends \PHPixie\Tests\Validate\Errors\Error\ValueTypeTest
{
    protected $valueType = 'scalar';
    
    public function error()
    {
        return new \PHPixie\Validate\Errors\Error\ValueType\Scalar();
    }
}