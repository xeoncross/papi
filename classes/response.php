<?php
// JSON response object
class Response
{
	public $errors = array();
	public $messages = array();
	public $data = array();
	public $validation = array();

	public function addError($error)
	{
		$this->errors[] = $error;
	}

	public function addMessage($msg)
	{
		$this->messages[] = $msg;
	}

	public function addData($value)
	{
		$this->data = $value;
	}

	public function addValidationError($field, $error)
	{
		$this->validation[$field] = sprintf($error, $field);
	}
	
	public function __toString()
	{
		$obj = new stdClass();
		$obj->data = $this->data;
		$obj->errors = $this->errors;
		$obj->messages = $this->messages;
		$obj->validation = $this->validation;
		
		return json_encode($obj);
	}
}
