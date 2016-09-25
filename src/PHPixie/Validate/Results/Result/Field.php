<?php

namespace PHPixie\Validate\Results\Result;

use PHPixie\Validate\Errors;
use PHPixie\Validate\Results;

class Field extends \PHPixie\Validate\Results\Result
{
    /**
     * @var string
     */
    protected $path;

    /**
     * Field constructor.
     * @param $results Results
     * @param $errors Errors
     * @param $rootResult Root
     * @param $path string
     */
    public function __construct($results, $errors, $rootResult, $path)
    {
        parent::__construct($results, $errors);
        
        $this->rootResult = $rootResult;
        $this->path       = $path;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->rootResult->getPathValue($this->path);
    }

    /**
     * @param $path string
     * @return mixed
     */
    protected function buildFieldResult($path)
    {
        $path = $this->path.'.'.$path;
        return $this->results->field($this->rootResult, $path);
    }
}
