<?php 
	class Error404 extends CI_Controller 
	{
		 
		public function index() 
		{ 
			 $this->load->view('home/error');//loading in my template 
		} 
		public function test(){
			$this->load->view('test');
		}
	
	} 
?>