<?php
	Class Myprofile extends MY_Controller{
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
			$_SESSION['page']	=	"myprofile";
			$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
			$wallet		=	$this->select->get_one_wallet($array);
			
			$this->load->view('home/myprofile');
		}
		public function updateprofile(){
			$post 	=	$this->input->post();
			$post['updated_at']		=	date('Y-m-d H:i:S');
			$array 	=	array(
									'user_mob'	=>	$post['user_mob'],
									'id!='		=>	$_SESSION['user']['id']
								);
			if(count($user =	 $this->select->get_one_user($array)))
			{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>This number is already taken.</b></p></div>");
			}
			else{
				$this->load->model('update');
				if($this->update->update_table("users","id",$_SESSION['user']['id'],$post))
				{
					$array 	=	array('id'	=>	$_SESSION['user']['id']);
					$_SESSION['user'] = $this->select->get_one_user($array);
					$this->session->set_flashdata('profilemsg',"<div class='alert alert-danger' style='background-color:green;font-color:white;'><p style='color:white !important;'><b>Congratulations!... Your profile has been updated successfully.</b></p></div>");
				}
				else{
					$this->session->set_flashdata('profilemsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>We are facing some technical issues. Please try after some time.</b></p></div>");
				}				
			}
			return redirect(base_url('myprofile'));	
		}
		public function changepassword(){
			$_SESSION['page']	=	"changepassword";
			$this->load->view('home/changepassword');
		}
		public function updatepassword(){
			$post 	=	$this->input->post();
			//print_r($post);
			$array	=	array(
								"user_pwd"	=>	md5($post['user_pwd']),
								"id"		=>	$_SESSION['user']['id']
							);
			if(count($user =	 $this->select->get_one_user($array)))
			{
				if($post['new_pwd']	==	$post['new_pwd2'])
				{
					$array 	=	array('user_pwd'	=>	md5($post['new_pwd']));
					$this->load->model('update');
					if($this->update->update_table("users","id",$_SESSION['user']['id'],$array))
					{
						$this->session->set_flashdata('logmsg',"password changed successfully. Please login.");
						unset($_SESSION['user']);
						unset($_SESSION['patient_id']);
						return redirect(base_url('login'));
					}
					else{
						$this->session->set_flashdata('profilemsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>We are facing some technical issues. Please try after some time.</b></p></div>");
					}
				}
				else{
					$this->session->set_flashdata('passmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>Passwords do not match.</b></p></div>");

				}
			}
			else{
				$this->session->set_flashdata('passmsg',"<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>Invalid current password.</b></p></div>");

			}
			return redirect(base_url('myprofile/changepassword'));
		}
		public function changenumber(){
			$_SESSION['page']	=	"changenumber";
			$this->load->view('home/changenumber');
		}
		public function updatemobile(){
			$post 		= 		$_POST;
			$_SESSION['mobilenumbers'] = $post;
			$array 		= 		array(	
										"user_mob" 		=> 		$post['user_mob'],
										"id!=" 			=> 		$_SESSION['user']['id'],
									);
			if($this->select->checkuser($array))
			{
				echo "0";
			}
			else{
				$_SESSION['rand'] =  rand(1111,9999);
				$msg 		= 		"Your OTP to change your mobile number is ".$_SESSION['rand']." .";
				if($this->smsgatewaycenter_com_Send($post['user_mob'], $msg))
				{
				echo "1";
				}
				else{
					echo "2";
				}
			}		

		}
		public function sendotpagainformobile(){
			$_SESSION['rand'] = rand(1111,9999);
			$msg 		= 		"Your OTP to change your mobile number is ".$_SESSION['rand']." .";
			if($this->smsgatewaycenter_com_Send($_SESSION['mobilenumbers']['user_mob'], $msg))
			{
				echo "1";
			}
			else{
				echo "0";
			}
			//echo $_SESSION['mobilenumbers']['user_mob'];
		}
		public function verifyotpformobile(){
			if(!isset($_SESSION['mobilenumbers']))
			{
				return redirect(base_url('Error404'));
			}
			$this->load->view('home/verifyotpformobile');

		}
		public function checkotpformobile(){
			$post 	= 	$_POST;
			//print_r($post);
			if($post['mobile_code']==$_SESSION['rand'])
			{
				//print_r($_SESSION['mobilenumbers']);
				$this->load->model('update');
				if($this->update->update_table("users","id",$_SESSION['user']['id'],$_SESSION['mobilenumbers']))
				{
					unset($_SESSION['rand']);
					unset($_SESSION['mobilenumbers']);
					$status = 1;
					if(isset($_SESSION['clinic_id']))
					{
						$url = base_url('Health/Profile');
					}
					else if(isset($_SESSION['hospital_id']))
					{
						$url = base_url('Health/Profile');
					}
					else if(isset($_SESSION['doctor_id']))
					{
						$url = base_url('doc/Profile');
					}
					else if(isset($_SESSION['diagnosis_id']))
					{
						$url = base_url('Diagnosis/Profile');
					}
					$_SESSION['user'] = $this->select->get_one_user(array("id" => $_SESSION['user']['id']));
				}
				else{
					$status = 2;
					$url ='';
				}
			}
			else{
				$status = 3;
				$url ='';
			}
			$array 	= 	array(
								"status" 	=> 	$status,
								"url" 	=> 	$url,
							);
			echo json_encode($array);

		}
	}
?>