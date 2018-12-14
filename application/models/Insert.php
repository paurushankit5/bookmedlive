<?php
	class Insert extends CI_Model
	{
		public function insert_table($array,$table)
		{
			if($this->db->insert($table,$array))
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
		 
		}
		
		public function insert_batch_table($array,$table)
		{
			if($this->db->insert_batch($table,$array))
			{
				return true;
			}
			else
			{
				return false;
			}
		 
		}
		
		 
	}
?>