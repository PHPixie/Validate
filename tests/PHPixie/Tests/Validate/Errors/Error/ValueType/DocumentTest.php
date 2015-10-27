<?php

namespace PHPixie\Tests\Validate\Errors\Error\ValueType;

/**
 * @coversDefaultClass \PHPixie\Validate\Errors\Error\ValueType\Document
 */
class DocumentTest extends \PHPixie\Tests\Validate\Errors\Error\ValueTypeTest
{
    protected $valueType = 'document';
    
    public function error()
    {
        return new \PHPixie\Validate\Errors\Error\ValueType\Document();
    }
}
