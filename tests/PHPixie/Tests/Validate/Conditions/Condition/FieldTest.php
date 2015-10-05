<?php

namespace PHPixie\Tests\Validate\Conditions\Condition;

/**
 * @coversDefaultClass \PHPixie\Validate\Conditions\Condition\Field
 */ 
class FieldTest extends \PHPixie\Test\Testcase
{
    protected $filters;
    protected $field = 'pixie';
    
    protected $condition;
    
    public function setUp()
    {
        $this->filters = $this->quickMock('\PHPixie\Validate\Filters');
        
        $this->condition = new \PHPixie\Validate\Conditions\Condition\Field(
            $this->filters,
            $this->field
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::filter
     * @covers ::getFilters
     * @covers ::<protected>
     */
    public function testFilter()
    {
        $filters[]= $this->prepareAddFilter('pixie');
        $this->condition->filter('pixie');
        
        $filters[]= $this->prepareAddFilter('trixie', array(5));
        $this->condition->filter('trixie', array(5));
        
        $this->assertSame($filters, $this->condition->getFilters());
    }
    
    /**
     * @covers ::__call
     * @covers ::<protected>
     */
    public function testCall()
    {
        $filters[]= $this->prepareAddFilter('pixie');
        $this->condition->pixie();
        
        $filters[]= $this->prepareAddFilter('trixie', array(5));
        $this->condition->trixie(5);
        
        $this->assertSame($filters, $this->condition->getFilters());
    }
    
    /**
     * @covers ::filters
     * @covers ::<protected>
     */
    public function testFilters()
    {
        $filters = array();
        
        $filters[]= $this->prepareAddFilter('pixie');
        $filters[]= $this->prepareAddFilter('trixie', array(5), 1);
        
        $this->condition->filters(array(
            'pixie',
            'trixie' => array(5)
        ));
        
        $this->assertSame($filters, $this->condition->getFilters());
    }
    
    /**
     * @covers ::check
     * @covers ::<protected>
     */
    public function testCheck()
    {
        $filters = array();
        for($i=0; $i<5; $i++) {
            $filter = $this->prepareAddFilter('pixie'.$i);
            $filters[]= $filter;
            
            $this->condition->filter('pixie'.$i);
        }
        
        $sliceData  = $this->quickMock('\PHPixie\Slice\Data');
        
        foreach(array(true, false) as $expects) {
            $this->method($sliceData, 'get', 'trixie', array($this->field), 0);
            foreach($filters as $key => $filter) {
                if(!$expects && $key > 3) {
                    continue;
                }
                
                $isValid = $expects || $key !== 3;
                $this->method($filter, 'check', $isValid, array('trixie'), 0);
                
                if(!$isValid) {
                    $this->method($filter, 'name', 'pixie3', array(), 1);
                }
            }
            
            $this->assertSame($expects, $this->condition->check($sliceData));
        }
    }
    
    protected function prepareAddFilter($name, $parameters = array(), $at = 0)
    {
        $filter = $this->quickMock('\PHPixie\Validate\Filters\Filter');
        $this->method($this->filters, 'filter', $filter, array($name, $parameters), $at);
        return $filter;
    }
}