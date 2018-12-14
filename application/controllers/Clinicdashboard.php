<?php
	Class Clinicdashboard extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!isset($_COOKIE['clinic_id']))
			{
				return redirect (base_url('cliniclogin'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			$clinicarray	=	array('clinic_id'	=>	$_COOKIE['clinic_id']);
			$this->myclinic	=	$this->select->get_one_clinic($clinicarray);
			ob_start();
		}
		public function index()
		{
			$array	=	array('doctor_clinic_id'	=>	$_COOKIE['clinic_id']);
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);
			if(count($doctors))
			{
				$i=0;
				foreach($doctors as $x)
				{
					 
					$array	=	array('appointment_date'	=>	date('Y-m-d'),
										'appointment_status'=>	'APPROVED',
										'appointment_doctor_id'=>	$x['doctor_id']
										
										);
					$quant1	=	$this->select->count_all_appointments($array);
					 
				 
					 
				 
					$doctors[$i++]['appointments']	=	array(
															'quant1'	=>	$quant1,
															 
													);
					
				}
			}
			$array	=	array(
								
								'appointment_payment'	=>	'Transaction Successful',
								'appointment_date>'		=>	date('Y-m-d'),
								'clinic_id'				=>	$_COOKIE['clinic_id'],
							);			 
			$advanceappointments	=	$this->select->count_clinicwise_appointments($array);
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										'clinic_id'				=>	$_COOKIE['clinic_id'],
									);				
				
				//print_r($array);
				$monapp[$i]['number']	=	$this->select->count_clinicwise_appointments($array);
				$monapp[$i]['date']		=	$date;
			
			}
			//echo "<pre>";
			//print_r($monapp);
			$array	=	array(
								'myclinic'	=>	$this->myclinic,
								'doctors'	=>	$doctors,
								'monapp'	=>	$monapp,
								'advanceappointments'	=>	$advanceappointments
								);
			$this->load->view('clinic/home',['array'	=>	$array]);
		}
		public function signout()
		{
			setcookie('clinic_id', '0', time() - (3600), "/");	
			return redirect(base_url());
		}
		
		public function doctors()
		{
			$this->load->library('pagination');
			$array	=	array(
								'doctor_clinic_id'	=>	$_COOKIE['clinic_id'],
								 
							);
			$config		=	array(
								'base_url'		=>		base_url('clinicdashboard/doctors'),
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
								'myclinic'	=>	$this->myclinic
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('clinic/doctors',['array'	=>	$array]);
		}
		public function services()
		{
			$this->load->library('pagination');
			$array	=	array(
								'clinic_service_clinic_id'	=>	$_COOKIE['clinic_id'],								 
							);
			$config		=	array(
								'base_url'		=>		base_url('clinicdashboard/services'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_services($array),
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
			$services	=	$this->select->get_some_services($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'services'	=>	$services,
								'myclinic'	=>	$this->myclinic
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('clinic/services',['array'	=>	$array]);
		}
		public function addservices()
		{
			$array	=	array(
								 
								'myclinic'	=>	$this->myclinic
								);
			 
			$this->load->view('clinic/addservices',['array'	=>	$array]);
		}
		public function storeservices()
		{
			$post	=	$this->input->post();
			$i=0;
			foreach($post['clinic_service_name'] as $x)
			{
				$data[$i]['clinic_service_name']		=	$post['clinic_service_name'][$i];	
				$data[$i]['clinic_service_speciality']	=	$post['clinic_service_speciality'][$i];	
				$data[$i]['clinic_service_clinic_id']	=	$post['clinic_service_clinic_id'];	
				$i++;
			}
			echo "<pre>";
			print_r($data);
			if($this->insert->insert_batch_table($data,'clinic_service'))
			{
				$this->session->set_flashdata('addservicemsg','<div class="alert alert-success">Services Added Successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('addservicemsg','<div class="alert alert-danger">System Failure.</div>');
			}
			return redirect('clinicdashboard/addservices');
		}
		public function delservices()
		{
			
			$post	=	$this->input->post();
			//print_r($post);
			$this->load->model('delete');
			if($this->delete->delete_table($post,'clinic_service'))
			{
				$this->session->set_flashdata('servicemsg','<div class="alert alert-success">Services deleted Successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('servicemsg','<div class="alert alert-danger">System Failure.</div>');
			}
			echo "1";
			
		}
		public function doctordetails()
		{
			$doctor_id	= $this->uri->segment(3);
			$array		=	array(
									'doctor_id'		=>		$doctor_id,
									'doctor_clinic_id'	=>	$_COOKIE['clinic_id']
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
									'myclinic'	=>	$this->myclinic
									);
				$this->load->view('clinic/doctordetail',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('Error404'));
			}
		}
		public function profile()
		{
			$cities	=	$this->select->get_all_cities();
			
			 $array	=	array(
									'cities' 	=>	$cities,
									'myclinic'	=>	$this->myclinic
									);
				$this->load->view('clinic/profile',['array'	=>	$array]);
		}
		public function regcertificates()
		{
			 $array	=	array(
								'myclinic'	=>	$this->myclinic
							);
			$this->load->view('clinic/regcertificates',['array'	=>	$array]);
		}
		public function timings()
		{
			 $array	=	array(
								'myclinic'	=>	$this->myclinic
							);
			$this->load->view('clinic/timings',['array'	=>	$array]);
		}
		
		public function updateclinic()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			if($this->update->update_table('clinic','clinic_id',$post['clinic_id'],$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/profile'));
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
			return redirect(base_url('clinicdashboard/timings'));
		}
		
		public function updateclinicservices()
		{
			$post	=	$this->input->post();
			$post['clinic_features']	=	implode(",",$post['clinic_features']);
			$clinic_id					=	$_COOKIE['clinic_id'];
			 
			
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
			
		}
		public function updateclinicwaste()
		{
			$post	=	$this->input->post();
			$clinic_id	=	$_COOKIE['clinic_id'];
			$clinic_waste_disposal_pre	=	$post['clinic_waste_disposal_pre'];			 
			unset($post['clinic_waste_disposal_pre']);
			if(!file_exists('./images/clinic/'.$clinic_id.'/'))
			{
				mkdir('./images/clinic/'.$clinic_id.'/'); 
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
			
		}
		public function updateclinicpres()
		{
			$post	=	$this->input->post();
			$clinic_id					=	$_COOKIE['clinic_id'];
			 
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
			
		}
		public function updatecliniclogo()
		{
			$post	=	$this->input->post();			 
			$clinic_id					=	$_COOKIE['clinic_id'];
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
			
		}
		public function updateclinicphoto()
		{
			$post	=	$this->input->post();
			$clinic_id					=	$_COOKIE['clinic_id'];			 
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
			 
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
			
		}
		public function updatereg()
		{
			$post	=	$this->input->post();			 
			$clinic_id					=	$_COOKIE['clinic_id'];			 
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Profile updated Successfully. </b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger"><b>System Failure. </b></div>');
			
			}
			return redirect(base_url('clinicdashboard/regcertificates'));
					
		}
		
		public function appointments()
		{
			$array	=	array('doctor_clinic_id'	=>	$_COOKIE['clinic_id']);
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);
			if(count($doctors))
			{
				$i=0;
				foreach($doctors as $x)
				{
					 
					$array	=	array('appointment_date'	=>	date('Y-m-d'),
										'appointment_status'=>	'APPROVED',
										'appointment_doctor_id'=>	$x['doctor_id']
										
										);
					
					$quant1	=	$this->select->count_all_appointments($array);
					//echo $this->db->last_query()."<br>"; 
				 
					$array	=	array('appointment_date'	=>	date('Y-m-d', time() + 86400),
										'appointment_status'=>	'APPROVED',
										'appointment_doctor_id'=>	$x['doctor_id']
										);
					$quant2	=	$this->select->count_all_appointments($array);
					 $first	=	date('Y-m-1');
					 $last	=	date('Y-m-31');
					 $doctor_id	=	$x['doctor_id'];
					 $sql	=	"SELECT count(appointment_id) as total FROM appointment WHERE 
								appointment_date between  '$first' and '$last' AND appointment_status = 'APPROVED' AND appointment_doctor_id = '$doctor_id'";
					$month	=	$this->select->get_single_row($sql);
					 
					/*$array	=	array('appointment_date'	=>	date('Y-m-d', time() + 2*86400),
										'appointment_status'=>	'APPROVED',
										'appointment_doctor_id'=>	$x['doctor_id']
										);
					$quant3	=	$this->select->count_all_appointments($array);
					 
					$array	=	array('appointment_date'	=>	date('Y-m-d', time() + 3*86400),
										'appointment_status'=>	'APPROVED',
										'appointment_doctor_id'=>	$x['doctor_id']
										);
					$quant4	=	$this->select->count_all_appointments($array);
					/*echo $x['doctor_name']."<br>";
					echo date('Y-m-d')." => ".$quant1."<br>";
					echo date('Y-m-d', time() + 1*86400)." => ".$quant2."<br>";
					echo date('Y-m-d', time() + 2*86400)." => ".$quant3."<br>";
					echo date('Y-m-d', time() + 3*86400)." => ".$quant4."<br>";
					echo "<br><br><br>";
					*/
					$doctors[$i++]['appointments']	=	array(
															'quant1'	=>	$quant1,
															'quant2'	=>	$quant2,
															'month'		=>	$month['total'],
															 
													);
					
				}
			}
			//echo "<pre>";			
			//print_r($doctors);
			$array	=	array('doctors'	=>	$doctors,
								'myclinic'	=>	$this->myclinic
								);
			
			
			$this->load->view('clinic/appointments',['array'	=>	$array]);
		}
		public function revenue()
		{
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array('doctor_clinic_id'	=>	$_COOKIE['clinic_id']);
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);
			$monrev		=	array(); 
			
			if(count($doctors))
			{
				$i=0;
				foreach($doctors as $x)
				{
					$doctor_ids[]	=	$x['doctor_id'];
					$array1	=	array('appointment_date'	=>	date('Y-m-d'),
										'appointment_payment'=>	'Transaction Successful',
										'appointment_doctor_id'=>	$x['doctor_id'],										
										);
					$array2	=	array('appointment_date'	=>	date('Y-m-d', time() + 86400),
										'appointment_payment'=>	'Transaction Successful',
										'appointment_doctor_id'=>	$x['doctor_id'],										
										);
					$array3	=	array('appointment_date'	=>	date('Y-m-d', time() + 2*86400),
										'appointment_payment'=>	'Transaction Successful',
										'appointment_doctor_id'=>	$x['doctor_id'],										
										);
					$array4	=	array('appointment_date'	=>	date('Y-m-d', time() + 3*86400),
										'appointment_payment'=>	'Transaction Successful',
										'appointment_doctor_id'=>	$x['doctor_id'],										
										);
					$array5	=	array('appointment_date'	=>	date('Y-m-d', time() + 4*86400),
										'appointment_payment'=>	'Transaction Successful',
										'appointment_doctor_id'=>	$x['doctor_id'],										
										);
										
					$revenue1	=	$this->select->get_added_revenue($array1);
					$revenue2	=	$this->select->get_added_revenue($array2);
					$revenue3	=	$this->select->get_added_revenue($array3);
					$revenue4	=	$this->select->get_added_revenue($array4);
					$revenue5	=	$this->select->get_added_revenue($array5);
					 
					$doctors[$i++]['revenue']	=	array(
															'revenue1'	=>	$revenue1,
															'revenue2'	=>	$revenue2,
															'revenue3'	=>	$revenue3,
															'revenue4'	=>	$revenue4,
															'revenue5'	=>	$revenue5,
															);
					 
				}
				//$doctor_ids		=	implode(',',$doctor_ids);
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
					$monrev[$i]		=	$this->select->get_clinic_addedrevenue($array,$doctor_ids);
					$monrev[$i]['date']		=	$date;
				
				}
				
			}
			
			//echo "<pre>";
			//print_r($monrev);
			
			$array	=	array(
								'myclinic'	=>	$this->myclinic,
								'doctors'	=>	$doctors,
								'monrev'	=>	$monrev,
								'settings'	=>	$settings,
								
								);
			
			
			$this->load->view('clinic/revenue',['array'	=>	$array]);
		}
		public function editdoctorprofile()
		{
			$array	=	array(
			'doctor_clinic_id'	=>	$_COOKIE['clinic_id'],
			'doctor_id'			=>	$this->uri->segment(3)
			);
			if(count($doctor	=	$this->select->get_one_doctor($array)))
			{
				$cities	=	$this->select->get_all_cities();
				$array	=	array(
								'doctor'	=>	$doctor,
								'cities'	=>	$cities,
								'myclinic'	=>	$this->myclinic,	
								);
			$this->load->view('clinic/editdoctorprofile',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('clinicdashboard/doctors'));
			}
			
		}
		public function updatedoctorprofile()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b> Profile updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('clinicdashboard/doctordetails/'.$post['doctor_id']));
		}
		
		public function editdoctorfees()
		{
			$array	=	array(
								'doctor_clinic_id'	=>	$_COOKIE['clinic_id'],
								'doctor_id'			=>	$this->uri->segment(3)
							);
			if(count($doctor	=	$this->select->get_one_doctor($array)))
			{
				$array	=	array('doctor'	=>	$doctor,
									'myclinic'	=>	$this->myclinic,
								);
				$this->load->view('clinic/editdoctorfees',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('clinicdashboard/doctors'));
			}
		}
		public function viewallappointments()
		{
			$doctor_id	=	$this->uri->segment(3);
			$array		=	array('doctor_id'	=>	$doctor_id);
			$doctor		=	$this->select->get_one_doctor($array);	
			$array	=	array(
								'appointment_doctor_id'	=>	$doctor_id,
								'appointment_date'		=>	date('Y-m-d'),
								'appointment_payment'	=>	'Transaction Successful',
								);
			$appointments	=	$this->select->get_some_appointments(999,0,$array);
			//echo "<pre>";
			//print_r($array);
			//print_r($appointments);
			$array	=	array(
									'appointments'	=>	$appointments,
									'doctor'		=>	$doctor,
									'myclinic'		=>	$this->myclinic,
									'date'			=>	date('Y-m-d'),
								);
			$this->load->view('clinic/viewallappointments',['array'	=>	$array]);
		}
		
		public function showallappointments()
		{
			$post	=	$this->input->post();
			$doctor_id	=	$post['appointment_doctor_id'];
			$array		=	array('doctor_id'	=>	$doctor_id);
			$doctor		=	$this->select->get_one_doctor($array);	
			 
			$appointments	=	$this->select->get_some_appointments(999,0,$post);
			//echo "<pre>";
			//print_r($array);
			//print_r($appointments);
			$array	=	array(
									'appointments'	=>	$appointments,
									'doctor'		=>	$doctor,
									'myclinic'		=>	$this->myclinic,
									'date'			=>	$post['appointment_date'],
								);
			$this->load->view('clinic/viewallappointments',['array'	=>	$array]);
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
			print_r($post);
			 
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:green;color:white;"><b>Consultancy fees and time slots updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('practitionermsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('clinicdashboard/doctordetails/'.$post['doctor_id']));
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
									'myclinic'		=>	$this->myclinic,
									
								);
				$this->load->view('clinic/viewpatientdetails',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('clinicdashboard'));
			}
		}
		public function adddoctors()
		{
			$clinic	=	$this->select->get_employee(999,0);
			$cities	=	$this->select->get_all_cities();
			$array	=	array(
								'myclinic'		=>	$this->myclinic,
								'cities'		=>	$cities,
							);
			$this->load->view('clinic/adddoctors',['array'	=>	$array]);
		}
		public function storedoctor()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
									'doctor_email'	=>	$post['doctor_email']
								);
			if($post['doctor_password']!=$post['doctor_password2'])
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><b>Passwords do not match.</b></div>');
				
			}
			else if($this->select->checkdoctor($array))
			{
				$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><b>Practitioner is already added.</b></div>');
				 
			}
			else
			{
				unset($post['doctor_password2']);
				if($this->insert->insert_table($post,'doctor'))
				{
					$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-success" style="background:green;color:white"><b>Doctor added successfully.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('addpractitionermsg','<div class="alert alert-danger" style="background:red;color:white"><bSystem Failure.</b></div>');
				}
				
			}
			return redirect(base_url('clinicdashboard/adddoctors'));
		}
		public function editeducation()
		{
			$doctor_id	=	$this->uri->segment(3);
			$array			=	array(
									'doctor_id'	=>	$doctor_id,
									'doctor_clinic_id'	=>	$_COOKIE['clinic_id']
									);
			if(count($doctor			=	$this->select->get_one_doctor($array))){
				//$cities			=	$this->select->get_all_cities($array);
				$specialities	=	$this->select->get_all_specialization($array);
				$array			=	array('qualification_doctor_id'	=>	$doctor_id);
				$education		=	$this->select->get_some_education($array);
				$array			=	array('document_doctor_id'	=>	$doctor_id);
				$documents		=	$this->select->get_some_documents($array);
				$array			=	array(
										'doctor'	=>	$doctor,
										'documents'	=>	$documents,									 
										'specialities'	=>	$specialities,
										'myclinic'		=>	$this->myclinic,
										'education'	=>	$education,
										);
				//echo "<pre>";
				//print_r($array);
				$this->load->view('clinic/editeducation',['array'	=>	$array]);
			}
			else{
				return redirect (base_url());
			}
			
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
			return redirect(base_url('clinicdashboard/editeducation/'.$doctor_id));
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
				echo "<pre>";
				//print_r($array);
				foreach($array as $x)
				{
					print_r($x);
					$this->update->update_table('qualification','qualification_id',$x['qualification_id'],$x);
				}
			}
			return redirect(base_url('clinicdashboard/editeducation/'.$doctor_id));
			
		}
		public function storedocuments()
		{
			echo "<pre>";
			
			$post	=	$this->input->post();
			$doctor_id	=	$post['document_doctor_id'][0];
			//print_r($_FILES['document_certificate']);
			print_r($post);
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
			return redirect(base_url('clinicdashboard/editeducation/'.$doctor_id));
			 
		}
		public function updatedocument()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			//exit();
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
			return redirect(base_url('clinicdashboard/editeducation/'.$post['document_doctor_id'][0]));
		
			
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
								'base_url'		=>		base_url('clinicdashboard/viewappointments/'.$doctor_id),
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
								 'myclinic'		=>	$this->myclinic,
								 'doctor'		=>	$doctor,
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('clinic/viewappointments',['array'	=>	$array]);
			
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
								'base_url'		=>		base_url('clinicdashboard/viewpreviousappointments/'.$doctor_id),
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
								 'myclinic'		=>	$this->myclinic,
								 'doctor'		=>	$doctor,
								'count'		=>	$this->uri->segment(4)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('clinic/viewpreviousappointments',['array'	=>	$array]);
		}
		public function resetpassword()
		{
				$array	=	array(
								
								 'myclinic'		=>	$this->myclinic,
								 
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('clinic/resetpassword',['array'	=>	$array]);
		}
		public function updatepassword()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$array	=	array(
								'clinic_password'	=>	$post['clinic_old_password'],
								'clinic_id'		=>	$_COOKIE['clinic_id'],
								);
			if($clinic_id	=	$this->select->checkclinic($array))
			{
				if($post['clinic_password']!=$post['clinic_password2'])
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Passwords do not match.</div>');
				}
				else
				{
					unset($post['clinic_password2']);
					unset($post['clinic_old_password']);
					if($this->update->update_table('clinic','clinic_id',$clinic_id,$post))
					{
						$this->session->set_flashdata('passmsg','<div class="alert alert-success">Password changes successfully.</div>');
					
					}
					else
					{
						$this->session->set_flashdata('passmsg','<div class="alert alert-success">System failure.</div>');
					}
				}
			}
			else
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old Password does not match.</div>');
		
			}
			return redirect(base_url('clinicdashboard/resetpassword'));
		}
		public function findrevenue()
		{
			
			$post	=	$this->input->get();
			//print_r($post);
			//exit();
			$array	=	array('doctor_clinic_id'	=>	$_COOKIE['clinic_id']);
			$doctors	=	$this->select->get_some_doctors_details(999,0,$array);			
			$monrev		=	array();
			if(count($doctors))
			{				
				foreach($doctors as $x)
				{
					$doctor_ids[]	=	$x['doctor_id'];					
				}
				$d=cal_days_in_month(CAL_GREGORIAN,$post['month'],$post['year']);			 
				for($i=1;$i<=$d;$i++)
				{
					$date	=	 $post['year'].'-'.$post['month'].'-'.$i;
					$array		=	array(
											'appointment_payment'	=>	'Transaction Successful',
											'appointment_date'		=>	$date,									
										);				
					
					//print_r($array);
					$monrev[$i]		=	$this->select->get_clinic_addedrevenue($array,$doctor_ids);
					$monrev[$i]['date']		=	$date;			
				}
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);			
			
			$array	=	array(
								'myclinic'	=>	$this->myclinic,
								'doctors'	=>	$doctors,
								'monrev'	=>	$monrev,
								'settings'	=>	$settings,								
								 								
								);
			$this->load->view('clinic/findrevenue',['array'	=>	$array]);			
		}
		public function findappointment()
		{			  
			$post	=	$this->input->get();			 			
			$d=cal_days_in_month(CAL_GREGORIAN,$post['month'],$post['year']);	
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 $post['year']."-".$post['month']."-".$i;
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										'clinic_id'				=>	$_COOKIE['clinic_id'],
									);	
				$monapp[$i]['number']	=	$this->select->count_clinicwise_appointments($array);
				$monapp[$i]['date']		=	$date;			
			}
			$array	=	array(
								'myclinic'	=>	$this->myclinic,
								 
								'monapp'	=>	$monapp,
								 
								);
			
			 
			$this->load->view('clinic/findappointment',['array'	=>	$array]);
		}
		 
		
	}
?>
