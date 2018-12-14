<?php
	class Payment extends MY_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('select');
			$this->load->model('home');
			$this->load->model('update');
			$this->load->model('insert');
			date_default_timezone_set('Asia/kolkata');
			if(!isset($_SESSION['user']))
			{
				return redirect(base_url('Error404'));
			}
		}
		public function booknow(){
			$post 		=	$this->input->post();
			$this->booknownew($post);
			
		}
		public function booknownew($post){
			if($post['usewallet']==1)
			{
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				//print_r($wallet);
				$array	=	array(
								'id'			=>	$post['ap_doctor_id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				//echo $doc['user_fee'];
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
				$gst		=	($settings['settings_gst']*$charge)/100;
	
				$totalamount	=	$charge+$gst+$doc['user_fee'];
				$totalamount	=	 ceil($totalamount);
				$extracharge	=	$totalamount-$doc['user_fee'];
				$array 			= 	array(
											"settings_id"	=> 	2,
										);
				$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];

				$ap_id 			=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
				if($wallet['wallet_amount'] >= $totalamount)
				{
					$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_time"				=>  $post['ap_time'],
										"ap_shift"				=>  $post['ap_shift'],
										"ap_id"					=>  $ap_id,
										"ap_payment"			=>	1,
										"ap_status"				=>	1,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  $totalamount,										
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],										
										"ap_card_money"			=>  0,
										"created_at"			=>  date("Y-m-d H:i:s"),
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
					$this->db->trans_start();
					$this->load->model("insert");
					$this->load->model("update");
					$this->insert->insert_table($array,"appointment");
					$newwallet 	=	$wallet['wallet_amount']-$totalamount;
					$array 	=	array(
										"wallet_amount"	=> 	$newwallet
									);
					$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$array);
					$this->db->trans_complete();
					if ($this->db->trans_status() == FALSE)
					{
					     $status = 0; 
					     $url    = base_url('Fail');
					}
					else{
						$this->sendmailtouser($ap_id);
						$status = 1;
						$url    = base_url('Payment/success/'.$ap_id);
					}
					$output = array(
										'status'=>$status,
										'url'=>$url,
									);
					echo json_encode($output, false);
				}
				else{
					//code where wallet amount is less than total payable amount
				}	

			}
			else{
				//code if user wishes not to use wallet 
				
			}
		}
		public function reschedulenow(){
			$post 	=	$this->input->post();
			$post['ap_rescheduled']		=	1;
			if($this->update->update_table("appointment","ap_id",$post['ap_id'],$post))
			{
				$ap_id 	=	$post['ap_id'];
				$post 	= 	$this->select->get_single_row("select ap.*,p.user_name as patient_name,d.user_name as doctor_name,adl1,adl2,location,city,state,country from appointment ap inner join users p on (p.id=ap.ap_patient_id) inner join users d on (d.id=ap.ap_doctor_id) inner join address ad on
						 	case WHEN d.user_clinic_id!='0' Then (ad.user_id=d.user_clinic_id) Else (ad.user_id=d.id) END  where ap_id = '$ap_id'");
				$address = $post['adl1'].", ".$post['adl2'].", ".$post['location'].", ".$post['city'].", ".$post['state'];
				$patient_id 	=	$post['ap_patient_id'];
				$array 	=	 array('id'	=>	$patient_id);
				$patient =	 $this->select->get_one_user($array);		
				$data	=	'<html>

									<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
										
										<div style="width:100%;background:#3f5267;color:white;padding:5px;">
											<h2 style="text-align:center">Appointment Rescheduled</h2>
										</div>
										<div style="width:100%;padding:10px;">
											<h3><b>Dear '.$patient['user_name'].',</b></h3>

											<p>Your appointment with Ap Id - '.$post['ap_id'].' has been rescheduled. You new appointment details are as follows:-</p>

											<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
											<p>Doctor - <span style="font-weight:bold;">Dr. '.$post['doctor_name'].'</span></p>
											<p>Date & Time - <span style="font-weight:bold;">'.$post['ap_time']." on ".date('d-M-Y',strtotime($post['ap_date'])).'</span></p>
											<p>Amount to be paid - <span style="font-weight:bold;"> &#x20B9; '.$post['ap_amount_to_be_paid'].'</span></p>
											<p>Address - <span style="font-weight:bold;">'.$address.'</span></p>

											<hr>
											<p>Regards : BOOKMEDIZ Team<br>
											Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
											<hr>
										</div>
									</div>
								</html>';
					//echo $data ;
					if(isset($_SESSION['patient_id']))
					{
						$msg 	= "Congratulations, you have successfully rescheduled your appointment with Dr. ".$post['doctor_name']." , Appointment-ID  - ".$post['ap_id']." . Your appointment date and time is ".date('d-M,Y',strtotime($post['ap_date']))." at ".$post['ap_time']." . Address - ".$address." ."; 
						$url    = base_url('myappointments');
						//echo $msg;
						$this->sendmail($_SESSION['user']['user_email'],"Bookmediz Appointment Rescheduled",$data,"Appointment Rescheduled");			
						$this->smsgatewaycenter_com_Send("91".$_SESSION['user']['user_mob'],$msg);						
						$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>Your appointment has been successfully rescheduled.</b></p></div>");
					}
					else if(isset($_SESSION['doctor_id']))
					{
						
						$msg 	= "Dr. ".$post['doctor_name']." has rescheduled your appointment with Appointment-ID  - ".$post['ap_id']." . Your new appointment details are ".date('d-M,Y',strtotime($post['ap_date']))." at ".$post['ap_time']." . Address - ".$address." .";
						$this->sendmail($patient['user_email'],"Bookmediz Appointment Rescheduled",$data,"Appointment Rescheduled");			
						$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],$msg);
						$url    = base_url('Doc/myappointments');
					}				
					$status 	=	1;					
			}
			else{
				$status 	=	0;
				$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>We are facing some technical issues. Please try later.</b></p></div>");
				$url 	=	base_url('Error404');
			}				
			$output = array(
								'status'=>$status,
								'url'=>$url,
							);
			echo json_encode($output, false);

		}
		public function payusingebs(){
			$post 	=	$this->input->post();
			//print_r($post);
			if($post['usewallet']==0)
			{
				$array 		=	array(
								'id'			=>	$post['ap_doctor_id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				//echo $doc['user_fee'];
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
				$gst		=	($settings['settings_gst']*$charge)/100;
	
				$totalamount	=	$charge+$gst+$doc['user_fee'];
				$totalamount	=	 ceil($totalamount);
				$extracharge	=	$totalamount-$doc['user_fee'];
				$array 			= 	array(
											"settings_id"	=> 	2,
										);
				$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];

				$ap_id 			=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
				$array = array(
									"ap_doctor_id"  		=>  $post['ap_doctor_id'],
									"ap_patient_id"			=>  $post['ap_patient_id'],
									"ap_date"				=>  $post['ap_date'],
									"ap_time"				=>  $post['ap_time'],
									"ap_shift"				=>  $post['ap_shift'],
									"ap_id"					=>  $ap_id,
									"ap_payment"			=>	0,
									"ap_status"				=>	0,
									"ap_amount_to_be_paid"	=> 	$post['ap_amount_to_be_paid'],
									"ap_money"				=>  $totalamount,
									"ap_wallet_money"		=>  0,										
									"ap_card_money"			=>  $totalamount,
									"ap_gateway"			=>  "ebs",
									"created_at"			=>  date("Y-m-d H:i:s"),
									"updated_at"			=>  date("Y-m-d H:i:s"),
								);
				$this->db->trans_start();
				$this->load->model("insert");
				$this->insert->insert_table($array,"appointment");
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/ebspayment/'.$ap_id);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
				 
			}
			else{
				/*$array 		=	array(
								'id'			=>	$post['ap_doctor_id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				//echo $doc['user_fee'];
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
				$gst		=	($settings['settings_gst']*$charge)/100;
	
				$totalamount	=	$charge+$gst+$doc['user_fee'];
				$totalamount	=	 ceil($totalamount);
				$extracharge	=	$totalamount-$doc['user_fee'];
				$array 			= 	array(
											"settings_id"	=> 	2,
										);
				$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];*/
				$totalamount 	= 	10;
				
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				if($totalamount<=$wallet['wallet_amount'])
				{
					$this->booknownew($post);
					exit();
				} 
				$ap_id 			=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
				$array = array(
									"ap_doctor_id"  		=>  $post['ap_doctor_id'],
									"ap_patient_id"			=>  $post['ap_patient_id'],
									"ap_date"				=>  $post['ap_date'],
									"ap_time"				=>  $post['ap_time'],
									"ap_id"					=>  $ap_id,
									"ap_shift"				=>	$post['ap_shift'],
									"ap_payment"			=>	0,
									"ap_status"				=>	0,
									"ap_money"				=>  $totalamount,
									"ap_wallet_money"		=>  $wallet['wallet_amount'],										
									"ap_card_money"			=>  $totalamount-$wallet['wallet_amount'],
									"ap_amount_to_be_paid"	=> 	$post['ap_amount_to_be_paid'],
									"ap_gateway"			=>  "ebs",
									"created_at"			=>  date("Y-m-d H:i:s"),
									"updated_at"			=>  date("Y-m-d H:i:s"),
								);
				$this->db->trans_start();
				$this->load->model("insert");
				$this->insert->insert_table($array,"appointment");
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/ebspayment/'.$ap_id);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
			}
		}
		public function ebspayment(){
			$array 	=	array(
								'ap_id' 			=>		$this->uri->segment(3),
								'ap_patient_id'		=>	$_SESSION['user']['id'],
								'ap_payment'		=>	0,
								'ap_status'			=>	0,
							);
			$this->load->model('home');
			if(count($ap = $this->home->get_one_row("appointment",$array,'*'))){
				$array 		=	array('ap'	=>	$ap);
				$this->load->view('home/ebspay.php',['array'	=>		$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function response(){	

			$secret_key = "0643c3a6fd2c960d5253ba71073b6b7f";	 // Pass Your Registered Secret Key from EBS secure Portal
			if(isset($_REQUEST)){
				 $response = $_REQUEST;
			     $sh = $response['SecureHash'];	
			     $params = $secret_key;
			     ksort($response);
			     foreach ($response as $key => $value){
			        if (strlen($value) > 0 and $key!='SecureHash') {
					        $params .= '|'.$value;
				        }
			        }
				  $hashValue = strtoupper(hash("sha512",$params));// for SHA512
				    unset($_REQUEST['/payment/response']);
				    if(isset($_REQUEST['__cfduid']))
			  		{
			  			unset($_REQUEST['__cfduid']);
			  		}
			  		if(isset($_REQUEST['ci_session']))
			  		{
			  			unset($_REQUEST['ci_session']);
			  		}
			  		
			  		$this->load->model("insert");
					$this->insert->insert_table($_REQUEST,"money");
			  	if($_REQUEST['ResponseCode'] == '0'){
			  		//echo "<pre>";

			  		//start db transactiomn
			  		$this->db->trans_start(); 
					$this->load->model('update'); 
					//get appointment data
					$array 	=	array(
									'ap_id' 	=>		$_REQUEST['MerchantRefNo']
								);
					$this->load->model('home');
					$ap = $this->home->get_one_row("appointment",$array,'*');
					//if payment is made through wallet then deduct mioney from wallet
					if($ap['ap_wallet_money']	!= 0)
					{
						$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
						$wallet		=	$this->select->get_one_wallet($array);
						$newwallet 	=	$wallet['wallet_amount']-$ap['ap_wallet_money'];
						$array 	=	array(
											"wallet_amount"	=> 	$newwallet
										);
						
						$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$array);
					}
					$array 		=	array(		
											'ap_paymentid'	=>		$_REQUEST['PaymentID'],
											'ap_status'		=>		1,
											'ap_payment'	=>		1,
										);
					$this->update->update_table("appointment","ap_id",$ap['ap_id'],$array);
					$this->db->trans_complete();
					if ($this->db->trans_status() == FALSE)
					{
					    return redirect(base_url('Error404')); 
					}
					else{
						$this->sendmailtouser($ap['ap_id']);
						return redirect(base_url('Payment/success/'.$ap['ap_id'])); 
					}

			  	}
			  	else{
			  		return redirect(base_url('payment/failure'));
			  	}
				
			}else{
				return redirect(base_url('Error404')); 
			}
		}
		public function success(){
			$array 	=	array(
									'ap_id' 	=>		$this->uri->segment(3)
								);
			$this->load->model('home');
			$ap = $this->home->get_one_row("appointment",$array,'*');
			if($ap['ap_status']==1)
			{
				$array 		=		array(
											'ap'	=>	$ap,
										);
				$this->load->view('home/success',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function failure(){
			$this->load->view('home/failure.php');
		}
		public function booktestnow(){
			$post 		=	$this->input->post();
			$this->booktestnownew($post);
			
		}
		public function booktestnownew($post){
			if($post['usewallet']==1)
			{
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
			 	$totalamount	=	$post['totalamount'];
				$ap_id 			=	$_SESSION['ap_id'];
				if($wallet['wallet_amount'] >= $totalamount)
				{
					$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_test_ids"			=>  $post['test_ids'],
										"ap_payment"			=>	1,
										"ap_status"				=>	1,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  $totalamount,										
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],								
										"ap_card_money"			=>  0,
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
					$this->db->trans_start();
					$this->load->model("insert");
					$this->load->model("update");
					$this->update->update_table("appointment","ap_id",$_SESSION['ap_id'],$array);
					$newwallet 	=	$wallet['wallet_amount']-$totalamount;
					$array 	=	array(
										"wallet_amount"	=> 	$newwallet
									);
					$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$array);
					$this->db->trans_complete();
					if ($this->db->trans_status() == FALSE)
					{
					     $status = 0; 
					     $url    = base_url('Error404');
					}
					else{
						$this->sendmailtouser($ap_id);
						$status = 1;
						$url    = base_url('Payment/success/'.$ap_id);
						unset($_SESSION['ap_id']);
					}
					$output = array(
										'status'=>$status,
										'url'=>$url,
									);
					echo json_encode($output, false);
				}
				else{
					//code where wallet amount is less than total payable amount
				}	

			}
			else{
				//code if user wishes not to use wallet 
				
			}
		}
		public function paytestusingebs(){
			$post 	=	$this->input->post();
			//print_r($post);
			if($post['usewallet']==0)
			{
				 
				$totalamount	=	 $post['totalamount'];
				$ap_id 			=	$_SESSION['ap_id'];			 
				$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_test_ids"			=>  $post['test_ids'],
										"ap_payment"			=>	0,
										"ap_status"				=>	0,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  0,										
										"ap_card_money"			=>  $totalamount,
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],	
										"ap_gateway"			=>  "ebs",
										"created_at"			=>  date("Y-m-d H:i:s"),
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
				$this->db->trans_start();
				$this->load->model("update");
				$this->update->update_table("appointment","ap_id",$_SESSION['ap_id'],$array);
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/ebspayment/'.$ap_id);
					unset($_SESSION['ap_id']);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
				 
			}
			else{
				$totalamount	=	 $post['totalamount'];
				$ap_id 			=	$_SESSION['ap_id'];	
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				 
				$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_test_ids"			=>  $post['test_ids'],
										"ap_payment"			=>	0,
										"ap_status"				=>	0,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  $wallet['wallet_amount'],								
										"ap_card_money"			=>  $totalamount-$wallet['wallet_amount'],
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],	
										"ap_gateway"			=>  "ebs",
										"created_at"			=>  date("Y-m-d H:i:s"),
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
				$this->db->trans_start();
				$this->load->model("update");
				$this->update->update_table("appointment","ap_id",$_SESSION['ap_id'],$array);
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/ebspayment/'.$ap_id);
					unset($_SESSION['ap_id']);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
			}
		}
		public function rescheduletestnow(){
			$post 	=	$this->input->post();
			$post['ap_rescheduled']		=	1;
			if($this->update->update_table("appointment","ap_id",$post['ap_id'],$post))
			{
				$ap_id 	=	$post['ap_id'];
				$data	=	'<html>

									<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
										
										<div style="width:100%;background:#3f5267;color:white;padding:5px;">
											<h2 style="text-align:center">Appointment Rescheduled</h2>
										</div>
										<div style="width:100%;padding:10px;">
											<h3><b>Dear '.$_SESSION['user']['user_name'].',</b></h3>

											<p>Your appointment with Ap Id - '.$post['ap_id'].' has been rescheduled. You new appointment date is '.date('d,M-y',strtotime($post['ap_date'])).' .</p>

											<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>

											<hr>
											<p>Regards : BOOKMEDIZ Team<br>
											Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
											<hr>
										</div>
									</div>
								</html>';
					//echo $data ;
					if(isset($_SESSION['patient_id']))
					{
						 
						$this->sendmail($_SESSION['user']['user_email'],"Bookmediz Appointment Rescheduled",$data,"Appointment Rescheduled");			
						$this->smsgatewaycenter_com_Send("91".$_SESSION['user']['user_mob'],"Congratulations, you have successfully rescheduled your appointment ".$post['ap_id']." . Thank you for using BOOKMEDIZ.");
						$url    = base_url('myappointments');
						$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>Your appointment has been successfully rescheduled.</b></p></div>");
						$url    = base_url('myappointments');
					}
					else if(isset($_SESSION['diagnosis_id']))
					{
						$array 	=	array('ap_id'	=>	$post['ap_id']);
						$ap 	=	$this->select->get_one_appointment($array);
						$patient_id 	=	$ap['ap_patient_id'];
						$array 	=	 array('id'	=>	$patient_id);
						$patient =	 $this->select->get_one_user($array);
						$this->sendmail($patient['user_email'],"Bookmediz Appointment Rescheduled",$data,"Appointment Rescheduled");			
						$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"The diagnosis center has rescheduled your appointment with appointment id- ".$post['ap_id']." . Thank you for using BOOKMEDIZ.");
						$url    = base_url('Diagnosis/appointments');
					}				
					$status 	=	1;					
			}
			else{
				$status 	=	0;
				$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>We are facing some technical issues. Please try later.</b></p></div>");
				$url 	=	base_url('Error404');
			}				
			$output = array(
								'status'=>$status,
								'url'=>$url,
							);
			echo json_encode($output, false);
		}
		public function payusingpaytm(){
			$post 	=	$this->input->post();
			//print_r($post);
			if($post['usewallet']==0)
			{
				$array 		=	array(
								'id'			=>	$post['ap_doctor_id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				//echo $doc['user_fee'];
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
				$gst		=	($settings['settings_gst']*$charge)/100;
	
				$totalamount	=	$charge+$gst+$doc['user_fee'];
				$totalamount	=	 ceil($totalamount);
				$extracharge	=	$totalamount-$doc['user_fee'];
				$array 			= 	array(
											"settings_id"	=> 	2,
										);
				$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];

				$ap_id 			=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
				$array = array(
									"ap_doctor_id"  		=>  $post['ap_doctor_id'],
									"ap_patient_id"			=>  $post['ap_patient_id'],
									"ap_date"				=>  $post['ap_date'],
									"ap_time"				=>  $post['ap_time'],
									"ap_shift"				=>  $post['ap_shift'],
									"ap_id"					=>  $ap_id,
									"ap_payment"			=>	0,
									"ap_status"				=>	0,
									"ap_amount_to_be_paid"	=> 	$post['ap_amount_to_be_paid'],
									"ap_money"				=>  $totalamount,
									"ap_wallet_money"		=>  0,										
									"ap_card_money"			=>  $totalamount,
									"ap_gateway"			=>  "paytm",
									"created_at"			=>  date("Y-m-d H:i:s"),
									"updated_at"			=>  date("Y-m-d H:i:s"),
								);
				$this->db->trans_start();
				$this->load->model("insert");
				$this->insert->insert_table($array,"appointment");
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/paytmpayment/'.$ap_id);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
				 
			}
			else{
				/*$array 		=	array(
								'id'			=>	$post['ap_doctor_id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				//echo $doc['user_fee'];
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
				$gst		=	($settings['settings_gst']*$charge)/100;
	
				$totalamount	=	$charge+$gst+$doc['user_fee'];
				$totalamount	=	 ceil($totalamount);
				$extracharge	=	$totalamount-$doc['user_fee'];
				$array 			= 	array(
											"settings_id"	=> 	2,
										);
				$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];*/
				$totalamount 	= 	10;
				
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				if($totalamount<=$wallet['wallet_amount'])
				{
					$this->booknownew($post);
					exit();
				}
				$ap_id 			=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
				 
				$array = array(
									"ap_doctor_id"  		=>  $post['ap_doctor_id'],
									"ap_patient_id"			=>  $post['ap_patient_id'],
									"ap_date"				=>  $post['ap_date'],
									"ap_time"				=>  $post['ap_time'],
									"ap_id"					=>  $ap_id,
									"ap_payment"			=>	0,
									"ap_status"				=>	0,
									"ap_money"				=>  $totalamount,
									"ap_wallet_money"		=>  $wallet['wallet_amount'],										
									"ap_card_money"			=>  $totalamount-$wallet['wallet_amount'],
									"ap_amount_to_be_paid"	=> 	$post['ap_amount_to_be_paid'],
									"ap_gateway"			=>  "paytm",
									"created_at"			=>  date("Y-m-d H:i:s"),
									"updated_at"			=>  date("Y-m-d H:i:s"),
								);
				$this->db->trans_start();
				$this->load->model("insert");
				$this->insert->insert_table($array,"appointment");
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/paytmpayment/'.$ap_id);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
			}
		}
		public function paytmpayment(){
			$array 	=	array(
								'ap_id' 			=>	$this->uri->segment(3),
								'ap_patient_id'		=>	$_SESSION['user']['id'],
								'ap_payment'		=>	0,
								'ap_status'			=>	0,
							);
			$this->load->model('home');
			if(count($ap = $this->home->get_one_row("appointment",$array,'*'))){
				$array 		=	array('ap'	=>	$ap);
				$this->load->view('home/paytmpayment',['array'	=>		$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function paytmresponse(){
			//echo "<pre>";
			//print_r($_POST);
			if(isset($_POST)){
				$response = $_POST;
			    $this->load->model("insert");
				$this->insert->insert_table($response,"paytm");
			  	if($response['STATUS'] == 'TXN_SUCCESS'){
			  		$this->db->trans_start(); 
					$this->load->model('update'); 
					//get appointment data
					$array 	=	array(
									'ap_id' 	=>		$response['ORDERID']
								);
					$this->load->model('home');
					$ap = $this->home->get_one_row("appointment",$array,'*');
					//if payment is made through wallet then deduct mioney from wallet
					if($ap['ap_wallet_money']	!= 0)
					{
						$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
						$wallet		=	$this->select->get_one_wallet($array);
						$newwallet 	=	$wallet['wallet_amount']-$ap['ap_wallet_money'];
						$array 	=	array(
											"wallet_amount"	=> 	$newwallet
										);
						
						$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$array);
					}
					$array 		=	array(		
											'ap_paymentid'	=>		$response['TXNID'],
											'ap_status'		=>		1,
											'ap_payment'	=>		1,
										);
					$this->update->update_table("appointment","ap_id",$ap['ap_id'],$array);
					$this->db->trans_complete();
					if ($this->db->trans_status() == FALSE)
					{
					    return redirect(base_url('Error404')); 
					}
					else{
						$this->sendmailtouser($ap['ap_id']);
						return redirect(base_url('Payment/success/'.$ap['ap_id'])); 
					}

			  	}
			  	else{
			  		return redirect(base_url('payment/failure'));
			  	}
				
			}else{
				return redirect(base_url('Error404')); 
			}
		}
		public function paytestusingpaytm(){
			$post 	=	$this->input->post();
			//print_r($post);
			if($post['usewallet']==0)
			{
				 
				$totalamount	=	 $post['totalamount'];
				$ap_id 			=	$_SESSION['ap_id'];			 
				$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_test_ids"			=>  $post['test_ids'],
										"ap_payment"			=>	0,
										"ap_status"				=>	0,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  0,										
										"ap_card_money"			=>  $totalamount,
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],	
										"ap_gateway"			=>  "paytm",
										"created_at"			=>  date("Y-m-d H:i:s"),
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
				$this->db->trans_start();
				$this->load->model("update");
				$this->update->update_table("appointment","ap_id",$_SESSION['ap_id'],$array);
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/paytmpayment/'.$ap_id);
					unset($_SESSION['ap_id']);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
				 
			}
			else{
				$totalamount	=	 $post['totalamount'];
				$ap_id 			=	$_SESSION['ap_id'];	
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				 
				$array = array(
										"ap_doctor_id"  		=>  $post['ap_doctor_id'],
										"ap_patient_id"			=>  $post['ap_patient_id'],
										"ap_date"				=>  $post['ap_date'],
										"ap_test_ids"			=>  $post['test_ids'],
										"ap_payment"			=>	0,
										"ap_status"				=>	0,
										"ap_money"				=>  $totalamount,
										"ap_wallet_money"		=>  $wallet['wallet_amount'],								
										"ap_card_money"			=>  $totalamount-$wallet['wallet_amount'],
										"ap_amount_to_be_paid"	=>  $post['ap_amount_to_be_paid'],	
										"ap_gateway"			=>  "paytm",
										"created_at"			=>  date("Y-m-d H:i:s"),
										"updated_at"			=>  date("Y-m-d H:i:s"),
									);
				$this->db->trans_start();
				$this->load->model("update");
				$this->update->update_table("appointment","ap_id",$_SESSION['ap_id'],$array);
				$this->db->trans_complete();
				if ($this->db->trans_status() == FALSE)
				{
				     $status = 0; 
				     $url = '';
				}
				else{
					$status = 1;
					$url    =  base_url('payment/paytmpayment/'.$ap_id);
					unset($_SESSION['ap_id']);
				}
				$output = array(
								'url'			=>		$url,
								'status'		=>		$status,
								);
				echo json_encode($output, false);
			}
		}
		public function test(){
			
				$ap_id 	=	"APID15275893043605";
				$post 	= 	$this->select->get_single_row("select ap.*,p.user_name as patient_name,d.user_name as doctor_name,adl1,adl2,location,city,state,country from appointment ap inner join users p on (p.id=ap.ap_patient_id) inner join users d on (d.id=ap.ap_doctor_id) inner join address ad on
						 	case WHEN d.user_clinic_id!='0' Then (ad.user_id=d.user_clinic_id) Else (ad.user_id=d.id) END  where ap_id = '$ap_id'");
				$address = $post['adl1'].", ".$post['adl2'].", ".$post['location'].", ".$post['city'].", ".$post['state'];
						
				$data	=	'<html>

									<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
										
										<div style="width:100%;background:#3f5267;color:white;padding:5px;">
											<h2 style="text-align:center">Appointment Rescheduled</h2>
										</div>
										<div style="width:100%;padding:10px;">
											<h3><b>Dear '.$_SESSION['user']['user_name'].',</b></h3>

											<p>Your appointment with Ap Id - '.$post['ap_id'].' has been rescheduled. You new appointment details are as follows:-</p>

											<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
											<p>Doctor - <span style="font-weight:bold;">Dr. '.$post['doctor_name'].'</span></p>
											<p>Date & Time - <span style="font-weight:bold;">'.$post['ap_time']." on ".date('d-M-Y',strtotime($post['ap_date'])).'</span></p>
											<p>Amount to be paid - <span style="font-weight:bold;"> &#x20B9; '.$post['ap_amount_to_be_paid'].'</span></p>
											<p>Address - <span style="font-weight:bold;">'.$address.'</span></p>

											<hr>
											<p>Regards : BOOKMEDIZ Team<br>
											Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
											<hr>
										</div>
									</div>
								</html>';
					//echo $data ;
					if(isset($_SESSION['patient_id']))
					{
						 
					}
					else if(isset($_SESSION['doctor_id']))
					{
						$array 	=	array('ap_id'	=>	$post['ap_id']);
						$ap 	=	$this->select->get_one_appointment($array);
						$patient_id 	=	$ap['ap_patient_id'];
						$array 	=	 array('id'	=>	$patient_id);
						$patient =	 $this->select->get_one_user($array);
						$msg 	= "Dr. ".$post['doctor_name']." has rescheduled your appointment with Appointment-ID  - ".$post['ap_id']." . Your new appointment details are ".date('d-M,Y',strtotime($post['ap_date']))." at ".$post['ap_time']." . Address - ".$address." .";
						//$this->sendmail($patient['user_email'],"Bookmediz Appointment Rescheduled",$data,"Appointment Rescheduled");			
						//$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"The doctor has rescheduled your appointment with appointment id- ".$post['ap_id']." . Thank you for using BOOKMEDIZ.");
						$url    = base_url('Doc/myappointments');
					 }
					 $msg2="Congratulations, you have successfully rescheduled your appointment with ##Field## , Appointment-ID - ##Field## . Your appointment date and time is ##Field## at ##Field## . Address - ##Field## .";
					//echo $data;
					 echo "<br>";
					 echo $msg;
					 echo "<br>";
		 			 //echo $msg2;
	}

		}
?>