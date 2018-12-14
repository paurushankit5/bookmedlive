<?php
	Class Myquestions extends MY_Controller{
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
			$_SESSION['page']	=	"myquestions";
			$array 	=	array(
								'question_patient_id'	=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');		
			$config		=	array(
								'base_url'		=>		base_url('myquestions/index'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_patient_all_questions($array),
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
			$que	=	$this->select->get_some_patient_questions($config['per_page'],$this->uri->segment(3),$array);
			$array 	=	array(
								"que"	=>	$que,
							);
			//print_r($ap);
			$this->load->view('home/myquestions',['array'	=>	$array]);
		}
		 
	}
?>