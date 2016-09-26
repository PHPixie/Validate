<?php

namespace PHPixie\Validate;

/**
 * Class Filters
 * @package PHPixie\Validate
 */
class Filters
{
    /**
     * @var array
     */
    protected $externalRegistries;
    /**
     * @var array
     */
    protected $registries;
    /**
     * @var array
     */
    protected $filterMap;

    /**
     * Filters constructor.
     * @param array $externalRegistries
     */
    public function __construct($externalRegistries = array())
    {
        $this->externalRegistries = $externalRegistries;
    }

    /**
     * @return array
     */
    public function registries()
    {
        $this->requireRegistries();        
        return $this->registries;
    }

    /**
     * @return array
     */
    public function filterMap()
    {
        $this->requireFilterMap();
        return $this->filterMap;
    }

    protected function requireRegistries()
    {
        if($this->registries !== null) {
            return;
        }
        
        $this->registries = array_merge(
            $this->buildRegistries(),
            $this->externalRegistries
        );
    }
    
    protected function requireFilterMap()
    {
        if($this->filterMap !== null) {
            return;
        }
        
        $this->requireRegistries();
        
        $filterMap = array();
        
        foreach($this->registries as $registryKey => $registry) {
            foreach($registry->filters() as $name) {
                $filterMap[$name] = $registryKey;
            }
        }
        
        $this->filterMap = $filterMap;
    }

    /**
     * @return array
     */
    protected function buildRegistries()
    {
        return array(
            $this->buildCompareRegistry(),
            $this->buildPatternRegistry(),
            $this->buildStringRegistry()
        );
    }

    /**
     * @param $name string
     * @param $value
     * @param $arguments array
     * @return mixed
     * @throws Exception
     */
    public function callFilter($name, $value, $arguments = array())
    {
        $this->requireFilterMap();
        
        if(!array_key_exists($name, $this->filterMap)) {
            throw new \PHPixie\Validate\Exception("Filter '$name' does not exist");
        }
        
        $registryKey = $this->filterMap[$name];
        $registry = $this->registries[$registryKey];
        return $registry->callFilter($name, $value, $arguments);
    }

    /**
     * @param $name string
     * @param $arguments array
     * @return Filters\Filter
     */
    public function filter($name, $arguments = array())
    {
        return new Filters\Filter($this, $name, $arguments);
    }

    /**
     * @return Filters\Registry\Type\Compare
     */
    protected function buildCompareRegistry()
    {
        return new Filters\Registry\Type\Compare();
    }

    /**
     * @return Filters\Registry\Type\Pattern
     */
    protected function buildPatternRegistry()
    {
        return new Filters\Registry\Type\Pattern();
    }

    /**
     * @return Filters\Registry\Type\StringRegistry
     */
    protected function buildStringRegistry()
    {
        return new Filters\Registry\Type\StringRegistry();
    }
}