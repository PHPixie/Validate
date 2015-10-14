<?php

namespace PHPixie\Tests\Validate\Errors\Error\ValueType;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\ValueType\ArrayType
 */ 
class ArrayTypeTest extends \PHPixie\Tests\Validate\Errors\Error\ValueTypeTest
{
    protected $valueType = 'array';
    
    public function error()
    {
        return new \PHPixie\Validate\Errors\Error\ValueType\ArrayType();
    }
}