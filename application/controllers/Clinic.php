<?php
	Class Clinic extends CI_Controller
	{
		public function details()
		{
			$this->load->model('select');
			ob_start();
			$array	=	array(
								'clinic_id'		=>	$this->uri->segment(3),
								'clinic_status'	=>	1,								
								);
			$clinic	=	$this->select->get_one_clinic($array);
			if(!count($clinic))
			{
				return redirect(base_url('Error404'));
			}
			$array	=	array(
								'doctor_clinic_id'		=>	$this->uri->segment(3),
								'doctor_status'	=>	1,								
								);
			$doctors	=	$this->select->get_some_doctors_name(999,0,$array);
			$cities		=	$this->select->get_all_cities();
			$speciality	=	$this->select->get_all_specialization();
			 
			$array	=	array(
							'doctors'	=>	$doctors,
							'clinic'	=>	$clinic,							 
						 
						 							 
							'cities'	=>	$cities,							 
							'speciality'=>	$speciality,							 
							 							 
							);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('home/clinicdetails',['array'	=>	$array]);
			 
		}
	 
	}
?>