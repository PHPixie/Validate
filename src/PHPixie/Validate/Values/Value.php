<?php

namespace PHPixie\Validate\Values;

/**
 * Class Value
 * @package PHPixie\Validate\Values
 */
abstract class Value
{
    /**
     * @var bool
     */
    protected $isRequired = false;
    /**
     * @var array
     */
    protected $rules = array();

    public function required()
    {
        $this->isRequired = true;
    }

    /**
     * @param $callback callable
     */
    public function callback($callback)
    {
        $rule = $this->ruleBuilder->callback($callback);
        $this->addRule($rule);
    }

    /**
     * @param $conditionCallback
     */
    public function conditional($conditionCallback)
    {
        $rule = $this->getConditionalRule();
        $rule = $this->ruleBuilder->callback($callback);
        $this->addRule($rule);
    }

    /**
     * @param $value
     * @param $result
     */
    public function validate($value, $result)
    {
        $isEmpty = in_array($value, array(null, ''), true);
        
        if($isEmpty) {
            if(!$this->isRequired) {
                $result->emptyError();
            }
            return;
        }
        
        $this->validateValue($value, $result);
    }
    
    protected function validateValue($value, $result);
}
