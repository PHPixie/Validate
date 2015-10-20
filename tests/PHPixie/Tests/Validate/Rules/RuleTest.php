<?php

namespace PHPixie\Tests\Validate\Rules;


class Callback{
    public function __invoke()
    {
        
    }
}

abstract class RuleTest extends \PHPixie\Test\Testcase
{
    protected function ruleCallback($rule)
    {
        $callback = $this->quickMock('\PHPixie\Tests\Validate\Rules\Callback');
        $this->method($callback, '__invoke', null, array($rule), 0);
        return $callback;
    }
    
    protected function getRule()
    {
        return $this->quickMock('\PHPixie\Validate\Rules\Rule');   
    }
}