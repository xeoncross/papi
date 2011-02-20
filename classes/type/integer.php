<?php
// Force values to be integers
class Type_Integer extends Type
{
	public function validate()
	{
		return ctype_digit($this->value);
	}
	
	public function error()
	{
		return '%s is not numeric';
	}
}