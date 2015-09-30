<?php

namespace PHPixie\Validate;

class Filters
{
    protected $filterMap;
    protected $negatedMap;
    
    public function __construct()
    {
        
    }
    
    public function filterMap()
    {
        foreach($this->repositories() as $repository) {
            $repositoryName = $repository->name();
            
            foreach($registry->filters() as $name) {
                $this->filterMap[$name] = array($repositoryName, false);
                
                $negated = 'not'.ucfirst($name);
                $this->negatedMap[$negated] = $name;
            }
        }
    }
    
    public function callFilter($name, $value, $arguments = array())
    {
        list($repositoryName, $name) = $this->filterMap[$name];
        $repository = $this->repositories[$repositoryName];
        return $repository->callFilter($name, $value, $arguments);
    }
    
    public function filterByName($name, $arguments = array(), $negate = false)
    {
        if(array_key_exists($name, $this->negatedMap)) {
            $negate = !$negate;
            $name   = $this->negatedMap[$name];
        }
        
        return $this->filter($name, $arguments, $negate);
    }
    
    public function filter($name, $arguments = array(), $negate = false)
    {
        return new Filters\Filter($name, $arguments, $negate);
    }
}