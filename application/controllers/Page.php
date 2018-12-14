<?php
	class Page extends CI_Controller{
		public function aboutus()
		{
			$this->load->view('home/aboutus');
		}
		public function confidentiality()
		{
			$this->load->view('home/confidentiality');
		}
		public function disclaimer()
		{
			$this->load->view('home/disclaimer');
		}
		public function privacy(){
			$this->load->view('home/privacy');
		}
		public function terms(){
			$this->load->view('home/terms');
		}
		public function refund(){
			$this->load->view('home/refund');
		}
		
	}
?>