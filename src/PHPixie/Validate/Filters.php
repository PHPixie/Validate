<?php

namespace PHPixie\Validate;

class Filters
{
    protected $registries = array();
    protected $filterMap  = array();
    
    public function __construct($externalRegistries)
    {
        $this->registries[]= $this->buildStringRegistry();
        foreach($externalRegistries as $registry) {
            $this->registries[]= $registry;
        }
        
        foreach($this->registries as $registry) {
            foreach($registry->filters() as $name) {
                $this->filterMap[$name] = $registry;
            }
        }
    }
    
    public function checkFilter($filter, $value)
    {
        $name = $filter->name();
        if(!array_key_exists($name, $this->filterMap)) {
            throw new Exception("Filter '$name' does not exist");
        }
        
        $registry = $this->filterMap[$name];
        return $registry->check($name, $value, $filter->attributes());
    }
    
    public function filter($name, $arguments = array())
    {
        return new Filters\Filter($name, $arguments);
    }
}