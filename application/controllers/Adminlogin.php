<?php
	Class Adminlogin extends MY_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			if($this->session->userdata('admin_id'))
			{
				return redirect (base_url('hosadmin'));
			}
			 
			date_default_timezone_set('Asia/kolkata');
			ob_start();
		}
		public function index()
		{
			ob_start();
			$this->load->view('home/adminlogin');
		}
		public function verifylogin()
		{
			ob_start();
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$this->load->model('select');
			if($admin_id	=	$this->select->checkadminlogin($post))
			{
				$_SESSION['admin_id']	=	$admin_id;
				return redirect(base_url('Hosadmin'));
			}
			else
			{
				$this->session->set_flashdata('loginmsg','<div class="alert alert-danger" style="background:red;color:white"><b>Inccorrect Username Or Password.</b></div>');
				return redirect(base_url('Adminlogin'));
			}
			ob_end_flush();
		}
		public function forgotpassword(){
			$this->load->view('home/forgotadminpassword');
		}
		public function verifymobile(){
			$mobile 	= 	$_POST['mobile'];
			$this->load->model('select');
			if($this->select->get_total_rows("select admin_id from admin where admin_id=1 and mobile='$mobile'")){
				$rand 	= 	rand(111111,999999);
				$array 	= 	array("password" => $rand);
				$this->load->model('update');
				if($this->update->update_table("admin","admin_id",1,$array))
				{
					$msg 	= 	"Your new password to login to the admin panel is $rand . Please change the password once you login to the admin section.";
					$this->smsgatewaycenter_com_Send("91".$mobile, $msg);
					$this->session->set_flashdata('loginmsg','<div class="alert alert-danger" style="background:red;color:white"><b>Please login through the password sent to your registered mobile number. </b></div>');
				return redirect(base_url('Adminlogin'));
				}
				
			}
			else{
				$this->session->set_flashdata('loginmsg','<div class="alert alert-danger" style="background:red;color:white"><b>Inccorrect Mobile.</b></div>');
				return redirect(base_url('Adminlogin/forgotpassword'));	
			}
		}
		public function enterotp(){

		}
	}
?>