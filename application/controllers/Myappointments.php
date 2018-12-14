<?php
	class Myappointments extends MY_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('select');
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
			if(!isset($_SESSION['user']))
			{
				return redirect(base_url('Error404'));
			}
		}
		public function index(){
			$_SESSION['page']	=	"myappointments";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_patient_id'		=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('myappointments/index'),
								'per_page'		=>		'5',
								'total_rows'	=>		$this->select->count_all_appointments($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li class='page-item'>",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li class='page-item'>",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li class='page-item'>",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class='page-item active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li class='hidden'><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li class='hidden'><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$ap	=	$this->select->get_some_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array 	=	array(
								"ap"	=>	$ap,
							);
			//echo "<pre>";
			//print_r($ap);
			$this->load->view('home/myappointments',['array'	=>	$array]);
		}
		public function cancel(){
			//$post 	=	$this->inputs->post();
			$ap_id 	=	$_POST['ap_id'];
			$this->load->model('update');
			$this->load->model('select');
			$this->load->model('insert');
			$array 	=	array('ap_id'	=>	$ap_id);
			$ap 	=	$this->select->get_single_row("select ap.*,u.user_name as doc_name from appointment ap inner join users u on (u.id=ap.ap_doctor_id) where ap.ap_id='$ap_id'");
			$array 	=	array(
								'ap_status'		=>	2,
							);
			if($this->update->update_table("appointment","ap_id",$ap_id,$array))
			{
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				if(count($wallet))
				{
					$balance['wallet_amount'] 	=	$wallet['wallet_amount']+$ap['ap_money'];
					$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$balance);

				}
				else{
					$balance 	=	array(
											"wallet_patient_id"	=>	$_SESSION['user']['id'],
											"wallet_amount"		=>	$ap['ap_money'],
										);
					$this->insert->insert_table($balance,"wallet");
				}

				if($ap['ap_test_ids']!='')
				{
					$doc_name 	= 	$ap['doc_name'];
					$org 		= 	"Diagnosis";
					$msg = "You have Successfully cancelled your appointment with $doc_name and Appointment-ID - ".$ap_id." on ".date('d-M, Y',strtotime($ap['ap_date']))." at ".$ap['ap_time']." . The amount of Rs. ".$ap['ap_money']." has been refunded to your bookmediz wallet.";
						
				}
				else{
					$doc_name = "Dr. ".$ap['doc_name'];
					$org 	="Doctor";
					$msg = "You have Successfully cancelled your appointment with $doc_name and Appointment-ID - ".$ap_id." on ".date('d-M, Y',strtotime($ap['ap_date']))." . The amount of Rs. ".$ap['ap_money']." has been refunded to your bookmediz wallet.";
				}

				$data	=	'<html>

								<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
									
									<div style="width:100%;background:#3f5267;color:white;padding:5px;">
										<h2 style="text-align:center">Appointment Cancelled</h2>
									</div>
									<div style="width:100%;padding:10px;">
										<h3><b>Dear '.$_SESSION['user']['user_name'].',</b></h3>

										<p>You have cancelled your appointment . Your amount of Rs. <b>'.$ap['ap_money'].'</b> has been refunded to your bookmediz wallet. </p>
										<p>'.$org.' - <span style="font-weight:bold;">'.$doc_name.'</span></p>
										<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
										<p>Date & Time - <span style="font-weight:bold;">'.$ap['ap_time']." on ".date('d-M-Y',strtotime($ap['ap_date'])).'</span></p>
										  


										<hr>
										<p>Regards : BOOKMEDIZ Team<br>
										Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
										<hr>
									</div>
								</div>
							</html>';
				
				//echo $msg."<br>";	
				$this->sendmail($_SESSION['user']['user_email'],"Bookmediz Appointment Cancelled",$data,"Appointment Cancelled");	
				$this->smsgatewaycenter_com_Send("91".$_SESSION['user']['user_mob'],$msg);
				$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>You have Successfully cancelled your appointment ".$ap_id.". The amount of Rs.".$ap['ap_money']." has been refunded to your bookmediz wallet.</b></p></div>");
				echo 1;
			}
			else{
				$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>We are facing some technical issues. Please try later.</b></p></div>");
				echo 0;
			}			
		}
		public function reschedule(){
			$ap_id 	=	$this->uri->segment(3);
			$array 	=	array(
								'ap_id'			=>	$ap_id,
								'ap_status'		=>	1,
								'ap_payment'	=>	1,
								'ap_rescheduled'=>	0,
								'ap_patient_id'	=>	$_SESSION['user']['id'],
								'ap_date>='		=>	date('Y-m-d')
							);
			$ap 	=	$this->select->get_one_appointment($array);
			

			if($ap['ap_date']==date('Y-m-d'))
			{
				$day =  strtolower(date('D'));
				if($ap['ap_shift'] = "M")
				{
					$field= $day."_morning_start";
				}
				else{
					$field= $day."_evening_start";	
				}
				//echo $field;
				$doc_id     = 	$ap['ap_doctor_id'];
				$shiftstarttime 	= 	$this->select->get_single_row("select $field from timings where user_id='$doc_id'");
				$shiftstarttime 	= 	explode(":",$shiftstarttime[$field]);
				$shiftstarttime 	= 	($shiftstarttime[0]*3600)+($shiftstarttime[1]*60)+($shiftstarttime[02]);
				$now 				= 	explode(":",date("H:i:s"));
				$now 				= 	($now[0]*3600)+($now[1]*60)+($now[2]);
				$maxlimit 			= 	$now 	+ 	$now;
				//echo $now;
				//print_r($shiftstarttime);
				if($shiftstarttime<$maxlimit)
				{
					if($_SESSION['user']['user_type']=="1")
					{ 
						$this->session->set_flashdata('apmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>You can not reschedule this appointment. The appointment can only be rescheduled 2 hours prior to the appointment shift.</b></p></div>");
						return redirect (base_url('myappointments/index'));
					}
				}
			}
			if(count($ap))
			{
				$this->load->model('select');
				$array	=	array(
									'id'			=>	$ap['ap_doctor_id'],
									'is_active'		=>	1,
									); 
				if(!count($doctor		=	$this->select->get_one_user($array))){
					return redirect (base_url('Error404'));
				}
				$array 	=	array('user_id'	=>	$ap['ap_doctor_id']);
				$time 	=	$this->select->get_user_time($array);
				if(!count($time)){
					return redirect(base_url('Error404'));
				}
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				$array 		=	array(
										'doctor'	=>	$doctor,
										'ap'		=>	$ap,
										'settings'	=>	$settings,
										'wallet'	=>	$wallet,
										'time'		=>	$time,

										);
				$this->load->view('home/reschedule',['array'	=>	$array]);
			}
			else{
				return redirect ('Error404');
			}
		}
		public function rescheduletest(){
			$ap_id 	=	$this->uri->segment(3);
			$array 	=	array(
								'ap_id'			=>	$ap_id,
								'ap_status'		=>	1,
								'ap_payment'	=>	1,
								'ap_rescheduled'=>	0,
								'ap_patient_id'	=>	$_SESSION['user']['id'],
								'ap_date>='		=>	date('Y-m-d')
							);
			$ap 	=	$this->select->get_one_appointment($array);
			if(count($ap))
			{
				$this->load->model('select');
				$array	=	array(
									'id'			=>	$ap['ap_doctor_id'],
									'is_active'		=>	1,
									); 
				if(!count($doctor		=	$this->select->get_one_user($array))){
					return redirect (base_url('Error404'));
				}
				$array 	=	array('user_id'	=>	$ap['ap_doctor_id']);
				$time 	=	$this->select->get_user_time($array);
				if(!count($time)){
					return redirect(base_url('Error404'));
				}
				$array		=	array('settings_id'	=>	1);
				$settings	=	$this->select->get_settings($array);
				$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				$array 		=	array(
										'doctor'	=>	$doctor,
										'ap'		=>	$ap,
										'settings'	=>	$settings,
										'wallet'	=>	$wallet,
										'time'		=>	$time,

										);
				$this->load->view('home/rescheduletest',['array'	=>	$array]);
			}
			else{
				return redirect ('Error404');
			}
		}
		public function test(){
			$ap_id ='APID15280053369392';
			$ap 	=	$this->select->get_single_row("select ap.*,u.user_name as doc_name from appointment ap inner join users u on (u.id=ap.ap_doctor_id) where ap.ap_id='$ap_id'");
			 
			 	if($ap['ap_test_ids']!='')
				{
					$doc_name 	= 	$ap['doc_name'];
					$org 		= 	"Diagnosis";
				}
				else{
					$doc_name = "Dr. ".$ap['doc_name'];
					$org 	="Doctor";
				}
				$msg = "You have Successfully cancelled your appointment with $doc_name and Appointment-ID - ".$ap_id." on ".date('d-M, Y',strtotime($ap['ap_date']))." at ".$ap['ap_time']." . The amount of Rs. ".$ap['ap_money']." has been refunded to your bookmediz wallet.";			
				//$this->sendmail($_SESSION['user']['user_email'],"Bookmediz Appointment Cancelled",$data,"Appointment Cancelled");	
				echo $msg."<br>";
				echo $this->smsgatewaycenter_com_Send("91".$_SESSION['user']['user_mob'],$msg);
				
		}
		
	}
?>