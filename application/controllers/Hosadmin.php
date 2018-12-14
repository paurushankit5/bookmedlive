
<?php
	class Hosadmin extends MY_Controller{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!$this->session->userdata('admin_id'))
			{
				return redirect (base_url('adminlogin'));
			}
			$this->load->model('select');
			$this->load->model('home');
			$this->load->model('update');
			$this->load->model('insert');
			$_SESSION['page'] = '';
			//date_default_timezone_set('Asia/kolkata');
			ob_start();
		}
		public function index(){
			$_SESSION['page'] = 'dashboard';
			$m = date('m');
			$y = date('Y');
			$today 	= 	date('Y-m-d');
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($y.'-'.$m.'-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'ap_payment'			=>	1,
										'ap_status'				=>	1,	
										'ap_date'				=>	$date,	 
									);				
				
				//print_r($array);
				$monrev[$i]['ap_money']		=	$this->select->count_all_appointments($array);
				$monrev[$i]['date']		=	$date;
				 
			} 
			$array 	= 	array(
								"user_type" => 4,
								"is_active" => 1,
							);
			$activeindidoc 	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 4,
								"is_active" => 0,
							);
			$pendingindidoc 	= 	$this->select->count_some_users($array);
			//clinic
			$array 	= 	array(
								"user_type" => 2,
								"is_active" => 1,
							);
			$activeclinic 	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 2,
								"is_active" => 0,
							);
			$pendingclinic 	= 	$this->select->count_some_users($array);
			//hospital
			$array 	= 	array(
								"user_type" => 3,
								"is_active" => 1,
							);
			$activehospital 	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 3,
								"is_active" => 0,
							);
			$pendinghospital	= 	$this->select->count_some_users($array);
			//Diagnosis			
			$array 	= 	array(
								"user_type" => 7,
								"is_active" => 1,
							);
			$activediagnosis 	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 7,
								"is_active" => 0,
							);
			$pendingdiagnosis	= 	$this->select->count_some_users($array);
			$today 				= 	date("Y-m-d");
			$indidocap 			= 	$this->select->get_single_row("select count(ap_id) as count from appointment a inner join users u on (u.id = a.ap_doctor_id) where u.user_type='4' and ap_date='$today' and ap_status='1' and ap_payment='1'");
			$clinicdocap 			= 	$this->select->get_single_row("select count(ap_id) as count from appointment a inner join users u on (u.id = a.ap_doctor_id) where u.user_type='5' and ap_date='$today' and ap_status='1' and ap_payment='1'");
			$hosdocap 			= 	$this->select->get_single_row("select count(ap_id) as count from appointment a inner join users u on (u.id = a.ap_doctor_id) where u.user_type='6' and ap_date='$today' and ap_status='1' and ap_payment='1'");
			$diagnosisap 			= 	$this->select->get_single_row("select count(ap_id) as count from appointment a inner join users u on (u.id = a.ap_doctor_id) where u.user_type='7' and ap_date='$today' and ap_status='1' and ap_payment='1'");
			
			$array 	= 	array(
								"user_type" => 1,
							);
			$allpatient	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 2,
							);
			$allclinic	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 3,
							);
			$allhospital= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 4,
							);
			$allindidoc	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 5,
							);
			$allclinicdoc	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 6,
							);
			$allhosdoc	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" => 7,
							);
			$alldiagnosis	= 	$this->select->count_some_users($array);

			$array 				= 	array(
											"activeindidoc" 	=> 	 $activeindidoc,
											"pendingindidoc" 	=> 	 $pendingindidoc,
											"activeclinic" 		=> 	 $activeclinic,
											"pendingclinic" 	=> 	 $pendingclinic,
											"activehospital" 	=> 	 $activehospital,
											"pendinghospital" 	=> 	 $pendinghospital,
											"activediagnosis" 	=> 	 $activediagnosis,
											"pendingdiagnosis" 	=> 	 $pendingdiagnosis,
											"m" 				=> 	 $m,
											"y" 				=> 	 $y,
											"monrev" 				=> 	 $monrev,
											"indidocap" 		=> 	 $indidocap,
											"clinicdocap" 		=> 	 $clinicdocap,
											"hosdocap" 			=> 	 $hosdocap,
											"diagnosisap" 		=> 	 $diagnosisap,
											"allpatient" 		=> 	 $allpatient,
											"allclinic" 		=> 	 $allclinic,
											"allhospital" 		=> 	 $allhospital,
											"allindidoc" 		=> 	 $allindidoc,
											"allclinicdoc" 		=> 	 $allclinicdoc,
											"allhosdoc" 		=> 	 $allhosdoc,
											"alldiagnosis" 		=> 	 $alldiagnosis,

										);
			$this->load->view('admin/index',['array' 	=> 	$array]);
		}
		public function signout(){
			unset($_SESSION['admin_id']);
			return redirect(base_url(''));
		}
		public function speciality(){
			$_SESSION['page'] = 'speciality';
			$speciality =	$this->home->get_all_row("speciality",array("1"=>1),"*",'speciality_name','ASC');
			$array 		= 	array('speciality'	=>	$speciality);
			$this->load->view('admin/speciality',['array'	=>	$array]);
		}
		public function delspeciality(){
			$array 	= 	array('speciality_id' 	=> 	$_POST['speciality_id']);
			$this->load->model('delete');
			if($this->delete->delete_table($array,"speciality"))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Speciality deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");

			}
		}
		public function storespec(){
			$post 	= 	$this->input->post();
			if($this->insert->insert_table($post,"speciality"))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Speciality added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/speciality'));
		}
		public function updatespec(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("speciality","speciality_id",$post['speciality_id'],$post))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Speciality updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/speciality'));
		}
		public function services(){
			$_SESSION['page'] = 'services';
			$services =	$this->home->get_all_row("service",array("1"=>1),"*",'service_name','ASC');
			$array 		= 	array('services'	=>	$services);
			$this->load->view('admin/services',['array'	=>	$array]);
		}
		public function storeservice(){
			$post 	= 	$this->input->post();
			if($this->insert->insert_table($post,"service"))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Service added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/services'));
		}
		public function updateservice(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("service","id",$post['id'],$post))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Service updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/services'));
		}
		public function delservice(){
			$array 	= 	array('id' 	=> 	$_POST['id']);
			$this->load->model('delete');
			if($this->delete->delete_table($array,"service"))
			{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Service deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");

			}
		}
		public function department(){
			$_SESSION['page']  = "department";
			$sql 	= 	"select * from department  ";
			$department 	= 	$this->select->get_questions($sql);
			if(count($department))
			{
				$i=0;
				foreach ($department as $x) {
					$array 	= 	array(
										"department_id"	=>	$x['id']
									);
					$department[$i++]['subdept'] 	= $this->home->get_all_row("subdepartment",$array,"*",'name','ASC');
				}
			}
			$array 	= 	array('department'	=>	$department);
			$this->load->view('admin/department',['array'	=>	$array]);
		}
		public function storesubdepartment(){
			$post 	= 	$this->input->post();
			if($this->insert->insert_table($post,"subdepartment"))
			{
				$this->session->set_flashdata('depmsg',"<div class='alert alert-success'>Sub-Department added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('depmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/department'));
		}
		public function updatesubdepartment(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("subdepartment","id",$post['id'],$post))
			{
				$this->session->set_flashdata('depmsg',"<div class='alert alert-success'>Sub-Department updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('depmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/department'));
		}
		public function delsubdepartment(){
			$array 	= 	array('id' 	=> 	$_POST['id']);
			$this->load->model('delete');
			if($this->delete->delete_table($array,"subdepartment"))
			{
				$this->session->set_flashdata('depmsg',"<div class='alert alert-success'>Sub-Department deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");

			}	
		}
		public function servicecharge(){
			$_SESSION['page']	= 	"settings"; 
			$sql 	= 	"select * from settings  ";
			$settings 	= 	$this->select->get_single_row($sql);
			$array 		= 	array(
									"settings"	=> 	$settings
								);
			$this->load->view('admin/servicecharge',['array'	=>	$array]);
		}
		public function updategst(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("settings","settings_id",'1',$post))
			{
				$this->session->set_flashdata('gstmsg',"<div class='alert alert-success'>GST Details updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('gstmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/servicecharge'));
		}
		public function indidoc(){
			$_SESSION['page']='indidoc';
			$pendingdoc 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active, (select GROUP_CONCAT(qualification_specialization Separator ' , ') as specialisation from qualification where qualification_doctor_id=u.id) as specialisation FROM `users` u WHERE `user_type` = 4 AND `is_active` = 0 AND `user_clinic_id` = 0 ORDER BY `id` DESC LIMIT 5");
			 
			$activedoc 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active, (select GROUP_CONCAT(qualification_specialization Separator ' , ') as specialisation from qualification where qualification_doctor_id=u.id) as specialisation FROM `users` u WHERE `user_type` = 4 AND `is_active` = 1 AND `user_clinic_id` = 0 ORDER BY `id` DESC LIMIT 5");
			$countpendingdoc  	= 	$this->select->get_total_rows("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active, (select GROUP_CONCAT(qualification_specialization Separator ' , ') as specialisation from qualification where qualification_doctor_id=u.id) as specialisation FROM `users` u WHERE `user_type` = 4 AND `is_active` = 0 AND `user_clinic_id` = 0 ORDER BY `id`");
			$countactivedoc  	= 	$this->select->get_total_rows("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active, (select GROUP_CONCAT(qualification_specialization Separator ' , ') as specialisation from qualification where qualification_doctor_id=u.id) as specialisation FROM `users` u WHERE `user_type` = 4 AND `is_active` = 1  AND `user_clinic_id` = 0 ORDER BY `id`");

			$array 		= 	array(
									"activedoc"			=> 	$activedoc,
									"pendingdoc"		=> 	$pendingdoc,
									"countpendingdoc"	=> 	$countpendingdoc,
									"countactivedoc"	=> 	$countactivedoc,
								);
			//echo $this->db->last_query();
			$this->load->view('admin/indidoc',['array'	=> 	$array]); 
		}
		public function docdetails(){
			$_SESSION['page']	=	"doctors";
			$id			=	$this->uri->segment(3);
								
			$doc 		=	$this->select->get_single_row("SELECT * FROM `users` WHERE `id` = '$id' and (user_type=4 or user_type=5 or user_type=6)");
			//echo $this->db->last_query();
			//exit();
			if(count($doc)){
				$array 		=	array(
										'qualification_doctor_id'	=>	$this->uri->segment(3)
									);
				$edu 		=	$this->select->get_some_education($array);
				$array 		=	 array(
											'user_id'	=>	$this->uri->segment(3),
										);
				$timings 	=	$this->home->get_one_row("timings",$array,"*");
				
				 
				$array	=	array(
									'document_user_id'	=>	$this->uri->segment(3),
									);
				$document 	=	$this->select->get_some_documents($array);
				$id 		=	$this->uri->segment(3);
				$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc"); 
			 	if($doc['user_type'] == '4')
			 	{
			 		$array 				=	array('user_id'	=>	$id);
					$doc['address'] 	=	$this->select->get_one_address($array);
					$array 				=	array(
											"bank_ac_user_id"	=>	$id);
					$doc['account'] 	=	$this->home->get_one_row("bank_account",$array,"*");
			 	}
				$array 		=	array(
										'doc'		=>	$doc,
										'edu'		=>	$edu, 
										'timings'	=>	$timings,
										'document'	=>	$document, 
										'gallery'	=>	$gallery, 
									);
				//echo "<pre>";
				//print_r($array);
				$this->load->view('admin/docdetails',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function changeuserstatus(){
			$post 	= 	$_POST;
			//print_r($post);
			if($this->update->update_table("users","id",$post['id'],$post))
			{
				$this->session->set_flashdata('usermsg',"<div class='alert alert-success'>User status updated successfully.</div>");
				//echo 1;
			}
			else{
				$this->session->set_flashdata('usermsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				//echo 2;
			}
		}
		public function loginasuser(){
			$array 	= 	array("id"	=>	$_POST['id']); 
			if(isset($_SESSION['patient_id'])){
				unset($_SESSION['patient_id']);

			}
			if(isset($_SESSION['clinic_id'])){
				unset($_SESSION['clinic_id']);

			}
			if(isset($_SESSION['doctor_id'])){
				unset($_SESSION['doctor_id']);

			}
			if(isset($_SESSION['hospital_id'])){
				unset($_SESSION['hospital_id']);

			}
			if(isset($_SESSION['diagnosis_id'])){
				unset($_SESSION['diagnosis_id']);

			}
			$id = 	$_POST['id'];
			if($user = $this->select->get_single_row("select u.* ,uc.user_name as clinic_name from users u left join users uc on (u.user_clinic_id = uc.id) where u.id=$id")){
				$user_id	=	$user['id'];
				$_SESSION['user']	=	$user;
				$type =	$user['user_type'];
				if($type==1)
				{
					$_SESSION['patient_id']	=	$user_id;
					$url  = base_url('myprofile');
				}
				else if($type==2)
				{
					$_SESSION['clinic_id']	=	$user_id;
					$url  = base_url('Health/dashboard');					 
				}
				else if($type==3)
				{
					$_SESSION['hospital_id']	=	$user_id;
					$url = base_url('Health/dashboard');					
				}
				else if($type==4 || $type ==5 || $type ==6)
				{
					$_SESSION['doctor_id']	=	$user_id;
					$url 	= 	 base_url('Doc/dashboard');
				}
				else if($type==7)
				{
					$_SESSION['diagnosis_id']	=	$user_id;
					$url 	= 	base_url('Diagnosis/dashboard');
					
				}
				if($_POST['url']!='')
				{
					 $url 	= 	$_POST['url'];
				}
				echo $url;
				 				
			}
		}
		public function clinic(){
			$pendingclinic 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active,(select count(*) from users d where d.user_clinic_id= u.id) as doccount FROM `users` u WHERE `user_type` = 2 AND `is_active` = 0  ORDER BY `id` DESC LIMIT 5");
			$activeclinic 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active,(select count(*) from users d where d.user_clinic_id= u.id) as doccount FROM `users` u WHERE `user_type` = 2 AND `is_active` = 1   ORDER BY `id` DESC LIMIT 5");
			$countactiveclinic 	= 	$this->select->get_total_rows("SELECT `id` FROM `users` u WHERE `user_type` = 2 AND `is_active` = 1   ORDER BY `id`");
			$countpendingclinic 	= 	$this->select->get_total_rows("SELECT `id`  FROM `users` u WHERE `user_type` = 2 AND `is_active` = 0   ORDER BY `id`  ");
			$array 	= 	array(
								"user_type" => 5,
								"is_active" => 1,
							);
			$activeclinicdoc	= 	$this->select->count_some_users($array); 
			$array 	= 	array(
								"user_type" => 5,
								"is_active" => 0,
							);
			$pendingclinicdoc	= 	$this->select->count_some_users($array); 
			$array 	= 	array(
								"pendingclinic"			=> 	$pendingclinic,
								"activeclinic"			=> 	$activeclinic,
								"countactiveclinic"		=> 	$countactiveclinic,
								"countpendingclinic"	=> 	$countpendingclinic,
								"activeclinicdoc"		=> 	$activeclinicdoc,
								"pendingclinicdoc"		=> 	$pendingclinicdoc,
							);
			$this->load->view('admin/clinic',['array'	=> 	$array]);
		}

		public function pendingclinic(){
			$_SESSION['page']	=	"clinic";
			$array 	=	array(
								'user_type'			=>			2,
								'is_active'			=>			0,
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('hosadmin/activeclinic'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$clinic	=	$this->home->get_some_row("users u",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_image,(select count(*) from users d where d.user_clinic_id= u.id) as doccount",$config['per_page'],$this->uri->segment(3),'id','Desc');
			$array 	=	array(
								"clinic"	=>	$clinic,
								"status"	=>	"Pending",
							);
			$this->load->view('admin/activeclinic',['array'	=>	$array]);
		}
		public function activeclinic(){
			$_SESSION['page']	=	"clinic";
			$array 	=	array(
								'user_type'			=>			2,
								'is_active'			=>			1,
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('hosadmin/activeclinic'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$clinic	=	$this->home->get_some_row("users u",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_image,(select count(*) from users d where d.user_clinic_id= u.id) as doccount",$config['per_page'],$this->uri->segment(3),'id','Desc');
			$array 	=	array(
								"clinic"	=>	$clinic,
								"status"	=>	"Active",
							);
			$this->load->view('admin/activeclinic',['array'	=>	$array]);
		}
		public function clinicdetails(){
			$_SESSION['page']	=	"clinic";
			$id			=	$this->uri->segment(3);
								
			$clinic 		=	$this->select->get_single_row("SELECT * FROM `users` WHERE `id` = '$id' and user_type=2");
			//echo $this->db->last_query();
			//exit();
			if(count($clinic)){
			 	//timings
				$array 		=	 array(
											'user_id'	=>	$this->uri->segment(3),
										);
				$timings 	=	$this->home->get_one_row("timings",$array,"*");
				//certi
				$array 	=	array(
								"user_id"	=>	$this->uri->segment(3),
							);
				$certi 	=	$this->home->get_one_row("clinic",$array,"*");
				//gallery
				$id 		=	$this->uri->segment(3);
				$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc"); 
			 	//address
			 	$array 				=	array('user_id'	=>	$id);
				$clinic['address'] 	=	$this->select->get_one_address($array);
				//account
				$array 				=	array(
											"bank_ac_user_id"	=>	$id);
				$clinic['account'] 	=	$this->home->get_one_row("bank_account",$array,"*");
			 	
			 	//service
			 	$array 				=	array(
											"user_id"	=>	$this->uri->segment(3),
										);
				$services 			=	$this->select->get_clinic_services($array); 

				//specialisation
				$array 	=	array(
							'qualification_doctor_id'		=>		$this->uri->segment(3),
							);
				$qualification 	=	$this->select->get_some_education($array);

				//doctor
				$where	=	array('user_clinic_id'	=>	$this->uri->segment(3));
				$clinic['doc'] 	=	$this->home->get_all_row('users',$where,'*','id','desc');
				$array 		=	array(
										'clinic'		=>	$clinic,
										'gallery'		=>	$gallery, 
										'timings'		=>	$timings,
										'services'		=>	$services, 
										'gallery'		=>	$gallery, 
										'certi'			=>	$certi, 
										'qualification'	=>	$qualification, 
									);
				//echo "<pre>";
				//print_r($array);
				$this->load->view('admin/clinicdetails',['array'	=>	$array]);
			}
			else{
				$this->load->view('home/error404');
			}
		}
		public function activeindidoc(){
			$array 	= 	array(
								"user_type"		  =>	4,
								"is_active"  	  =>	1,
								"user_clinic_id"  =>	0,
							);
			$doc 	= 	$this->get_some_user($array,base_url('hosadmin/activeindidoc'));
			$array 	= 	array(
								"doc"		=> 	$doc,
								"header"	=> 	"Active Individual Doctor",
							);
			$this->load->view('admin/doclist',['array'	=> 	$array]);
		}
		public function pendingindidoc(){
			$array 	= 	array(
								"user_type"		  =>	4,
								"is_active"  	  =>	0,
								"user_clinic_id"  =>	0,
							);
			$doc 	= 	$this->get_some_user($array,base_url('hosadmin/pendingindidoc'));
			$array 	= 	array(
								"doc"		=> 	$doc,
								"header"	=> 	"Pending Individual Doctor",
							);
			$this->load->view('admin/doclist',['array'	=> 	$array]);
		}
		public function get_some_user($array,$url){
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		$url,
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$user	=	$this->home->get_some_row("users",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_image,user_fee",$config['per_page'],$this->uri->segment(3),'id','Desc');
			return $user;
		}
		public function diagnosis(){
			$_SESSION['page']='diagnosis';
			$pendingdoc 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image`,is_active FROM `users` u WHERE `user_type` = 7 AND `is_active` = 0   ORDER BY `id` DESC LIMIT 5");
			 
			$activedoc 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image`,is_active FROM `users` u WHERE `user_type` = 7 AND `is_active` = 1   ORDER BY `id` DESC LIMIT 5");
			$countpendingdoc  	= 	$this->select->get_total_rows("SELECT `id` FROM `users` u WHERE `user_type` = 7 AND `is_active` = 0 ");
			$countactivedoc  	= 	$this->select->get_total_rows("SELECT `id` FROM `users` u WHERE `user_type` = 7 AND `is_active` = 1 ");

			$array 		= 	array(
									"activedoc"			=> 	$activedoc,
									"pendingdoc"		=> 	$pendingdoc,
									"countpendingdoc"	=> 	$countpendingdoc,
									"countactivedoc"	=> 	$countactivedoc,
								);
			//echo $this->db->last_query();
			$this->load->view('admin/diagnosis',['array'	=> 	$array]); 	
		}
		public function activediagnosis(){
			$array 	= 	array(
								"user_type"		  =>	7,
								"is_active"  	  =>	1, 
							);
			$doc 	= 	$this->get_some_user($array,base_url('hosadmin/activediagnosis'));
			$array 	= 	array(
								"doc"		=> 	$doc,
								"header"	=> 	"Active Diagnosis",
							);
			$this->load->view('admin/diagnosislist',['array'	=> 	$array]);	
		}
		public function pendingdiagnosis(){
			$array 	= 	array(
								"user_type"		  =>	7,
								"is_active"  	  =>	0, 
							);
			$doc 	= 	$this->get_some_user($array,base_url('hosadmin/pendingdiagnosis'));
			$array 	= 	array(
								"doc"		=> 	$doc,
								"header"	=> 	"Pending Diagnosis",
							);
			$this->load->view('admin/diagnosislist',['array'	=> 	$array]);
		}
		public function diagnosisdetails(){
			$_SESSION['page']	=	"doctors";
			$id			=	$this->uri->segment(3);
								
			$doc 		=	$this->select->get_single_row("SELECT * FROM `users` WHERE `id` = '$id' and user_type=7");
			//echo $this->db->last_query();
			//exit();
			if(count($doc)){
				 
				$array 		=	 array(
											'user_id'	=>	$this->uri->segment(3),
										);
				$timings 	=	$this->home->get_one_row("timings",$array,"*");
				
				 
				 
				$id 		=	$this->uri->segment(3);
				$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc"); 
			 	$array 				=	array('user_id'	=>	$id);
				$doc['address'] 	=	$this->select->get_one_address($array);
				$array 				=	array(
											"bank_ac_user_id"	=>	$id);
				$doc['account'] 	=	$this->home->get_one_row("bank_account",$array,"*");
			 	 
				$cat 				=	$this->select->get_questions("select t.* from test_category t inner join diagnosis_category d on (d.cat_id = t.id) where d.user_id = '$id' order by cat_name asc");
				$array 	=	array(
								"user_id"	=>	$id
							);
				$certi 	=	$this->home->get_one_row("clinic",$array,"*");
				$array 		=	array(
										'doc'		=>	$doc,
										'cat'		=>	$cat, 
										'timings'	=>	$timings,
										'certi'		=>	$certi, 
										'gallery'	=>	$gallery, 
									);
				//echo "<pre>";
				//print_r($array);
				$this->load->view('admin/diagnosisdetails',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function showtests(){
			$post 	=	$_POST;
			//$post['test_path_id']	=	$post['user_id'];
			$test 	=	$this->home->get_all_row("test",$post,"*",'test_name','ASC');
			if(count($test))
			{
				?>
				<table class="table table-responsive table-striped table-bordered">
				<?php
				$i=0;
				foreach($test as $x)
				{
					?>
					<tr>
						<td class="hidden-xs"><?= ++$i;?>.</td>
						<td><?= $x['test_name'];?></td>
						<td class="hidden-xs">&#x20B9; <?= $x['test_price'];?></td>
						 
					</tr>
					<?php
				}
				?>
				</table>
				<?php
			}
			else{
				echo "No Tests Found";
			}
		}
		public function hospital(){
			$pendingclinic 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active,(select count(*) from users d where d.user_clinic_id= u.id) as doccount FROM `users` u WHERE `user_type` = 3 AND `is_active` = 0  ORDER BY `id` DESC LIMIT 5");
			$activeclinic 	= 	$this->select->get_questions("SELECT `id`, `user_name`, `user_email`, `user_mob`, `user_alt_mob`, `user_image` , user_fee,is_active,(select count(*) from users d where d.user_clinic_id= u.id) as doccount FROM `users` u WHERE `user_type` = 3 AND `is_active` = 1   ORDER BY `id` DESC LIMIT 5");
			$countactiveclinic 	= 	$this->select->get_total_rows("SELECT `id` FROM `users` u WHERE `user_type` = 3 AND `is_active` = 1   ORDER BY `id`");
			$countpendingclinic 	= 	$this->select->get_total_rows("SELECT `id`  FROM `users` u WHERE `user_type` = 3 AND `is_active` = 0   ORDER BY `id`  ");
			$array 	= 	array(
								"user_type" =>6,
								"is_active" =>1,
							);
			$activehosdoc	= 	$this->select->count_some_users($array);
			$array 	= 	array(
								"user_type" =>6,
								"is_active" =>0,
							);
			$pendinghosdoc	= 	$this->select->count_some_users($array); 
			$array 	= 	array(
								"pendingclinic"			=> 	$pendingclinic,
								"activeclinic"			=> 	$activeclinic,
								"countactiveclinic"		=> 	$countactiveclinic,
								"countpendingclinic"	=> 	$countpendingclinic,
								"activehosdoc"			=> 	$activehosdoc,
								"pendinghosdoc"			=> 	$pendinghosdoc,
							);
			$this->load->view('admin/hospital',['array'	=> 	$array]);
		}
		public function activehospital(){ 
			$_SESSION['page']	=	"hospital";
			$array 	=	array(
								'user_type'			=>			3,
								'is_active'			=>			1,
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('hosadmin/activehospital'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$clinic	=	$this->home->get_some_row("users u",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_image,(select count(*) from users d where d.user_clinic_id= u.id) as doccount",$config['per_page'],$this->uri->segment(3),'id','Desc');
			$array 	=	array(
								"hos"	=>	$clinic,
								"header"	=>	"Active Hospital",
							);
			$this->load->view('admin/hoslist',['array'	=>	$array]);
		}
		public function pendinghospital(){
			$_SESSION['page']	=	"hospital";
			$array 	=	array(
								'user_type'			=>			3,
								'is_active'			=>			0,
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('hosadmin/pendinghospital'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$clinic	=	$this->home->get_some_row("users u",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_image,(select count(*) from users d where d.user_clinic_id= u.id) as doccount",$config['per_page'],$this->uri->segment(3),'id','Desc');
			$array 	=	array(
								"hos"	=>	$clinic,
								"header"	=>	"Pending Hospital",
							);
			$this->load->view('admin/hoslist',['array'	=>	$array]);
		}
		public function hosdetails(){
			$_SESSION['page']	=	"clinic";
			$id			=	$this->uri->segment(3);
								
			$clinic 		=	$this->select->get_single_row("SELECT * FROM `users` WHERE `id` = '$id' and user_type=3");
			 
			if(count($clinic)){
			 	//timings
				$array 		=	 array(
											'user_id'	=>	$this->uri->segment(3),
										);
				$timings 	=	$this->home->get_one_row("timings",$array,"*");
				//certi
				$array 	=	array(
								"user_id"	=>	$this->uri->segment(3),
							);
				$certi 	=	$this->home->get_one_row("clinic",$array,"*");
				//gallery
				$id 		=	$this->uri->segment(3);
				$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc"); 
			 	//address
			 	$array 				=	array('user_id'	=>	$id);
				$clinic['address'] 	=	$this->select->get_one_address($array);
				//account
				$array 				=	array(
											"bank_ac_user_id"	=>	$id);
				$clinic['account'] 	=	$this->home->get_one_row("bank_account",$array,"*");
			 	
			 	//service
			 	$array 				=	array(
											"user_id"	=>	$this->uri->segment(3),
										);
				$services 			=	$this->select->get_clinic_services($array); 

				//specialisation
				$array 	=	array(
							'qualification_doctor_id'		=>		$this->uri->segment(3),
							);
				$qualification 	=	$this->select->get_some_education($array);

				$array 	=	array(
								"user_id"	=>	$id
							);
				$hos_dept 	=	$this->home->get_all_row("hos_department",$array,"*","dept_id","asc");
				if(count($hos_dept))
				{
					$i=0;
					foreach($hos_dept as $x){
						if($x['dept_id']==1)
						{
							$hos_dept[$i]['name'] ="Clinical";
						}
						else if($x['dept_id']==2)
						{
							$hos_dept[$i]['name'] ="Para-Clinical";
						}
						else if($x['dept_id']==3)
						{
							$hos_dept[$i]['name'] ="Non-Clinical";
						}
						$subdept_id = explode(",",$x['subdept_id']); 
						$hos_dept[$i++]['subdept'] 	= 	$this->select->get_some_subdepartment($subdept_id);
						//echo $this->db->last_query()."<br>";
					}
				}
				$doc = $this->select->get_questions("select u.id as id,user_name,user_image,user_fee,is_active,s.name as subdept_name from users u left join subdepartment s on (s.id=u.user_subdept_id) where user_clinic_id='$id' ");
				 
				$array 		=	array(
										'clinic'		=>	$clinic,
										'gallery'		=>	$gallery, 
										'timings'		=>	$timings,
										'services'		=>	$services, 
										'gallery'		=>	$gallery, 
										'certi'			=>	$certi, 
										'qualification'	=>	$qualification, 
										'hos_dept'		=>	$hos_dept, 
										'doc'			=>	$doc, 
									);
				//echo "<pre>";
				//print_r($hos_dept);
				$this->load->view('admin/hosdetails',['array'	=>	$array]);
					
			}
			else{
				$this->load->view('home/error404');
			}
		}
		public function states(){
			$_SESSION['page'] =
			$array 	= 	array('country_id' 	=> 	'101');
			$states = 	$this->home-> get_all_row("states",$array,"*",'name','ASC');
			$array 	= 	array("states"	=> 	$states);
			$this->load->view('admin/states',['array'	=> 	$array]);
		}
		public function storestate(){
			$post 	= 	$_POST;
			//echo "<pre>";
			//print_r($post);
			if($this->home->checkrow($post,"states")){
				$this->session->set_flashdata('statemsg',"<div class='alert alert-warning'>This state is already added.</div>");
			}
			else{
				if($this->insert->insert_table($post,"states"))
				{
					$this->session->set_flashdata('statemsg',"<div class='alert alert-success'>State added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('statemsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			return redirect (base_url('hosadmin/states'));
		}
		public function delstate(){
			$post 	= 	$_POST;
			$this->load->model('delete');
			if($this->delete->delete_table($post,"states"))
			{
				$this->session->set_flashdata('statemsg',"<div class='alert alert-success'>State deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('statemsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			echo 1;
		}
		public function updatestate(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("states","id",$post['id'],$post))
			{
				$this->session->set_flashdata('statemsg',"<div class='alert alert-success'>State updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('statemsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/states'));
		}
		public function citylist(){
			$state_id 	= 	$this->uri->segment(3);
			$array 		= 	array('state_id'	=> 	$state_id);
			$cities 	= 	$this->home->get_all_row("city",$array,"*",'name','ASC');
			$array 		= 	array('id'	=> 	$state_id);
			$state 		= 	$this->home->get_one_row("states",$array,"*");
			$array 		= 	array(
									"state"		=> 	$state,
									"cities"		=> 	$cities,
								);
			$this->load->view('admin/cities',['array'	=> 	$array]);
		}
		public function storecity(){
			$post 	= 	$_POST;
			//echo "<pre>";
			//print_r($post);
			if($this->home->checkrow($post,"city")){
				$this->session->set_flashdata('citymsg',"<div class='alert alert-warning'>This city is already added.</div>");
			}
			else{
				if($this->insert->insert_table($post,"city"))
				{
					$this->session->set_flashdata('citymsg',"<div class='alert alert-success'>City added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('citymsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			return redirect (base_url('hosadmin/citylist/'.$post['state_id']));
		}
		public function delcity(){
			$post 	= 	$_POST;
			$this->load->model('delete');
			if($this->delete->delete_table($post,"city"))
			{
				$this->session->set_flashdata('citymsg',"<div class='alert alert-success'>City deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('citymsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			echo 1;	
		}
		public function updatecity(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("city","id",$post['id'],$post))
			{
				$this->session->set_flashdata('citymsg',"<div class='alert alert-success'>City updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('citymsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/citylist/'.$post['state_id']));
		}
		public function localitylist(){
			$city_id 	= 	$this->uri->segment(3);



			$array 		= 	array('city_id'	=> 	$city_id);
			$localities	= 	$this->home->get_all_row("locality",$array,"*",'name','ASC');
			$array 		= 	array('id'	=> 	$city_id);
			$city 		= 	$this->home->get_one_row("city",$array,"*");
			$array 		= 	array('id'	=> 	$city['state_id']);
			$state 		= 	$this->home->get_one_row("states",$array,"*");
			$array 		= 	array(
									"state"		=> 	$state,
									"city"		=> 	$city,
									"localities"		=> 	$localities,
								);
			//echo "<pre>";
			//print_r($localities);
			$this->load->view('admin/locality',['array'	=> 	$array]);
		}
		public function storelocality(){
			$post 	= 	$_POST;
			//echo "<pre>";
			//print_r($post);
			if($this->home->checkrow($post,"locality")){
				$this->session->set_flashdata('localmsg',"<div class='alert alert-warning'>This locality is already added.</div>");
			}
			else{
				if($this->insert->insert_table($post,"locality"))
				{
					$this->session->set_flashdata('localmsg',"<div class='alert alert-success'>Locality added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('localmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			return redirect (base_url('hosadmin/localitylist/'.$post['city_id']));
		}
		public function dellocality(){
			$post 	= 	$_POST;
			$this->load->model('delete');
			if($this->delete->delete_table($post,"locality"))
			{
				$this->session->set_flashdata('localmsg',"<div class='alert alert-success'>Locality deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('localmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			echo 1;
		}
		public function updatelocality(){
			$post 	= 	$this->input->post();
			if($this->update->update_table("locality","id",$post['id'],$post))
			{
				$this->session->set_flashdata('localmsg',"<div class='alert alert-success'>Locality updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('localmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/localitylist/'.$post['city_id']));
		}
		public function myrevenue(){
			$_SESSION['page']	=	"myrevenue"; 
			$m = $_GET['m'];
			$y = $_GET['y'];
			$today 	= 	date('Y-m-d');
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($y.'-'.$m.'-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'ap_payment'			=>	1,
										'ap_status'				=>	1,	
										'ap_date'				=>	$date,	 
									);				
				
				//print_r($array);
				$monrev[$i]		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;
				 
			} 
			$array 	=	array(
								'monrev'	=>	$monrev,
								'm'			=>	$m,
								'y'			=>	$y, 
								);
			$indidoc  = 	$this->select->get_questions("select u.id,u.user_name,(select sum(ap_money) as month from appointment where ap_payment = '1' and ap_status = '1' and MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id=u.id) as month, (select sum(ap_money) as today from appointment where ap_payment = '1' and ap_status = '1' and ap_date = '$date'  and ap_doctor_id=u.id) as today  from users u where u.is_active='1' and u.user_type='4'" );
			$diagnosis  = 	$this->select->get_questions("select u.id,u.user_name,(select sum(ap_money) as month from appointment where ap_payment = '1' and ap_status = '1' and MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id=u.id) as month, (select sum(ap_money) as today from appointment where ap_payment = '1' and ap_status = '1' and ap_date = '$date'  and ap_doctor_id=u.id) as today  from users u where u.is_active='1' and u.user_type='7'" );
			
			$clinic = $this->select->get_questions("select u.id,u.user_name,(select GROUP_CONCAT(d.id Separator ',') as doc_id from users d where d.user_clinic_id=u.id) as doc_id from users u where u.is_active='1' and u.user_type='2' ");
			if(count($clinic))
			{
				$i=0;
				foreach($clinic as $x)
				{
					$doc_ids 	= 	explode(",",$x['doc_id']);					 
					$array 	= 	array(
										"ap_payment"		=> 	1,
										"ap_status"			=> 	1,
										'YEAR(ap_date)'		=> 	$y,
										'MONTH(ap_date)'	=> 	$m,
									);
					$clinic[$i]['month']  	= 	$this->select->get_clinic_addedrevenue($array,$doc_ids)['ap_money'];
					$array 	= 	array(
										"ap_payment"		=> 	1,
										"ap_status"			=> 	1, 
										"ap_date" 			=> 	$today
									);
					$clinic[$i++]['today']  	= 	$this->select->get_clinic_addedrevenue($array,$doc_ids)['ap_money'];
					//echo $this->db->last_query()."<br>";
				}
			}
			$hospital = $this->select->get_questions("select u.id,u.user_name,(select GROUP_CONCAT(d.id Separator ',') as doc_id from users d where d.user_clinic_id=u.id) as doc_id from users u where u.is_active='1' and u.user_type='3' ");
			if(count($clinic))
			{
				$i=0;
				foreach($hospital as $x)
				{
					$doc_ids 	= 	explode(",",$x['doc_id']);					 
					$array 	= 	array(
										"ap_payment"		=> 	1,
										"ap_status"			=> 	1,
										'YEAR(ap_date)'		=> 	$y,
										'MONTH(ap_date)'	=> 	$m,
									);
					$hospital[$i]['month']  	= 	$this->select->get_clinic_addedrevenue($array,$doc_ids)['ap_money'];
					$array 	= 	array(
										"ap_payment"		=> 	1,
										"ap_status"			=> 	1, 
										"ap_date" 			=> 	$today
									);
					$hospital[$i++]['today']  	= 	$this->select->get_clinic_addedrevenue($array,$doc_ids)['ap_money'];
					//echo $this->db->last_query()."<br>";
				}
			}
			$array 	= 	array(
								"clinic"		=> 		$clinic,
								"hospital"		=> 		$hospital,
								"diagnosis"		=> 		$diagnosis,
								"indidoc"		=> 		$indidoc,
								"monrev"		=> 		$monrev,
							);
			$this->load->view('admin/myrevenue',['array'	=>	$array]);
		}
		public function appointment(){
			$_SESSION['page']	=	"appointment"; 
			$m = $_GET['m'];
			$y = $_GET['y'];
			$today 	= 	date('Y-m-d');
			//echo $today;
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($y.'-'.$m.'-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'ap_payment'			=>	1,
										'ap_status'				=>	1,	
										'ap_date'				=>	$date,	 
									);				
				
				//print_r($array);
				$monrev[$i]['ap_money']		=	$this->select->count_all_appointments($array);
				$monrev[$i]['date']		=	$date;
				 
			} 
			$array 	=	array(
								'monrev'	=>	$monrev,
								'm'			=>	$m,
								'y'			=>	$y, 
								);
			$indidoc  = 	$this->select->get_questions("select u.id,u.user_name,(select count(ap_money) as month from appointment where ap_payment = '1' and ap_status = '1' and MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id=u.id) as month, (select count(ap_money) as today from appointment where ap_payment = '1' and ap_status = '1' and ap_date = '$today'  and ap_doctor_id=u.id) as today  from users u where u.is_active='1' and u.user_type='4'" );
		 
			$diagnosis  = 	$this->select->get_questions("select u.id,u.user_name,(select count(ap_money) as month from appointment where ap_payment = '1' and ap_status = '1' and MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id=u.id) as month, (select count(ap_money) as today from appointment where ap_payment = '1' and ap_status = '1' and ap_date = '$today'  and ap_doctor_id=u.id) as today  from users u where u.is_active='1' and u.user_type='7'" );
			
			$clinic = $this->select->get_questions("select u.id,u.user_name,(select GROUP_CONCAT(d.id Separator ',') as doc_id from users d where d.user_clinic_id=u.id) as doc_id from users u where u.is_active='1' and u.user_type='2' ");
			if(count($clinic))
			{
				$i=0;
				foreach($clinic as $x)
				{
					//$doc_ids 	= 	explode(",",$x['doc_id']);					 
					$doc_ids 	= 	$x['doc_id'];	
					if($doc_ids=='')
					{
						$doc_ids = 0;
					}		 
					$clinic[$i]['month']		=	$this->select->get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and MONTH(ap_date)='$m' and YEAR(ap_date)='$y' and ap_doctor_id in ($doc_ids)")['number'];
					 
					$clinic[$i++]['today']  	= 	$this->select->	get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and ap_date='$today' and ap_doctor_id in ($doc_ids)")['number'];
					//echo $this->db->last_query()."<br>";
				}
			}
			$hospital = $this->select->get_questions("select u.id,u.user_name,(select GROUP_CONCAT(d.id Separator ',') as doc_id from users d where d.user_clinic_id=u.id) as doc_id from users u where u.is_active='1' and u.user_type='3' ");
			if(count($hospital))
			{
				$i=0;
				foreach($hospital as $x)
				{
					//$doc_ids 	= 	explode(",",$x['doc_id']);					 
					$doc_ids 	= 	$x['doc_id'];	
					if($doc_ids=='')
					{
						$doc_ids = 0;
					}		 
					$hospital[$i]['month']		=	$this->select->get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and MONTH(ap_date)='$m' and YEAR(ap_date)='$y' and ap_doctor_id in ($doc_ids)")['number'];
					 
					$hospital[$i++]['today']  	= 	$this->select->	get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and ap_date='$today' and ap_doctor_id in ($doc_ids)")['number'];
					//echo $this->db->last_query()."<br>";
				}
			}
			 
			$array 	= 	array(
								"clinic"		=> 		$clinic,
								"hospital"		=> 		$hospital,
								"diagnosis"		=> 		$diagnosis,
								"indidoc"		=> 		$indidoc,
								"monrev"		=> 		$monrev,
							);
			 
			$this->load->view('admin/appointment',['array'	=>	$array]);
		}
		public function trending(){
			$_SESSION['trending'] = 'trending';
			$clinic 	=	$this->select->get_questions("select * from users where user_trending=1 and (user_type='2' or user_type='3') order by user_trending_order desc" );	
			$array 	= 	array(
								"clinic"	=> 		$clinic
							);
			$this->load->view('admin/trending',['array' 	=> 	$array]);
		}
		public function searchtrendingclinic(){
			$post 	= 	$_POST;
			 
			$clinic 	= 	$this->select->get_untrendingclinic($post['user_name']);
			 
			if(count($clinic))
			{
				?><table class="table table-responsive"><?php
				foreach ($clinic as $x) {
					?>
						<tr>
							<td><?= $x['user_name'];?></td>
							<td><button class="btn btn-primary" onclick="addtrending('<?= $x['id']; ?>');"><i class="fa fa-plus"></i></button></td>
						</tr>
					<?php
				}
				?></table><div class="clearfix"></div><?php
			}

		}
		public function addtrendingclinic(){
			$post 	= 	$_POST;
			//$array 	= 	array("user_trending" => 1);
			$this->update->update_table("users","id",$post['id'],$post);
			echo 1;

		}
		public function saveordertrending(){
			$post 	= 	$_POST;
			//echo "<pre>";
			//print_r($post);
			$ids = explode(",",$post['row_order']);
			$count 	= 	count($ids);
			if($count)
			{
				foreach($ids as $x)
				{
					$array 	= 	array(
										"user_trending_order" 	=> 	$count--,
										"id" 				=> 	$x,

									);
					$this->update->update_table("users","id",$array['id'],$array);

				}
			}
			return redirect(base_url('hosadmin/trending'));

		}
		public function changepassword()
		{
			$_SESSION['page']='settings';
			$this->load->view('admin/changepassword');
		}
		public function updatepassword()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
								'password'	=>	$post['password1'],
								'admin_id'	=>	1,
								);
			if($post['password2']!=	$post['password3'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Passwords do not match</div>');
				 
			}
			else if(!$this->select->checkadminlogin($array))
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old Password does not match</div>');
				 
			}
			else 
			{
				$array	=	array('password'	=>	$post['password2']);
				if($this->update->update_table('admin','admin_id',1,$array))
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-success">Password changed successfully</div>');
					
				}
				else
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">system failure. Please try later</div>');
					 
				}
			}
			return redirect(base_url('home/changepassword'));
		}
		public function changemobile()
		{
			$_SESSION['page']='settings';
			$admin  = 	$this->home->get_one_row("admin",array("admin_id"	=> 	1),"*");
			$array 	= 	array(
								"admin"		=> 	$admin
							);

			$this->load->view('admin/changemobile',['array'	=> 	$array]);
		}
		public function updatemobile(){
			$post 	= 	$_POST; 
			if($this->update->update_table('admin','admin_id',1,$post))
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-success">Phone changed successfully</div>');
				
			}
			else
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">system failure. Please try later</div>');
				 
			}
			return redirect (base_url('hosadmin/changemobile'));
		}
		public function changeemail()
		{
			$_SESSION['page']='settings';
			$this->load->view('admin/changeemail');
		}
		public function updateemail()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			$array	=	array(
								'username'	=>	$post['email1'],
								'admin_id'	=>	1,
								);
			if($post['email2']!=	$post['email3'])
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Emails do not match</div>');
				 
			}
			else if(!$this->select->checkadminlogin($array))
			{
				$this->session->set_flashdata('passmsg','<div class="alert alert-danger">Old email does not match</div>');
				 
			}
			else 
			{
				$array	=	array('username'	=>	$post['email2']);
				if($this->update->update_table('admin','admin_id',1,$array))
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-success">Email changed successfully</div>');
					
				}
				else
				{
					$this->session->set_flashdata('passmsg','<div class="alert alert-danger">system failure. Please try later</div>');
					 
				}
			}
			return redirect(base_url('hosadmin/changeemail'));
		}
		public function changepic()
		{
			$_SESSION['page']='settings';
			$this->load->helper('form');
			$this->load->view('admin/changepic');
		}
		public function storeimage()
		{
			
			$post	=	$this->input->post();
			echo "<pre>";
			print_r($post);
			$config['upload_path']          = './img/admin';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['file_name']      		= 'admin.png';
/* 			$config['max_size']             = 100;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
 */
			$this->load->library('upload', $config);
			@unlink('./img/admin/admin.png');
			if ( ! $this->upload->do_upload('userfile'))
			{
				//$data = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('picmsg','<div class="alert alert-danger">'. $this->upload->display_errors().'</div>');	
					
			}
			else
			{
					$data = array('upload_data' => $this->upload->data());

					//$this->load->view('upload_success', $data);
					$this->session->set_flashdata('picmsg','<div class="alert alert-success">Image Uploaded Successfully. </div>');
			}
			return redirect(base_url('hosadmin/changepic'));
		}
		public function delusers()
		{
			$_SESSION['page']='settings';
			$this->load->view('admin/delusers');
		}
		public function findsomeusers(){
			 
			$post 	= 	$_POST;
			//print_r($post);
			$user 	= 	$this->home->get_one_row("users",$post,"*");
			if(count($user))
			{
				?>
				<table class="table table-responsive">
				 
				 	<tr>
				 		<th>Name</th>
				 		<th>Action</th>
				 	</tr>
					<tr>
						<td><b><?= $user['user_name'];?></b></td>
						<td><button class="btn btn-danger" onclick="delnow('<?= $user['id'];?>');"><i class="fa fa-trash"></i></button></td>
					</tr>
				 
				 
				</table>
				<?php
			}
			else{
				echo "No user found";
			}
		}	
		public function deluser(){
			$post 	= 	$_POST;
			$this->load->model('delete');
			if($this->delete->delete_table($post,"users"))
			{
				$this->session->set_flashdata('delmsg',"<div class='alert alert-success'>User deleted successfully.</div>");
			}
			else{
				$this->session->set_flashdata('delmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}	
		}
		public function searchbyname(){
			$q 	= 	$_GET['q'];
			$sql = "select user_name,user_type,id from users where user_name like '%$q%' order by user_type asc";
			$users 	= 	$this->select->get_questions($sql);
			$array 	= 	array(
								"users"		=>	 $users
							);
			$this->load->view('admin/searchbyname',['array'	=>	 $array]);
		}
		public function getuserbylocation(){
			$_SESSION['page'] = "getuserbylocation";
			$array 	= 	array('country_id' => 101);
			$state 	= 	$this->home->get_all_row("states",$array,"*",'name','ASC');
			$array 	= 	array('state'	=> 	$state);
			$this->load->view('admin/getuserbylocation',['array'	=> 	$array]);
		}
		public function getsomeusersbycity(){
			$post 	= 	$_POST;
			$city = $post['city'];
			$locality = $post['locality'];
			$condition ="a.city = '$city'";
			if($locality!='')
			{
				$condition .=" and a.location = '$locality' ";
			}
			
			$indidoc = $this->select->get_questions("select user_name,user_type,u.id,u.created_at from users u inner join address a on a.user_id = u.id where $condition and user_type = 4");
			$clinic = $this->select->get_questions("select user_name,user_type,u.id,u.created_at from users u inner join address a on a.user_id = u.id where $condition and user_type = 2");
			$hos = $this->select->get_questions("select user_name,user_type,u.id,u.created_at from users u inner join address a on a.user_id = u.id where $condition and user_type = 3");
			$diagnosis = $this->select->get_questions("select user_name,user_type,u.id,u.created_at from users u inner join address a on a.user_id = u.id where $condition and user_type = 7");
			$clinicdoc = $this->select->get_questions("select u.user_name,u.user_type,u.id,u.created_at,uc.user_name as clinic_name,uc.id as clinic_id from users u inner join users uc on (uc.id =u.user_clinic_id) inner join  address a on a.user_id = uc.id where $condition and uc.user_type = 2");
			$hosdoc = $this->select->get_questions("select u.user_name,u.user_type,u.id,u.created_at,uc.user_name as clinic_name,uc.id as clinic_id from users u inner join users uc on (uc.id =u.user_clinic_id) inner join  address a on a.user_id = uc.id where $condition and uc.user_type = 3");
			?>
			<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Individual Doctor</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($indidoc))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($indidoc as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td><a href="<?= base_url('hosadmin/docdetails/'.$x['id']);?>">Dr. <?= $x['user_name'];?></a></td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
		    <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Clinic Doctor</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($indidoc))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($clinicdoc as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td>
		        							<a href="<?= base_url('hosadmin/docdetails/'.$x['id']);?>">Dr. <?= $x['user_name'];?></a>
		        							<br>(<a href="<?= base_url('hosadmin/clinicdetails/'.$x['clinic_id']);?>"><?= $x['clinic_name'];?>)</a>
		        						</td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
		    <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Hospital Doctor</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($hosdoc))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($hosdoc as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td>
		        							<a href="<?= base_url('hosadmin/docdetails/'.$x['id']);?>">Dr. <?= $x['user_name'];?></a>
		        							<br>(<a href="<?= base_url('hosadmin/clinicdetails/'.$x['clinic_id']);?>"><?= $x['clinic_name'];?>)</a>
		        						</td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
		    <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Diagnosis</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($diagnosis))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($diagnosis as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td><a href="<?= base_url('hosadmin/diagnosisdetails/'.$x['id']);?>"><?= $x['user_name'];?></a></td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
		    <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Clinic</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($clinic))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($clinic as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td><a href="<?= base_url('hosadmin/clinicdetails/'.$x['id']);?>"><?= $x['user_name'];?></a></td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
		    <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Hospital</h3>		           
		        </div>
		        <div class="box-body">
		        	<?php
		        		if(count($hos))
		        		{
		        			$i=0;
		        			?>
		        			<table class="table table-responsive">
		        			<?php
		        			foreach ($hos as $x) {
		        				?>
		        					<tr>
		        						<td><?= ++$i; ?>.</td>
		        						<td><a href="<?= base_url('hosadmin/hosdetails/'.$x['id']);?>"><?= $x['user_name'];?></a></td>
		        						<td>Member Since : <?= date("d M,Y",strtotime($x['created_at']));?></td>
		        					</tr>
		        				<?php
		        			}
		        			?>
		        			</table>
		        			<?php
		        		}
		        		else{
		        			echo "No records found.";
		        		}
		        	?>
		        </div>
		    </div>
			<?php 
		}
		public function  patientdetails(){
			$id 	= 	$this->uri->segment(3);
			$array 	= 	array("id"	=> 	$id);
			$user 	= 	$this->select->get_one_user($array);
			if(!count($user))
			{
				return redirect(base_url('Error404'));
			}
			$array 	= 	array(
								"user"	=> 	$user
							);
			$this->load->view('admin/patientdetails',['array'	=> 	$array]);
		}
		public function test_category(){
			$_SESSION['page'] 	= 	"test_category";
			$cat 				= 	$this->home->get_all_row("test_category",array("1"	=> 	1),"*",'cat_name','ASC');
			$array 				= 	array("cat"	 => 	$cat);
			$this->load->view('admin/test_category',['array'	=> 	$array]);
		}
		public function storecat(){
			$post 	= 	$_POST;
			if($this->home->checkrow($post,"test_category"))
			{
				$this->session->set_flashdata('catmsg',"<div class='alert alert-warning'>This category already exists.</div>");
			}
			else if($this->insert->insert_table($post,"test_category"))
			{
				$this->session->set_flashdata('catmsg',"<div class='alert alert-success'>Test Category added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('catmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect(base_url('hosadmin/test_category'));
		}
		public function deltest_category(){
			$this->load->model('delete');
			if($this->delete->delete_table($_POST,"test_category"))
			{

				$this->session->set_flashdata('catmsg',"<div class='alert alert-success'>Test Category deleted successfully.</div>");
			}
			else{
				echo "We are facing some technical issues. Please try later.";
				$this->session->set_flashdata('catmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
		}
		public function updatecat(){
			if($this->update->update_table("test_category","id",$_POST['id'],$_POST))
			{
				$this->session->set_flashdata('catmsg',"<div class='alert alert-success'>Test Category updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect (base_url('Hosadmin/test_category'));
		}
		public function pending_users(){
			$_SESSION['page']	=	"pending_users";
			$array 	=	array(
								'is_active'	=>	0,
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('hosadmin/pending_users'),
								'per_page'		=>		'20',
								'total_rows'	=>		$this->select->count_some_users($array),
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
			$users	=	$this->home->get_some_row("users",$array,"id,user_name,is_active,user_email,user_mob,user_alt_mob,user_type,created_at",$config['per_page'],$this->uri->segment(3),'id','Desc');
			$array 	=	array(
								"users"	=>	$users,
							);
			$this->load->view('admin/pending_users',['array'	=>	$array]);
		}
	}
?>