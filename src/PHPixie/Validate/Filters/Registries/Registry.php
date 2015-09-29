<?php

namespace PHPixie\Validate\Filters\Registries;

interface Registry
{
    public function check($name, $value, $parameters);
    public function filters();
}