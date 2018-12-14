<?php
	Class Mywallet extends CI_Controller{
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
			$_SESSION['page']	=	"mywallet";
			$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
			$wallet		=	$this->select->get_one_wallet($array);
			if(!count($wallet))
			{
				$wallet['wallet_amount']	=	0;
			}
			$array 		=	array('wallet'	=>	$wallet);
			$this->load->view('home/mywallet',['array'	=>	$array]);
		}
	}
?>