<?php
	class Pathdashboard extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!isset($_COOKIE['path_id']))
			{
				return redirect (base_url('diagnosislogin'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			ob_start();	
			$arrayx		=	array('path_id'	=>	$_COOKIE['path_id']);
			$this->me	=	$this->select->get_one_pathology($arrayx);			
		}		
		public function index()
		{
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$charge			=	(100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
			 
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date;
				$array	=	array(
									'path_ap_path_id'	=>	$_COOKIE['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
								);				 
				$revenue[]	=	array(
											'date'		=>	$date,
											'revenue'	=>	$this->select->count_all_pathappointments($array),
											//'revenue'	=>	200,
										);				
			}
			//echo "<pre>";
			//print_r($array);
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_payment'	=>	'Transaction Successful',
								'path_ap_date'		=>	date('Y-m-d'),
								'path_ap_status!='	=>	'Appointment Canecelled',
							);
			$appointments	=	$this->select->get_some_pathappointments(999,0,$array);
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
			
			$array	=	array(
								'me'	=>	$this->me,
								'appointments'	=>	$appointments,
								'revenue'	=>	$revenue,	
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/home',['array'	=>	$array]);
		}
		public function findappointments()
		{
			$post	=	$this->input->get();
		 
			$m	=	$post['month'];
			$y	=	$post['year'];
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);
			for($i=1;$i<=$d;$i++)
			{
				
				$date	=	 date($y.'-'.$m.'-'.$i);
				$array	=	array(
									'path_ap_path_id'	=>	$_COOKIE['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
								);				 
				$revenue[]	=	array(
											'date'		=>	$date,
											'revenue'	=>	$this->select->count_all_pathappointments($array),
											//'revenue'	=>	200,
										);				
			}
			$array	=	array(
								'me'	=>	$this->me,
								 
								'revenue'	=>	$revenue,	
								);
			 
			$this->load->view('path/findappointments',['array'	=>	$array]); 
			
		}
		public function signout()
		{
			setcookie('path_id', '0', time() - (3600), "/");	
			return redirect(base_url());
		}
		public function myprofile()
		{
			$cities	=	$this->select->get_all_cities();
			$array	=	array(
							'me'	=>	$this->me,
							'cities'=>	$cities
							);
			//print_r($array);
			$this->load->view('path/myprofile',['array'	=>	$array]);
		}
		public function ownership()
		{
			$array	=	array('me'	=>	$this->me);
			//print_r($array);
			$this->load->view('path/ownership',['array'	=>	$array]);
		}
		
		public function updateprofile()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
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
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Congratulations!.. Your account has been updated.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
			}
			
			return redirect(base_url('pathdashboard/myprofile'));
			
		}
		public function updateownership()
		{
			echo "<pre>";
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
			//print_r($_FILES['prescription_image']);
			//print_r($array);
		 
			/*if($prescription_id	=	$this->insert->insert_table($post,'prescription'))
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
			*/
			return redirect(base_url('pathdashboard/ownership'));
			
		}
		public function testwedo()
		{
			$array	=	array('test_path_id'	=>	$_COOKIE['path_id']);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('pathdashboard/testwedo'),
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
			$test	=	$this->select->get_some_test($config['per_page'],$this->uri->segment(3),$array);
			
			$array	=	array(
							'me'	=>	$this->me,
							'test'	=>	$test,
							'count'	=>	$this->uri->segment(3),
							);
			 
			$this->load->view('path/testwedo',['array'	=>	$array]);
		}
		public function addtest()
		{
			$array	=	array('me'	=>	$this->me);
			//print_r($array);
			$this->load->view('path/addtest',['array'	=>	$array]);
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
			return redirect(base_url('pathdashboard/testwedo'));
		}
		public function edittest()
		{
			$test_id	=	$this->uri->segment(3);
			$array	=	array(
								'test_id'	=>	$test_id,
								'test_path_id'	=>	$_COOKIE['path_id']
								);
			$test		=	$this->select->get_one_test($array);
			if(count($test))
			{
				$array	=	array(
									'me'	=>	$this->me,
										'test'	=>	$test,
									);
				$this->load->view('path/edittest',['array'	=>	$array]);
			}
			else
			{
				return redirect(base_url('pathdashboard/testwedo'));
			
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
			return redirect(base_url('pathdashboard/edittest/'.$post['test_id']));
		}
		public function workinghours()
		{
			$array	=	array(
								'me'	=>	$this->me,
								 
							);
			$this->load->view('path/workinghours',['array'	=>	$array]);
		}
		public function updatehours()
		{
			$post	=	$this->input->post();
			if(!isset($post['path_mon']))
			{
				$post['path_mon']=	0;
			}
			if(!isset($post['path_tues']))
			{
				$post['path_tues']=	0;
			}
			if(!isset($post['path_wed']))
			{
				$post['path_wed']=	0;
			}
			if(!isset($post['path_thurs']))
			{
				$post['path_thurs']=	0;
			}
			if(!isset($post['path_fri']))
			{
				$post['path_fri']=	0;
			}
			if(!isset($post['path_sat']))
			{
				$post['path_sat']=	0;
			}
			if(!isset($post['path_sun']))
			{
				$post['path_sun']=	0;
			}
			
			echo "<pre>";
			print_r($post);
			if($this->update->update_table('pathology','path_id',$post['path_id'],$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success"><b>Congratulations!.. Working hours has been updated.</b></div>');
			}
			else
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
			}
			
			return redirect(base_url('pathdashboard/workinghours'));
		}
		
		public function myappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_status!='		=>	'Appointment Canecelled',
								'path_ap_date>='		=>	date('Y-m-d'),
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/myappointments'),
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
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(3),$array);
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/myappointments',['array'	=>	$array]);
		}
		
		public function todayappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_payment'	=>	'Transaction Successful',
								'path_ap_date'		=>	date('Y-m-d'),
								'path_ap_status!='	=>	'Appointment Canecelled',
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/todayappointments'),
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
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(3),$array);
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/todayappointments',['array'	=>	$array]);
		}
		public function pastappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_payment'	=>	'Transaction Successful',
								'path_ap_date<'		=>	date('Y-m-d'),
								'path_ap_status!='	=>	'Appointment Canecelled',
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/pastappointments'),
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
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(3),$array);
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/pastappointments',['array'	=>	$array]);
		}
		public function cancelledappointments()
		{
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_payment'	=>	'Transaction Successful',								 
								'path_ap_status'	=>	'Appointment Canecelled',
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/cancelledappointments'),
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
			$appointments	=	$this->select->get_some_pathappointments($config['per_page'],$this->uri->segment(3),$array);
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'settings'		=>	$settings,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/cancelledappointments',['array'	=>	$array]);
		}
		
		
		public function revenue()
		{
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$charge			=	(100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
			 
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date;
				$array	=	array(
									'path_ap_path_id'	=>	$_COOKIE['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
								);
				 
				$revenue[]	=	array(
											'date'		=>	$date,
											'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
											//'revenue'	=>	200,
										);
				
			}
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_date'		=>	date('Y-m-d'),
								'path_ap_payment'	=>	'Transaction Successful',
								);
			$rev1	=	array(
								'date'		=>	$array['path_ap_date'],
								'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
								);
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_date'		=>	date('Y-m-d',time() + 1*86400),
								'path_ap_payment'	=>	'Transaction Successful',
								);
			$rev2	=	array(
								'date'		=>	$array['path_ap_date'],
								'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
								);
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_date'		=>	date('Y-m-d',time() + 2*86400),
								'path_ap_payment'	=>	'Transaction Successful',
								);
			$rev3	=	array(
								'date'		=>	$array['path_ap_date'],
								'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
								);
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_date'		=>	date('Y-m-d',time() + 3*86400),
								'path_ap_payment'	=>	'Transaction Successful',
								);
			$rev4	=	array(
								'date'		=>	$array['path_ap_date'],
								'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
								);
			$array	=	array(
								'path_ap_path_id'	=>	$_COOKIE['path_id'],
								'path_ap_date'		=>	date('Y-m-d',time() + 4*86400),
								'path_ap_payment'	=>	'Transaction Successful',
								);
			$rev5	=	array(
								'date'		=>	$array['path_ap_date'],
								'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
								);
								
		
			
			
			
			
			$array	=	array(
								'revenue'	=>	$revenue,								
								'me'		=>	$this->me,
								'rev1'		=>	$rev1,
								'rev2'		=>	$rev2,
								'rev3'		=>	$rev3,
								'rev4'		=>	$rev4,
								'rev5'		=>	$rev5,
								
								);
			
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/revenue',['array'	=>	$array]);
		}
		public function findrevenue()
		{
			$post	=	$this->input->get();
			//echo "<pre>";
			//print_r($post);
						$d=cal_days_in_month(CAL_GREGORIAN,$post['month'],$post['year']);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$charge			=	(100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
			//echo $charge;
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($post['year'].'-'.$post['month'].'-'.$i);
				//echo $date;
				$array	=	array(
									'path_ap_path_id'	=>	$_COOKIE['path_id'],
									'path_ap_date'		=>	$date,
									'path_ap_payment'	=>	'Transaction Successful',
								);
				 
				$revenue[]	=	array(
											'date'		=>	$date,
											'revenue'	=>	round(($this->select->get_added_pathrevenue($array)['path_ap_amount']*100/$charge),2),
											//'revenue'	=>	200,
										);
				
			}			
			$array	=	array(
								'revenue'	=>	$revenue,								
								'me'		=>	$this->me,
								
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('path/findrevenue',['array'	=>	$array]);
		}
		public function uploadreport()
		{
			$post	=	$this->input->post();
			$post['path_report_add_time']	=	date('Y-m-d h:i:s');
			$post['path_report_name']	=	$_FILES['path_report_name']['name'];
			$path_report_id	=	$this->insert->insert_table($post,'path_report');
			if(!file_exists('./images/report/'.$path_report_id.'/'))
				{
				mkdir('./images/report/'.$path_report_id.'/'); 
			}
			move_uploaded_file($_FILES['path_report_name']['tmp_name'],"./images/report/".$path_report_id.'/'.$post['path_report_name']);
			
			return redirect ('pathdashboard/myappointments');
		}
		public function cancelappointment()
		{
			$post	=	$this->input->post();
			$appointment	=	$this->select->get_one_pathappointment($post);
			//print_r($appointment);
			$post['path_ap_status']		=	'Appointment Canecelled';
			//$post['appointment_payment']	=	'CANCELLED';
			//print_r($post);
			$this->update->update_table('path_appointment','path_ap_id',$post['path_ap_id'],$post);
			$array		=	array('wallet_patient_id'	=>		$appointment['path_ap_patient_id']);
			if(count($wallet	=	$this->select->get_one_wallet($array)))
			{
				$wallet['wallet_amount']	=	$wallet['wallet_amount']+$appointment['path_ap_amount'];
				$this->update->update_table('wallet','wallet_id',$wallet['wallet_id'],$wallet);
				 
			}
			else
			{
				$array	=	array(
									'wallet_patient_id'	=>		$appointment['path_ap_patient_id'],
									'wallet_amount'		=>		$appointment['path_ap_amount']
									);
				$this->insert->insert_table($array,'wallet');				 
			}
			$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Appointment cancelled successfully.</div>');
			
		}
		public function resetpassword()
		{
			$array	=	array(
								'me'		=>	$this->me,
							);
			$this->load->view('path/resetpassword',['array'	=>	$array]);
		}
		public function updatepassword()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			print_r($this->me);
			if($post['old_password']!=$this->me['path_password'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old Password do not match.</div>');
			}
			else if($post['new_password']!=$post['confirm_password'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Confirm Password do not match.</div>');
			}
			else
			{
				$array		=	array('path_password'	=>	$post['new_password']);
				if($this->update->update_table('pathology','path_id',$_COOKIE['path_id'],$array))
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-success"><b>Congratulations!.. Your password has been updated.</b></div>');
				}
				else
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Oops1.. System failure.</div>');
				}
			}
			return redirect(base_url('pathdashboard/resetpassword'));
		}
		public function deletetest()
		{
			$test_id	=	$this->uri->segment(3);
			$array		=	array(
									'test_id'		=>	$test_id,
									'test_path_id'	=>	$_COOKIE['path_id'],									
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
			return redirect(base_url('pathdashboard/testwedo'));
		}
		public function leave()
		{
			$array	=	array(
									'vacation_path_id'	=>	$_COOKIE['path_id'],
									);
			$vacations	=	$this->select->get_some_vacations($array);
			$array	=	array(
								'me'			=>	$this->me,								 								 							
								'vacations'		=>	$vacations,								 								 							
								);			 
			//print_r($vacations);
			$this->load->view('path/vacations',['array'	=>	$array]);
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
					$array[$i]['vacation_path_id']=$_COOKIE['path_id'];
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
			return redirect(base_url('pathdashboard/leave'));
		}
	}
?>
