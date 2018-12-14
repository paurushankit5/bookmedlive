<?php
	class Register extends MY_Controller{
		public function __construct(){
			parent ::__construct();
			$this->load->model('insert');
            $this->load->model('select');
            $this->load->model('update');
            if(isset($_SESSION['user']))
			{
				return redirect(base_url('Error404'));
			}	
		}
		public function index(){
			$this->load->helper(array('form'));

           $this->load->view('home/register');
		}
		public function  storepatient(){
			$post 	=	$this->input->post();
			
			$this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');
            $this->form_validation->set_rules('user_age', 'Age', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/register');
            }
            else{
            	$post['created_at']	=	date('Y-m-d');
            	$post['updated_at']	=	date('Y-m-d');
            	$post['user_type']	=	1; // for patinet user_type is 1
            	$post['is_active']	=	1;
            	$post['mobile_code']=	rand(1111,9999);

            	unset($post['user_pwd2']);
            	$post['user_pwd']	=	md5($post['user_pwd']);
				 
				if($id = $this->insert->insert_table($post,'users'))
				{
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Welcome to Bookmediz. Your OTP to verify your mobile is ".$post['mobile_code']." .");
					$_SESSION['new_user_id']	=	$id;
					$user = $this->select->get_one_user(array('id'	=>	$id));
					return redirect(base_url('Register/verifymobile'));
					/*if(isset($_SESSION['url']))
					{
						header('Location :'.$_SESSION['url'] );
					}
					else{
						return redirect(base_url());
					}*/
				}
				else{
					$this->session->set_flashdata('regmsg','We are facing some technical issues. Please try later');
					return redirect(base_url('register'));
				}
            }

		}
		public function sendotpagain(){
			$rand 	=	rand(1111,9999);
			$array	=	array(
									 'mobile_code'	=>	$rand,									
								);
			if($this->update->update_table('users','id',$_SESSION['new_user_id'],$array))
			{
				$status=1;
				$user = $this->select->get_one_user(array('id'	=>	$_SESSION['new_user_id']));
				$this->smsgatewaycenter_com_Send("91".$user['user_mob'], "Welcome to Bookmediz. Your new OTP is ".$rand);
			}
			else{
				$status=0;
			}
			$output = array('status'=>$status);
			echo json_encode($output, false);
		}
		public function verifymobile(){
			if(!isset($_SESSION['new_user_id']))
			{
				return redirect(base_url('Error404'));
			}
			$this->load->view('home/verifymobile');
		}
		public function checkotp(){
			$post		=	$this->input->post();
			$post['id']	=	$_SESSION['new_user_id'];
			$this->load->model('select');
			if($this->select->checkuser($post))
			{
				$this->load->model('update');
				$array	=	array(
									'is_active'		=>	0,
									'mobile_code'	=>	'',									
								);
				if($this->update->update->update_table('users','id',$_SESSION['new_user_id'],$array))
				{
					$status		=	1;
					unset($_SESSION['new_user_id']);
					 
				}
				else
				{
					$status		=	2;
					
				}
			}
			else{
				$status		=	3;
			}
			$output = array('status'=>$status);
			echo json_encode($output, false);
		}
		public function clinic(){
			$this->load->helper(array('form'));

           $this->load->view('home/registerclinic');
		}
		public function hospital(){
			$this->load->helper(array('form'));

           $this->load->view('home/registerhospital');
		}
		public function  storeclinic(){
			$post 	=	$this->input->post();
			
			 $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');
            

            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/registerclinic');
            }
            else{
            	$post['created_at']	=	date('Y-m-d');
            	$post['updated_at']	=	date('Y-m-d');
            	$post['user_type']	=	2; //for clinic user_type=2
            	$post['is_active']	=	0;
            	$post['user_pwd']	=	md5($post['user_pwd']);
            	$post['mobile_code']=	rand(1111,9999);

            	unset($post['user_pwd2']);
            	$this->load->model('insert');
				if($id = $this->insert->insert_table($post,'users'))
				{
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Welcome to Bookmediz. Your OTP to verify your mobile is ".$post['mobile_code']." .");
					$_SESSION['new_user_id']	=	$id;
					$user = $this->select->get_one_user(array('id'	=>	$id));
					return redirect(base_url('Register/verifymobile'));
					/*$_SESSION['clinic_id']	=	$id;
					if(isset($_SESSION['url']))
					{
						header('Location :'.$_SESSION['url'] );
					}
					else{
						return redirect(base_url());
					}*/
				}
				else{
					$this->session->set_flashdata('regmsg','We are facing some technical issues. Please try later');
					return redirect(base_url('Register/Clinic'));
				}
            }

		}
		public function storehospital(){
			$post 	=	$this->input->post();
			
			 $this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');

            

            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/registerclinic');
            }
            else{
            	$post['created_at']	=	date('Y-m-d');
            	$post['updated_at']	=	date('Y-m-d');
            	$post['user_type']	=	3; //for hospital user_type=2
            	$post['is_active']	=	0;
            	$post['user_pwd']	=	md5($post['user_pwd']);
            	$post['mobile_code']=	rand(1111,9999);

            	unset($post['user_pwd2']);
            	$this->load->model('insert');
				if($id = $this->insert->insert_table($post,'users'))
				{
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Welcome to Bookmediz. Your OTP to verify your mobile is ".$post['mobile_code']." .");
					$_SESSION['new_user_id']	=	$id;
					$user = $this->select->get_one_user(array('id'	=>	$id));
					return redirect(base_url('Register/verifymobile'));
					/*$_SESSION['clinic_id']	=	$id;
					if(isset($_SESSION['url']))
					{
						header('Location :'.$_SESSION['url'] );
					}
					else{
						return redirect(base_url());
					}*/
				}
				else{
					$this->session->set_flashdata('regmsg','We are facing some technical issues. Please try later');
					return redirect(base_url('Register/Clinic'));
				}
            }
		}
		public function Individualdoctor(){
			$this->load->helper(array('form'));

           $this->load->view('home/registerindidoc');
		}
		
		public function storeindidoc(){
			$post 	=	$this->input->post();
			
			$this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');

            

            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/registerindidoc');
            }
            else{
            	$post['created_at']	=	date('Y-m-d');
            	$post['updated_at']	=	date('Y-m-d');
            	$post['user_type']	=	4; //for indi doc user_type=4
            	$post['is_active']	=	0;
            	$post['user_pwd']	=	md5($post['user_pwd']);
            	$post['mobile_code']=	rand(1111,9999);

            	unset($post['user_pwd2']);
            	
				if($id = $this->insert->insert_table($post,'users'))
				{
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Welcome to Bookmediz. Your OTP to verify your mobile is ".$post['mobile_code']." .");
					$_SESSION['new_user_id']	=	$id;
					$user = $this->select->get_one_user(array('id'	=>	$id));
					return redirect(base_url('Register/verifymobile'));
					 
				}
				else{
					$this->session->set_flashdata('regmsg','We are facing some technical issues. Please try later');
					return redirect(base_url('Register/Individualdoctor'));
				}
            }
		}
		public function diagnosis(){
			$this->load->helper(array('form'));

           $this->load->view('home/registerdiagnosis');
		}
		public function storediagnosis(){
			$post 	=	$this->input->post();
			
			$this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');
            
            

            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/registerdiagnosis');
            }
            else{
            	$post['created_at']	=	date('Y-m-d');
            	$post['updated_at']	=	date('Y-m-d');
            	$post['user_type']	=	7; //for diagnosis center user_type=7
            	$post['is_active']	=	0;
            	$post['user_pwd']	=	md5($post['user_pwd']);
            	$post['mobile_code']=	rand(1111,9999);

            	unset($post['user_pwd2']);
            	
				if($id = $this->insert->insert_table($post,'users'))
				{
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Welcome to Bookmediz. Your OTP to verify your mobile is ".$post['mobile_code']." .");
					$_SESSION['new_user_id']	=	$id;
					$user = $this->select->get_one_user(array('id'	=>	$id));
					return redirect(base_url('Register/verifymobile'));
					 
				}
				else{
					$this->session->set_flashdata('regmsg','We are facing some technical issues. Please try later');
					return redirect(base_url('Register/diagnosis'));
				}
            }
		}
	}
?>