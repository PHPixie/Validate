<?php

namespace PHPixie\Validate;

/**
 * Class Builder
 * @package PHPixie\Validate
 */
class Builder
{
    /**
     * @var array
     */
    protected $instances = array();

    /**
     * @return Errors
     */
    public function errors()
    {
        return $this->instance('errors');
    }

    /**
     * @return Filters
     */
    public function filters()
    {
        return $this->instance('filters');
    }

    /**
     * @return Results
     */
    public function results()
    {
        return $this->instance('results');
    }

    /**
     * @return Rules
     */
    public function rules()
    {
        return $this->instance('rules');
    }

    /**
     * @param $rule
     * @return Validator
     */
    public function validator($rule)
    {
        return new Validator(
            $this->results(),
            $rule
        );
    }

    /**
     * @param Validator $validator
     * @return Form
     */
    public function form($validator)
    {
        return new Form($validator);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }

    /**
     * @return Errors
     */
    protected function buildErrors()
    {
        return new Errors();
    }

    /**
     * @return Filters
     */
    protected function buildFilters()
    {
        return new Filters();
    }

    /**
     * @return Results
     */
    protected function buildResults()
    {
        return new Results($this);
    }

    /**
     * @return Rules
     */
    protected function buildRules()
    {
        return new Rules($this);
    }
}
