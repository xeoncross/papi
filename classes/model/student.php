<?php

class Model_Student extends Model
{
	public $table = 'student';
	
	public function __construct()
	{
		// Load database
		parent::__construct();
		
		// Check user session perhaps?
		
		// Check API key?
		
		// Check your bank account to see if that VC funding came through?
	}
	
	public function byId($student_id = 1)
	{
		// Fetch the row
		$row = $this->db->row('SELECT * FROM '. $this->table. ' WHERE id = ?', array($student_id));
		
		// Return the row
		return array('user' => $row); 
	}
	
	public function getAll(Type_Integer $limit, Type_Integer $offset)
	{
		// Fetch the rows
		return $this->db->fetch('SELECT * FROM '. $this->table. ' LIMIT '. $offset->value. ','. $limit->value);
	}
}
