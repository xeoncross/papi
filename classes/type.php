<?php
// Abstract class for all Type-hint classes
abstract class Type
{
	public $value;
	public $name;
	
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}
	
	public function validate()
	{
		return FALSE;
	}
	
	public function error()
	{
		return 'Error not set for %s';
	}
}