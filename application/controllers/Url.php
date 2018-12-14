<?php
	class Url extends CI_Controller
	{
		public function sessionurl(){
			$post	=	$this->input->post();
			$_SESSION['url']	=	$post['url'];
			echo 1;
		}
		
	}
	
?>