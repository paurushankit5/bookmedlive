<?php
	class Delete extends CI_Model
	{
		public function delete_table($array,$tablename)
		{
			if($this->db->where($array)
						->delete($tablename))
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