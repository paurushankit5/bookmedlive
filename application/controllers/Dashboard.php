<?php
	class Dashboard extends CI_Controller
	{
		public function index()
		{
				ob_start();
			$this->load->view('test');
		}
	}
?>