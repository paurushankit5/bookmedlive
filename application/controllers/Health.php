<?php
	Class Health extends MY_Controller
	{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if((!isset($_SESSION['clinic_id']))&&(!isset($_SESSION['hospital_id'])))
			{
				return redirect (base_url('login'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
			$_SESSION['page']= ''; 
		}
		public function dashboard(){
			$_SESSION['page']= 'dashboard'; 
			 
			$array 	=	array(
								"user_clinic_id"	=>	$_SESSION['user']['id']
							);
			$doc 	=	$this->home->get_all_row("users",$array,"id,user_name");
			$docs =array();
			//getting the id of clinic doctors
			if(count($doc))
			{
				foreach($doc as $x)
				{
					$docs[] 	=	$x['id'];
				}	
			}
			$m  	= 	date('m');
			$y  	= 	date('Y');
			$docs   =   implode(",",$docs);
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			if($docs =='')
			{
				$docs = 0;
			}	 
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
			$monrev[$i]		=	$this->select->get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and ap_date='$date' and ap_doctor_id in ($docs)");
				$monrev[$i]['date']		=	$date;
				//echo $this->db->last_query()."<br><br>"; 
				//exit();

			}
			$my_id 	= 	$_SESSION['user']['id'];
			$today 	= 	date('Y-m-d');
			$ap 	= 	$this->select->somequery("select a.id,ap_id,ap_patient_id,ap_doctor_id,ap_date,ap_time,ap_money,ap_shift,p.user_name as patient_name,d.user_name as doctor_name,dept.name as department_name from appointment a inner join users p on (p.id = a.ap_patient_id) inner join users d on (d.id=a.ap_doctor_id) inner join users c on (c.id=d.user_clinic_id) left join subdepartment dept on (d.user_subdept_id = dept.id) where ap_payment='1' and ap_status='1' and ap_date='$today' and d.user_clinic_id='$my_id' order by ap_doctor_id,ap_time asc");

		 
			$array 	=	array(
								'monrev'	=>	$monrev,
							 	'ap'		=>	$ap
								);
		$this->load->view('health/dashboard',['array'	=>	$array]);
		}
		public function profile(){
			$_SESSION['page']= 'profile';
			$cities 	=	$this->select->get_all_cities();
			$array 		=	array('user_id'	=>	$_SESSION['user']['id']);
			$address 	=	$this->select->get_one_address($array);
			$array 		=	array(
									"bank_ac_user_id"	=>	$_SESSION['user']['id']
									);
			$acccount 	=	$this->home->get_one_row("bank_account",$array,"*");

			$array 		=	array(
									'cities'	=>	$cities,
									'address'	=>	$address,
									'acccount'	=>	$acccount,
								);
			$this->load->view('health/profile.php',['array'	=>	$array]); 

		}
		public function updateprofile(){
			$post 	=	$this->input->post();
			if(!isset($post['user_service']))
			{
				$post['user_service'] ='';
			}
			$array 	=	array(
								'user_service'	=>	$post['user_service'],
								'user_about'	=>	$post['user_about'],
								'user_name'		=>	$post['user_name'],
								'updated_at'	=>	date('Y-m-d H:i:S'),
							);
			if($this->update->update_table('users','id',$_SESSION['user']['id'],$array))
			{
				$array 	=	array('user_id'	=>	$_SESSION['user']['id']);
				if($address_id = $this->select->checkaddress($array)){
					$array 	=	array(
										 
										'adl1'		=>	$post['adl1'],
										'adl2'		=>	$post['adl2'],
										'location'	=>	$post['location'],
										'pin'		=>	$post['pin'],
									);
					if($this->update->update_table('address','id',$address_id,$array)){
						$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Profile updated successfully.</div>");
					}
					else{
						$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");

					}
				}
				else{
					///echo "insert";
					$array 	=	array(
										'user_id'	=>	$_SESSION['user']['id'],
										'adl1'		=>	$post['adl1'],
										'adl2'		=>	$post['adl2'],
										'location'	=>	$post['location'],
										'pin'		=>	$post['pin'],
									);
					if($this->insert->insert_table($array,'address')){
						$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Profile updated successfully.</div>");
					}
					else{
						$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");

					}
				}
			}
			else{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");
			}
			$_SESSION['user']= $this->select->get_one_user(array('id'	=>	$_SESSION['user']['id']));
			return redirect(base_url('Health/profile'));	
		}
		public function updatepic(){
			/*echo "<pre>";
			print_r($_FILES);*/
			if($this->update->update_table('users','id',$_SESSION['user']['id'],array('user_image'	=>	$_FILES['user_image']['name'])))
			{
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/'); 
				}			 
				if($_FILES['user_image']['name']!='')
				{
					$post['user_image']	=	$_FILES['user_image']['name'];
					 
					@unlink('./images/user/'.$_SESSION['user']['id'].'/'.$_SESSION['user_image']);
					move_uploaded_file($_FILES['user_image']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/'.$post['user_image']);
				}
			}
			$_SESSION['user']= $this->select->get_one_user(array('id'	=>	$_SESSION['user']['id']));
			
			return redirect(base_url('Health/profile'));

			
		}
		public function timings(){
			$_SESSION['page']	=	"timings";
			$timings 	=	$this->home->get_one_row('timings',array('user_id'	=>	$_SESSION['user']['id']),'*');
			$array 		=	array(
									'timings'	=>	$timings,
								);
			$this->load->view('health/timings',['array'	=>	$array]);
		}
		 
		public function doctors(){
			$_SESSION['page']	=	"doctors";
			$where	=	array('user_clinic_id'	=>	$_SESSION['user']['id']);
			$doc 	=	$this->home->get_all_row('users',$where,'*','id','desc');
			/*print_r($doc);
			echo $this->db->last_query();*/
			$array 		=	array(
									'doc'	=>	$doc
								);
			$this->load->view('health/doctors',['array'	=>	$array]);
		}
		public function adddoc(){
			$this->load->helper('form');
			$_SESSION['page']	=	"doctors";
			$array 	=	array();
			if($_SESSION['user']['user_type']=='3')
			{
				$array 	=	array(
									"user_id"	=>	$_SESSION['user']['id'],
									"dept_id"	=>	1,
								);
				$hos_dept 	=	$this->home->get_one_row("hos_department",$array,"*");
				
				if(count($hos_dept))
				{
					$subdept_id 	=	explode(",",$hos_dept['subdept_id']);
					
					$subdept 		=	$this->select->get_hos_subdepartment($subdept_id);
					if(count($subdept))
					{
						$array 	=	array("subdept"	=>	$subdept);
					}
					else{
						$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");
			 
					return redirect('Health/department');
					}	
				}
				else{
				 
					$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");
			 
					return redirect('Health/department');
				 

				}	
			}
			$this->load->view('health/adddoc',['array'	=>	$array]);
		}
		public function storedoc(){
			$post =	$this->input->post();
			
			$this->load->library('form_validation');
            $this->form_validation->set_rules('user_name', 'user_name', 'required');
            $this->form_validation->set_rules('user_email', 'Email', 'required|is_unique[users.user_email]');
            $this->form_validation->set_rules('user_mob', 'Mobile', 'required|is_unique[users.user_mob]');
            //	$this->form_validation->set_rules('user_alt_mob', 'Alternate Contact', 'required|is_unique[users.user_mob]');
            $this->form_validation->set_rules('user_age', 'Age', 'required');
            $this->form_validation->set_rules('user_experience', 'Experience', 'required');

            if ($this->form_validation->run() == FALSE)
            {	
            	$array 	=	array();
				if($_SESSION['user']['user_type']=='3')
				{
					$array 	=	array(
										"user_id"	=>	$_SESSION['user']['id'],
										"dept_id"	=>	1,
									);
					$hos_dept 	=	$this->home->get_one_row("hos_department",$array,"*");
					
					if(count($hos_dept))
					{
						$subdept_id 	=	explode(",",$hos_dept['subdept_id']);
						
						$subdept 		=	$this->select->get_hos_subdepartment($subdept_id);
						if(count($subdept))
						{
							$array 	=	array("subdept"	=>	$subdept);
						}
						else{
							$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");
				 
						return redirect('Health/department');
						}	
					}
					else{
					 
						$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");
				 
						return redirect('Health/department');
					 

					}	
				}
                $this->load->view('health/adddoc',['array'	=>	$array]);
            }
            else{
            	//echo "<pre>";
				
				$post['user_clinic_id']	=	$_SESSION['user']['id'];
				$post['created_at']		=	date('Y-m-d H:i:s');
				$post['updated_at']		=	date('Y-m-d H:i:s');
				if($_SESSION['user']['user_type']==2){
					$post['user_type']	=	5;//for clinic_doc user_type=5
				}
				else if($_SESSION['user']['user_type']==3){
					$post['user_type']	=	6;//for hospital_doc user_type=5
				}
				$rand 	=	md5(rand(111111,999999));
				
				$post['user_code']	=	$rand;
				 
				if($id =$this->insert->insert_table($post,"users"))
				{
					$url =  base_url('Account/verifydocemail/'.$id.'/'.$rand);
					$this->session->set_flashdata('adddocmsg',"<div class='alert alert-success'>Doctor added successfully.</div>");
					$demo 	 =	"<html><head></head><body style='width:90%;border:1px solid gray;padding:20px;'>";

					$demo 	.=	"<h1 style='font-size:40px;'><center>BOOKMEDIZ</center></h1><hr>";
					$demo 	.= 	"<h3>Welcome to BOOKMEDIZ.</h3>";
					$demo 	.= 	"<p> Dear ".$post['user_name']."<br><br>Your email has been registered with us. ".$_SESSION['user']['user_name']." has added your profile as a doctor. Please follow the below link to activate your account.<br></br></p><br><br>";
					$demo   .=  "<center><a href='".$url."' style='padding:20px 30px;background:red;color:white;text-decoration:none;'>Click Here To Activate Your Account</a></center>";
					$demo   .=  "<br><br><br></br><center>Or copy this link <br><b>".$url."</b></center><hr>";
					$demo 	.= 	"<b>Regards:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Booomediz Team.<br>";
					$demo 	.= 	"<b>Call Us:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-8093311169 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-7008047316<br><hr>";
					$demo 	.=	"</body></html>";
					$this->sendmail($post['user_email'],"Welcome to Bookmediz",$demo,"Welcome to BOOKMEDIZ");		
					$this->smsgatewaycenter_com_Send("91".$post['user_mob'], "Hello ".$post['user_name']." . Welcome to BOOKMEDIZ. Please click on the link sent to your email to verify your account.");		
				}
				else{
					$this->session->set_flashdata('adddocmsg',"<div class='alert alert-danger'>We are facing some technical issues.Please try later.</div>");
				}
				return redirect(base_url('Health/adddoc'));
            }
		}
		public function docdetails(){
			$_SESSION['page']	=	"doctors";
			$user_id	=	$_SESSION['user']['id'];
			$array 		=	array(
									'id'	=>	$this->uri->segment(3),
									'user_clinic_id'	=>	$_SESSION['user']['id']
								);

			$doc 		=	$this->home->get_one_row('users',$array,'*');
			
			if(count($doc)){
				if($doc['user_subdept_id']!='0')
				{	
					$subdepartment_id 			= 	$doc['user_subdept_id'];
					$doc['department'] 	= 	$this->select->get_single_row("select name from subdepartment where id ='$subdepartment_id'")['name'];
				}
				$array 		=	array(
										'qualification_doctor_id'	=>	$this->uri->segment(3)
									);
				$edu 		=	$this->select->get_some_education($array);
				$array 		=	 array(
											'user_id'	=>	$_SESSION['user']['id']
										);
				$timings 	=	$this->home->get_one_row("timings",$array,"*");
				
				$speciality =	$this->select->get_all_specialization();
				$array	=	array(
									'document_user_id'	=>	$this->uri->segment(3),
									);
				$document 	=	$this->select->get_some_documents($array);
				$council 	=	$this->select->get_all_council();
				$subdept_id = 	$this->select->get_single_row("select subdept_id from hos_department where user_id ='$user_id' and dept_id='1'")['subdept_id'];
				$subdept_id  = "'".implode("','",explode(",",$subdept_id))."'";

			 	$department = 	$this->select->get_questions("select * from subdepartment where id in ($subdept_id)");
			 	
				$array 		=	array(
										'doc'		=>	$doc,
										'edu'		=>	$edu,
										'speciality'=>	$speciality,
										'timings'	=>	$timings,
										'document'	=>	$document,
										'council'	=>	$council,
										'department'=>	$department,
									);
				$this->load->view('health/docdetails',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
			
		}
		public function storeeducation(){
			$post 	=	$this->input->post();
			/*echo "<pre>";
			print_r($post);*/
			$doctor_id	=	$post['qualification_doctor_id']; 
			$i=0;
			foreach($post['qualification_name'] as $x)
			{
				$array[$i]['qualification_name']			=	$x;	
				$array[$i]['qualification_college']			=	$post['qualification_college'][$i];	
				$array[$i]['qualification_complete_year']	=	$post['qualification_complete_year'][$i];	
				$array[$i]['qualification_specialization']	=	$post['qualification_specialization'][$i];	
				$array[$i]['qualification_doctor_id']		=	$post['qualification_doctor_id'] ;	
				$i++;
			}
			//print_r($array);
			if($this->insert->insert_batch_table($array,'qualification'))
			{
				$this->session->set_flashdata('docdetailmsg','<div class="alert alert-success">Education and Specialisation added successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('docdetailmsg','<div class="alert alert-danger">We are facing some technical issues. Please try after some time.</div>');

			}
			return redirect(base_url('Health/docdetails/'.$doctor_id));
		}
		public function services(){
			$_SESSION['page']	=	"services";
			$array 				=	array(
											"user_id"	=>	$_SESSION['user']['id']
										);
			$services 			=	$this->select->get_clinic_services($array);
			$allservice 		=	$this->home->get_all_row("service",array("1"	=>	1),"*",'service_name','ASC');
			$array 		=	array(
									'services'		=>	$services,
									'allservice'	=>	$allservice,
								);
			$this->load->view('health/services',['array'	=>	$array]); 

		}
		public function storeservices(){
			$post 	=	$this->input->post();
			if(count($post['service_id']))
			{
				$this->load->model('delete');
				$array = array(
									'user_id'	=>	$_SESSION['user']['id']
							);
				$this->db->trans_start();
				$this->delete->delete_table($array,"clinicservice");
				$i=0;
				foreach($post['service_id'] as $x)
				{
					$edu[$i]['service_id']	=	$x;
					$edu[$i]['user_id']		=	$_SESSION['user']['id'];
					$i++;
				}
				$this->insert->insert_batch_table($edu,"clinicservice");
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE)
				{
					$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");  
				}
				else{
					$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Services added successfully.</div>");  
				}
				return redirect(base_url('health/services'));
				
				 
			}
		}
		public function specialities(){
			$_SESSION['page']	=	"specialities";
			$array 	=	array(
							'qualification_doctor_id'		=>		$_SESSION['user']['id'],
							);
			$qualification 	=	$this->select->get_some_education($array);
			$speciality =	$this->select->get_all_specialization();
			$array 		=	array(
									'qualification'	=>	$qualification,
									'speciality'	=>	$speciality,
								);
			$this->load->view('health/speciality',['array'	=>	$array]);
		}

		public function storespeciality(){
			$post 	=	$this->input->post();
			/*echo "<pre>";
			print_r($post);*/
			if(count($post['qualification_specialization']))
			{
				$this->load->model('delete');
				$array = array(
									'qualification_doctor_id'	=>	$_SESSION['user']['id']
							);
				$this->db->trans_start();
				$this->delete->delete_table($array,"qualification");
				$i=0;
				foreach($post['qualification_specialization'] as $x)
				{
					$edu[$i]['qualification_specialization']	=	$x;
					$edu[$i]['qualification_doctor_id']		=	$_SESSION['user']['id'];
					$i++;
				}
				$this->insert->insert_batch_table($edu,"qualification");
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE)
				{
					$this->session->set_flashdata('specmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");  
				}
				else{
					$this->session->set_flashdata('specmsg',"<div class='alert alert-success'>Specialisation added successfully.</div>");  
				}
				return redirect(base_url('health/specialities'));
				
				 
			}
		}
		public function storeaccountdetails(){
			$post 	=	$this->input->post();
			
			$array 	=	array(
								"bank_ac_user_id"	=>	$_SESSION['user']['id']
							);
			if($this->home->checkrow($array,"bank_account"))
			{
				//echo $this->db->last_query();
				if($this->update->update_table('bank_account','bank_ac_user_id',$_SESSION['user']['id'],$post))
				{
					$this->session->set_flashdata('promsg',"<div class='alert alert-success'>Bank acccount updated successfully.</div>");
				}
				else{
					$this->session->set_flashdata('promsg',"<div class='alert alert-danger'>We are facing some technical issue. Please try later.</div>");
				}
			}
			else{
				$post['bank_ac_user_id']	=	$_SESSION['user']['id'];
				$this->load->model('insert');
				if($this->insert->insert_table($post,"bank_account"))
				{
					$this->session->set_flashdata('promsg',"<div class='alert alert-success'>Bank acccount added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('promsg',"<div class='alert alert-danger'>We are facing some technical issue. Please try later.</div>");
				}
			}
			return redirect (base_url('Health/profile'));
		}
		public function gallery(){
			$_SESSION['page']	='gallery';
			$id 		=	$_SESSION['user']['id'];
			$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc");
			$array 		=	array(
									'gallery'	=>	$gallery
								);
			$this->load->view('health/gallery',['array'	=>	$array]);
		}
		public function addgallery(){
			$rand 	=	rand(1111,999);
			$ext = pathinfo($_FILES['image_name']['name'], PATHINFO_EXTENSION);
			//echo $ext;
			$array		=	array(
									'image_name'	=>	$rand.".".$ext,
									'image_user_id'	=>	$_SESSION['user']['id']
								);
			if($id = $this->insert->insert_table($array,"gallery"))
			{
				if(!file_exists('./img/gallery/'.$id.'/'))
				{
					mkdir('./img/gallery/'.$id.'/'); 
				}
				$config['upload_path']        	= './img/gallery/'.$id.'/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['file_name']        	= $rand;                
                $config['max_size']       	 	= 0; 
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image_name'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('gallerymsg',"<div class='alert alert-danger'>".$this->upload->display_errors('<p>', '</p>')."</div>");                       
                }
                else
                {
                        $error = array('upload_data' => $this->upload->data());
                         $this->session->set_flashdata('gallerymsg',"<div class='alert alert-success'>Image uploaded successfully.</div>");
               	}
			}
			else{
				 $this->session->set_flashdata('gallerymsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
			}
			return redirect(base_url('health/gallery'));
		}
		public function appointments(){
			$_SESSION['page']='appointments';
			$array 	=	array(
								"user_clinic_id"	=>	$_SESSION['user']['id']
							);
			$doc 	=	$this->home->get_all_row("users",$array,"id,user_name");
			if(count($doc))
			{
				$i=0;
				$m= date('m');
				$y= date('Y');
				foreach ($doc as $x) {
					$doc_id = $x['id'];
					//get number of appointment for today
					$array	=	array('ap_date'	=>	date('Y-m-d'),
										'MONTH(ap_date)'=> 	$m,
										'YEAR(ap_date)'	=> 	$y,
										'ap_status'=>	'1',
										'ap_payment'=>	'1',
										'ap_doctor_id'	=>	$x['id']										
										);
					
					$doc[$i]['today']	=	$this->select->count_all_appointments($array);
					//echo $this->db->last_query()."<br>"; 
				 
					$array	=	array('ap_date>'	=>	date('Y-m-d'),
										'ap_status'=>	'1',
										'ap_payment'=>	'1',
										'ap_doctor_id'	=>	$x['id']
										);
					$doc[$i]['tomorrow']	=	$this->select->count_all_appointments($array);
					//echo $this->db->last_query()."<br>"; 
					
					$sql ="SELECT ap_id FROM appointment WHERE MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id='$doc_id' and ap_status='1' and ap_payment='1'";
					$doc[$i]['month']	=	$this->select->get_total_rows($sql);
					//echo $this->db->last_query()."<br>"; 


					$i++;
				}
			}
			
			arsort($doc);
			$array 		=	array("doc"		=>		$doc);
			$this->load->view('health/appointments',['array'	=>	$array]);
		}
		public function revenue(){
			$_SESSION['page']	=	"revenue";
			$date 	=	 $this->uri->segment(3);
			$date   = 	 explode("-",$date);
			$m =	$date[1];
			$y =	$date[0];
			if($m == '' || $y=='' || $y >(date('Y')+1))
			{
				return redirect(base_url('Error404'));
			}
			$array 	=	array(
								"user_clinic_id"	=>	$_SESSION['user']['id']
							);
			$doc 	=	$this->home->get_all_row("users",$array,"id,user_name");
			$docs ='';
			//getting the id of clinic doctors
			if(count($doc))
			{
				$i = 0;
				foreach($doc as $x)
				{					
					$docs[] 	=	$x['id'];
					$doc_id 	= 	$x['id'];
					$sql 	= 	"SELECT sum(ap_money) as monthlyrevenue FROM appointment WHERE MONTH(ap_date) = '$m' AND YEAR(ap_date) = $y and ap_payment=1 and ap_status=1 and ap_doctor_id='$doc_id'";
					$doc[$i++]['monthlyrevenue'] = $this->select->get_single_row($sql)['monthlyrevenue'];
				}	
			}
			
			
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			//echo "<pre>";		 
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
				$monrev[$i]		=	$this->select->get_clinic_addedrevenue($array,$docs);
				$monrev[$i]['date']		=	$date;
				//echo $this->db->last_query()."<br><br>"; 
			}

			//print_r($monrev);

			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array); 
			$array 	=	array(
								'monrev'	=>	$monrev,
								'm'			=>	$m,
								'y'			=>	$y,
								'settings'	=>	$settings,
								'doc'		=>	$doc,
								);
			/*echo "<pre>";
			print_r($doc);*/
			$this->load->view('health/revenue',['array'	=>	$array]);
		}
		public function certificates(){
			$_SESSION['page']	=	"certificates";
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id']
							);
			$certi 	=	$this->home->get_one_row("clinic",$array,"*");
			$array 	=	array(
								"certi"		=>	$certi
								);
			$this->load->view('health/certificates',['array'	=>	$array]);

		}
		public function docappointment(){
			$_SESSION['page']	=	"appointments";
			$id 		=		$this->uri->segment(3);
			$date		=		$this->uri->segment(4);
			$array 		=		array(
										"id"				=>	$id,
										"user_clinic_id"	=>	$_SESSION['user']['id'],
									);
			$doc =	$this->select->get_one_user($array);
			if(!count($doc))
			{
				return redirect(base_url('Error404'));
			}
			$array		=	array(
										'ap_payment'			=>	1,
										'ap_status'				=>	1,	
										'ap_date'				=>	$date,
										'ap_doctor_id'			=>	$id,
									);	
			$ap 		=		$this->select->get_some_doc_appointments(999,0,$array);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array); 
			$array 		=	array(
									"ap"		=>		$ap,
									"doc"		=>		$doc,
									"settings"		=>		$settings,
									);
			$this->load->view('health/docappointment',['array'	=>	$array]);
		}
		public function findappointmentsbymonth(){
			$_SESSION['page']	=	"appointments";
			$id 	=	$this->uri->segment(3);
			$m 		=	$_GET['m'];
			$y		=	$_GET['y'];
			$doc_id = 	$this->uri->segment(3);
			$array 		=		array(
										"id"				=>	$doc_id,
										"user_clinic_id"	=>	$_SESSION['user']['id'],
									);
			$doc =	$this->select->get_one_user($array);
			if(!count($doc))
			{
				return redirect(base_url('Error404'));
			}
			$sql ="SELECT appointment.*,users.user_name FROM appointment inner join users on users.id=appointment.ap_patient_id WHERE MONTH(ap_date) = '$m' AND YEAR(ap_date) = '$y' and ap_doctor_id='$doc_id' and ap_status='1' and ap_payment='1' order by ap_date ASC";
			$ap	=	$this->select->somequery($sql);
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array); 
			$array 	=	array(
								"doc"		=>	$doc,
								"ap"		=>	$ap,
								"settings"	=>	$settings,
							);
			$this->load->view('health/findappointmentsbymonth',['array'		=>	$array]);
			
		}
		public function department(){

			if(!$_SESSION['user']['user_type'] =='3')
			{
				return redirect('Error404');
			}
			$_SESSION['page']	=	"department";
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id']
							);
			$hos_dept 	=	$this->home->get_all_row("hos_department",$array,"*");
			$array 		=	array('1'	=>	1);
			$dept 		=	$this->home->get_all_row("department",$array,"*");
			if(count($dept))
			{
				$i=0;
				foreach($dept as $x)
				{
					$array 	=	array(
										"department_id"	=>	$x['id']
									);
					$dept[$i]['subdept'] 		=	$this->home->get_all_row("subdepartment",$array,"*");
					$i++;
				}
			}
			//echo "<pre>";
			//print_r($hos_dept);
			$array 	=	array(
								"dept"			=>	$dept,
								"hos_dept"		=>	$hos_dept,
							);
			$this->load->view('health/department',['array'	=>	$array]);

		}
		public function storedepartment(){
			$post 	=	$this->input->post();
			
			$subdept_id 	=	implode(",",$post['subdept']);
			$array 	=	array(
								"dept_id"		=>	$post['department_id'],
								"user_id"			=>	$_SESSION['user']['id'],
								 
							);
			if($id = $this->home->checkrow($array,"hos_department"))
			{
				$array 	=	array(
								"subdept_id"		=>	$subdept_id,
							);
			
				if($this->update->update_table('hos_department','id',$id,$array))
				{
					$this->session->set_flashdata('departmentmsg',"<div class='alert alert-success'>Department updated successfully.</div>");
				}
				else{
					$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			else{
				$array 	=	array(
								"dept_id"		=>	$post['department_id'],
								"user_id"			=>	$_SESSION['user']['id'],
								"subdept_id"		=>	$subdept_id,
							);
			

				if($this->insert->insert_table($array,'hos_department'))
				{
					$this->session->set_flashdata('departmentmsg',"<div class='alert alert-success'>Department added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			return redirect('Health/department');

		}
		public function selectdepartment(){
			$_SESSION['page'] = "doctors";
			if($_SESSION['user']['user_type']!=3)
			{
				return redirect(base_url('Error404'));
			}
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id'],
								"dept_id"	=>	1,
							);
			$dept = $this->home->get_one_row("hos_department",$array,"*");
			
			
			if((!count($dept)))
			{
				$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");			 
					return redirect('Health/department');
			}
			$user_id 		=	$_SESSION['user']['id'];
			$subdept_id 	=	$dept['subdept_id'];
			$subdept 			=	$this->select->get_questions("select s.*,(select count(id) from users where user_clinic_id='$user_id' and user_subdept_id=s.id) as doctorcount from subdepartment s where id in ($subdept_id) order by doctorcount desc");
			$array 	=	array(
								"subdept"	=>	$subdept
								);
			$this->load->view('health/selectdepartment',['array'	=>	$array]);
		}
		public function doclist(){
			$_SESSION['page']	=	"doctors";
			$where	=	array(
								'user_clinic_id'	=>	$_SESSION['user']['id'],
								'user_subdept_id'	=>	$this->uri->segment(3),
								);
			$doc 	=	$this->home->get_all_row('users',$where,'*','id','desc');
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id'],
								"dept_id"	=>	1
							);
		 	$my_dept= 	$this->home->get_one_row("hos_department",$array,"subdept_id");
		 	$subdept_id =	explode(",",$my_dept['subdept_id']);
		 	if(!in_array($this->uri->segment(3),$subdept_id))
		 	{
		 		return redirect(base_url('Error404'));
		 	}
		 	$array 		=	array(
		 							"id"	=>	$this->uri->segment(3),
		 						);
		 	$department =	$this->home->get_one_row("subdepartment",$array,"*");
		 	//print_r($department);
			$array 		=	array(
									'doc'			=>	$doc,
									'department'	=>	$department,
								);
			$this->load->view('health/doclist',['array'	=>	$array]);
		}
		public function editdocdetails(){
			$_SESSION['page']	=	"doctors";
			$this->load->helper('form');
			//$_SESSION['page']= 'profile';
			$cities 	=	$this->select->get_all_cities();
			$array 		=	array(
									"id"				=>	$this->uri->segment(3),
									"user_clinic_id"	=>	$_SESSION['user']['id'],
								);
			$doc  		=	$this->select->get_one_user($array);
			if(!count($doc))
			{
				return redirect('Error404');
			}
			$array 		=	array(
									'cities'	=>	$cities,
									'doc'	=>	$doc,
								);
			$this->load->view('health/editdocdetails',['array'	=>	$array]); 
		}
		public function updatedocprofile(){
			$post 	=	$this->input->post();

			$array 	=	array(
								'user_about'			=>	$post['user_about'],
								'user_award'			=>	$post['user_award'],
								'user_work'			=>	$post['user_work'],
								'user_name'				=>	$post['user_name'],
								'user_age'				=>	$post['user_age'],
								'user_experience'		=>	$post['user_experience'],
								'user_fee'				=>	$post['user_fee'],
								'user_gender'			=>	$post['user_gender'],
								'user_time'				=>	$post['user_time'],
								'updated_at'			=>	date('Y-m-d H:i:S'),
							);
			/*echo "<pre>";
			print_r($post);
			print_r($array);*/

			if($this->update->update_table('users','id',$post['id'],$array))
			{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Profile updated successfully.</div>");
				 
			}		
			else{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");
			}
			$_SESSION['user']= $this->select->get_one_user(array('id'	=>	$_SESSION['user']['id']));
			return redirect(base_url('Health/docdetails/'.$post['id']));	
		}
		public function updatedocpic(){
			 
			if($this->update->update_table('users','id',$_POST['id'],array('user_image'	=>	$_FILES['user_image']['name'])))
			{
				if(!file_exists('./images/user/'.$_POST['id'].'/'))
				{
					mkdir('./images/user/'.$_POST['id'].'/'); 
				}			 
				if($_FILES['user_image']['name']!='')
				{
					$post['user_image']	=	$_FILES['user_image']['name'];
					 
					@unlink('./images/user/'.$_POST['id'].'/'.$_POST['preimage']);
					move_uploaded_file($_FILES['user_image']['tmp_name'],'./images/user/'.$_POST['id'].'/'.$post['user_image']);
				}
			}
			
			return redirect(base_url('Health/docdetails/'.$_POST['id']));

			
		}
		public function selectrevenuedepartment(){
			$_SESSION['page'] = "revenue";
			if($_SESSION['user']['user_type']!=3)
			{
				return redirect(base_url('Error404'));
			}
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id'],
								"dept_id"	=>	1,
							);
			$dept = $this->home->get_one_row("hos_department",$array,"*");
			
			
			if((!count($dept)))
			{
				$this->session->set_flashdata('departmentmsg',"<div class='alert alert-danger'>Please add your clinical department first.</div>");			 
					return redirect('Health/department');
			}
			$user_id 		=	$_SESSION['user']['id'];
			$subdept_id 	=	$dept['subdept_id'];
			$subdept 			=	$this->select->get_questions("select s.*,(select count(id) from users where user_clinic_id='$user_id' and user_subdept_id=s.id) as doctorcount from subdepartment s where id in ($subdept_id) order by doctorcount desc");
			$array 	=	array(
								"subdept"	=>	$subdept
								);
			$this->load->view('health/selectrevenuedepartment',['array'	=>	$array]);
		}
		public function hospitalrevenue(){
			$_SESSION['page']	=	"revenue";
			 
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id'],
								"dept_id"	=>	1
							);
		 	$my_dept= 	$this->home->get_one_row("hos_department",$array,"subdept_id");
		 	$subdept_id =	explode(",",$my_dept['subdept_id']);
		 	if(!in_array($this->uri->segment(3),$subdept_id))
		 	{
		 		return redirect(base_url('Error404'));
		 	}
		 	$array 		=	array(
		 							"id"	=>	$this->uri->segment(3),
		 						);
		 	$department =	$this->home->get_one_row("subdepartment",$array,"*");
		 	
			$date 	=	 $this->uri->segment(4);
			$date   = 	 explode("-",$date);
			$m =	$date[1];
			$y =	$date[0];
			if($m == '' || $y=='' || $y >(date('Y')+1))
			{
				return redirect(base_url('Error404'));
			}
			$array 	=	array(
								"user_clinic_id"	=>	$_SESSION['user']['id'],
								"user_subdept_id"	=>	$this->uri->segment(3),
							);
			$doc 	=	$this->home->get_all_row("users",$array,"id,user_name");
			$docs =array();
			//getting the id of clinic doctors
			if(count($doc))
			{
				$i=0;
				foreach($doc as $x)
				{
					$docs[] 	=	$x['id'];
					$doc_id 	= 	$x['id'];
					$sql 	= 	"SELECT sum(ap_money) as monthlyrevenue FROM appointment WHERE MONTH(ap_date) = '$m' AND YEAR(ap_date) = $y and ap_payment=1 and ap_status=1 and ap_doctor_id='$doc_id'";
					$doc[$i++]['monthlyrevenue'] = $this->select->get_single_row($sql)['monthlyrevenue'];
				}	
			}
			
			
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			//echo "<pre>";		 
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
				$monrev[$i]		=	$this->select->get_clinic_addedrevenue($array,$docs);
				$monrev[$i]['date']		=	$date;
				//echo $this->db->last_query()."<br><br>"; 
			}
			//print_r($monrev);

			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array); 
			$array 	=	array(
								'monrev'	=>	$monrev,
								'doc'	=>	$doc,
								'm'			=>	$m,
								'y'			=>	$y,
								'settings'	=>	$settings,
								'department'=>	$department,
								);
			//echo "<pre>";
			//print_r($doc);
			$this->load->view('health/hospitalrevenue',['array'	=>	$array]);
		}
		public function updatecerti(){
			$post 	=	$this->input->post();
			$post['user_id']	=	$_SESSION['user']['id'];
			if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/'))
			{
				mkdir('./images/user/'.$_SESSION['user']['id'].'/'); 
			}
			if($_FILES['clinic_logo']['name']!='')
			{
				$post['clinic_logo']	=	$_FILES['clinic_logo']['name'];				
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/logo/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/logo/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/logo/');
				}
				move_uploaded_file($_FILES['clinic_logo']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/logo/'.$post['clinic_logo']);
			}
			if($_FILES['clinic_reg_proof']['name']!='')
			{
				$post['clinic_reg_proof']	=	$_FILES['clinic_reg_proof']['name'];
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/reg/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/reg/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/reg/');
				}
				move_uploaded_file($_FILES['clinic_reg_proof']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/reg/'.$post['clinic_reg_proof']);
			}
			if($_FILES['clinic_pres_pad']['name']!='')
			{
				$post['clinic_pres_pad']	=	$_FILES['clinic_pres_pad']['name'];
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/pad/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/pad/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/pad/');
				}
				move_uploaded_file($_FILES['clinic_pres_pad']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/pad/'.$post['clinic_pres_pad']);
			}
			if($_FILES['clinic_waste_disposal']['name']!='')
			{
				$post['clinic_waste_disposal']	=	$_FILES['clinic_waste_disposal']['name'];
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/waste/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/waste/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/waste/');
				}
				move_uploaded_file($_FILES['clinic_waste_disposal']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/waste/'.$post['clinic_waste_disposal']);
			}
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id']
							);
			if($this->home->checkrow($array,"clinic"))
			{
				if($this->update->update_table("clinic","user_id",$_SESSION['user']['id'],$post))
				{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-success'>Certificates updated successfully.</div>");
				}	
				else{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try layter</div>");
				}
			}
			else{
				if($this->insert->insert_table($post,"clinic"))
				{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-success'>Certificates added successfully.</div>");
				}	
				else{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try layter</div>");
				}
			}
			return redirect(base_url('Health/certificates'));
		}
		public function searchmydoc(){
			$user_name	=	$_GET['search'];
			$id 		=	$_SESSION['user']['id'];
			$sql 		=	"select id,user_name,user_email,user_mob,user_alt_mob,is_active from users where user_clinic_id = '$id' and user_name like  '%$user_name%'";
			$doc 		=	$this->select->get_questions($sql);
			$array 		=	array("doc"	=>	$doc);
			$this->load->view('health/searchmydoc',['array'	=>	$array]);
		}
		public function storedocuments(){
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			print_r($_FILES['document_certificate']);
			$i=0;
			foreach($post['document_reg_no'] as $x)
			{
				$array[$i]['document_reg_no']		=	$x;
				$array[$i]['document_council_name']	=	$post['document_council_name'][$i];
				$array[$i]['document_year']			=	$post['document_year'][$i];
				$array[$i]['document_certificate']	=	$_FILES['document_certificate']['name'][$i];
				$array[$i]['document_user_id']		=	$post['document_user_id'][$i];
				$i++;
			}
			//print_r($array);
			if(count($array))
			{
				$i=0;
				foreach($array as $x)
				{
					if($document_id	=	$this->insert->insert_table($x,'document'))
					{						
						if($x['document_certificate']!='')
						{
							if(!file_exists('./images/certi/'.$document_id.'/'))
							{
								mkdir('./images/certi/'.$document_id.'/'); 
							}
							move_uploaded_file($_FILES['document_certificate']['tmp_name'][$i],"./images/certi/$document_id/".$x['document_certificate']);
						}
						$this->session->set_flashdata('docdetailmsg','<div class="alert alert-success">Documents added successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('docdetailmsg','<div class="alert alert-danger">We are gfacing some technical issues. Please try later.</div>');
					}
					$i++;
				}
			}			
			return redirect(base_url('Health/docdetails/'.$post['document_user_id'][0]));
		}
		public function findmonthappointments(){
			$_SESSION['page']= 'appointments'; 
			 
			$array 	=	array(
								"user_clinic_id"	=>	$_SESSION['user']['id']
							);
			$doc 	=	$this->home->get_all_row("users",$array,"id,user_name");
			$docs =array();
			//getting the id of clinic doctors
			if(count($doc))
			{
				foreach($doc as $x)
				{
					$docs[] 	=	$x['id'];
				}	
			}
			$m  	= 	$_GET['m'];
			$y  	= 	$_GET['y'];
			$docs   =   implode(",",$docs);
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);	
			//echo "<pre>";		 
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
			$monrev[$i]		=	$this->select->get_single_row("select count(ap_id) as number from appointment where ap_payment=1 and ap_status=1 and ap_date='$date' and ap_doctor_id in ($docs)");
				$monrev[$i]['date']		=	$date;
				//echo $this->db->last_query()."<br><br>"; 
				//exit();

			}


		 
			$array 	=	array(
								'monrev'	=>	$monrev,
							 	 
								);
			$this->load->view('health/findmonthappointments',['array'	=>	$array]);	
		}
		public function storetimings(){
			$post 	= 	$_POST;
			//echo "<pre>";
			//print_r($post);
			$day 	= 	$post['presentday'];
			if($post['working_day']==1)
			{
				$new_array[$day] 				  = 0;
				$new_array[$day."_morning_start"] = "00:00:00";
				$new_array[$day."_morning_end"]   = "00:00:00";
				$new_array[$day."_evening_start"] = "00:00:00";
				$new_array[$day."_evening_end"]   = "00:00:00";
			}
			else{
				$new_array[$day] 				  = 1;
				if($post['morning_day']==1)
				{
					$new_array[$day."_morning_start"] = "00:00:00";
					$new_array[$day."_morning_end"]   = "00:00:00";
				}
				else{
					$new_array[$day."_morning_start"] = $post['morning_start'];
					$new_array[$day."_morning_end"]   = $post['morning_end'];
				}
				if($post['evening_day']==1)
				{
					$new_array[$day."_evening_start"] = "00:00:00";
					$new_array[$day."_evening_end"]   = "00:00:00";
				}
				else{
					$new_array[$day."_evening_start"] = $post['evening_start'];
					$new_array[$day."_evening_end"]   = $post['evening_end'];
				}
			}
			if($new_array[$day."_morning_start"]!="00:00:00" && $new_array[$day."_morning_start"]>= $new_array[$day."_morning_end"])
			{
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-warning'>Morning start time can not be less than end time.</div>");
			}
			else if($new_array[$day."_evening_start"]!="00:00:00" && $new_array[$day."_evening_start"]>= $new_array[$day."_evening_end"])
			{
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-warning'>Morning start time can not be less than end time.</div>");
			}
			else{
				$where 	= 	array(
									"user_id" 	=> 	$_SESSION['user']['id']
								);
				if($id = $this->select->checktimings($where))
				{
					$this->update->update_table('timings','id',$id,$new_array);	
					$this->session->set_flashdata('timingmsg',"<div class='alert alert-success'>Timings updated successfully.</div>");				 
				}
				else{
					$new_array['user_id'] = $_SESSION['user']['id'];
					$this->insert->insert_table($new_array,"timings");	

					$this->session->set_flashdata('timingmsg',"<div class='alert alert-success'>Timings added successfully.</div>");					 
				}
			}
			return redirect(base_url('Health/timings'));
		}
		public function storemap()
		{
			$array 	= 	array('user_id'	=> 	$_SESSION['user']['id']);
			$id = $this->home->checkrow($array,"address");
			$array 	= 	array(
									"user_id" 	=> 	$_SESSION['user']['id'],
									"map" 		=> 	$_FILES['map']['name'],
								);
			if(!$id)
			{				
				$id = $this->insert->insert_table($array,"address");
			}	
			else
			{
				$this->update->update_table('address','user_id',$_SESSION['user']['id'],$array);			
			}
			if(!file_exists('./images/address/'.$id.'/'))
			{
					mkdir('./images/address/'.$id.'/'); 
			}			 
			if($_FILES['map']['name']!='')
			{
				$post['map']	=	$_FILES['map']['name'];
				foreach (new DirectoryIterator('./images/address/'.$id.'/') as $fileInfo) {
				    if(!$fileInfo->isDot()) {
				        unlink($fileInfo->getPathname());
				    }
				}
				move_uploaded_file($_FILES['map']['tmp_name'],'./images/address/'.$id.'/'.$post['map']);
			}
			return redirect(base_url('Health/profile'));
		}
		public function updatedocdepartment(){
			$post 	= 	$this->input->post();
			if($this->update->update_table('users','id',$post['id'],$post))
			{
				 $this->session->set_flashdata('docdetailmsg',"<div class='alert alert-success'>Department updated successfully.</div>");
			}
			else{
				 $this->session->set_flashdata('docdetailmsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");
			}
			return redirect (base_url('health/docdetails/'.$post['id']));

		}

	}
?>