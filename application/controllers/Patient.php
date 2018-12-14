<?php
	class Patient extends MY_Controller{
		public function __construct()
		{
			parent ::__construct();
			 
			$this->load->model('select');
			 
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
			$_SESSION['page']= ''; 
			ob_start();
		}
		public function details(){
			$array 	=	array(
								"id"			=>	$this->uri->segment(3),
							);
			
			if(count($user 	=	$this->select->get_one_user($array)))
			{
				$array 	=	array(
									"user"		=>		$user
								);
				$this->load->view('home/patientdetails',['array'	=>	$array]);
			}
			else{
				//return redirect(base_url('Error404'));
			}

		}
	}

?>