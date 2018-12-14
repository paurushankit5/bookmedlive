<?php
	class Doctordashboard extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			if(!isset($_COOKIE['doctor_id']))
			{
				return redirect (base_url('doctorlogin'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			$array	=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
			$this->me		=	$this->select->get_one_doctor($array);
			ob_start();
		}
		
		public function index()
		{
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
									);				
				
				//print_r($array);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;
			
			}
			 $array	=	array(
			'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
			'appointment_date'		=>	date('Y-m-d'),
			'appointment_payment'	=>	'Transaction Successful',
			);
			$doctor_id	=	$_COOKIE['doctor_id'];
			 			
			$appointments	=	$this->select->get_some_appointments(15,0,$array);
			 $i=0;
			$demo="select * from question inner join patient on patient.patient_id = question.question_patient_id
					where question_doctor_id='$doctor_id' and question_ans=''";
			 
			 
			$questions	=	$this->select->get_questions($demo);
			 
			$array	=	array(
								'me'			=>	$this->me,
								'monapp'		=>	$monapp,
								'appointments'	=>	$appointments,								
								'questions'		=>	$questions,								
								);
			//echo "<pre>";
			//print_r($questions);
			//print_r(explode(',',$this->me['doctor_qualification']));
			
			//echo "</pre>";
			$this->load->view('doctor/home',['array'	=>	$array]);
		}
		
		public function myprofile()
		{
			$array	=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
			$doctor	=	$this->select->get_one_doctor($array);
			$cities	=	$this->select->get_all_cities($array);
			$specialities	=	$this->select->get_all_specialization($array);
			$array	=	array(
								'doctor'	=>	$doctor,
								'cities'	=>	$cities,
								'specialities'	=>	$specialities,
								'me'		=>	$this->me
								);
			$this->load->view('doctor/myprofile',['array'	=>	$array]);
		}
		
		public function updateprofile()
		{
			$post		=	$this->input->post();
			$preimage	=	$post['preimage'];
			$doctor_id	=	$post['doctor_id'];
			unset($post['preimage']);
			if($_FILES['doctor_pic']['name'])
			{
				$post['doctor_pic']	=	$_FILES['doctor_pic']['name'];
			}
			
			//$post['doctor_qualification']	=	implode(",",$post['doctor_qualification']);
			
			if($this->update->update_table('doctor','doctor_id',$post['doctor_id'],$post))
			{				
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="background:green;color:white;"><b>Profile updated successfully.</b></div>');
				if($_FILES['doctor_pic']['name']!='')
				{
					if(!file_exists('./images/doc/'.$doctor_id.'/'))
					{
						mkdir('./images/doc/'.$doctor_id.'/'); 
					}
					unlink("./images/doc/$doctor_id/".$preimage);
					if (move_uploaded_file($_FILES['doctor_pic']['tmp_name'],"./images/doc/$doctor_id/".$post['doctor_pic']))
					{
						$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Profile Updated Successfully. </div>');				 
					}
					else
					{
						$this->session->set_flashdata('profilemsg','<div class="alert alert-danger">Image Upload error. </div>');
					} 
				}
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('doctordashboard/myprofile'));
			
		}
	 
		public function consultancyfee()
		{
			$array	=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
			$doctor	=	$this->select->get_one_doctor($array);
			$array	=	array('doctor'	=>	$doctor,
								'me'	=>	$this->me);
			$this->load->view('doctor/consultancyfee',['array'	=>	$array]);
		}
		
		public function updatefee()
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="background:green;color:white;"><b>Profile updated successfully.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="background:red;color:white;"><b>System Failure.</b></div>');

			}
			return redirect(base_url('doctordashboard/consultancyfee'));
		}
		public function myappointments()
		{
			$array	=	array(
			'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
			'appointment_payment'	=>	'Transaction Successful',
			'appointment_date>='	=>	date('Y-m-d'),
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('doctordashboard/myappointments'),
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
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'			=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/myappointments',['array'	=>	$array]);
			
		}
		
		public function previousappointments()
		{
			$array	=	array(
			'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
			'appointment_payment'	=>	'Transaction Successful',
			'appointment_date<'	=>	date('Y-m-d'),
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('doctordashboard/previousappointments'),
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
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'			=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/previousappointments',['array'	=>	$array]);
			
		}
		
		public function mypatients()
		{
			$array	=	array(
			'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
			
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('doctordashboard/mypatients'),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_some_patients($array),
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
			$patients	=	$this->select->get_patients($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'patients'	=>	$patients,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/mypatients',['array'	=>	$array]);
			
		}
		
		public function todaysappointments()
		{
			$array	=	array(
			'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
			'appointment_date'		=>	date('Y-m-d'),
			'appointment_payment'	=>	'Transaction Successful',
			);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('doctordashboard/todaysappointments'),
								'per_page'		=>		'100',
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
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'			=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/todaysappointments',['array'	=>	$array]);
		}
		
		public function viewpatientdetails()
		{
			$patient_id	=	$this->uri->segment(3);
			$array	=	array('patient_id'	=>	$patient_id);
			if($this->select->checkpatient($array))
			{
				$patient=	$this->select->get_one_patient($array);
				$array	=	array(
									'prescription_patient_id'	=>	$patient_id
									);
				$prescription	=	$this->select->get_all_prescription($array);
				$array	=	array(
									'patient'		=>	$patient,
									'prescription'	=>	$prescription,
									'me'			=>	$this->me
									
								);
				$this->load->view('doctor/viewpatientdetails',['array'	=>	$array]);
			}
			else
			{
				$this->session->set_flashdata('patientmsg','<div class="alert alert-danger" style="background:red;color:white;"><b>Invalid Url.</b></div>');
				return redirect(base_url('doctordashboard/mypatients'));
			}
			
		}
		public function storeprescription()
		{
			echo "<pre>";
			$post	=	$this->input->post();			 
			 
			 
			$post['prescription_image']		=	$_FILES['prescription_image']['name'];
			$post['prescription_add_time']	=	date('Y-m-d H:i:s');
			print_r($post);
			//print_r($_FILES['prescription_image']);
			//print_r($array);
		 
			if($prescription_id	=	$this->insert->insert_table($post,'prescription'))
			{
				mkdir('./images/pres/'.$prescription_id.'/'); 
				 
				 	 
                if (move_uploaded_file($_FILES['prescription_image']['tmp_name'],"./images/pres/$prescription_id/".$post['prescription_image']))
                {
					$this->session->set_flashdata('patientmsg','<div class="alert alert-success">Prescription Added Successfully</div>');				 
                }
                else
                {
					$this->session->set_flashdata('patientmsg','<div class="alert alert-danger">Prescription Image Upload error</div>');
                }				
			}
			else
			{
				$this->session->set_flashdata('patientmsg','<div class="alert alert-danger">System Failure</div>');	
			}
			return redirect(base_url('doctordashboard/viewpatientdetails/'.$post['prescription_patient_id']));
			
		}
		
		public function signout()
		{
			setcookie('doctor_id', '0', time() - (3600), "/");	
			return redirect(base_url());
		}
		
		public function reschedule()
		{
			$appointment_id		=	$this->uri->segment(3);
			$array				=	array('appointment_id'	=>	$appointment_id);
			if(count($appointment		=	$this->select->get_one_appointment($array)))
			{
				$array	=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
				$doctor	=	$this->select->get_one_doctor($array);
				$array	=	array(									 
									'appointment'	=>	$appointment,
									'doctor'		=>	$doctor,
									'me'			=>	$this->me									
								);
				$this->load->view('doctor/reschedule',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('doctordashboard'));
			}
		}
		
		public function rescheduleappointment()
		{
			$post	=	 $this->input->post();
			if($this->update->update_table('appointment','appointment_id',$post['appointment_id'],$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Appointment rescheduled successfully.</div>');
				echo "yes";
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger">System Failure.</div>');
				echo "no";
			}
		}
		public function revenue()
		{
			$array1	=	array('appointment_date'	=>	date('Y-m-d'),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array2	=	array('appointment_date'	=>	date('Y-m-d', time() + 86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array3	=	array('appointment_date'	=>	date('Y-m-d', time() + 2*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array4	=	array('appointment_date'	=>	date('Y-m-d', time() + 3*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array5	=	array('appointment_date'	=>	date('Y-m-d', time() + 4*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array6	=	array('appointment_date'	=>	date('Y-m-d', time() + 5*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array7	=	array('appointment_date'	=>	date('Y-m-d', time() - 86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array8	=	array('appointment_date'	=>	date('Y-m-d', time() - 2*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array9	=	array('appointment_date'	=>	date('Y-m-d', time() - 3*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array10	=	array('appointment_date'	=>	date('Y-m-d', time() - 4*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],										
								);
			$array11	=	array('appointment_date'	=>	date('Y-m-d', time() - 5*86400),
								'appointment_payment'=>	'Transaction Successful',
								'appointment_doctor_id'=>	$_COOKIE['doctor_id'],
								
								);
								
			$revenue1	=	$this->select->get_added_revenue($array1);
			$revenue2	=	$this->select->get_added_revenue($array2);
			$revenue3	=	$this->select->get_added_revenue($array3);
			$revenue4	=	$this->select->get_added_revenue($array4);
			$revenue5	=	$this->select->get_added_revenue($array5);
			$revenue6	=	$this->select->get_added_revenue($array6);
			$revenue7	=	$this->select->get_added_revenue($array7);
			$revenue8	=	$this->select->get_added_revenue($array8);
			$revenue9	=	$this->select->get_added_revenue($array9);
			$revenue10	=	$this->select->get_added_revenue($array10);
			$revenue11	=	$this->select->get_added_revenue($array11);
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
										'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
									);				
				
				//print_r($array);
				$monrev[$i]		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;
				
			}
			
			$array	=	array(									 
									'me'			=>	$this->me,
									'revenue1'		=>	$revenue1,
									'revenue2'		=>	$revenue2,
									'revenue3'		=>	$revenue3,
									'revenue4'		=>	$revenue4,
									'revenue5'		=>	$revenue5,
									'revenue6'		=>	$revenue6,
									'revenue7'		=>	$revenue7,
									'revenue8'		=>	$revenue8,
									'revenue9'		=>	$revenue9,
									'revenue10'		=>	$revenue10,
									'revenue11'		=>	$revenue11,
									'settings'		=>	$settings,
									'monrev'		=>	$monrev,
									
								);
			
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/revenue',['array'	=>	$array]);
			
		}
		public function findrevenue()
		{
			
			$post	=	$this->input->get();
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);			
			$d=cal_days_in_month(CAL_GREGORIAN,$post['month'],$post['year']);			 
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 $post['year'].'-'.$post['month'].'-'.$i;
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
									);				
				
				$monrev[$i]		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;				
			}
			//echo "<pre>";
			//print_r($monrev);
			
			$array	=	array(									 
									'me'			=>	$this->me,									 
									'settings'		=>	$settings,
									'monrev'		=>	$monrev,									
								);
			
			 
			$this->load->view('doctor/findrevenue',['array'	=>	$array]);
			
		}
		public function cancelappointment()
		{
			$post	=	$this->input->post();
			$appointment	=	$this->select->get_one_appointment($post);
			//print_r($appointment);
			$post['appointment_status']		=	'CANCELLED';
			$post['appointment_payment']	=	'CANCELLED';
			//print_r($post);
			$this->update->update_table('appointment','appointment_id',$post['appointment_id'],$post);
			$array		=	array('wallet_patient_id'	=>		$appointment['appointment_patient_id']);
			if(count($wallet	=	$this->select->get_one_wallet($array)))
			{
				$wallet['wallet_amount']	=	$wallet['wallet_amount']+$appointment['appointment_money'];
				$this->update->update_table('wallet','wallet_id',$wallet['wallet_id'],$wallet);
				 
			}
			else
			{
				$array	=	array(
									'wallet_patient_id'	=>		$appointment['appointment_patient_id'],
									'wallet_amount'		=>		$appointment['appointment_money']
									);
				$this->insert->insert_table($array,'wallet');				 
			}
			$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Appointment cancelled successfully.</div>');
		}
		public function viewdiagnosisreport()
		{
			
			$array	=	array(
								'patient_id'	=>	$this->uri->segment(3)
								);
			if(count($patient	=	$this->select->get_one_patient($array)))
			{
				$array	=	array(
								'path_report_patient_id'	=>	$this->uri->segment(3)
								);
				$report	=	$this->select->get_some_report($array);
				 
				//echo "<pre>";
				//print_r($report);
				$array	=	array(									 
									'me'			=>	$this->me,
									'report'		=>	$report,						
									'patient'		=>	$patient,						
								);
				$this->load->view('doctor/viewdiagnosisreport',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('doctordashboard'));
			}
			
		}
		public function updatequestion()
		{
			$post	=	$this->input->post();
			$post['question_doctor_id']	=	$_COOKIE['doctor_id'];	
			$post['question_ans_add_time']	=	date('Y-m-d H:i:s');	
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('question','question_id',$post['question_id'],$post))
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-success">Congratulations!.. Your answer has been successfully added.</div>');
			}
			else
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-danger">Oopss!.. System Failure.</div>');
			}
			return redirect(base_url('doctordashboard/answeredquestions'));
		}
		public function answeredquestions()
		{
			$array	=	array(
								'question_doctor_id'	=>	$_COOKIE['doctor_id'],								
								'question_doc_clear'	=>	0,								
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('doctordashboard/answeredquestions'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_all_questions($array),
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
			$questions	=	$this->select->get_some_questions($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'me'		=>	$this->me,
								'questions'=>	$questions,
								'count'		=>	$this->uri->segment(3),
								
							);
			$this->load->view('doctor/answeredquestions',['array'	=>	$array]);
		}
		public function education()
		{
			$array			=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
			$doctor			=	$this->me;
			//$cities			=	$this->select->get_all_cities($array);
			$specialities	=	$this->select->get_all_specialization($array);
			$array			=	array('qualification_doctor_id'	=>	$_COOKIE['doctor_id']);
			$education		=	$this->select->get_some_education($array);
			$array			=	array('document_doctor_id'	=>	$_COOKIE['doctor_id']);
			$documents		=	$this->select->get_some_documents($array);
			$council		=	$this->select->get_all_council();
			$array			=	array(
									'doctor'	=>	$doctor,
									'documents'	=>	$documents,
									'council'	=>	$council,
									 
									'specialities'	=>	$specialities,
									'me'		=>	$this->me,
									'education'	=>	$education,
									);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/education',['array'	=>	$array]);
		}
		public function storeeducation()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$i=0;
			foreach($post['qualification_name'] as $x)
			{
				$array[$i]['qualification_name']			=	$x;	
				$array[$i]['qualification_college']			=	$post['qualification_college'][$i];	
				$array[$i]['qualification_complete_year']	=	$post['qualification_complete_year'][$i];	
				$array[$i]['qualification_specialization']	=	$post['qualification_specialization'][$i];	
				$array[$i]['qualification_doctor_id']		=	$_COOKIE['doctor_id'];	
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
			 return redirect(base_url('doctordashboard/education'));
		}
		public function updateeducation()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
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
			return redirect(base_url('doctordashboard/education'));
			
		}
		public function documents()
		{
			$array			=	array('doctor_id'	=>	$_COOKIE['doctor_id']);
			$doctor			=	$this->me;
			//$cities			=	$this->select->get_all_cities($array);
			$specialities	=	$this->select->get_all_specialization($array);
			$array			=	array('document_doctor_id'	=>	$_COOKIE['doctor_id']);
			$documents		=	$this->select->get_some_documents($array);
			$array			=	array(
									'doctor'	=>	$doctor,
									 
									'specialities'	=>	$specialities,
									'me'		=>	$this->me,
									'documents'	=>	$documents,
									);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('doctor/documents',['array'	=>	$array]);
		}
		public function storedocuments()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			//print_r($post);
			print_r($_FILES['document_certificate']);
			$i=0;
			foreach($post['document_reg_no'] as $x)
			{
				$array[$i]['document_reg_no']		=	$x;
				$array[$i]['document_council_name']	=	$post['document_council_name'][$i];
				$array[$i]['document_year']			=	$post['document_year'][$i];
				$array[$i]['document_certificate']	=	$_FILES['document_certificate']['name'][$i];
				$array[$i]['document_doctor_id']	=	$_COOKIE['doctor_id'];
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
			return redirect(base_url('doctordashboard/education'));
			 
		}
		public function updatedocument()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$i=0;
			if(count($post['document_reg_no']))
			{
				foreach($post['document_reg_no'] as $x)
				{
					$array[$i]['document_reg_no']		=	$x;
					$array[$i]['document_council_name']	=	$post['document_council_name'][$i];
					$array[$i]['document_year']			=	$post['document_year'][$i];
					$array[$i]['document_id']			=	$post['document_id'][$i];
					$i++;
				}
				foreach($array as $x)
				{
					print_r($x);
					$this->update->update_table('document','document_id',$x['document_id'],$x);
				}
			}
			return redirect(base_url('doctordashboard/education'));
			
			
		}
		public function findappointment()
		{
			
			$post	=	$this->input->get();
			$d=cal_days_in_month(CAL_GREGORIAN,$post['month'],$post['year']);
			for($i=1;$i<=$d;$i++)
			{
				//$date	=	 date('Y-m-'.$i);
				$date	=	 $post['year'].'-'.$post['month'].'-'.$i;
				//echo $date."<br>";
				$array		=	array(
										'appointment_payment'	=>	'Transaction Successful',
										'appointment_date'		=>	$date,	
										'appointment_doctor_id'	=>	$_COOKIE['doctor_id'],
									);				
				
				//print_r($array);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;
			
			}
			$i=0;			 
			$array	=	array(
								'me'			=>	$this->me,
								'monapp'		=>	$monapp,								 							
								);
			 
			 
			$this->load->view('doctor/findappointment',['array'	=>	$array]);
		}
		public function leave()
		{
			$array	=	array(
									'vacation_doctor_id'	=>	$_COOKIE['doctor_id'],
									);
			$vacations	=	$this->select->get_some_vacations($array);
			$array	=	array(
								'me'			=>	$this->me,								 								 							
								'vacations'		=>	$vacations,								 								 							
								);			 
			//print_r($vacations);
			$this->load->view('doctor/vacations',['array'	=>	$array]);
		}
		public function storevacations()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			if($post['start_date']>$post['end_date'])
			{
				$this->session->set_flashdata('vacmsg','<div class="alert alert-danger">End date can not be less than start date.</div>');
				
			}
			else
			{				
				$step = '+1 day';
				$output_format = 'Y-m-d';
				$dates = array();
				$current = strtotime($post['start_date']);
				$last = strtotime($post['end_date']);

				while( $current <= $last ) {

					$dates[] = date($output_format, $current);
					$current = strtotime($step, $current);
				}

				$i=0;
				foreach($dates as $x)
				{
					$array[$i]['vacation_doctor_id']=$_COOKIE['doctor_id'];
					$array[$i]['vacation_date']=$x;
					$i++;
				}
				//print_r($dates);
				//print_r($array);
				if($this->insert->insert_batch_table($array,'vacation'))
				{
					$this->session->set_flashdata('vacmsg','<div class="alert alert-success">Vacations Added successfully.</div>');
				
				}
				else
				{
					$this->session->set_flashdata('vacmsg','<div class="alert alert-danger">System Failure.</div>');
				
				}
				
				
			}
			return redirect(base_url('doctordashboard/leave'));
		}
		public function deletequalification()
		{
			$qualification_id	=	$this->uri->segment(3);
			$array				=	array(
										'qualification_id'			=>	$qualification_id,
										'qualification_doctor_id'	=>	$_COOKIE['doctor_id'],										
										);
			$this->load->model('delete');
			if($this->delete->delete_table($array,'qualification'))
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-success">Education deleted successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-danger">system Failure.</div>');
			
			}
			return redirect(base_url('doctordashboard/education'));
		}
		public function deletecerti()
		{
			$document_id	=	$this->uri->segment(3);
			$array				=	array(
										'document_id'			=>	$document_id,
										'document_doctor_id'	=>	$_COOKIE['doctor_id'],										
										);
			$this->load->model('delete');
			if($this->delete->delete_table($array,'document'))
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-success">Documents & Registration deleted successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('educationmsg','<div class="alert alert-danger">system Failure.</div>');
			
			}
			return redirect(base_url('doctordashboard/education'));
		}
		public function deletechat()
		{
			$question_id	=	$this->uri->segment(3);
			$array				=	array(
										'question_id'			=>	$question_id,
										'question_doctor_id'	=>	$_COOKIE['doctor_id'],										
										);
			$this->load->model('delete');
			if($this->delete->delete_table($array,'question'))
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-success">Conversation deleted successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-danger">system Failure.</div>');
			
			}
			return redirect(base_url('doctordashboard/answeredquestions'));
		}
		public function clearhistory()
		{
			$array	=	array(
								'question_doctor_id'	=>		$_COOKIE['doctor_id'],
								'question_doc_clear'	=>		1,
								);
			if($this->update->update_table('question','question_doctor_id',$_COOKIE['doctor_id'],$array))
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-success">Chat history cleared.</div>');
			}
			else
			{
				$this->session->set_flashdata('ansmsg','<div class="alert alert-danger">system Failure.</div>');
			}
			return redirect(base_url('doctordashboard/answeredquestions'));
		}
		
	}

	
?>