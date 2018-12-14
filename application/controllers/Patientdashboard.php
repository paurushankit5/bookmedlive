<?php
	class Patientdashboard extends CI_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!isset($_COOKIE['patient_id']))
			{
				return redirect (base_url('patientlogin'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			ob_start();	
			$arrayx		=	array('patient_id'	=>	$_COOKIE['patient_id']);
			$this->me	=	$this->select->get_one_patient($arrayx);	
		}
		
		public function index()
		{
			$cities			=	$this->select->get_all_cities();
			$speciality		=	$this->select->get_all_specialization();
			$array	=	array(
								'appointment_patient_id'	=>	$_COOKIE['patient_id'],								
								'appointment_payment'		=>	'Transaction Successful',								
								'appointment_date>='		=>	date('Y-m-d'),								
							);
		 			
			$appointments	=	$this->select->get_some_appointments(10,0,$array);
			
			$array	=	array(
								'path_ap_patient_id'	=>	$_COOKIE['patient_id'],
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_date>='		=>	date('Y-m-d'),
							);
			$pathappointments	=	$this->select->get_some_pathappointments(10,0,$array);
			$array	=	array(
								'me'				=>	$this->me,
								'cities'			=>	$cities,
								'speciality'		=>	$speciality,
								'appointments'		=>	$appointments,								
								'pathappointments'	=>	$pathappointments,								
								);
			
			$this->load->view('patient/home',['array'	=>	$array]);
		}
		public function myprofile()
		{
			$array	=	array('patient_id'	=>	$_COOKIE['patient_id']);
			$patient	=	$this->select->get_one_patient($array);
			$array	=	array('patient'	=>	$patient,
							'me'		=>	$this->me
							);
			$this->load->view('patient/myprofile',['array'	=>	$array]);
		}
		
		public function updateprofile()
		{
			
			$post	=	$this->input->post();
			$preimage		=	$post['preimage'];
			unset($post['preimage']);
			if($_FILES['patient_pic']['name'])
			{
				$post['patient_pic']	=	$_FILES['patient_pic']['name'];
			}
			echo "<pre>";
			print_r($post);
			$patient_id	=	$post['patient_id'];
			if($this->update->update_table('patient','patient_id',$post['patient_id'],$post))
			{
				$this->session->set_flashdata('profilemsg','<div class="alert alert-success" style="background:green;color:white;"><b>Profile updated successfully.</b></div>');
				if($_FILES['patient_pic']['name']!='')
				{
					if(!file_exists('./images/patient/'.$patient_id.'/'))
					{
						mkdir('./images/patient/'.$patient_id.'/'); 
					}
					if($preimage!='')
					{
						unlink("./images/patient/$patient_id/".$preimage);
					}
					
					if (move_uploaded_file($_FILES['patient_pic']['tmp_name'],"./images/patient/$patient_id/".$post['patient_pic']))
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
			return redirect(base_url('patientdashboard/myprofile'));
		
		}
		
		public function finddoctors()
		{
			$cities			=	$this->select->get_all_cities();
			$speciality		=	$this->select->get_all_specialization();
			$array		=	array(
									'me'			=>	$this->me,
									'cities'		=>	$cities,
									'speciality'	=>	$speciality,
								);
			$this->load->view('patient/finddoctors',['array'	=>	$array]);
		}
		
		public function showdoctors()
		{
			$post	=	$this->input->get();
			$post['doctor_status']	=	'1';
			//echo "<pre>";
			//print_r($post);
			$city	=	$post['doctor_city'];
			@$name	=	$post['doctor_name'];
			$sql	=	"SELECT *
						from doctor left join clinic on clinic.clinic_id=doctor.doctor_clinic_id left join qualification on qualification.qualification_doctor_id=doctor.doctor_id
						 where doctor_fee!=0 and ((  doctor_city = '$city' and doctor_name = '$name')
							or (  doctor_city = '$city' and qualification_specialization = '$name')
							or (  doctor_city = '$city' and doctor_name LIKE '%$name%' )
							or (  doctor_city = '$city' and qualification_specialization LIKE '%$name%' )
							or (  doctor_city = '$city' or  doctor_name ='$name' )
							or (  doctor_city = '$city' or  qualification_specialization ='$name' )
							or (  doctor_city = '$city' or  doctor_name LIKE '%$name%')
							or (  doctor_city = '$city' or  qualification_specialization LIKE '%$name%'))							
							group by doctor_id							
						";
			//echo $sql;
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$doctors	=	$this->select->somequery($sql);
			//echo "<pre>";
			//print_r($post);
			//print_r($doctors);
			$array	=	array(
							'doctors'	=>	$doctors,
							'settings'	=>	$settings,
							'me'		=>	$this->me,
							);
			$this->load->view('patient/showdoctors',['array'	=>	$array]);
			
		}
		public function makeanappointment()
		{
			$array	=	array('doctor_id'	=>	$this->uri->segment(3));
			
			$doctor	=	$this->select->get_one_doctor($array);
			$array	=	array('vacation_doctor_id'	=>		$this->uri->segment(3));
			$vacations	=	$this->select->get_some_vacations($array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
			$wallet	=	$this->select->get_one_wallet($array);
			$array	=	array(
								'doctor'	=>	$doctor,
								'settings'	=>	$settings,
								'vacations'	=>	$vacations,
								'wallet'	=>	$wallet,
								'me'		=>	$this->me);
			$this->load->view('patient/makeanappointment',['array'	=>	$array]);
			
		}
		public function storeappointment()
		{
			$post	=	$this->input->post();
			$array	=	array('vacation_doctor_id'	=>		$post['appointment_doctor_id']);			
			$vacations	=	$this->select->get_some_vacations($array);	
			$val=0;
			if(count($vacations))
			{
				foreach($vacations as $x)
				{
					if($x['vacation_date']==$post['appointment_date'])
					{
						$val=1;
						break;
					}
				}
			}
			//print_r($post);
			
			if($val==1)
			{
				$this->session->set_flashdata('findmsg',"<div class='alert alert-success'><b>Doctor is not available on ".date('d-M-Y',strtotime($post['appointment_date']))."</b></div>"); 
				echo "not available";
			}
			else if($appointment_id	=	$this->insert->insert_table($post,'appointment'))
			{
				if($post['appointment_card_money']==0)
				{
					$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
					$wallet	=	$this->select->get_one_wallet($array);
					$wallet_amount	=	$wallet['wallet_amount']-$post['appointment_wallet_money'];
					$array		=	array(
											'wallet_amount'		=>	$wallet_amount,
										);
					$this->update->update_table('wallet','wallet_patient_id',$_COOKIE['patient_id'],$array);
					$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Congratulations!.. Your appointment has been booked. </div>');
				}
				echo $appointment_id;
			}
			else
			{
				$this->session->set_flashdata('findmsg',"<div class='alert alert-success'>System Failure</div>"); 
				echo '0';
			}
			
				
		}
		public function paynow()
		{	
			$array	=	array('patient_id'	=>	$_COOKIE['patient_id']);
			$patient	=	$this->select->get_one_patient($array); 
			$array	=	array(
			'appointment_id'	=>	$this->uri->segment(4),
			'fee'	=>	$this->uri->segment(3),
			'patient'	=>	$patient,
			 
			);
			
			$this->load->view('patient/paynow',['array'	=>	$array]);
		}
		public function response()
		{
			 

			$secret_key = "0643c3a6fd2c960d5253ba71073b6b7f";	 // Pass Your Registered Secret Key from EBS secure Portal
			if(isset($_REQUEST))
			{
				 $response = $_REQUEST;
				 unset($response['/patientdashboard/response']);
				 
				if($response['ResponseMessage']	=='Transaction Successful')
				{
					$test			=	'APPROVED';
					$array			=	array('appointment_id'	=>	$response['MerchantRefNo']);
					$appointment 	=	$this->select->get_one_appointment($array);
					if(($appointment['appointment_wallet_money']!='' || $appointment['appointment_wallet_money']!=0) && $appointment['appointment_card_money']!=0)
					{
						$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
						$wallet	=	$this->select->get_one_wallet($array);
						$wallet_amount	=	$wallet['wallet_amount']-$appointment['appointment_wallet_money'];
						$array		=	array(
												'wallet_amount'		=>	round($wallet_amount,2),
											);
						$this->update->update_table('wallet','wallet_patient_id',$_COOKIE['patient_id'],$array);					
					}					
				}
				else
				{
					$test	=	'NOT APPROVED';
				}
				/*echo "<pre>";
				print_r($response);
				echo "</pre>";*/
				$money_id	=	$this->insert->insert_table($response,'money');
				$array		=	array(
										'appointment_status'	=>	$test,
										'appointment_payment'	=>	$response['ResponseMessage'],
										);
				$this->update->update_table('appointment','appointment_id',$response['MerchantRefNo'],$array);
				if($response['ResponseMessage']=='Transaction Successful')
				{
					$array	=	array(
										'me'		=>	$this->me,					
									);
					$this->load->view('patient/success',['array'	=>	$array]);
				}
				else
				{
					$array	=	array(
										'me'		=>	$this->me,					
									);
					$this->load->view('patient/failure',['array'	=>	$array]);					
				}
			}
			else
			{
				return redirect(base_url('patientdashboard'));
			}
		}
		
		public function checkappointments()
		{
			$post	=	$this->input->post();
			$post['appointment_payment']	=	'Transaction Successful';
			
			$appointments	=	$this->select->getappointments($post);
			//echo "<pre>";
			$i	=	'';
			if(count($appointments))
			{
				foreach($appointments as $x)
				{
					$i	.=	"#".implode("",explode(" ",implode("",explode(":",$x['appointment_time'])))).",";
				}
				$i	=	rtrim($i,',');

				echo $i;
			}
		}
		
		public function myappointments()
		{
			$array	=	array(
								'appointment_patient_id'	=>	$_COOKIE['patient_id'],								
								'appointment_payment'		=>	'Transaction Successful',								
								'appointment_date>='		=>	date('Y-m-d'),								
								);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/myappointments'),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_appointments($array),
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
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('patient/myappointments',['array'	=>	$array]);
			
		}
		public function pastappointments()
		{
			$array	=	array(
								'appointment_patient_id'	=>	$_COOKIE['patient_id'],								
								'appointment_payment'		=>	'Transaction Successful',								
								'appointment_date<'		=>	date('Y-m-d'),								
								);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/pastappointments'),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_all_appointments($array),
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
			$appointments	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('patient/pastappointments',['array'	=>	$array]);
			
		}
		
		public function signout()
		{
			setcookie('patient_id', '0', time() - (3600), "/");	
			return redirect(base_url(''));
		}
		
		public function myprescription()
		{
			$array	=	array(
								'prescription_patient_id'	=>	$_COOKIE['patient_id'],
							);
			$prescription	=	$this->select->get_prescription($array);
			//echo "<pre>";
			//print_r($prescription);
			$array	=	array(
								'prescription'	=>	$prescription,
								'me'		=>	$this->me,
								 
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('patient/myprescription',['array'	=>	$array]);
		}
		
		public function prescriptions()
		{
			$array	=	array(
								'prescription_patient_id'	=>	$_COOKIE['patient_id'],
								'prescription_doctor_id'	=>	$this->uri->segment(3),
							);
			$prescription	=	$this->select->get_all_prescription($array);
			//echo "<pre>";
			//print_r($prescription);
			$array	=	array(
								'prescription'	=>	$prescription,
								'me'		=>	$this->me,
								 
								);
			 
			$this->load->view('patient/prescriptions',['array'	=>	$array]);
		}
		public function findpathology()
		{
			$cities		=	$this->select->get_all_cities();
			$array		=	array(
									'me'		=>	$this->me,
									'cities'	=>	$cities
								);
			$this->load->view('patient/findpathology',['array'	=>	$array]);
		}
		public function showpath()
		{
			$post	=	$this->input->get();
			$path	=	$this->select->findpathology($post);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array(
								'path'		=>	$path,
								'city'		=>	$post['path_city'],
								'me'		=>	$this->me,
								'settings'	=>	$settings,
								 
								);
			 
			$this->load->view('patient/showpath',['array'	=>	$array]);
		}
		public function viewpathtest()
		{
			$path_id	=	$this->uri->segment(3);
			$array		=	array('path_id'		=>		$path_id);
			$path		=	$this->select->get_one_pathology($array);
			$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
			$wallet		=	$this->select->get_one_wallet($array);
			$array		=	array('test_path_id'		=>		$path_id);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/viewpathtest/'.$path_id),
								'per_page'		=>		'20',
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
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array(
							'me'	=>	$this->me,
							'wallet'	=>	$wallet,
							'test'	=>	$test,
							'path'	=>	$path,
							'settings'=>	$settings,
							'count'	=>	$this->uri->segment(4),
							);
			 
			$this->load->view('patient/viewpathtest',['array'	=>	$array]);
		}
		public function loadmoretests()
		{
			$post	=	$this->input->post();
			$offset	=	20*$post['count'];	
			$array	=	array('test_path_id'		=>		$post['path_id']);
			$test	=	$this->select->get_some_test(20,$offset,$array);
			if(count($test))
			{
				
				foreach($test as $x)
				{
					?>
						
						<tr style="margin:20px">
							<td><?= ++$offset;?></td>
							<td><?= $x['test_name'];?></td>
							<td>Rs. <?= $x['test_price'];?></td>
							<td><?= $x['test_details'];?></td>
							 
							<td><button class="btn btn-success" id="<?= $x['test_id'];?>" onClick="addtest('<?= $x['test_id'];?>');">Add Test</button></td>
						</tr>
						 
						
					<?php
				}
				echo "<tr class='loadmore'><td colspan='5'><button onclick='loadmore();' class='btn btn-warning btn-block'>Load More</button></td></tr>";

			}
			else
			{
				//echo "<tr><td colspan='5'><div class='alert alert-warning'><p>No Tests found.</p></div></td></tr>";
				echo " <div class='alert alert-warning'><p>No more Tests found.</p></div>";
	
			}
			
		}
		public function payfortest()
		{
			
			$post	=	$this->input->post();
			$post['path_ap_status']		='PENDING';
			$post['path_ap_payment']	='Transaction Incomplete';
			$post['path_ap_addtime']	=date('Y-m-d H:i:s');
			 
			$array	=	array('vacation_path_id'	=>		$post['path_ap_path_id']);			
			$vacations	=	$this->select->get_some_vacations($array);	
			$val=0;
			if(count($vacations))
			{
				foreach($vacations as $x)
				{
					if($x['vacation_date']==$post['path_ap_date'])
					{
						$val=1;
						break;
					}
				}
			}
			$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
			$wallet	=	$this->select->get_one_wallet($array);
			if($wallet['wallet_amount']<$post['path_ap_wallet_amount'])
			{
				return redirect('Error404');
			}			 
			if($post['path_ap_card_amount']==0)
			{
				$post['path_ap_status']	=	'APPROVED';
				$post['path_ap_payment']	=	'Transaction Successful';
			}
			/*else if($wallet['wallet_amount']!=0)
			{
				$post['path_ap_wallet_amount']	=	$wallet['wallet_amount'];
				$post['path_ap_card_amount']	=	round(($post['path_ap_amount']-$wallet['wallet_amount']),2);
			}
			else
			{
				$post['path_ap_card_amount']	=	round($post['path_ap_amount'],2);
			}*/
			//print_r($post);	
			if($val==1)
			{
				$this->session->set_flashdata('testmsg',"<div class='alert alert-success'><b>Diagnosis Center is closed on ".date('d-M-Y',strtotime($post['path_ap_date']))."</b></div>"); 
				echo "unavailable";
			}
			else if($path_ap_id	=	$this->insert->insert_table($post,'path_appointment'))
			{
				
				if($post['path_ap_card_amount']==0)
				{
					$wallet_amount	=	$wallet['wallet_amount']-$post['path_ap_amount'];
					$array		=	array(
											'wallet_amount'		=>	$wallet_amount,
										);
					$this->update->update_table('wallet','wallet_patient_id',$_COOKIE['patient_id'],$array);
					$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Congratulations!.. Your appointment has been booked and the payment has been deducted from your wallet. </div>');
					
					echo "paid";
				}				 
				else
				{					 
					$array	=	array(
										'path_ap_id'	=>	$path_ap_id,
										'amount'		=>	$post['path_ap_card_amount'],							
									);
					echo json_encode($array);
				}
			}
			else
			{
				$this->session->set_flashdata('testmsg',"<div class='alert alert-success'>System Failure</div>"); 
				echo '0';
			}		
			
			 
			 			
		}
		public function paypathnow()
		{
			$array	=	array('patient_id'	=>	$_COOKIE['patient_id']);
			$patient	=	$this->select->get_one_patient($array); 
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array	=	array(			 
							'settings'		=>	$settings,
							'fee'			=>	$this->uri->segment(4),
							'path_ap_id'	=>	$this->uri->segment(3),
							'patient'		=>	$patient,
							);
			$this->load->view('patient/paypathnow',['array'	=>	$array]);
		}
		public function pathresponse()
		{
			$secret_key = "0643c3a6fd2c960d5253ba71073b6b7f";	 // Pass Your Registered Secret Key from EBS secure Portal
			if(isset($_REQUEST))
			{
				$response = $_REQUEST;
				unset($response['/patientdashboard/pathresponse']);
				//echo "<pre>";
				//print_r($response);
				if($response['ResponseMessage']	=='Transaction Successful')
				{
					$test	=	'APPROVED';
					$array			=	array('path_ap_id'	=>	$response['MerchantRefNo']);
					$appointment 	=	$this->select->get_one_pathappointment($array);
					if(($appointment['path_ap_wallet_amount']!=0) && $appointment['path_ap_card_amount']!=0)
					{
						$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
						$wallet	=	$this->select->get_one_wallet($array);
						$wallet_amount	=	$wallet['wallet_amount']-$appointment['path_ap_wallet_amount'];
						$array		=	array(
												'wallet_amount'		=>	round($wallet_amount,2),
											);
						$this->update->update_table('wallet','wallet_patient_id',$_COOKIE['patient_id'],$array);					
					}
				}
				else
				{
					$test	=	'NOT APPROVED';
				}
				
				$money_id	=	$this->insert->insert_table($response,'pathmoney');
				$array		=	array(
										'path_ap_status'	=>	$test,
										'path_ap_payment'	=>	$response['ResponseMessage'],
										);
				$this->update->update_table('path_appointment','path_ap_id',$response['MerchantRefNo'],$array);
				if($response['ResponseMessage']=='Transaction Successful')
				{
					$array	=	array(
										'me'		=>	$this->me,					
									);
					$this->load->view('patient/pathsuccess',['array'	=>	$array]);
				}
				else
				{
					$array	=	array(
										'me'		=>	$this->me,					
									);
					$this->load->view('patient/failure',['array'	=>	$array]);					
				}
			 
			}
			else
			{
				return redirect(base_url('patientdashboard'));
			}
		}
		public function diagnosisappointment()
		{
			$array	=	array(
								'path_ap_patient_id'	=>	$_COOKIE['patient_id'],
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_date>='		=>	date('Y-m-d'),
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/diagnosisappointment'),
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('patient/diagnosisappointment',['array'	=>	$array]);
			
		}
		public function pastdiagnosisappointment()
		{
			$array	=	array(
								'path_ap_patient_id'	=>	$_COOKIE['patient_id'],
								'path_ap_payment'		=>	'Transaction Successful',
								'path_ap_date<'			=>	date('Y-m-d'),
							);
			 
			$this->load->library('pagination');
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/pastdiagnosisappointment'),
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
			$array	=	array(
								'appointments'	=>	$appointments,
								'me'		=>	$this->me,
								'count'		=>	$this->uri->segment(3)
								);
			//echo "<pre>";
			//print_r($array);
			$this->load->view('patient/pastdiagnosisappointment',['array'	=>	$array]);
			
		}
		public function mywallet()
		{
			$array		=	array('wallet_patient_id'	=>		$_COOKIE['patient_id']);
			$wallet	=	$this->select->get_one_wallet($array);
			$array	=	array(
								'wallet'	=>	$wallet,
								'me'		=>	$this->me,
								 
								);
			$this->load->view('patient/mywallet',['array'	=>	$array]);					
			 
		}
		public function askaquestion()
		{
			$array	=	array(
								'me'		=>	$this->me,
							);
			$this->load->view('patient/askaquestion',['array'	=>	$array]);
		}
		public function savequestion()
		{
			$post	=	$this->input->post();
			$post['question_patient_id']	=	$_COOKIE['patient_id'];
			$post['question_add_time']		=	date('Y-m-d H:i:s');
			//echo "<pre>";
			//print_r($post);
			if($question_id	=	$this->insert->insert_table($post,'question'))
			{
				$this->session->set_flashdata('showdoctormsg','<div class="alert alert-success">Congratultions!.. Your question has been sent to our doctors. We will answer your question shortly.</div>');
			}
			else
			{
				$this->session->set_flashdata('showdoctormsg','<div class="alert alert-danger"> System Failure.</div>');
			}
			//return redirect('patientdashboard/myquestions');
		}
		public function myquestions()
		{
			$array	=	array(
								'question_patient_id'	=>	$_COOKIE['patient_id'],								
							);
			 
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('patientdashboard/myquestions'),
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
			$this->load->view('patient/myquestions',['array'	=>	$array]);
		}
		public function reschedule()
		{
			$appointment_id		=	$this->uri->segment(3);
			$array				=	array(
										'appointment_id'	=>	$appointment_id,
										'appointment_patient_id'	=>	$_COOKIE['patient_id'],
										);
			if(count($appointment		=	$this->select->get_one_appointment($array)))
			{
				$array	=	array('doctor_id'	=>	$appointment['appointment_doctor_id']);
				$doctor	=	$this->select->get_one_doctor($array);
				$array	=	array(									 
									'appointment'	=>	$appointment,
									'doctor'		=>	$doctor,
									'me'			=>	$this->me									
								);
				$this->load->view('patient/reschedule',['array'	=>	$array]);
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
			$this->session->set_flashdata('profilemsg','<div class="alert alert-success">Appointment cancelled successfully and the amount has been credited to your wallet.</div>');
		}	
		public function resetpassword()
		{
			$array	=	array(
								'me'		=>	$this->me,
							);
			$this->load->view('patient/resetpassword',['array'	=>	$array]);
		}
		public function updatepassword()
		{
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$array	=	array(
								'patient_password'	=>	$post['patient_old_password'],
								'patient_id'		=>	$_COOKIE['patient_id'],
								);
			if($patient_id	=	$this->select->checkpatient($array))
			{
				if($post['patient_password']!=$post['patient_password2'])
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Passwords do not match.</div>');
				}
				else
				{
					unset($post['patient_password2']);
					unset($post['patient_old_password']);
					if($this->update->update_table('patient','patient_id',$patient_id,$post))
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
			return redirect(base_url('patientdashboard/resetpassword'));
		}
		public function showdoctorsuggestion()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			$this->load->model('select');
			$doctor	=	$this->select->get_doctor_hint($post['doctor_name']);
			$speciality	=	$this->select->get_speciality_hint($post['doctor_name']);
			
			if(count($doctor))
			{
				foreach($doctor as $x)
				{
					?>
					<option value="<?= $x['doctor_name'];?>">
					<?php
				}
			}
			 
			if(count($speciality))
			{
				foreach($speciality as $x)
				{
					?>
					<option value="<?= $x['speciality_name'];?>">
					<?php
				}
			}
		}
		public function storequestions(){
			$post 	=	$this->input->post();
			$post['question_patient_id']	= $_COOKIE['patient_id'];
			$post['question_add_time']		= date('Y-m-d H:i:s');
			if($this->insert->insert_table($post,'question'))
			{
				echo "<div class='alert alert-success'>Question submitted successfully.We will get back to you soon.</div>"; 
			}
			else{
				echo "<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>";
			}
		}
		
	}

?>