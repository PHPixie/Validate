<?php

namespace PHPixie;

class Validate
{
    protected $builder;
    
    public function __construct()
    {
        $this->builder = $this->buildBuilder();
    }
    
    public function documentValidator($callback = null)
    {
        $rule = $this->rules()->document();
        if($callback !== null) {
            $callback($rule);
        }
        return $this->validator($rule);
    }
    
    public function arrayValidator($callback = null)
    {
        $rule = $this->rules()->arrayOf();
        if($callback !== null) {
            $callback($rule);
        }
        return $this->validator($rule);
    }
    
    public function validator($rule)
    {
        return $this->builder->validator($rule);
    }
    
    public function rules()
    {
        return $this->builder->rules();
    }
    
    public function builder()
    {
        return $this->builder;
    }
    
    protected function buildBuilder()
    {
        return new Validate\Builder();
    }
}
