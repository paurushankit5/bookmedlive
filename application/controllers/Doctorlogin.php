<?php
	Class Doctorlogin extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			if(isset($_COOKIE['doctor_id']))
			{
				return redirect (base_url('doctordashboard'));
			}
				ob_start(); 
			date_default_timezone_set('Asia/kolkata');
		}
		public function index()
		{
			return redirect('login');
		}
		 
		
		
	}
?>