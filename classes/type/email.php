<?php
// Force values to be valid emails
class Type_Email extends Type
{
	public function validate()
	{
		return is_string($this->value) AND preg_match('/^[A-Z0-9._%+-]{1,50}@[A-Z0-9.-]{1,50}\.[A-Z]{2,4}$/i', $this->value);
	}
	
	public function error()
	{
		return '%s is not a valid email';
	}
}