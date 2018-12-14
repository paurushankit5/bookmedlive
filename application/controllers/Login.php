<?php
	class Login extends MY_Controller{
		public function __Construct(){
			parent ::__Construct();
			if(isset($_SESSION['user']))
			{
				return redirect(base_url('Error404'));
			}
			$this->load->model('select');
			$this->load->model('update');

		}
		public function index(){
			$this->load->helper(array('form'));
			$this->load->view('home/login');
		}

		public function validatelogin(){
			ob_start();
			$post 	=	$this->input->post();
			//$post['user_pwd']	=	md5($post['user_pwd']);
			$pwd	=	md5($post['user_pwd']);
			$email	=	$post['user_email'];
			 
			  
			if($user = $this->select->get_single_row("select u.* ,uc.user_name as clinic_name from users u left join users uc on (u.user_clinic_id = uc.id) where u.user_pwd = '$pwd' and (u.user_email = '$email' or u.user_mob ='$email') ")){
				$user_id	=	$user['id'];
				//$user = $this->select->get_one_user($post);
				$_SESSION['user']	=	$user;
				$type =	$user['user_type'];
				if($type==1)
				{
					$_SESSION['patient_id']	=	$user_id;
				}
				else if($type==2)
				{
					$_SESSION['clinic_id']	=	$user_id;
					if(isset($_SESSION['url']))
					{
						$url =	$_SESSION['url'];
						unset($_SESSION['url']);
						return redirect($url);
					}
					else{
						return redirect(base_url('Health/dashboard'));
					}

				}
				else if($type==3)
				{
					$_SESSION['hospital_id']	=	$user_id;
					if(isset($_SESSION['url']))
					{
						$url =	$_SESSION['url'];
						unset($_SESSION['url']);
						return redirect($url);
					}
					else{
						return redirect(base_url('Health/dashboard'));
					}
				}
				else if($type==4 || $type ==5 || $type ==6)
				{
					$_SESSION['doctor_id']	=	$user_id;
					if(isset($_SESSION['url']))
					{
						$url =	$_SESSION['url'];
						unset($_SESSION['url']);
						return redirect($url);
					}
					else{
						return redirect(base_url('Doc/dashboard'));
					}
				}
				else if($type==7)
				{
					$_SESSION['diagnosis_id']	=	$user_id;
					if(isset($_SESSION['url']))
					{
						$url =	$_SESSION['url'];
						unset($_SESSION['url']);
						return redirect($url);
					}
					else{
						return redirect(base_url('Diagnosis/dashboard'));
					}
				}
				if(isset($_SESSION['url']))
				{
					$url =	$_SESSION['url'];
					unset($_SESSION['url']);
					return redirect($url);
				}
				else{
					return redirect(base_url());
				}
				 				
			}
			else{
				$this->session->set_flashdata('logmsg','Invalid credentials. Please try again.');
				return redirect(base_url('login'));
			}

			
		}
		public function forgotpassword(){
			$this->load->view('home/forgotpassword');
		}
		public function checkemail(){
			ob_start();
			$post 	=	$this->input->post();
			 
			$email	=	$post['user_email'];
			 
			  
			if($user = $this->select->get_single_row("select id from users where user_email = '$email' or user_mob ='$email'")){
				echo "1";
			}
			else{
				echo "0";
			}
		}
		public function sendforgototp(){
			$post 	=	$this->input->post();
			//echo "<pre>";
			print_r($post);
			$post 	=	$this->input->post();			 
			$email	=	$post['email'];

			if($user = $this->select->get_single_row("select id,user_mob,user_email,user_name from users where user_email = '$email' or user_mob ='$email'")){
				$rand 	=	rand(1111,9999);
				$array 	=	array(
									"user_code"		=>	$rand,
									);
				$this->load->model('update');
				$this->update->update_table("users","id",$user['id'],$array);
				if($post['otpmethod']=="mail")
				{
					$data	=	'<html>

									<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
										
										<div style="width:100%;background:#3f5267;color:white;padding:5px;">
											<h2 style="text-align:center">Reset Bookmediz Account Password</h2>
										</div>
										<div style="width:100%;padding:10px;">
											<h3><b>Dear '.$user['user_name'].',</b></h3>

											<p>Your OTP to reset your BOOKMEDIZ account password is <b>'.$rand.'</b></p>

											 
											<hr>
											<p>Regards : BOOKMEDIZ Team<br>
											Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
											<hr>
										</div>
									</div>
								</html>';
					$this->sendmail($user['user_email'],"OTP To Reset Bookmediz Account Password",$data,"Reset Password");
					$this->session->set_flashdata('otpmsg','OTP has been sent to your registered Email-Id. ');	
				}
				else{
					$this->smsgatewaycenter_com_Send("91".$user['user_mob'], "Your OTP to reset your BOOKMEDIZ account password is ".$rand." .");
					$this->session->set_flashdata('otpmsg','OTP has been sent to your registered mobile number. ');	
				}
				$_SESSION['forgot_user_id'] =	$user['id'];
				$_SESSION['method'] 		=	$post['otpmethod'];
				return redirect(base_url('Login/enetrotp'));
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function enetrotp(){
			if(!isset($_SESSION['forgot_user_id'])){
				return redirect(base_url('Error404'));
			} 
			else if(!isset($_SESSION['method'])){
				return redirect(base_url('Error404'));
			} 
			$this->load->view('home/enterotp');
		}
		public function sendforgototpagain(){
			$rand 	=	rand(1111,9999);
			$array	=	array(
									 'user_code'	=>	$rand,									
								);
			if($this->update->update_table('users','id',$_SESSION['forgot_user_id'],$array))
			{
				$status=1;
				$user = $this->select->get_one_user(array('id'	=>	$_SESSION['forgot_user_id']));
				if($_SESSION['method']=="mail")
				{
					$data	=	'<html>

									<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
										
										<div style="width:100%;background:#3f5267;color:white;padding:5px;">
											<h2 style="text-align:center">Reset Bookmediz Account Password</h2>
										</div>
										<div style="width:100%;padding:10px;">
											<h3><b>Dear '.$user['user_name'].',</b></h3>

											<p>Your OTP to reset your BOOKMEDIZ account password is <b>'.$rand.'</b></p>

											 
											<hr>
											<p>Regards : BOOKMEDIZ Team<br>
											Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
											<hr>
										</div>
									</div>
								</html>';
					$this->sendmail($user['user_email'],"OTP To Reset Bookmediz Account Password",$data,"Reset Password");
				}
				else{
					$this->smsgatewaycenter_com_Send("91".$user['user_mob'], "Your OTP to reset your BOOKMEDIZ account password is ".$rand." .");
				}
			}
			else{
				$status=0;
			}
			$output = array('status'=>$status);
			echo json_encode($output, false);
		}
		public function checkforgototp()
		{
			$post		=	$this->input->post();
			$post['id']	=	$_SESSION['forgot_user_id'];
			$this->load->model('select');
			if($this->select->checkuser($post))
			{
				$status		=	1;				 
			}
			else{
				$status		=	3;
			}
			$output = array('status'=>$status);
			echo json_encode($output, false);
		}
		public function setpassnow(){
			$post	=	$this->input->post();
			$array 	=	array(
								"user_pwd"	=>	md5($post['pwd']),
								"user_code"	=>	''
							);
			$this->load->model('update');
			if($this->update->update_table("users","id",$_SESSION['forgot_user_id'],$array))
			{
				unset($_SESSION['forgot_user_id']);
				unset($_SESSION['method']);
				$status		=	1;		
				$this->session->set_flashdata('logmsg','You have succesfully reset your password. ');		 
			}
			else{
				$status		=	0;
			}
			$output = array('status'=>$status);
			echo json_encode($output, false);

		}
	}
?>