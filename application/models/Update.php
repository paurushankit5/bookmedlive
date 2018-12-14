<?php
	class Update extends CI_Model
	{
		 
		
		public function update_table($table_name,$column_name,$column_data,$array)
		{
			if($this->db->where($column_name,$column_data) 
					->update($table_name, $array))
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