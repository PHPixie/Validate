<?php

namespace PHPixie\Validate\Filters\Registries\Registry;

abstract class Implementation implements \PHPixie\Validate\Filters\Registries\Registry
{
    public function check($name, $value, $parameters)
    {
        $method = array($this, 'check'.ucfirst($name));
        array_unshift($parameters, $value);
        
        return call_user_func_array($method, $parameters);
    }
}