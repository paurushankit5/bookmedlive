<?php
	Class Departments extends CI_Controller
	{
		public function index()
		{
				ob_start();
			$this->load->view('demo/department');
		}
	}
?>