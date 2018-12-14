<?php
	Class Health extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!isset($_SESSION['clinic_id']))
			{
				return redirect (base_url('login'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			 
		}
		public function dashboard(){
			$this->load->view('health/dashboard');
		}
	}
?>