<?php

namespace PHPixie\Validate;

class Builder
{
    protected $instances = array();
    
    public function errors()
    {
        return $this->instance('errors');
    }
    
    public function filters()
    {
        return $this->instance('filters');
    }
    
    public function rules()
    {
        return $this->instance('rules');
    }
    
    public function result()
    {
        return new Result($this);
    }
    
    public function validator($rule)
    {
        return new Validator($this, $rule);
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildErrors()
    {
        return new Errors();
    }
    
    protected function buildFilters()
    {
        return new Filters();
    }
    
    protected function buildRules()
    {
        return new Rules($this);
    }
}
