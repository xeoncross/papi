<?php
// Base model class
class Model
{
	public $db = NULL;
	
	public function __construct()
	{
		$this->db = new DB(config('database'));
	}
}
