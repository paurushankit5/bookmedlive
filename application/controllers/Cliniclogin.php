<?php
	Class Cliniclogin extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			if(isset($_COOKIE['clinic_id']))
			{
				return redirect (base_url('clinicdashboard'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			ob_start();
			date_default_timezone_set('Asia/kolkata');
		}
		public function index()
		{
			return redirect(base_url('login'));
		}
		 
		
		
	 
	}
?>