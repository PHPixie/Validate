<?php

namespace PHPixie;

/**
 * Class Validate
 * @package PHPixie
 */
class Validate
{
    /**
     * @var Validate\Builder
     */
    protected $builder;

    /**
     * Validate constructor.
     */
    public function __construct()
    {
        $this->builder = $this->buildBuilder();
    }

    /**
     * @param null|string $callback
     * @return Validate\Validator
     */
    public function validator($callback = null)
    {
        $rule = $this->rules()->value();
        if($callback !== null) {
            $callback($rule);
        }
        return $this->buildValidator($rule);
    }

    /**
     * @param $rule
     * @return Validate\Validator
     */
    public function buildValidator($rule)
    {
        return $this->builder->validator($rule);
    }

    /**
     * @param Validate\Validator $validator
     * @return Validate\Form
     */
    public function form($validator)
    {
        return $this->builder->form($validator);
    }

    /**
     * @return mixed
     */
    public function rules()
    {
        return $this->builder->rules();
    }

    /**
     * @return Validate\Builder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * @return Validate\Builder
     */
    protected function buildBuilder()
    {
        return new Validate\Builder();
    }
}
