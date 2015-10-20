<?php

namespace PHPixie\Tests\Validate\Rules\Rule\Value;

/**
 * @coversDefaultClass \PHPixie\Validate\Rules\Rule\Value\Document
 */ 
class DocumentTest extends \PHPixie\Tests\Validate\Rules\Rule\ValueTest
{
    protected function value()
    {
        return new \PHPixie\Validate\Rules\Rule\Value\Document($this->rules);
    }
}