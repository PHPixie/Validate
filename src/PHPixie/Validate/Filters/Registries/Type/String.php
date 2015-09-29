<?php

namespace PHPixie\Validate\Filters\Registries\Type;

class String
{
	public function alpha($val) {
		return (bool) preg_match('/^\pL++$/uD', $val);
	}

	public function numeric($val) {
		return (bool) preg_match('#^[0-9]*$#',$val);
	}
	
	public function alphaNumeric($val) {
		return (bool) preg_match('/^[\pL\pN]++$/uD', $val);
	}
	
	public function slug($val) {
		return (bool) preg_match('/^[\pL\pN\-]++$/uD', $val);
	}
	
	public function decimal($val) {
		return (bool) preg_match('/^[0-9]+(?:\.[0-9]+)?$/D', $val);
	}
	
	
	public function phone($val) {
		return (bool) preg_match('#^[0-9\(\)\+ \-]*$#',$val);
	}
	
	public function between($val, $min, $max) {
		return ($val>=$min && $val<=$max);
	}
	
	public function matches($val,$regexp){
		return (bool) preg_match($regexp,$val);
	}
	
	public function url($val){
		return (bool) preg_match(
            '~^
			[-a-z0-9+.]++://
			(?!-)[-a-z0-9]{1,63}+(?<!-)
			(?:\.(?!-)[-a-z0-9]{1,63}+(?<!-)){0,126}+
			(?::\d{1,5}+)?
			(?:/.*)?
			$~iDx',
            $val);
	}
	
	public function email($val) {
		return (bool) preg_match(
            '/^
            [-_a-z0-9\'+*$^&%=~!?{}]++
			(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+
			@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.
            [a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})
			(?::\d++)?
            $/iDx',
            $val
        );
	}
	
	public function minLength($val, $min) {
		return $this->length($value)>=$min;
	}
	
	public function maxLength($val, $max) {
		return $this->length($value)<=$max;
	}
    
	public function lengthBetween($val, $min, $max) {
        $length = $this->length($value);
        return $this->between($length, $min, $max);
	}
	
	public function ruleIn($val,$allowed) {
		return in_array($val, $allowed, true);
	}
    
    protected function length($string)
    {
        return utf8_decode($string);
    }
}