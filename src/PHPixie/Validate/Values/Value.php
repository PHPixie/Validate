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
     * @var string
     */
    protected $requiredErrorMessage = null;

    /**
     * @var array
     */
    protected $rules = array();

    public function required($errorMessage = null)
    {
        $this->isRequired = true;
        $this->requiredErrorMessage = $errorMessage;
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
     * @param $callback
     */
    public function conditional($callback)
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
                $result->emptyError($this->requiredErrorMessage);
            }
            return;
        }
        
        $this->validateValue($value, $result);
    }
    
    abstract protected function validateValue($value, $result);
}
