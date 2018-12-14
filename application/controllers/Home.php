<?php
	Class Home extends MY_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!$this->session->userdata('admin_id'))
			{
				return redirect (base_url('Error404'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			ob_start();
		}
		public function findmonthlypatientreport(){
			$post	=	$this->input->get();
		 	
			 
			$d=cal_days_in_month(CAL_GREGORIAN,$post['m'],$post['year']);
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($post['year'].'-'.$post['m'].'-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										 
									);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;	
				
				 
			}
			$array			=	array(
									 
										'monapp'					=>	$monapp,		
										
									);
			$this->load->view('admin/findmonthlypatientreport',['array'	=>	$array]);
		 
		 
			
		}
		public function index()
		{
			// get active doctors
			$array			=	array('doctor_clinic_id!='	=>	0,
										'doctor_status'		=>	1
									);
			$clinicdoctors	=	$this->select->count_some_doctor($array);
			
			//get individual doctors
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	1
									);
			$individualdoctors	=	$this->select->count_some_doctor($array);
			
			//get active clinic
			$array			=	array('clinic_status!='	=>	0,);
			$allclinic		=	$this->select->count_some_clinic($array);
			
			//get active diagnosis lab
			$array	=	array('path_status'	=>	1);
			$allpath		=	$this->select->count_some_path($array);
			
			//code to check pending individual doctors
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	0
										);
			$pendingindividualdoctor	=	$this->select->count_some_doctor($array);
			
			//code to check pending clinic doctors
			$array			=	array('doctor_clinic_id!='	=>	0,
										'doctor_status'		=>	0
										);
			$pendinginclinicdoctor	=		$this->select->count_some_doctor($array);
			
			
			//array to count pending clinics
			$array			=	array(
										'clinic_status'	=>	0,
									);
			$pendingclinic	=	$this->select->count_some_clinic($array);
			
			//array to count pending diagnosis lab
			$array	=	array('path_status'	=>	0);
			$pendingpath	=	$this->select->count_some_path($array);
			
			
			//count number of appointments for individul doctor
			$array	=	array('appointment_date'	=>	date('Y-m-d'),
								'appointment_status'=>	'APPROVED',
								'doctor_clinic_id'	=>	'0',										
							);
			$count_indi_doc_patient	=	$this->select->count_some_special_appointments($array);

								
			//count number of appointments for clinic doctor
			$array	=	array('appointment_date'	=>	date('Y-m-d'),
								'appointment_status'=>	'APPROVED',
								'doctor_clinic_id!='	=>	'0',										
							);
			$count_clinic_doc_patient	=	$this->select->count_some_special_appointments($array);
			//echo $count_clinic_doc_patient;
								
			//count number of appointments for pathology center
			$array	=	array(								 
								'path_ap_payment'	=>	'Transaction Successful',
								'path_ap_date'		=>	date('Y-m-d'),	
								'path_ap_status!='		=>	'Appointment Canecelled',
							);
			$count_path_appointment	=	$this->select->count_all_pathappointments($array);
			//echo $count_path_appointment;
			
			
			//code to get all the doctor appointments of this month
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										 
									);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;			
			}
			$array			=	array(
										'clinicdoctors'				=>	$clinicdoctors,
										'individualdoctors'			=>	$individualdoctors,
										'allclinic'					=>	$allclinic,
										'allpath'					=>	$allpath,
										'pendingindividualdoctor'	=>	$pendingindividualdoctor,
										'pendinginclinicdoctor'		=>	$pendinginclinicdoctor,
										'pendingclinic'				=>	$pendingclinic,
										'pendingpath'				=>	$pendingpath,
										'count_indi_doc_patient'	=>	$count_indi_doc_patient,
										'count_clinic_doc_patient'	=>	$count_clinic_doc_patient,
										'count_path_appointment'	=>	$count_path_appointment,
										'monapp'					=>	$monapp,
										
										
									);
			$this->load->view('admin/home',['array'	=>	$array]);
		}
		
		public function addpractitioners()
		{
			$clinic	=	$this->select->get_employee(999,0);
			$cities	=	$this->select->get_all_cities();
			//print_r($data);
			$array	=	array(
							'clinic'	=>	$clinic,
							'cities'	=>	$cities
							);
			$this->load->view('admin/addpractitioners',['array'	=>	$array]);
		}
		public function storepractitioner()
		{
			$this->load->model('select');
			$this->load->model('insert');
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
									'doctor_email'	=>	$post['doctor_email']
								);
			if($post['doctor_password']!=$post['doctor_password2'])
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><b>Passwords do not match.</b></div>');
				return redirect(base_url('home/addpractitioners'));
			}
			else if($this->select->checkdoctor($array))
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><b>Practitioner is already added.</b></div>');
				return redirect(base_url('home/addpractitioners'));
			}
			else
			{
				unset($post['doctor_password2']);
				if($this->insert->insert_table($post,'doctor'))
				{
					$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-success" style="background:green;color:white"><b>Practitioner added successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><bSystem Failure.</b></div>');
				}
				return redirect(base_url('home/addpractitioners'));
			}
			
			
		}
		
		public function practitioners()
		{
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/practitioners'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_all_practitioners(),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_practitioners($config['per_page'],$this->uri->segment(3));
			$array	=	array(
								'data'	=>	$data,
								);
			$this->load->view('admin/practitioners',['array'	=>	$array]);
			
		}
		public function singledoc()
		{
			// get active doctors count and list
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	1
									);
			$count_indi_doc	=	$this->select->count_some_doctor($array);
			$indi_doc		=	$this->select->get_some_doctors(100,0,$array);
			// get pending doctors count and list
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	0
									);
			
			$count_pending_doc	=	$this->select->count_some_doctor($array);
			$pending_indi_doc	=	$this->select->get_some_doctors(100,0,$array);
			$i=0;
			if(count($pending_indi_doc))
			{
				foreach($pending_indi_doc as $x)
				{
					$array			=	array('qualification_doctor_id'		=>	$x['doctor_id']);
					$qualification	=	$this->select->get_qualification_name($array);
					$pending_indi_doc[$i]['qualification']	=	$qualification;
					$i++;
				}
			}
			$i=0;
			if(count($indi_doc))
			{
				foreach($indi_doc as $x)
				{
					$array			=	array('qualification_doctor_id'		=>	$x['doctor_id']);
					$qualification	=	$this->select->get_qualification_name($array);
					$indi_doc[$i]['qualification']	=	$qualification;
					$i++;
				}
			}
			
			/*echo "<pre>";
			print_r($count_indi_doc);
			echo "<br>";
			 
			print_r($indi_doc);
			echo "<br>";
			 
			print_r($count_pending_doc);
			echo "<br>";
			
			 
			print_r($pending_indi_doc);
			echo "</pre>";
			*/
			
			$array		=	array(
									'indi_doc'			=>	$indi_doc,
									'count_indi_doc'	=>	$count_indi_doc,
									'count_pending_doc'	=>	$count_pending_doc,
									'pending_indi_doc'	=>	$pending_indi_doc,
									);
			$this->load->view('admin/singledoc',['array'	=>	$array]);
			
		}
		public function practitionerdetail()
		{
			/*$doctor_id	= $this->uri->segment(3);
			$array		=	array(
									'doctor_id'		=>		$doctor_id,
								);
			$doctor		=	$this->select->get_one_doctor($array);
			$array		=	array('qualification_doctor_id'	=>	$doctor_id);
			$qualification	=	$this->select->get_some_education($array);
			$array		=	array(
									'document_doctor_id'	=>	$doctor_id,
								);
			$document	=	$this->select->get_some_documents($array);
			if(count($doctor))
			{
				$array	=	array(
									'doctor'		=>	$doctor,
									'qualification'	=>	$qualification,
									'document'		=>	$document,
									);
				$this->load->view('admin/practitionerdetail',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('home/practitioners'));
			}*/
			$doctor_id	= $this->uri->segment(3);
			$array		=	array(
									'doctor_id'		=>		$doctor_id,									 
								);
			$doctor		=	$this->select->get_one_doctor($array);
			$array		=	array('qualification_doctor_id'	=>	$doctor_id);
			$qualification	=	$this->select->get_some_education($array);
			$array		=	array('document_doctor_id'	=>	$doctor_id);
			$document	=	$this->select->get_some_documents($array);			
			if(count($doctor))
			{
				$array	=	array(
									'document'		=>	$document,
									'qualification'	=>	$qualification,
									'doctor'	=>	$doctor,
									 
									);
				$this->load->view('admin/practitionerdetail',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('home'));
			}
			
		}
		
		public function signout()
		{
			unset($_SESSION['admin_id']);
			return redirect(base_url('adminlogin'));
		}
		
		public function addemployee()
		{
			$this->load->view('admin/addemployee');
		}
		
		public function storeemployee()
		{
			$this->load->model('select');
			$this->load->model('insert');
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
									'clinic_email'	=>	$post['clinic_email']
								);
			if($post['clinic_password']!=$post['clinic_password2'])
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger" style="background:red;color:white"><b>Passwords do not match.</b></div>');
			}
			else if($this->select->checkemployee($array))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger" style="background:red;color:white"><b>Clinic is already added.</b></div>');
			}
			else
			{
				unset($post['clinic_password2']);
				if($this->insert->insert_table($post,'clinic'))
				{
					$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success" style="background:green;color:white"><b>Clinic  added successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger" style="background:red;color:white"><b>System Failure.</b></div>');
				}				
			}
			return redirect(base_url('home/addemployee'));
		}
		
		public function clinicemployee()
		{
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/clinicemployee'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_all_employee(),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_employee($config['per_page'],$this->uri->segment(3));
			$array	=	array(
								'data'	=>	$data,
								);
			//echo "<pre>";
			//print_r($data);
			$this->load->view('admin/clinicemployee',['array'	=>	$array]);
		}
		public function addpathology()
		{
			$this->load->view('admin/addpathology');
		}
		public function pathlist()
		{
			$array	=	array(1	=>	1);
			$path	=	$this->select->findpathology($array);
			//echo "<pre>";
			//print_r($path);
			$array	=	array('path'	=>	$path);
			$this->load->view('admin/pathlist',['array'	=>	$array]);
		}
		public function editpath()
		{
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			$cities =	$this->select->get_all_cities();
			$array	=	array(
								'path'		=>	$path,
								'cities'	=>	$cities,
							);
			//print_r($array);
			$this->load->view('admin/editpath',['array'	=>	$array]);
		}
		public function updatepath()
		{
			$post	=	$this->input->post();
			$preimage	=	$post['preimage'];
			unset($post['preimage']);
			if($_FILES['path_image']['name']!='')
			{
				$post['path_image']	=	$_FILES['path_image']['name'];
				if(!file_exists('./images/path/'.$_COOKIE['path_id'].'/'))
				{
					mkdir('./images/path/'.$_COOKIE['path_id'].'/'); 
				}
				@unlink("./images/path/".$_COOKIE['path_id']."/".$preimage);
				move_uploaded_file($_FILES['path_image']['tmp_name'],"./images/path/".$_COOKIE['path_id']."/".$post['path_image']);
			}
			if($this->update->update_table('pathology','path_id',$post['path_id'],$post))
			{
				$this->session->set_flashdata('pathmsg','<div class="alert alert-success"><b>Congratulations!.. Pathology profile has been updated.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('pathmsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
			}
			
			return redirect(base_url('home/viewpath/'.$post['path_id']));
		}
		public function storepath()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$array	=	array(
								'path_email'		=>		$post['path_email']
							);
			 
			if($post['path_password']!=$post['path_password2'])
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="color:white;background:red;"><b>Passwords do not match.</b></div>');
				
			}
			else if($this->select->checkpathology($array))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="color:white;background:red;"><b>This user already exists.</b></div>');
				 
			}
			else 
			{
				unset($post['path_password2']);
				if($this->insert->insert_table($post,'pathology'))
				{
					$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="color:white;background:green;"><b>Congratulations! You are successfully registered.</b></div>');
					 
				}
				else
				{
					$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="color:white;background:red;"><b>OOPS! System Failure.</b></div>');
				 
				}
			}
			return redirect(base_url('home/addpathology'));
		}
		public function viewclinicdoctors()
		{
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$clinic_id);
			if(count($clinic		=	$this->select->get_one_clinic($array)))
			{
				$array			=	array(
											'doctor_clinic_id'		=>	$clinic_id,
											);
				$this->load->library('pagination');		
				$config		=	array(
									'base_url'		=>		base_url('home/viewclinicdoctors/'.$this->uri->segment(3)),
									'per_page'		=>		'10',
									'total_rows'	=>		$this->select->count_some_doctor($array),
									'full_tag_open'	=>		"<ul class='pagination'>",
									'full_tag_close'=>		"</ul>",
									'next_tag_open'=>		"<li>",
									'next_tag_close'=>		"</li>",
									'prev_tag_open'=>		"<li>",
									'prev_tag_close'=>		"</li>",
									'num_tag_open'=>		"<li>",
									'num_tag_close'=>		"</li>",
									'cur_tag_open'=>		"<li class='active'><a>",
									'cur_tag_close'=>		"</a></li>",
									 
									
								);
				$this->pagination->initialize($config);			
				$data	=	$this->select->get_some_doctors($config['per_page'],$this->uri->segment(4),$array);
				$array	=	array(
									'data'	=>	$data,
									'count'	=>	$this->uri->segment(4),									
									);
				$this->load->view('admin/viewclinicdoctors',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home/clinicemployee'));
			}
			
		}
		public function editclinic()
		{
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$clinic_id);
			$cities	=	$this->select->get_all_cities();			
			if(count($clinic		=	$this->select->get_one_clinic($array)))
			{
				 $array		=	array(
									'clinic'	=>	$clinic,
									'cities' 	=>	$cities,
									);
				 $this->load->view('admin/editclinic',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home/clinicemployee'));
			}
		}
		public function updateclinic()
		{
			$post	=	$this->input->post();
			print_r($post);
			if($this->update->update_table('clinic','clinic_id',$post['clinic_id'],$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Congratulations!.. Clinic details has been updated.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
			}
			
			return redirect(base_url('home/clinicdetails/'.$post['clinic_id']));
		}
		public function editdoctorprofile()
		{
			$array	=	array(			 
			'doctor_id'			=>	$this->uri->segment(3)
			);
			if(count($doctor	=	$this->select->get_one_doctor($array)))
			{
				$cities	=	$this->select->get_all_cities();
			$array	=	array(
								'doctor'	=>	$doctor,								 	
								'cities'	=>	$cities,								 	
								);
			$this->load->view('admin/editdoctorprofile',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('home'));
			}
			
		}
		public function updatedoctorprofile()
		{
			$post	=	$this->input->post();
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Profile updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');
			}
			return redirect(base_url('home/practitionerdetail/'.$post['doctor_id']));
		}
		public function editdoctorfees()
		{
			$array	=	array(
								'doctor_id'			=>	$this->uri->segment(3)
							);
			if(count($doctor	=	$this->select->get_one_doctor($array)))
			{
				$array	=	array('doctor'	=>	$doctor,
									 
								);
				$this->load->view('admin/editdoctorfees',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('home'));
			}
		}
		
		public function updatedoctorfee()
		{
			$post['doctor_mon']=	0;
			$post['doctor_tues']=	0;
			$post['doctor_wed']=	0;
			$post['doctor_thurs']=	0;
			$post['doctor_fri']=	0;
			$post['doctor_sat']=	0;
			$post['doctor_sun']=	0;
			$post	=	$this->input->post();
			echo "<pre>";
			//print_r($post);
			if(!isset($post['doctor_mon']))
			{
				$post['doctor_mon']=	0;
			}
			if(!isset($post['doctor_tues']))
			{
				$post['doctor_tues']=	0;
			}
			if(!isset($post['doctor_wed']))
			{
				$post['doctor_wed']=	0;
			}
			if(!isset($post['doctor_thurs']))
			{
				$post['doctor_thurs']=	0;
			}
			if(!isset($post['doctor_fri']))
			{
				$post['doctor_fri']=	0;
			}
			if(!isset($post['doctor_sat']))
			{
				$post['doctor_sat']=	0;
			}
			if(!isset($post['doctor_sun']))
			{
				$post['doctor_sun']=	0;
			}
			
			//$post['doctor_qualification']	=	implode(",",$post['doctor_qualification']);
			//print_r($post);
			 
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b>Consultancy fees and time slots updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('home/practitionerdetail/'.$post['doctor_id']));
		}
		public function patientlist()
		{
			$array	=	array(
			1	=>	1,
			
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/patientlist'),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_patients($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$patients	=	$this->select->get_all_patients($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'patients'	=>	$patients,								 
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			//echo $this->select->count_some_patients($array);
			$this->load->view('admin/patientlist',['array'	=>	$array]);
		}
		public function viewpatientdetails()
		{
			$patient_id	=	$this->uri->segment(3);
			$array	=	array('patient_id'	=>	$patient_id);
			if(count($patient=	$this->select->get_one_patient($array)))
			{				
				$array	=	array(
									'prescription_patient_id'	=>	$patient_id
									);
				$prescription	=	$this->select->get_all_prescription($array);
				$array	=	array(
									'patient'		=>	$patient,
									'prescription'	=>	$prescription,
									 
									
								);
				$this->load->view('admin/viewpatientdetails',['array'	=>	$array]);
			}
			else
			{
				$this->session->set_flashdata('patientmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>Invalid Url.</b></div>');
				return redirect(base_url('doctordashboard/mypatients'));
			}
			
		}
		public function addpatient()
		{
			$this->load->view('admin/addpatient');
		}
		public function storepatient()
		{
			
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$array	=	array(
								'patient_email'		=>		$post['patient_email']
							);
			$this->load->model('select');
			$this->load->model('insert');
			if($post['patient_password']!=$post['patient_password2'])
			{
				$this->session->set_flashdata('addepatientmsg','<div class="alert alert-success" style="color:white;background:red;"><b>Passwords do not match.</b></div>');
				 
			}
			else if($this->select->checkpatient($array))
			{
				$this->session->set_flashdata('addepatientmsg','<div class="alert alert-success" style="color:white;background:red;"><b>This user already exists.</b></div>');
		 
			}
			else 
			{
				unset($post['patient_password2']);
				if($this->insert->insert_table($post,'patient'))
				{
					$this->session->set_flashdata('addepatientmsg','<div class="alert alert-success" style="color:white;background:green;"><b>Congratulations! Patient has been added successfully.</b></div>');
					 
				}
				else
				{
					$this->session->set_flashdata('addepatientmsg','<div class="alert alert-success" style="color:white;background:red;"><b>OOPS! System Failure.</b></div>');
					 
				}
			}
			return redirect(base_url('home/addpatient'));
		}
		public function editpatientdetails()
		{
			$array	=	array('patient_id'	=>	$this->uri->segment(3));
			if(count($patient	=	$this->select->get_one_patient($array)))
			{
				$array	=	array('patient'	=>	$patient,
						 
							);
				$this->load->view('admin/editpatientdetails',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home'));
			}
			
		}
		public function updatepatientprofile()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('patient','patient_id',$post['patient_id'],$post))
			{
				$this->session->set_flashdata('patientmsg','<div class="alert alert-success" style="background:green;color:white;"><b>Patient Profile updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('patientmsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('home/viewpatientdetails/'.$post['patient_id']));
		}
		public function servicecharge()
		{
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			//print_r($settings);
			$array		=	array('settings'	=>	$settings);
			$this->load->view('admin/servicecharge',['array'	=>	$array]);
		}
		public function updateservicecharge()
		{
			$post	=	$this->input->post();
			if($this->update->update_table('settings','settings_id',$post['settings_id'],$post))
			{
				$this->session->set_flashdata('servicemsg','<div class="alert alert-success" style="background:green;color:white;"><b> Service Charge updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('servicemsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');
			}
			return redirect(base_url('home/servicecharge/'));
			
		}
		public function updateclinicstatus()
		{
			$post	=	$this->input->post();
			
			if($this->update->update_table('clinic','clinic_id',$post['clinic_id'],$post))
			{
				$this->session->set_flashdata('employeemsg','<div class="alert alert-success" style="background:green;color:white;"><b> Clinic status updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('employeemsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');
			}
			echo "1";
		}	
		public function updatedoctorstatus()
		{
			$post	=	$this->input->post();
			
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Doctor status updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');
			}
			echo "1";
		}	
		public function updatepathstatus()
		{
			$post	=	$this->input->post();
			
			if($this->update->update_table('pathology','path_id',$post['path_id'],$post))
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Daignosis Center status updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');
			}
			echo "1";
		}	
		public function storebankdetails()
		{
			$post	=	$this->input->post();
			
			if($this->insert->insert_table($post,'bank_account'))
			{
				$this->session->set_flashdata('singledocmsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details added successfully.</b></div>');
				echo "1";
			}
			else
			{
				$this->session->set_flashdata('singledocmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
				echo "0";
			}
			
		}
		public function checkandstoreclinicbankdetails()
		{
			$post	=	$this->input->post();
			$array	=	array('bank_ac_clinic_id'	=>	$post['bank_ac_clinic_id']);
			if($this->select->checkbankdetails($array))
			{
				if($this->update->update_table('bank_account','bank_ac_clinic_id',$post['bank_ac_clinic_id'],$post))
				{
					$this->session->set_flashdata('employeemsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details updated successfully.</b></div>');
					echo "1";
				}	
				else
				{
					$this->session->set_flashdata('employeemsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}				
			}
			else
			{
				if($this->insert->insert_table($post,'bank_account'))
				{
					$this->session->set_flashdata('employeemsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details added successfully.</b></div>');
					echo "1";
				}
				else
				{
					$this->session->set_flashdata('employeemsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}
			}		
		}
		public function checkandstorepathbankdetails()
		{
			$post	=	$this->input->post();
			$array	=	array('bank_ac_path_id'	=>	$post['bank_ac_path_id']);
			if($this->select->checkbankdetails($array))
			{
				if($this->update->update_table('bank_account','bank_ac_path_id',$post['bank_ac_path_id'],$post))
				{
					$this->session->set_flashdata('pathmsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details updated successfully.</b></div>');
					echo "1";
				}	
				else
				{
					$this->session->set_flashdata('pathmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}				
			}
			else
			{
				if($this->insert->insert_table($post,'bank_account'))
				{
					$this->session->set_flashdata('pathmsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details added successfully.</b></div>');
					echo "1";
				}
				else
				{
					$this->session->set_flashdata('pathmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}
			}		
		}
		public function checkandstoredoctorbankdetails()
		{
			$post	=	$this->input->post();
			$array	=	array('bank_ac_doctor_id'	=>	$post['bank_ac_doctor_id']);
			if($this->select->checkbankdetails($array))
			{
				if($this->update->update_table('bank_account','bank_ac_doctor_id',$post['bank_ac_doctor_id'],$post))
				{
					$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details updated successfully.</b></div>');
					echo "1";
				}	
				else
				{
					$this->session->set_flashdata('practitionermsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}				
			}
			else
			{
				if($this->insert->insert_table($post,'bank_account'))
				{
					$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Bank details added successfully.</b></div>');
					echo "1";
				}
				else
				{
					$this->session->set_flashdata('practitionermsg','<div class="alert alert-danger" style="background:red;color:white;"><b>System Failure.</b></div>');
					echo "0";
				}
			}		
		}
		
		public function clinic()
		{
			//get pending clinic count and details
			 $array	=	array(
								'clinic_status'	=>	0,
							);
			$count_pending_clinic	=	$this->select->count_some_clinic($array);
			$pending_clinic	=	$this->select->get_some_clinic(1000,0,$array);
			
			//get activated clinic count and details
			 $array	=	array(
								'clinic_status'	=>	1,
							);
			$count_activated_clinic	=	$this->select->count_some_clinic($array);
			$activated_clinic	=	$this->select->get_some_clinic(1000,0,$array);
			
			
			/*echo "<pre>";
			print_r($count_pending_clinic);
			print_r($pending_clinic);
			print_r($count_activated_clinic);
			print_r($activated_clinic);
			echo "</pre>";
			*/
			$array	=	array(
								'count_pending_clinic'		=>	$count_pending_clinic,
								'pending_clinic'			=>	$pending_clinic,
								'count_activated_clinic'	=>	$count_activated_clinic,
								'activated_clinic'		=>	$activated_clinic,
								);
			$this->load->view('admin/clinic',['array'	=>	$array]);
		}
		public function searchclinic()
		{
			$post	=	$this->input->get();
			$clinic	=	$this->select->search_clinic($post['clinic_name']);
			$array	=	array(
								'clinic'	=>	$clinic
								);
			
			$this->load->view('admin/searchclinic',['array'	=>	$array]);
		}
		public function patient()
		{
			$array	=	array(
								1	=>	1,			
							);
			$all_patient	=	$this->select->count_all_patients($array);
			//count todays appointment for individual doctors	 
			$array		=	array(
									'doctor_clinic_id'		=>	0,
									'appointment_date'		=>	date('Y-m-d'),									
									'appointment_status'	=>	'APPROVED',									
									);
			$indi_today_appointment	=	$this->select->count_some_special_appointments($array);
			//echo $this->db->last_query()."<br><br>";			
			$array		=	array(
									'doctor_clinic_id'		=>	0,
									'appointment_status'	=>	'APPROVED',	
									'appointment_date'		=>	date('Y-m-d', time() + 86400),										
									);
			$indi_upcoming_appointment	=	$this->select->count_some_special_appointments($array);
			//echo $this->db->last_query()."<br><br>";
			$first 	=	date('Y-m-d');
			$last 	=	date('Y-m-31');
			$sql	=	"SELECT * FROM appointment JOIN doctor ON doctor_id=appointment_doctor_id WHERE doctor_clinic_id ='0' AND appointment_date between '$first' AND '$last' AND appointment_status = 'APPROVED'";
			$indi_this_month_appointment	=	$this->select->count_query_wise_appointments($sql);
			//echo $this->db->last_query()."<br><br>";
			
			
			//count todays appointment for clinic doctors	 
			$array		=	array(
									'doctor_clinic_id!='		=>	0,
									'appointment_date'		=>	date('Y-m-d'),									
									'appointment_status'	=>	'APPROVED',									
									);
			$clinic_today_appointment	=	$this->select->count_some_special_appointments($array);
			//echo $this->db->last_query()."<br><br>";			
			$array		=	array(
									'doctor_clinic_id!='		=>	0,
									'appointment_status'	=>	'APPROVED',	
									'appointment_date'		=>	date('Y-m-d', time() + 86400),										
									);
			$clinic_upcoming_appointment	=	$this->select->count_some_special_appointments($array);
			//echo $this->db->last_query()."<br><br>";
			$first 	=	date('Y-m-d');
			$last 	=	date('Y-m-31');
			$sql	=	"SELECT * FROM appointment JOIN doctor ON doctor_id=appointment_doctor_id WHERE doctor_clinic_id !='0' AND appointment_date between '$first' AND '$last' AND appointment_status = 'APPROVED'";
			$clinic_this_month_appointment	=	$this->select->count_query_wise_appointments($sql);
			//echo $this->db->last_query()."<br><br>";
			
			
			//code for pathology
			$array	=	array(
								'path_ap_status'	=>	'APPROVED',
								'path_ap_date'		=>	date('Y-m-d'),
								);
			$path_today		=	$this->select->count_all_pathappointments($array);
			$array	=	array(
								'path_ap_status'	=>	'APPROVED',
								'path_ap_date'		=>	date('Y-m-d',time()+86400),
								);
			$path_upcoming		=	$this->select->count_all_pathappointments($array);
			$sql	=	"SELECT * FROM path_appointment   WHERE   path_ap_date between '$first' AND '$last' AND path_ap_status = 'APPROVED'";
			$path_this_month_appointment	=	$this->select->count_query_wise_appointments($sql);
			//echo $this->db->last_query();
			
			//get individual doctors name
			$array	=	array(	
								'doctor_status'			=>			1,
								'doctor_clinic_id'		=>			0
							);
			$indi_doc	=	$this->select->get_some_doctors_name(1000,0,$array);
			if(count($indi_doc))
			{
				$i=0;
				foreach($indi_doc as $x)
				{
						$doctor_id	=	$x['doctor_id'];
						//count todays appointment for individual doctors	 
						$array		=	array(
												'doctor_id'				=>	$x['doctor_id'],
												'appointment_date'		=>	date('Y-m-d'),									
												'appointment_status'	=>	'APPROVED',									
												);
						$indi_doc[$i]['today']	=	$this->select->count_some_special_appointments($array);
						//echo $this->db->last_query()."<br><br>";			
						$array		=	array(
												'doctor_id'				=>	$x['doctor_id'],
												'appointment_status'	=>	'APPROVED',	
												'appointment_date'		=>	date('Y-m-d', time() + 86400),										
												);
						$indi_doc[$i]['upcoming']	=	$this->select->count_some_special_appointments($array);
						//echo $this->db->last_query()."<br><br>";
						$first 	=	date('Y-m-d');
						$last 	=	date('Y-m-31');
						$sql	=	"SELECT * FROM appointment JOIN doctor ON doctor_id=appointment_doctor_id WHERE doctor_id ='$doctor_id' AND appointment_date between '$first' AND '$last' AND appointment_status = 'APPROVED'";
						$indi_doc[$i]['month']	=	$this->select->count_query_wise_appointments($sql);
						//echo $this->db->last_query()."<br><br>";
						$i++;
				}
			}
			
			//get clinic  name
			$array	=	array(	
								'clinic_status'			=>			1,								 
							);
			$clinic_name	=	$this->select->get_some_clinic_name($array);
			//echo $this->db->last_query();
			if(count($clinic_name))
			{
				$i=0;
				foreach($clinic_name as $x)
				{
						$doctor_clinic_id	=	$x['clinic_id'];
						//count todays appointment for individual doctors	 
						$array		=	array(
												'doctor_clinic_id'		=>	$x['clinic_id'],
												'appointment_date'		=>	date('Y-m-d'),									
												'appointment_status'	=>	'APPROVED',									
												);
						$clinic_name[$i]['today']	=	$this->select->count_some_special_appointments($array);
						//echo $this->db->last_query()."<br><br>";			
						$array		=	array(
												'doctor_clinic_id'		=>	$x['clinic_id'],
												'appointment_status'	=>	'APPROVED',	
												'appointment_date'		=>	date('Y-m-d', time() + 86400),										
												);
						$clinic_name[$i]['upcoming']	=	$this->select->count_some_special_appointments($array);
						//echo $this->db->last_query()."<br><br>";
						$first 	=	date('Y-m-d');
						$last 	=	date('Y-m-31');
						$sql	=	"SELECT * FROM appointment JOIN doctor ON doctor_id=appointment_doctor_id WHERE doctor_clinic_id ='$doctor_clinic_id' AND appointment_date between '$first' AND '$last' AND appointment_status = 'APPROVED'";
						$clinic_name[$i]['month']	=	$this->select->count_query_wise_appointments($sql);
						//echo $this->db->last_query()."<br><br>";
						$i++;
				}
			}
			
			//get appointment for pathology
			$array	=	array(
								'path_status'	=>	1,
								);
			$path_name	=	$this->select->get_some_pathology($array);
			if(count($path_name))
			{
				$i=0;
				foreach($path_name as $x)
				{
					$path_id	=	$x['path_id'];
					$array	=	array(
								'path_ap_path_id'	=>	$x['path_id'],
								'path_ap_status'	=>	'APPROVED',
								'path_ap_date'		=>	date('Y-m-d'),
								);
					$path_name[$i]['today']		=	$this->select->count_all_pathappointments($array);
					$array	=	array(
										'path_ap_path_id'	=>	$x['path_id'],
										'path_ap_status'	=>	'APPROVED',
										'path_ap_date'		=>	date('Y-m-d',time()+86400),
										);
					$path_name[$i]['upcoming']		=	$this->select->count_all_pathappointments($array);
					$sql	=	"SELECT * FROM path_appointment   WHERE path_ap_path_id='$path_id' and  path_ap_date between '$first' AND '$last' AND path_ap_status = 'APPROVED'";
					$path_name[$i]['month']	=	$this->select->count_query_wise_appointments($sql);
					//echo $this->db->last_query();	
					$i++;
				}
			}
			
			/*echo "<pre>";
			print_r($path_name);
			print_r($clinic_name);
			print_r($indi_doc);
			echo "tota patient ".$all_patient."<br>";
			echo "today ".$indi_today_appointment."<br>";
			echo "upcoming total ".$indi_upcoming_appointment."<br>";
			echo "upcoming this month ".$indi_this_month_appointment."<br>";
			echo "today clinic ".$clinic_today_appointment."<br>";
			echo "upcoming total clinic ".$clinic_upcoming_appointment."<br>";
			echo "upcoming this month clinic ".$clinic_this_month_appointment."<br>";
			
			echo "</pre>";
			*/
			//$patients	=	$this->select->get_all_patients($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(								 							 
								'all_patient'						=>	$all_patient,
								'indi_today_appointment'			=>	$indi_today_appointment,
								'indi_upcoming_appointment'			=>	$indi_upcoming_appointment,
								'indi_this_month_appointment'		=>	$indi_this_month_appointment,
								'clinic_today_appointment'			=>	$clinic_today_appointment,
								'clinic_upcoming_appointment'		=>	$clinic_upcoming_appointment,
								'clinic_this_month_appointment'		=>	$clinic_this_month_appointment,
								'path_today'						=>	$path_today,
								'path_upcoming'						=>	$path_upcoming,
								'path_this_month_appointment'		=>	$path_this_month_appointment,
								'indi_doc'							=>	$indi_doc,
								'clinic_name'						=>	$clinic_name,
								'path_name'							=>	$path_name,
								);
			 
			$this->load->view('admin/patient',['array'	=>	$array]);
		}
		
		public function searchpatient()
		{
			$post	=	$this->input->get();
			$patient	=	$this->select->search_patient($post['patient_name']);
			$array	=	array(
								'patient'	=>	$patient
								);
			
			$this->load->view('admin/searchpatient',['array'	=>	$array]);
		}
		public function revenue()
		{			
			//get individua doctors revenue			 
			$array	=	array(	
								'doctor_status'			=>			1,
								'doctor_clinic_id'		=>			0
							);
			$indi_doc	=	$this->select->get_some_doctors_name(1000,0,$array);
			if(count($indi_doc))
			{
				$i=0;
				foreach($indi_doc as $x)
				{
					$doctor_id	=	$x['doctor_id'];
					$array	=	array('appointment_date'	=>	date('Y-m-d'),
								'appointment_payment'		=>	'Transaction Successful',
								'appointment_doctor_id'		=>	$x['doctor_id'],										
								);
					$indi_doc[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `appointment_doctor_id` = '$doctor_id'";
					$indi_doc[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			//get clinic  name
			$array	=	array(	
								'clinic_status'			=>			1,								 
							);
			$clinic_name	=	$this->select->get_some_clinic_name($array);
			//echo $this->db->last_query();
			if(count($clinic_name))
			{
				$i=0;
				foreach($clinic_name as $x)
				{
					$clinic_id	=	$x['clinic_id'];
					$array	=	array(
								'appointment_date'		=>	date('Y-m-d'),
								'appointment_payment'	=>	'Transaction Successful',
								'doctor_clinic_id'		=>	$x['clinic_id'],										
								);
					$clinic_name[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment inner join doctor on appointment.appointment_doctor_id=doctor.doctor_id WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `doctor_clinic_id` = '$clinic_id'";
					$clinic_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			
			//get appointment for pathology
			$array	=	array(
								'path_status'	=>	1,
								);
			$path_name	=	$this->select->get_some_pathology($array);
			if(count($path_name))
			{
				$i=0;
				foreach($path_name as $x)
				{
					$path_id	=	$x['path_id'];
					$array	=	array(
									'path_ap_path_id'	=>	$x['path_id'],
									'path_ap_date'		=>	date('Y-m-d'),
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='		=>	'Appointment Canecelled',
								);				 
					$path_name[$i]['today']	=	$this->select->get_added_pathrevenue($array);
					//echo  $this->db->last_query();
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(path_ap_amount) AS path_ap_amount FROM path_appointment WHERE path_ap_path_id = '$path_id' AND path_ap_date between '$first' and '$last' AND path_ap_payment = 'Transaction Successful' AND path_ap_status!='Appointment Canecelled'";
					$path_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,										 
									);				
				
				//print_r($array);
				$amount1		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;
				$array	=	array(
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='	=>	'Appointment Canecelled',
								);
				 
				$revenue	=	array(
											'date'		=>	$date,
											'revenue'	=>	$this->select->get_added_pathrevenue($array),
											//'revenue'	=>	200,
										);
				$amount2				=	$revenue['revenue']['path_ap_amount'];
				$monrev[$i]['total']	=	$amount1['appointment_money']+$amount2;
			}
			 
			/*
			echo "<pre>";
			//print_r($path_name);
			//print_r($clinic_name);
			//print_r($indi_doc);
			print_r($monrev);
			 
			echo "</pre>";
			*/
			$array		=	array(
									'path_name'			=>	$path_name,
									'clinic_name'		=>	$clinic_name,
									'indi_doc'			=>	$indi_doc,
									'settings'			=>	$settings,
									'monrev'			=>	$monrev,
								);
			$this->load->view('admin/revenue',['array'	=>	$array]);
		}
		public function myrevenue()
		{
			//get individua doctors revenue			 
			$array	=	array(	
								'doctor_status'			=>			1,
								'doctor_clinic_id'		=>			0
							);
			$indi_doc	=	$this->select->get_some_doctors_name(1000,0,$array);
			if(count($indi_doc))
			{
				$i=0;
				foreach($indi_doc as $x)
				{
					$doctor_id	=	$x['doctor_id'];
					$array	=	array('appointment_date'	=>	date('Y-m-d'),
								'appointment_payment'		=>	'Transaction Successful',
								'appointment_doctor_id'		=>	$x['doctor_id'],										
								);
					$indi_doc[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `appointment_doctor_id` = '$doctor_id'";
					$indi_doc[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			//get clinic  name
			$array	=	array(	
								'clinic_status'			=>			1,								 
							);
			$clinic_name	=	$this->select->get_some_clinic_name($array);
			//echo $this->db->last_query();
			if(count($clinic_name))
			{
				$i=0;
				foreach($clinic_name as $x)
				{
					$clinic_id	=	$x['clinic_id'];
					$array	=	array(
								'appointment_date'		=>	date('Y-m-d'),
								'appointment_payment'	=>	'Transaction Successful',
								'doctor_clinic_id'		=>	$x['clinic_id'],										
								);
					$clinic_name[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment inner join doctor on appointment.appointment_doctor_id=doctor.doctor_id WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `doctor_clinic_id` = '$clinic_id'";
					$clinic_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			
			//get appointment for pathology
			$array	=	array(
								'path_status'	=>	1,
								);
			$path_name	=	$this->select->get_some_pathology($array);
			if(count($path_name))
			{
				$i=0;
				foreach($path_name as $x)
				{
					$path_id	=	$x['path_id'];
					$array	=	array(
									'path_ap_path_id'	=>	$x['path_id'],
									'path_ap_date'		=>	date('Y-m-d'),
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='		=>	'Appointment Canecelled',
								);				 
					$path_name[$i]['today']	=	$this->select->get_added_pathrevenue($array);
					//echo  $this->db->last_query();
					$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date('Y-m-1');
					$last	=	date('Y-m-'.$d);
					$sql	=	"SELECT SUM(path_ap_amount) AS path_ap_amount FROM path_appointment WHERE path_ap_path_id = '$path_id' AND path_ap_date between '$first' and '$last' AND path_ap_payment = 'Transaction Successful' AND path_ap_status!='Appointment Canecelled'";
					$path_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,										 
									);				
				
				//print_r($array);
				$amount1		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;
				$array	=	array(
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='	=>	'Appointment Canecelled',
								);
				 
				$revenue	=	array(
											'date'		=>	$date,
											'revenue'	=>	$this->select->get_added_pathrevenue($array),
											//'revenue'	=>	200,
										);
				$amount2				=	$revenue['revenue']['path_ap_amount'];
				$monrev[$i]['total']	=	$amount1['appointment_money']+$amount2;
			}
			 
			/*
			echo "<pre>";
			//print_r($path_name);
			//print_r($clinic_name);
			//print_r($indi_doc);
			print_r($monrev);
			 
			echo "</pre>";
			*/
			$array		=	array(
									'path_name'			=>	$path_name,
									'clinic_name'		=>	$clinic_name,
									'indi_doc'			=>	$indi_doc,
									'settings'			=>	$settings,
									'monrev'			=>	$monrev,
								);
			$this->load->view('admin/myrevenue',['array'	=>	$array]);
		}
		public function diagnosis()
		{
			//pending diagnosis lab
			$array	=	array('path_status'	=>	0);
			$pending_path	=	$this->select->findpathology($array);
			$count_pending_path	=	$this->select->count_some_path($array);
			
			//active diagnosis lab
			$array	=	array('path_status'	=>	1);
			$active_path	=	$this->select->findpathology($array);
			$count_active_path	=	$this->select->count_some_path($array);
			
			
			/*
			echo "<pre>";
			print_r($pending_path);
			print_r($active_path);
			echo "</pre>";
			*/
			$array	=	array(
								'pending_path'			=>	$pending_path,
								'count_pending_path'	=>	$count_pending_path,
								'count_active_path'		=>	$count_active_path,
								'active_path'			=>	$active_path,
								
								);
			$this->load->view('admin/diagnosis',['array'	=>	$array]);
		}
		public function searchpathology()
		{
			$post	=	$this->input->get();
			$path	=	$this->select->search_path($post['path_name']);
			$array	=	array(
								'path'	=>	$path
								);
			
			$this->load->view('admin/searchpathology',['array'	=>	$array]);
		}
		public function editeducation()
		{
			$doctor_id	=	$this->uri->segment(3);
			$array			=	array('doctor_id'	=>	$doctor_id);
			$doctor			=	$this->select->get_one_doctor($array);
			//$cities			=	$this->select->get_all_cities($array);
			$specialities	=	$this->select->get_all_specialization($array);
			$array			=	array('qualification_doctor_id'	=>	$doctor_id);
			$education		=	$this->select->get_some_education($array);
			$array			=	array('document_doctor_id'	=>	$doctor_id);
			$documents		=	$this->select->get_some_documents($array);
			$council		=	$this->select->get_all_council();
			$array			=	array(
									'doctor'	=>	$doctor,
									'documents'	=>	$documents,									 
									'specialities'	=>	$specialities,
									'council'		=>	$council,
									//'myclinic'		=>	$this->myclinic,
									'education'	=>	$education,
									);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('admin/editeducation',['array'	=>	$array]);
		}
		public function storeeducation()
		{
			$post	=	$this->input->post();
			$doctor_id	=	$post['qualification_doctor_id']; 
			
			
			$i=0;
			foreach($post['qualification_name'] as $x)
			{
				$array[$i]['qualification_name']			=	$x;	
				$array[$i]['qualification_college']			=	$post['qualification_college'][$i];	
				$array[$i]['qualification_complete_year']	=	$post['qualification_complete_year'][$i];	
				$array[$i]['qualification_specialization']	=	$post['qualification_specialization'][$i];	
				$array[$i]['qualification_doctor_id']		=	$post['qualification_doctor_id'] ;	
				$i++;
			}
			
		 
			if($this->insert->insert_batch_table($array,'qualification'))
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-success">Education added successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-danger">System Failure.</div>');

			}
			 return redirect(base_url('home/editeducation/'.$doctor_id));
			 
		}
		public function updateeducation()
		{
			$post	=	$this->input->post();
			$doctor_id	=	$post['qualification_doctor_id'][0];
			if(count($post['qualification_id']))
			{
				$i=0;
				foreach($post['qualification_id'] as $x)
				{
					$array[$i]['qualification_id']				=	$x;
					$array[$i]['qualification_name']			=	$post['qualification_name'][$i];
					$array[$i]['qualification_college']			=	$post['qualification_college'][$i];
					$array[$i]['qualification_complete_year']	=	$post['qualification_complete_year'][$i];
					$array[$i]['qualification_specialization']	=	$post['qualification_specialization'][$i];
					
					$i++;
				}
				//echo "<pre>";
				//print_r($array);
				foreach($array as $x)
				{
					//print_r($x);
					$this->update->update_table('qualification','qualification_id',$x['qualification_id'],$x);
				}
			}
			return redirect(base_url('home/editeducation/'.$doctor_id));
			
		}
		public function storedocuments()
		{
			echo "<pre>";
			
			$post	=	$this->input->post();
			$doctor_id	=	$post['document_doctor_id'][0];
			//print_r($_FILES['document_certificate']);
			//print_r($post);
			$i=0;
			foreach($post['document_reg_no'] as $x)
			{
				$array[$i]['document_reg_no']		=	$x;
				$array[$i]['document_council_name']	=	$post['document_council_name'][$i];
				$array[$i]['document_year']			=	$post['document_year'][$i];
				$array[$i]['document_certificate']	=	$_FILES['document_certificate']['name'][$i];
				$array[$i]['document_doctor_id']	=	$post['document_doctor_id'][0];
				$i++;
			}
			print_r($array);
			if(count($array))
			{
				$i=0;
				foreach($array as $x)
				{
					if($document_id	=	$this->insert->insert_table($x,'document'))
					{						
						if($x['document_certificate']!='')
						{
							if(!file_exists('./images/certi/'.$document_id.'/'))
							{
								mkdir('./images/certi/'.$document_id.'/'); 
							}
							move_uploaded_file($_FILES['document_certificate']['tmp_name'][$i],"./images/certi/$document_id/".$x['document_certificate']);
						}
						$this->session->set_flashdata('educationmsg','<div class="alert alert-success">Documents added successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('educationmsg','<div class="alert alert-danger">System Failure.</div>');
					}
					$i++;
				}
			}			
			return redirect(base_url('home/editeducation/'.$doctor_id));
			 
		}
		public function updatedocument()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$i=0;
			if(count($post['document_reg_no']))
			{
				foreach($post['document_reg_no'] as $x)
				{
					$array[$i]['document_reg_no']		=	$x;
					$array[$i]['document_council_name']	=	$post['document_council_name'][$i];
					$array[$i]['document_year']			=	$post['document_year'][$i];
					$array[$i]['document_id']			=	$post['document_id'][$i];
					$array[$i]['document_doctor_id']	=	$post['document_doctor_id'][$i];
					$i++;
				}
				 
				foreach($array as $x)
				{
					//print_r($x);
					$this->update->update_table('document','document_id',$x['document_id'],$x);
				}
			}
			return redirect(base_url('home/editeducation/'.$post['document_doctor_id'][0]));
		
			
		}
		public function viewappointments()
		{
			$doctor_id	=	$this->uri->segment(3);
			$array	=	array(
			'appointment_doctor_id'	=>	$doctor_id,
			'appointment_payment'	=>	'Transaction Successful',
			'appointment_date>='	=>	date('Y-m-d'),
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/viewappointments/'.$doctor_id),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_appointments($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(4),$array);
			$array			=	array('doctor_id'	=>	$doctor_id);
			$doctor			=	$this->select->get_one_doctor($array);
			$array	=	array(
								'appointments'	=>	$appointments,
								// 'myclinic'		=>	$this->myclinic,
								 'doctor'		=>	$doctor,
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('admin/viewappointments',['array'	=>	$array]);
			
		}
		public function viewpreviousappointments()
		{
			$doctor_id	=	$this->uri->segment(3);
			$array	=	array(
			'appointment_doctor_id'	=>	$doctor_id,
			'appointment_payment'	=>	'Transaction Successful',
			'appointment_date<'	=>	date('Y-m-d'),
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('admin/viewpreviousappointments/'.$doctor_id),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_appointments($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(4),$array);
			$array			=	array('doctor_id'	=>	$doctor_id);
			$doctor			=	$this->select->get_one_doctor($array);
			$array	=	array(
								'appointments'	=>	$appointments,
								// 'myclinic'		=>	$this->myclinic,
								 'doctor'		=>	$doctor,
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('admin/viewpreviousappointments',['array'	=>	$array]);
		}
		public function clinicdetails()
		{
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$clinic_id);
			//$cities	=	$this->select->get_all_cities();			
			if(count($clinic		=	$this->select->get_one_clinic($array)))
			{
				 $array		=	array(
									'clinic'	=>	$clinic,
									//'cities' 	=>	$cities,
									);
				 $this->load->view('admin/clinicdetails',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home/clinicemployee'));
			}
		}
		public function regcertificates()
		{
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$clinic_id);
			//$cities	=	$this->select->get_all_cities();			
			if(count($clinic		=	$this->select->get_one_clinic($array)))
			{
				 $array		=	array(
									'clinic'	=>	$clinic,
									//'cities' 	=>	$cities,
									);
				 $this->load->view('admin/regcertificates',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home/clinicemployee'));
			}
		}
		public function updatereg()
		{
			$post	=	$this->input->post();			 
			$clinic_id					=	$post['clinic_id'];			 
			$clinic_reg_proof_pre		=	$post['clinic_reg_proof_pre'];			 
			unset($post['clinic_reg_proof_pre']);			 
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
			}			 
			if($_FILES['clinic_reg_proof']['name']!='')
			{
				$post['clinic_reg_proof']	=	$_FILES['clinic_reg_proof']['name'];
				if(!file_exists('./images/clinic/'.$clinic_id.'/reg/'))
				{
					mkdir('./images/clinic/'.$clinic_id.'/reg/'); 
				}
				@unlink("./images/clinic/$clinic_id/reg/".$clinic_reg_proof_pre);
				move_uploaded_file($_FILES['clinic_reg_proof']['tmp_name'],"./images/clinic/$clinic_id/reg/".$post['clinic_reg_proof']);
			}
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));					
		} 
		public function updateclinicphoto()
		{
			$post	=	$this->input->post();
			$clinic_id					=	$post['clinic_id'];			 
			$clinic_photo_pre			=	$post['clinic_photo_pre'];			 
			unset($post['clinic_photo_pre']);			 
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
			}			 
			if($_FILES['clinic_photo']['name']!='')
			{
				$post['clinic_photo']	=	$_FILES['clinic_photo']['name'];
				if(!file_exists('./images/clinic/'.$clinic_id.'/photo/'))
				{
					mkdir('./images/clinic/'.$clinic_id.'/photo/'); 
				}
				@unlink("./images/clinic/$clinic_id/photo/".$clinic_photo_pre);
				move_uploaded_file($_FILES['clinic_photo']['tmp_name'],"./images/clinic/$clinic_id/photo/".$post['clinic_photo']);
			}
			 
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));			
		}
		public function updatecliniclogo()
		{
			$post	=	$this->input->post();			 
			$clinic_id					=	$post['clinic_id'];
			$clinic_logo_pre			=	$post['clinic_logo_pre'];		 
			unset($post['clinic_logo_pre']);
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
			}
			if($_FILES['clinic_logo']['name']!='')
			{
				$post['clinic_logo']	=	$_FILES['clinic_logo']['name'];
				if(!file_exists('./images/clinic/'.$clinic_id.'/logo/'))
				{
					mkdir('./images/clinic/'.$clinic_id.'/logo/'); 
				}
				@unlink("./images/clinic/$clinic_id/logo/".$clinic_logo_pre);
				move_uploaded_file($_FILES['clinic_logo']['tmp_name'],"./images/clinic/$clinic_id/logo/".$post['clinic_logo']);
			}
			 
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));
			
		}
		public function updateclinicpres()
		{
			$post	=	$this->input->post();
			$clinic_id					=	$post['clinic_id'];
			 
			$clinic_pres_pad_pre		=	$post['clinic_pres_pad_pre'];
			unset($post['clinic_pres_pad_pre']);
			 
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
			}
			 
			if($_FILES['clinic_pres_pad']['name']!='')
			{
				$post['clinic_pres_pad']	=	$_FILES['clinic_pres_pad']['name'];
				if(!file_exists('./images/clinic/'.$clinic_id.'/pres/'))
				{
					mkdir('./images/clinic/'.$clinic_id.'/pres/'); 
				}
				@unlink("./images/clinic/$clinic_id/pres/".$clinic_pres_pad_pre);
				move_uploaded_file($_FILES['clinic_pres_pad']['tmp_name'],"./images/clinic/$clinic_id/pres/".$post['clinic_pres_pad']);
			}
			 
			
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));			
		}
		public function updateclinicwaste()
		{
			$post	=	$this->input->post();
			$clinic_id	=	$post['clinic_id'];
			$clinic_waste_disposal_pre	=	$post['clinic_waste_disposal_pre'];			 
			unset($post['clinic_waste_disposal_pre']);
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
			}
			if(!file_exists('./images/clinic/'.$clinic_id.'/waste/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/waste/'); 
			}			 
			if($_FILES['clinic_waste_disposal']['name']!='')
			{
				$post['clinic_waste_disposal']	=	$_FILES['clinic_waste_disposal']['name'];
				if(!file_exists('./images/clinic/'.$clinic_id.'/waste/'))
				{
					mkdir('./images/clinic/'.$_COOKIE['clinic_id'].'/waste/'); 
				}
				@unlink("./images/clinic/$clinic_id/waste/".$clinic_waste_disposal_pre);
				move_uploaded_file($_FILES['clinic_waste_disposal']['tmp_name'],"./images/clinic/$clinic_id/waste/".$post['clinic_waste_disposal']);
			}			
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));
			
		}
		public function updateclinicservices()
		{
			$post	=	$this->input->post();
			$post['clinic_features']	=	implode(",",$post['clinic_features']);
			$clinic_id					=	$post['clinic_id'];
			 
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('addemployeemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/regcertificates/'.$clinic_id));
			
		}
		public function clinictimings()
		{
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$clinic_id);			 			
			if(count($clinic		=	$this->select->get_one_clinic($array)))
			{
				 $array		=	array(
									'clinic'	=>	$clinic,									 
									);
				 $this->load->view('admin/clinictimings',['array'	=>	$array]);
			}
			else
			{
				return redirect (base_url('home/clinicemployee'));
			}
		}
		public function updateclinictimings()
		{
			$post	=	$this->input->post();
			$post['clinic_opening_days']	=	implode(",",$post['clinic_opening_days']);
			
			if($this->update->update_table('clinic','clinic_id',$post['clinic_id'],$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('home/clinicdetails/'.$post['clinic_id']));
		}
		public function viewpath()
		{
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			$array	=	array('path'	=>	$path);
			 
			$this->load->view('admin/viewpath',['array'	=>	$array]);
		}
		public function editpathtime()
		{
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			 
			$array	=	array(
								'path'		=>	$path,
								 
							);
			//print_r($array);
			$this->load->view('admin/editpathtime',['array'	=>	$array]);
		}
		public function editpathownership()
		{
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			 
			$array	=	array(
								'path'		=>	$path,
								 
							);
			//print_r($array);
			$this->load->view('admin/editpathownership',['array'	=>	$array]);
		}
		
		public function updatepathhours()
		{
			$post	=	$this->input->post();
			print_r($post);
			if($this->update->update_table('pathology','path_id',$post['path_id'],$post))
			{
				$this->session->set_flashdata('pathmsg','<div class="alert alert-success"><b>Congratulations!.. Pathology profile has been updated.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('pathmsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
			}
			
			return redirect(base_url('home/viewpath/'.$post['path_id']));
		}
		public function updatepathownership()
		{
			//echo "<pre>";
			$post	=	$this->input->post();			 
			 
			 
			$post['path_ownership_certificate']		=	$_FILES['path_ownership_certificate']['name'];
			$post['path_reg_proof']					=	$_FILES['path_reg_proof']['name'];
		 
			print_r($post);
			if($post['path_ownership_certificate']!='')
			{
				@mkdir('./images/pathowner/'.$post['path_id']); 
				if($post['path_ownership_certificate_2']!='')
				{
					unlink("./images/pathowner/".$post['path_id']."/".$post['path_ownership_certificate_2']);
				}
				 
				move_uploaded_file($_FILES['path_ownership_certificate']['tmp_name'],"./images/pathowner/".$post['path_id']."/".$post['path_ownership_certificate']);
                
			}
			else
			{
					unset($post['path_ownership_certificate']);
			}
			if($post['path_reg_proof']!='')
			{
				@mkdir('./images/pathreg/'.$post['path_id']); 
				if($post['path_reg_proof_2']!='')
				{
					unlink("./images/pathreg/".$post['path_id']."/".$post['path_reg_proof_2']);
				}
				 
				move_uploaded_file($_FILES['path_reg_proof']['tmp_name'],"./images/pathreg/".$post['path_id']."/".$post['path_reg_proof']);
               
			}
			else
			{
				unset($post['path_reg_proofx']);
			}
			unset($post['path_reg_proof_2']);
			unset($post['path_ownership_certificate_2']);
			$this->update->update_table('pathology','path_id',$post['path_id'],$post);
			 
			return redirect(base_url('home/viewpath/'.$post['path_id']));
		}
		public function viewpathtest()
		{
			$array	=	array('test_path_id'	=>	$this->uri->segment(3));
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/viewpathtest/'.$this->uri->segment(3)),
								'per_page'		=>		'100',
								'total_rows'	=>		$this->select->count_all_test($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$test	=	$this->select->get_some_test($config['per_page'],$this->uri->segment(4),$array);
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			 
			$array	=	array(
							 
							'test'	=>	$test,
							'path'	=>	$path,
							'count'	=>	$this->uri->segment(4),
							);
			 
			$this->load->view('admin/viewpathtest',['array'	=>	$array]);
		}
		public function addtest()
		{
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			$array	=	array('path'	=>	$path);
			//print_r($array);
			$this->load->view('admin/addtest',['array'	=>	$array]);
		}
		public function storetest()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			//print_r($post);
			$i=0;
			foreach($post['test_name'] as $x)
			{
				$array[$i]['test_name']	=	$x;
				$array[$i]['test_price']	=	$post['test_price'][$i];
				$array[$i]['test_details']=	$post['test_details'][$i];
				$array[$i]['test_path_id']=	$post['test_path_id'];
				$i++;
			}
			if($this->insert->insert_batch_table($array,'test'))
			{
				$this->session->set_flashdata('testmsg','<div class="alert alert-success"><b>Congratulations1.. Tests Added Succesfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('testmsg','<div class="alert alert-danger"><b>Oops!.. System Failure</b></div>');

			}
			return redirect(base_url('home/viewpathtest/'.$post['test_path_id']));
		}
		public function edittest()
		{
			$test_id	=	$this->uri->segment(3);
			$array	=	array(
								'test_id'	=>	$test_id,								 
								);
			$test		=	$this->select->get_one_test($array);
			if(count($test))
			{
				$array	=	array(									 
									'test'	=>	$test,
								);
				$this->load->view('admin/edittest',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('home'));
			
			}
		}
		public function updatetest()
		{
			$post	=	$this->input->post();
			if($this->update->update_table('test','test_id',$post['test_id'],$post))
			{
				$this->session->set_flashdata('editmsg','<div class="alert alert-success">Congratulations!.. Test updated successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('editmsg','<div class="alert alert-success">Oops!.. System Failure.</div>');
			}
			return redirect(base_url('home/edittest/'.$post['test_id']));
		}
		public function deletetest()
		{
			$test_id	=	$this->uri->segment(3);
			$path_id	=	$this->uri->segment(4);
			$array		=	array(
									'test_id'		=>	$test_id,									 									
								);
			$this->load->model('delete');
			if($this->delete->delete_table($array,'test'))
			{
				 $this->session->set_flashdata('testmsg','<div class="alert alert-success">Test deleted.</div>');
			}
			else
			{
				$this->session->set_flashdata('testmsg','<div class="alert alert-danger">system Failure.</div>');
			}
			return redirect(base_url('home/viewpathtest/'.$path_id));
		}
		public function pendingindidoc()
		{
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	0
									);
			//$count_indi_doc	=	$this->select->count_some_doctor($array);
			//$indi_doc		=	$this->select->get_some_doctors(100,0,$array);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/pendingindidoc'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_doctor($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_doctors($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			$this->load->view('admin/pendingindidoc',['array'	=>	$array]);
		}
		public function pendingclinicdoc()
		{
			$array			=	array('doctor_clinic_id!='	=>	0,
										'doctor_status'		=>	0
									);
			//$count_indi_doc	=	$this->select->count_some_doctor($array);
			//$indi_doc		=	$this->select->get_some_doctors(100,0,$array);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/pendingclinicdoc'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_doctor($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_doctors($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			$this->load->view('admin/pendingclinicdoc',['array'	=>	$array]);
		}
		public function activeclinicdoc()
		{
			$array			=	array('doctor_clinic_id!='	=>	0,
										'doctor_status'		=>	1
									);
			//$count_indi_doc	=	$this->select->count_some_doctor($array);
			//$indi_doc		=	$this->select->get_some_doctors(100,0,$array);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/activeclinicdoc'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_doctor($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_doctors($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			$this->load->view('admin/activeclinicdoc',['array'	=>	$array]);
		}
		public function activeindidoc()
		{
			$array			=	array('doctor_clinic_id'	=>	0,
										'doctor_status'		=>	1
									);
			//$count_indi_doc	=	$this->select->count_some_doctor($array);
			//$indi_doc		=	$this->select->get_some_doctors(100,0,$array);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/activeindidoc'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_doctor($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_doctors($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			$this->load->view('admin/activeindidoc',['array'	=>	$array]);
		}
		public function viewpathappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$this->uri->segment(3),
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_status!='		=>	'Appointment Canecelled',
								'path_ap_date>='		=>	date('Y-m-d'),
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/viewpathappointments/'.$this->uri->segment(3)),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_pathappointments($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(4),$array);
			if(count($appointments))
			{
				$i=0; 
				foreach($appointments as  $x)
				{
					$test_id	=	explode(",",$x['path_ap_test_id']);
					unset($alltest);
					foreach($test_id as $y)
					{
						$arrayx	=	array('test_id'	=>	$y);
						$testname	=	$this->select->get_test_name($arrayx);
						//print_r($testname);
						$alltest[]	=	$testname['test_name'];
					}
					$appointments[$i]['alltest']	=	$alltest;
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			 
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'path'			=>	$path,								 
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('admin/viewpathappointments',['array'	=>	$array]);
		}
		public function pastpathappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$this->uri->segment(3),
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_status!='		=>	'Appointment Canecelled',
								'path_ap_date<'			=>	date('Y-m-d'),
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/pastpathappointments/'.$this->uri->segment(3)),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_pathappointments($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(4),$array);
			if(count($appointments))
			{
				$i=0; 
				foreach($appointments as  $x)
				{
					$test_id	=	explode(",",$x['path_ap_test_id']);
					unset($alltest);
					foreach($test_id as $y)
					{
						$arrayx	=	array('test_id'	=>	$y);
						$testname	=	$this->select->get_test_name($arrayx);
						//print_r($testname);
						$alltest[]	=	$testname['test_name'];
					}
					$appointments[$i]['alltest']	=	$alltest;
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$arrayx		=	array('path_id'	=>	$this->uri->segment(3));
			$path	=	$this->select->get_one_pathology($arrayx);	
			 
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'path'			=>	$path,								 
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('admin/pastpathappointments',['array'	=>	$array]);
		}
		public function pendingclinic()
		{
			 $array	=	array(
								'clinic_status'	=>	0,
							);
			$count_pending_clinic	=	$this->select->count_some_clinic($array);
			$pending_clinic	=	$this->select->get_some_clinic(1000,0,$array);
			
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/pendingclinic'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_clinic($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_clinic($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			 
			$this->load->view('admin/pendingclinic',['array'	=>	$array]);
		}
		public function activeclinic()
		{
			 $array	=	array(
								'clinic_status'	=>	1,
							);
			$count_pending_clinic	=	$this->select->count_some_clinic($array);
			$pending_clinic	=	$this->select->get_some_clinic(1000,0,$array);
			
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('home/activeclinic'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_clinic($array),
								'full_tag_open'	=>		"<ul class='pagination'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='active'><a>",
								'cur_tag_close'=>		"</a></li>",
								 
								
							);
			$this->pagination->initialize($config);			
			$data	=	$this->select->get_some_clinic($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'data'	=>	$data,
								);
			 
			$this->load->view('admin/activeclinic',['array'	=>	$array]);
		}
		public function pendinglab()
		{
			$array	=	array('path_status'	=>	0);
			$path	=	$this->select->findpathology($array);
			//echo "<pre>";
			//print_r($path);
			$array	=	array('path'	=>	$path);
			$this->load->view('admin/pendinglab',['array'	=>	$array]);
		}
		public function activelab()
		{
			$array	=	array('path_status'	=>	1);
			$path	=	$this->select->findpathology($array);
			//echo "<pre>";
			//print_r($path);
			$array	=	array('path'	=>	$path);
			$this->load->view('admin/activelab',['array'	=>	$array]);
		}
		public function docrevenue()
		{
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			
			$array	=	array(
							'appointment_doctor_id'	=>	$this->uri->segment(3),
							'appointment_payment'	=>	'Transaction Successful',
							'appointment_date<='	=>	date('Y-m-'.$d),
							'appointment_date>='		=>	date('Y-m-1'),
							);
			$appointments	=	$this->select->get_some_appointments(10000,0,$array);
			
			$array		=	array(
									'doctor_id'		=>		$this->uri->segment(3),									 
								);
			$doctor		=	$this->select->get_one_doctor($array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);	
			$array		=	array(
									'appointments'		=>		$appointments,
									'doctor'			=>		$doctor,
									'settings'			=>		$settings,
									'year'				=>		date('Y'),
									'month'				=>		date('M')
								);
			$this->load->view('admin/docrevenue',['array'	=>	$array]);
		}
		public function finddocrevenue()
		{
			$m		=	$this->input->post('month');
			$y		=	$this->input->post('year');
			if($m=='01')
			{
				$month	=	"Jan";
			}
			else if($m=='02')
			{
				$month	=	"Feb";
			}
			else if($m=='03')
			{
				$month	=	"Mar";
			}
			else if($m=='04')
			{
				$month	=	"Apr";
			}
			else if($m=='05')
			{
				$month	=	"May";
			}
			else if($m=='06')
			{
				$month	=	"Jun";
			}
			else if($m=='07')
			{
				$month	=	"Jul";
			}
			else if($m=='08')
			{
				$month	=	"Aug";
			}
			else if($m=='09')
			{
				$month	=	"Sep";
			}
			else if($m=='10')
			{
				$month	=	"Oct";
			}
			else if($m=='11')
			{
				$month	=	"Nov";
			}
			else if($m=='12')
			{
				$month	=	"Dec";
			}
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			
			$array	=	array(
							'appointment_date<='	=>	date($y.'-'.$m.'-'.$d),
							'appointment_date>='		=>	date($y.'-'.$m.'-1'),	
							'appointment_doctor_id'	=>	$this->uri->segment(3),
							'appointment_payment'	=>	'Transaction Successful',
													 
							);
			
			$appointments	=	$this->select->get_some_appointments(10000,0,$array);
			
			 
			$array		=	array(
									'doctor_id'		=>		$this->uri->segment(3),									 
								);
			$doctor		=	$this->select->get_one_doctor($array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);	
			$array		=	array(
									'appointments'		=>		$appointments,
									'doctor'			=>		$doctor,
									'settings'			=>		$settings,
									'year'				=>		$y,
									'month'				=>		$month
								);
			$this->load->view('admin/docrevenue',['array'	=>	$array]);
		}
		public function clinicrevenue()
		{
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array('doctor_clinic_id'	=>	$this->uri->segment(3));
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);			
			$appointments	=	array();
			if(count($doctors))
			{
				foreach($doctors as $x)
				{
					$doctor_ids[]		=	$x['doctor_id'];
				}
				$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			
				$array	=	array(
								 
								'appointment_payment'	=>	'Transaction Successful',
								'appointment_date<='	=>	date('Y-m-'.$d),
								'appointment_date>='		=>	date('Y-m-1'),
								);
				$appointments	=	$this->select->get_some_clinic_appointments(10000,0,$array,$doctor_ids);
				
			}
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$this->uri->segment(3));			 			
			$clinic		=	$this->select->get_one_clinic($array);
			$array	=	array(								 
								'appointments'	=>	$appointments,
								'clinic'		=>	$clinic,
								'settings'	=>	$settings,
								'year'				=>		date('Y'),
								'month'				=>		date('M')
							);			
			$this->load->view('admin/clinicrevenue',['array'	=>	$array]);
		}
		public function findclinicrevenue()
		{
			$m		=	$this->input->post('month');
			$y		=	$this->input->post('year');
			if($m=='01')
			{
				$month	=	"Jan";
			}
			else if($m=='02')
			{
				$month	=	"Feb";
			}
			else if($m=='03')
			{
				$month	=	"Mar";
			}
			else if($m=='04')
			{
				$month	=	"Apr";
			}
			else if($m=='05')
			{
				$month	=	"May";
			}
			else if($m=='06')
			{
				$month	=	"Jun";
			}
			else if($m=='07')
			{
				$month	=	"Jul";
			}
			else if($m=='08')
			{
				$month	=	"Aug";
			}
			else if($m=='09')
			{
				$month	=	"Sep";
			}
			else if($m=='10')
			{
				$month	=	"Oct";
			}
			else if($m=='11')
			{
				$month	=	"Nov";
			}
			else if($m=='12')
			{
				$month	=	"Dec";
			}
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array('doctor_clinic_id'	=>	$this->uri->segment(3));
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);			
			if(count($doctors))
			{
				foreach($doctors as $x)
				{
					$doctor_ids[]		=	$x['doctor_id'];
				}
				$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			
				$array	=	array(
								 
								'appointment_payment'	=>	'Transaction Successful',
								'appointment_date<='	=>	date($y.'-'.$m.'-'.$d),
								'appointment_date>='		=>	date($y.'-'.$m.'-1'),
								);
				$appointments	=	$this->select->get_some_clinic_appointments(10000,0,$array,$doctor_ids);
				
			}
			$clinic_id	=	$this->uri->segment(3);
			$array		=	array('clinic_id'	=>	$this->uri->segment(3));			 			
			$clinic		=	$this->select->get_one_clinic($array);
			$array	=	array(								 
								'appointments'	=>	$appointments,
								'clinic'		=>	$clinic,
								'settings'	=>	$settings,
								'year'				=>		$y,
								'month'				=>		$month
							);			
			$this->load->view('admin/clinicrevenue',['array'	=>	$array]);
		}
		public function viewpathrevenue()
		{
			$path_id	=	$this->uri->segment(3);
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));			
			 
			$array	=	array(
								'path_ap_path_id'		=>	$path_id,
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_status!='		=>	'Appointment Canecelled',
								'path_ap_date>='		=>	date('Y-m-1'),
								'path_ap_date<='		=>	date('Y-m-'.$d),
							);
			 
					
			$appointments	=	$this->select->get_some_pathappointments(100000,0,$array);
			/*if(count($appointments))
			{
				$i=0; 
				foreach($appointments as  $x)
				{
					$test_id	=	explode(",",$x['path_ap_test_id']);
					unset($alltest);
					foreach($test_id as $y)
					{
						$arrayx	=	array('test_id'	=>	$y);
						$testname	=	$this->select->get_test_name($arrayx);
						//print_r($testname);
						$alltest[]	=	$testname['test_name'];
					}
					$appointments[$i]['alltest']	=	$alltest;
					$i++;
				}
			}*/
			$array		=	array('path_id'	=>	$path_id);
			$path		=	$this->select->get_one_pathology($array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,								 
								'path'			=>	$path,	
								'year'			=>		date('Y'),
								'month'			=>		date('M')
								);
			 
			$this->load->view('admin/viewpathrevenue',['array'	=>	$array]);
		}
		public function findpathrevenue()
		{
			$path_id	=	$this->uri->segment('3');
			$post		=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$m			=	$post['month'];
			$y			=	$post['year'];
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			
			 
			$array	=	array(
								'path_ap_path_id'		=>	$path_id,
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_status!='		=>	'Appointment Canecelled',
								'path_ap_date>='		=>	date($y.'-'.$m.'-1'),
								'path_ap_date<='		=>	date($y.'-'.$m.'-'.$d),
							);
			 
					
			$appointments	=	$this->select->get_some_pathappointments(100000,0,$array);
			 
			$array		=	array('path_id'	=>	$path_id);
			$path		=	$this->select->get_one_pathology($array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			if($m=='01')
			{
				$month	=	"Jan";
			}
			else if($m=='02')
			{
				$month	=	"Feb";
			}
			else if($m=='03')
			{
				$month	=	"Mar";
			}
			else if($m=='04')
			{
				$month	=	"Apr";
			}
			else if($m=='05')
			{
				$month	=	"May";
			}
			else if($m=='06')
			{
				$month	=	"Jun";
			}
			else if($m=='07')
			{
				$month	=	"Jul";
			}
			else if($m=='08')
			{
				$month	=	"Aug";
			}
			else if($m=='09')
			{
				$month	=	"Sep";
			}
			else if($m=='10')
			{
				$month	=	"Oct";
			}
			else if($m=='11')
			{
				$month	=	"Nov";
			}
			else if($m=='12')
			{
				$month	=	"Dec";
			}
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,								 
								'path'			=>	$path,	
								'year'			=>	date('Y'),
								'month'			=>	$month
								);
			 
			$this->load->view('admin/viewpathrevenue',['array'	=>	$array]);
		}
		public function activepath()
		{
			$array	=	array('path_status'	=>	1);
			$path	=	$this->select->findpathology($array);
			//echo "<pre>";
			//print_r($path);
			$array	=	array('path'	=>	$path);
			$this->load->view('admin/activepath',['array'	=>	$array]);
		}
		public function todaysappointment()
		{
			
			return redirect (base_url('home/viewdayappointments/'.date('Y-m-d')));
		}
		public function viewdayappointments()
		{
			$date	=	$this->uri->segment(3);
			//count number of appointments for individul doctor
			$array	=	array('appointment_date'	=>	$date,
								'appointment_status'=>	'APPROVED',
								'doctor_clinic_id'	=>	'0',										
							);
			//$count_indi_doc_appointment	=	$this->select->count_some_special_appointments($array);
			$indi_doc_appointment		=	$this->select->get_some_appointments(100000,0,$array);
			//echo $count_indi_doc_patient."<br>";
								
			//count number of appointments for clinic doctor
			$array	=	array('appointment_date'	=>	$date,
								'appointment_status'=>	'APPROVED',
								'doctor_clinic_id!='	=>	'0',										
							);
			//$count_clinic_doc_patient		=	$this->select->count_some_special_appointments($array);
			$clinic_doc_appointment			=	$this->select->get_some_appointments(100000,0,$array);
			
			//echo $count_clinic_doc_patient."<br>";
								
			//count number of appointments for pathology center
			$array	=	array(								 
								'path_ap_payment'	=>	'Transaction Successful',
								'path_ap_date'		=>	$date,
								'path_ap_status!='		=>	'Appointment Canecelled',
								);
			//$count_path_appointment	=	$this->select->count_all_pathappointments($array);
			$path_appointment		=	$this->select->get_some_pathappointments(100000,0,$array);
			 
			$array		=	array(
									'indi_doc_appointment'		=>	$indi_doc_appointment,
									'clinic_doc_appointment'	=>	$clinic_doc_appointment,
									'path_appointment'			=>	$path_appointment,
									'date'						=>	$date,
								);
			$this->load->view('admin/viewdayappointments',['array'	=>	$array]);
		}
		public function viewsomedayappointments()
		{
			$date	=	$this->input->get('date');
			return redirect(base_url('home/viewdayappointments/'.$date));
		}
		public function findrevenue()
		{
			//echo "<pre>";
			$m	=	$this->input->get('m');
			$y	=	$this->input->get('year');
			//print_r($this->input->post());
			$date	=	$y.'-'.$m.'-1';
			//echo $date;
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			//get individua doctors revenue			 
			$array	=	array(	
								'doctor_status'			=>			1,
								'doctor_clinic_id'		=>			0
							);
			$indi_doc	=	$this->select->get_some_doctors_name(1000,0,$array);
			if(count($indi_doc))
			{
				$i=0;
				foreach($indi_doc as $x)
				{
					$doctor_id	=	$x['doctor_id'];
					$array	=	array('appointment_date'	=>	$date,
								'appointment_payment'		=>	'Transaction Successful',
								'appointment_doctor_id'		=>	$x['doctor_id'],										
								);
					$indi_doc[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);				 
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `appointment_doctor_id` = '$doctor_id'";
					$indi_doc[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			//get clinic  name
			$array	=	array(	
								'clinic_status'			=>			1,								 
							);
			$clinic_name	=	$this->select->get_some_clinic_name($array);
			//echo $this->db->last_query();
			if(count($clinic_name))
			{
				$i=0;
				foreach($clinic_name as $x)
				{
					$clinic_id	=	$x['clinic_id'];
					$array	=	array(
								'appointment_date'		=>	$date,
								'appointment_payment'	=>	'Transaction Successful',
								'doctor_clinic_id'		=>	$x['clinic_id'],										
								);
					$clinic_name[$i]['today']	=	$this->select->get_added_revenue($array);
					 		 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);		
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment inner join doctor on appointment.appointment_doctor_id=doctor.doctor_id WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `doctor_clinic_id` = '$clinic_id'";
					$clinic_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			
			//get appointment for pathology
			$array	=	array(
								'path_status'	=>	1,
								);
			$path_name	=	$this->select->get_some_pathology($array);
			if(count($path_name))
			{
				$i=0;
				foreach($path_name as $x)
				{
					$path_id	=	$x['path_id'];
					$array	=	array(
									'path_ap_path_id'	=>	$x['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='		=>	'Appointment Canecelled',
								);				 
					$path_name[$i]['today']	=	$this->select->get_added_pathrevenue($array);
					//echo  $this->db->last_query();
					$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);		
					$sql	=	"SELECT SUM(path_ap_amount) AS path_ap_amount FROM path_appointment WHERE path_ap_path_id = '$path_id' AND path_ap_date between '$first' and '$last' AND path_ap_payment = 'Transaction Successful' AND path_ap_status!='Appointment Canecelled'";
					$path_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);
			for($i=1;$i<=$d;$i++)
			{
				 $date1		=	$y.'-'.$m.'-'.$i;
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date1,										 
									);				
				
				//print_r($array);
				$amount1		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date1;
				$array	=	array(
									'path_ap_date'		=>	$date1,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='	=>	'Appointment Canecelled',
								);
				 
				$revenue	=	array(
											'date'		=>	$date1,
											'revenue'	=>	$this->select->get_added_pathrevenue($array),
											//'revenue'	=>	200,
										);
				$amount2				=	$revenue['revenue']['path_ap_amount'];
				$monrev[$i]['total']	=	$amount1['appointment_money']+$amount2;
			}
			 
		 
			$array		=	array(
									'path_name'			=>	$path_name,
									'clinic_name'		=>	$clinic_name,
									'indi_doc'			=>	$indi_doc,
									'settings'			=>	$settings,
									'monrev'			=>	$monrev,
								);
			//print_r($array);
			$this->load->view('admin/findrevenue',['array'	=>	$array]);
		}
		public function findmyrevenue()
		{
			//echo "<pre>";
			$m	=	$this->input->get('m');
			$y	=	$this->input->get('year');
			//print_r($this->input->post());
			$date	=	$y.'-'.$m.'-1';
			//echo $date;
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			//get individua doctors revenue			 
			$array	=	array(	
								'doctor_status'			=>			1,
								'doctor_clinic_id'		=>			0
							);
			$indi_doc	=	$this->select->get_some_doctors_name(1000,0,$array);
			if(count($indi_doc))
			{
				$i=0;
				foreach($indi_doc as $x)
				{
					$doctor_id	=	$x['doctor_id'];
					$array	=	array('appointment_date'	=>	$date,
								'appointment_payment'		=>	'Transaction Successful',
								'appointment_doctor_id'		=>	$x['doctor_id'],										
								);
					$indi_doc[$i]['today']	=	$this->select->get_added_revenue($array);
					$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);				 
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `appointment_doctor_id` = '$doctor_id'";
					$indi_doc[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			//get clinic  name
			$array	=	array(	
								'clinic_status'			=>			1,								 
							);
			$clinic_name	=	$this->select->get_some_clinic_name($array);
			//echo $this->db->last_query();
			if(count($clinic_name))
			{
				$i=0;
				foreach($clinic_name as $x)
				{
					$clinic_id	=	$x['clinic_id'];
					$array	=	array(
								'appointment_date'		=>	$date,
								'appointment_payment'	=>	'Transaction Successful',
								'doctor_clinic_id'		=>	$x['clinic_id'],										
								);
					$clinic_name[$i]['today']	=	$this->select->get_added_revenue($array);
					 		 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);		
					$sql	=	"SELECT SUM(appointment_money) AS appointment_money FROM appointment inner join doctor on appointment.appointment_doctor_id=doctor.doctor_id WHERE appointment_date between '$first' AND '$last'  AND appointment_payment = 'Transaction Successful' AND `doctor_clinic_id` = '$clinic_id'";
					$clinic_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
				
			}
			
			//get appointment for pathology
			$array	=	array(
								'path_status'	=>	1,
								);
			$path_name	=	$this->select->get_some_pathology($array);
			if(count($path_name))
			{
				$i=0;
				foreach($path_name as $x)
				{
					$path_id	=	$x['path_id'];
					$array	=	array(
									'path_ap_path_id'	=>	$x['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='		=>	'Appointment Canecelled',
								);				 
					$path_name[$i]['today']	=	$this->select->get_added_pathrevenue($array);
					//echo  $this->db->last_query();
					$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);			 
					//echo $this->db->last_query()."<br><br>";
					$first	=	date($y.'-'.$m.'-1');
					$last	=	date($y.'-'.$m.'-'.$d);		
					$sql	=	"SELECT SUM(path_ap_amount) AS path_ap_amount FROM path_appointment WHERE path_ap_path_id = '$path_id' AND path_ap_date between '$first' and '$last' AND path_ap_payment = 'Transaction Successful' AND path_ap_status!='Appointment Canecelled'";
					$path_name[$i]['month']	=	$this->select->get_single_row($sql);
					//echo $this->db->last_query()."<br><br>";
 
					$i++;
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);
			for($i=1;$i<=$d;$i++)
			{
				 $date1		=	$y.'-'.$m.'-'.$i;
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date1,										 
									);				
				
				//print_r($array);
				$amount1		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date1;
				$array	=	array(
									'path_ap_date'		=>	$date1,
									'path_ap_payment'	=>	'Transaction Successful',
									'path_ap_status!='	=>	'Appointment Canecelled',
								);
				 
				$revenue	=	array(
											'date'		=>	$date1,
											'revenue'	=>	$this->select->get_added_pathrevenue($array),
											//'revenue'	=>	200,
										);
				$amount2				=	$revenue['revenue']['path_ap_amount'];
				$monrev[$i]['total']	=	$amount1['appointment_money']+$amount2;
			}
			 
		 
			$array		=	array(
									'path_name'			=>	$path_name,
									'clinic_name'		=>	$clinic_name,
									'indi_doc'			=>	$indi_doc,
									'settings'			=>	$settings,
									'monrev'			=>	$monrev,
								);
			//print_r($array);
			$this->load->view('admin/findmyrevenue',['array'	=>	$array]);
		}
		public function changepassword()
		{
			$this->load->view('admin/changepassword');
		}
		public function changeemail()
		{
			$this->load->view('admin/changeemail');
		}
		public function updatepassword()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
								'password'	=>	$post['password1'],
								'admin_id'	=>	1,
								);
			if($post['password2']!=	$post['password3'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Passwords do not match</div>');
				 
			}
			else if(!$this->select->checkadminlogin($array))
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old Password does not match</div>');
				 
			}
			else 
			{
				$array	=	array('password'	=>	$post['password2']);
				if($this->update->update_table('admin','admin_id',1,$array))
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-success">Password changed successfully</div>');
					
				}
				else
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">system failure. Please try later</div>');
					 
				}
			}
			return redirect(base_url('home/changepassword'));
		}
		public function updateemail()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
								'username'	=>	$post['email1'],
								'admin_id'	=>	1,
								);
			if($post['email2']!=	$post['email3'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Emails do not match</div>');
				 
			}
			else if(!$this->select->checkadminlogin($array))
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old email does not match</div>');
				 
			}
			else 
			{
				$array	=	array('username'	=>	$post['email2']);
				if($this->update->update_table('admin','admin_id',1,$array))
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-success">Email changed successfully</div>');
					
				}
				else
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">system failure. Please try later</div>');
					 
				}
			}
			return redirect(base_url('home/changeemail'));
		}
		public function changepic()
		{
			$this->load->helper('form');
			$this->load->view('admin/changepic');
		}
		public function storeimage()
		{
			
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$config['upload_path']          = './img/admin';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['file_name']      		= 'admin.png';
/* 			$config['max_size']             = 100;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
 */
			$this->load->library('upload', $config);
			@unlink('./img/admin/admin.png');
			if ( ! $this->upload->do_upload('userfile'))
			{
				//$data = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('picmsg','<div class="alert alert-danger">'. $this->upload->display_errors().'</div>');	
					
			}
			else
			{
					$data = array('upload_data' => $this->upload->data());

					//$this->load->view('upload_success', $data);
					$this->session->set_flashdata('picmsg','<div class="alert alert-success">Image Uploaded Successfully. </div>');
			}
			return redirect(base_url('home/changepic'));
		}
		
		
	}
?>
