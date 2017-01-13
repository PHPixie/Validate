<?php

namespace PHPixie\Validate\Results\Result;

use PHPixie\Validate\Errors;
use PHPixie\Validate\Results;

/**
 * Class Root
 * @package PHPixie\Validate\Results\Result
 */
class Root extends \PHPixie\Validate\Results\Result
{
    /**
     * @var array|object
     */
    protected $value;

    /**
     * Root constructor.
     * @param $results Results
     * @param $errorBuilder Errors
     * @param $value array|object
     */
    public function __construct($results, $errorBuilder, $value)
    {
        parent::__construct($results, $errorBuilder);
        
        $this->value = $value;
    }

    /**
     * @return array|object
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $path string
     * @return mixed|null
     */
    public function getPathValue($path)
    {
        $path = explode('.', $path);
        $value = $this->value;
        
        foreach($path as $step) {
            if(is_array($value) && array_key_exists($step, $value)) {
                $value = $value[$step];
                continue;
            }
            
            if(is_object($value) && property_exists($value, $step)) {
                $value = $value->$step;
                continue;
            }
            
            return null;
        }
        
        return $value;
    }

    /**
     * @param $path string
     * @return Errors\Error|null
     */
    public function getPathError($path)
    {
        $path = explode('.', $path);
        $result = $this;
        foreach ($path as $step) {
            if(!isset($result->fields[$step])) {
                return null;
            }

            $result = $result->fields[$step];
        }

        return $result->firstError();
    }

    /**
     * @param $path string
     * @return bool
     */
    public function isPathValid($path)
    {
        return $this->getPathError($path) === null;
    }


    /**
     * @param $path string
     * @return mixed
     */
    protected function buildFieldResult($path)
    {
        return $this->results->field($this, $path);
    }
}
