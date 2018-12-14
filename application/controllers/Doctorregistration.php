<?php
	class Doctorregistration extends CI_Controller
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
			
			$this->load->model('select');
			$array	=	array('clinic_status'	=>	1);
			$clinic	=	$this->select->get_some_clinic(999,0,$array);
			$cities	=	$this->select->get_all_cities();
			//print_r($data);
			$array	=	array(
							'clinic'	=>	$clinic,
							'cities'	=>	$cities,
							);
			$this->load->view('home/doctorregistration',['array'	=>	$array]);
		}
		public function storedoctors()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$array	=	array('doctor_email'	=>	$post['doctor_email']);
			$this->load->model('select');
			if($this->select->checkdoctor($array))
			{
				$this->session->set_flashdata('regmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>This email is already taken.</b></div>');
				return redirect(base_url('doctorregistration'));
			}
			else if($post['doctor_password']	!= $post['doctor_password2'])
			{
				$this->session->set_flashdata('regmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>
				Passwords do not match.</b></div>');
				return redirect(base_url('doctorregistration'));
			}
			else
			{
				$this->load->model('insert');
				unset($post['doctor_password2']);
				if($doctor_id	=	$this->insert->insert_table($post,'doctor'))
				{
					setcookie('doctor_id', $doctor_id, time() + (86400 * 365), "/");
					$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="color:white;"><b>
					Congratulations!.. You are now registered. Please update your profile and education to activate your account.</b></div>');
					return redirect(base_url('doctordashboard/myprofile'));
				}
				else
				{
					$this->session->set_flashdata('regmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>
						Oops!... sytsem failure</b></div>');
					return redirect(base_url('doctorregistration'));
				}
			}
			
		}
	}

?>