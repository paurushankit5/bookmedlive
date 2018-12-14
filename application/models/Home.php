<?php
	class Home extends CI_Model
	{
		public function get_all_row($table,$where,$select,$order_by = 'id',$asc ='ASC')
		{
			$q 	=	$this->db->select($select)
							->where($where)
							->order_by($order_by,$asc)
							->get($table);
			return $q->result_array();
		}
		public function get_one_row($table,$where,$select){
			$q 	=	$this->db->select($select)
							->where($where)
							->get($table);
			return $q->row_array();
		}
		public function get_some_row($table,$where,$select,$limit,$offset,$order_by = 'id',$asc ='ASC')
		{
			$q 	=	$this->db->select($select)
							->where($where)
							->limit($limit,$offset)
							->order_by($order_by,$asc)
							->get($table);
			return $q->result_array();
		}
		public function checkrow($array,$table)
		{
			$q	=	$this->db->select('id')
								->where($array)
								->get($table);
			if($row=$q->unbuffered_row())
			{
				return $row->id;
			}
			else
			{
				return false;
			}
		}
		
	}
?>