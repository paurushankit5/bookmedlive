<?php
	class Doc extends MY_Controller{
		public function __construct()
		{
			parent ::__construct();
			ini_set('max_execution_time', 300);
			if(!isset($_SESSION['doctor_id']))
			{
				return redirect (base_url('login'));
			}
			$this->load->model('select');
			$this->load->model('update');
			$this->load->model('insert');
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
			$_SESSION['page']= ''; 
			ob_start();
		}
		public function dashboard(){
			$_SESSION['page']	=	'dashboard';
			//code to get number of appointments in a month per day wise
			$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date('Y-m-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'ap_payment'	=>	1,
										'ap_status'		=>	1,
										'ap_date'		=>	$date,
										'ap_doctor_id'	=>	$_SESSION['user']['id'],
									);				
				
				//print_r($array);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;
			
			}
			//code to get all appointments for today
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_status'		=>	1,
								'ap_date'		=>	date('Y-m-d'),
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			$ap	=	$this->select->get_some_doc_appointments(999,0,$array);
			//code to get some questions for the doctor
			$array 	=	array(
								'question_doc_clear'	=>	0,
								'question_ans'			=>	'',
								'question_doctor_id'	=>	$_SESSION['user']['id'],
							);
			$que	=	$this->select->get_some_questions(5,0,$array);
			$array 	=	array(
								"ap"		=>	$ap,
								"que"		=>	$que,
								"monapp"	=>	$monapp,
								"m"			=>	date('m'),
								"y"			=>	date('Y'),
								);
			//echo "<pre>";
			//print_r($que);
			$this->load->view('doc/dashboard',['array'	=>	$array]	);
		}
		public function profile(){
			$this->load->helper('form');
			$_SESSION['page']= 'profile';
			$cities 	=	$this->select->get_all_cities();
			
			$array 		=	array('user_id'	=>	$_SESSION['user']['id']);
			$array 		= 	array(
									"country_id"	=>	'101'
									); 		
			$states 	= 	$this->home->get_all_row("states",$array,'*','name','ASC');

			$array 		=	array('user_id'	=>	$_SESSION['user']['id']);
			if($_SESSION['user']['user_type']==4)
			{
				$address 	=	$this->select->get_one_address($array);
				$current_state 		= 	$address['state'];
				$city 		= 	$this->select->somequery("select c.name ,c.id from city c inner join states s on (s.id=c.state_id) inner join countries co on (co.id=s.country_id) where s.name='$current_state' and co.id='101'");
				$current_city = 	$address['city'];
				$locality 		= 	$this->select->somequery("select l.name from locality l inner join city c on (c.id=l.city_id) inner join states s on (s.id=c.state_id) inner join countries co on (co.id=s.country_id) where c.name='$current_city' and s.name='$current_state' and co.id='101'");
			}
			else{
				$address 	=	array();
				$city 	 	=	array();
				$locality 	 	=	array();
			}

			$array 		=	array(
									"bank_ac_user_id"	=>	$_SESSION['user']['id']
									);

			$account 	=	$this->home->get_one_row("bank_account",$array,"*");
			$clinic = '';
			if($_SESSION['user']['user_clinic_id']!='0')
			{
				$clinic 	= 	$this->home->get_one_row("users",array("id"=>$_SESSION['user']['user_clinic_id']),"user_name")['user_name'];

			}
			//print_r($clinic);
			$array 		=	array(
									'cities'	=>	$cities,
									'address'	=>	$address,
									'account'	=>	$account,
									'states'	=>	$states,
									'city'		=>	$city,
									'locality'	=>	$locality,
									'clinic'	=>	$clinic,
								);
			$this->load->view('doc/profile.php',['array'	=>	$array]); 
		}
		public function updateprofile(){
			$post 	=	$this->input->post();

			$array 	=	array(
								'user_about'			=>	$post['user_about'],
								'user_work'				=>	$post['user_work'],
								'user_service'			=>	$post['user_service'],
								'user_award'			=>	$post['user_award'],
								'user_name'				=>	$post['user_name'],
								'user_age'				=>	$post['user_age'],
								'user_experience'		=>	$post['user_experience'],
								'user_fee'				=>	$post['user_fee'],
								'user_gender'			=>	$post['user_gender'],
								'user_time'				=>	$post['user_time'],
								'updated_at'			=>	date('Y-m-d H:i:S'),
							);
			if(isset($post['user_indi_clinic_name']))
			{
				$array['user_indi_clinic_name'] = 	$post['user_indi_clinic_name'];
			}
			/*echo "<pre>";
			print_r($post);
			print_r($array);*/

			if($this->update->update_table('users','id',$_SESSION['user']['id'],$array))
			{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Profile updated successfully.</div>");
				if($_SESSION['user']['user_type']==4)
				{
					$array 	=	array('user_id'	=>	$_SESSION['user']['id']);
					if($address_id = $this->select->checkaddress($array)){
						$array 	=	array(
											 
											'adl1'		=>	$post['adl1'],
											'adl2'		=>	$post['adl2'],
											'location'	=>	$post['location'],
											'state'		=>	$post['state'],
											'city'		=>	$post['city'],
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
			}		
			else{
				$this->session->set_flashdata('profilemsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");
			}
			$user_id 	= 	$_SESSION['user']['id'];
			$_SESSION['user']= $this->select->get_single_row("select u.* ,uc.user_name as clinic_name from users u left join users uc on (u.user_clinic_id = uc.id) where u.id='$user_id'");
			return redirect(base_url('Doc/profile'));	
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
			$user_id 	= 	$_SESSION['user']['id'];
			$_SESSION['user']= $this->select->get_single_row("select u.* ,uc.user_name as clinic_name from users u left join users uc on (u.user_clinic_id = uc.id) where u.id='$user_id'");
			
			return redirect(base_url('Doc/profile'));

			
		}
		public function doctiming(){
			$_SESSION['page']	=	"timings";
			$timings 	=	$this->home->get_one_row('timings',array('user_id'	=>	$_SESSION['user']['id']),'*');
			$array 		=	array(
									'timings'	=>	$timings,
								);
			$this->load->view('doc/doctiming',['array'	=>	$array]);
		}
		public function timings(){
			$_SESSION['page']	=	"timings";
			$timings 	=	$this->home->get_one_row('timings',array('user_id'	=>	$_SESSION['user']['id']),'*');
			//echo $this->db->last_query();
			//for clinic and hospital doctors we will restrict the hours for their doctors
			$clinictime 	=	array();
			if($_SESSION['user']['user_type']!=4)
			{
				$clinictime 	=	$this->home->get_one_row('timings',array('user_id'	=>	$_SESSION['user']['user_clinic_id']),'*');
			}
			
			$array 		=	array(
									'timings'		=>	$timings,
									'clinictime'	=>	$clinictime,
								);
			$this->load->view('doc/timings',['array'	=>	$array]);
		}
		public function gallery(){
			$_SESSION['page']	='gallery';
			$id 		=	$_SESSION['user']['id'];
			$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc");
			$array 		=	array(
									'gallery'	=>	$gallery
								);
			$this->load->view('doc/gallery',['array'	=>	$array]);
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
			return redirect(base_url('doc/gallery'));
		}
		public function updatetimings(){
			$post =	$this->input->post();
			/*echo "<pre>";
			print_r($post);
			*/
			$key = array_keys($post);
			$day = $key[0];
			//echo $day;
			

			if($post[$day] == '1')
			{
				 
				if($post[$day."morn"]==0 && $post[$day."even"]==0){
					$new_array = array(
										$day	=>	0,
										$day."_morning_start"	=>	"00:00:00",
										$day."_morning_end"		=>	"00:00:00",
										$day."_evening_start"	=>	"00:00:00",
										$day."_evening_end"		=>	"00:00:00",
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);
				}
				else if($post[$day."morn"]==0){
					$new_array = array(
										$day	=>	1,
										$day."_morning_start"	=>	"00:00:00",
										$day."_morning_end"		=>	"00:00:00",
										$day."_evening_start"	=>	$post['evening_start'],
										$day."_evening_end"		=>	$post['evening_end'],
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);
				}
				else if($post[$day."even"]==0){
					$new_array = array(
										$day	=>	1,
										$day."_morning_start"	=>	$post['morning_start'],
										$day."_morning_end"		=>	$post['morning_end'],
										$day."_evening_start"	=>	"00:00:00",
										$day."_evening_end"		=>	"00:00:00",
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);
				}
				else{
					$new_array = array(
										$day	=>	1,
										$day."_morning_start"	=>	$post['morning_start'],
										$day."_morning_end"		=>	$post['morning_end'],
										$day."_evening_start"	=>	$post['evening_start'],
										$day."_evening_end"		=>	$post['evening_end'],
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);
				}

			}
			else{
				$new_array = array(
										$day	=>	0,
										$day."_morning_start"	=>	"00:00:00",
										$day."_morning_end"		=>	"00:00:00",
										$day."_evening_start"	=>	"00:00:00",
										$day."_evening_end"		=>	"00:00:00",
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);	
			}

			$where	=	array(
								'user_id'	=>	$_SESSION['user']['id']
								);
			//echo "<pre>";
			//print_r($new_array);
			if($new_array[$day."_morning_start"]>$new_array[$day."_morning_end"])
			{
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>Morning Start time can not be less than end time.</div>");
			}
			else if($new_array[$day."_evening_start"]>$new_array[$day."_evening_end"]){
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>Evening Start time can not be less than end time.</div>");
			}
			else{
				if($id = $this->select->checktimings($where))
				{
					if($this->update->update_table('timings','id',$id,$new_array))
					{
						//echo "updated";
					}
				}
				else{
					if($this->insert->insert_table($new_array,"timings"))
					{
						//echo "inserted";
					}
				}
			}
			return redirect(base_url('Doc/timings'));

		}
		public function updateindidoctimings(){
			$post =	$this->input->post();
			/*echo "<pre>";
			print_r($post);
			*/
			$key = array_keys($post);
			$day = $key[0];
			//echo $day;
			if($post[$day] == 1)
			{
				$array =	array(
									$day."_".$key['1'],
									$day."_".$key['2'],
									$day."_".$key['3'],
									$day."_".$key['4'],
								);

				array_shift($post);
				$new_array = array_combine($array,$post);
				$new_array[$day] =1;
				$new_array['created_at']	=	date('Y-m-d H:i:s');
				$new_array['updated_at']	=	date('Y-m-d H:i:s');
				$new_array['user_id']		=	$_SESSION['user']['id'];
				
			}
			else{
				$new_array = array(
										$day	=>	0,
										$day."_morning_start"	=>	"00:00:00",
										$day."_morning_end"		=>	"00:00:00",
										$day."_evening_start"	=>	"00:00:00",
										$day."_evening_end"		=>	"00:00:00",
										'updated_at'			=>	date('Y-m-d H:i:s'),
										'user_id'				=>	$_SESSION['user']['id']
									);	
			}

			$where	=	array(
								'user_id'	=>	$_SESSION['user']['id']
								);
			//echo "<pre>";
			//print_r($new_array);
			if($new_array[$day."_morning_start"]>$new_array[$day."_morning_end"])
			{
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>Morning Start time can not be less than end time.</div>");
			}
			else if($new_array[$day."_evening_start"]>$new_array[$day."_evening_end"]){
				$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>Evening Start time can not be less than end time.</div>");
			}
			else{
				if($id = $this->select->checktimings($where))
				{
					if($this->update->update_table('timings','id',$id,$new_array))
					{
						echo "updated";
					}
				}
				else{
					if($this->insert->insert_table($new_array,"timings"))
					{
						echo "inserted";
					}
				}
			}
			return redirect(base_url('Doc/doctiming'));

		}
		public function specialisation(){
			$_SESSION['page']	=	'specialisation';
			$array 		=	array(
										'qualification_doctor_id'	=>	$_SESSION['user']['id']
									);
			$edu 		=	$this->select->get_some_education($array);
			$speciality =	$this->select->get_all_specialization();
			$array 		=	array(
									'edu'			=>	$edu,
									'speciality'	=>	$speciality,
								);
			$this->load->view('doc/specialisation',['array'	=>	$array]);
			 
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
				$array[$i]['qualification_course_name']	=	$post['qualification_course_name'][$i];	
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
			return redirect(base_url('Doc/specialisation/'));
		}
		public function editspecialisation(){

			$_SESSION['page']	=	'specialisation';
			$array 	=	array(
								'qualification_doctor_id'	=>	$_SESSION['user']['id'],
								'qualification_id'	=>	$this->uri->segment(3)
							);
			if(count($edu 	=	$this->select->get_one_education($array)))
			{
				$speciality =	$this->select->get_all_specialization();
				$array 		=	array('edu'	=>	$edu,'speciality'	=>	$speciality);
				$this->load->view('doc/editspecialisation',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}

		}
		public function updatespecialisation(){
			$post 	=	$this->input->post();
			/*echo "<pre>";
			print_r($post);*/
			if($this->update->update_table("qualification",'qualification_id',$post['qualification_id'],$post))
			{
				$this->session->set_flashdata('docdetailmsg','<div class="alert alert-success">Education and Specialisation updated successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('docdetailmsg','<div class="alert alert-danger">We are facing some technical issues. Please try after some time.</div>');
			}
			return redirect(base_url('Doc/specialisation/'));
		}
		public function leave(){
			$_SESSION['page']	=	'leave'; 
			$array	=	array(
									'vacation_doctor_id'	=>	$_SESSION['user']['id'],
									);
			$vacations	=	$this->select->get_some_vacations($array);
			$array	=	array(
								 						 								 							
								'vacations'		=>	$vacations,								 								 							
								);			 
			//print_r($vacations);
			$this->load->view('doc/leave',['array'	=>	$array]);
		}
		public function storevacations()
		{
			$post	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			if($post['start_date']>$post['end_date'])
			{
				$this->session->set_flashdata('vacmsg','<div class="alert alert-danger">End date can not be less than start date.</div>');
				
			}
			else
			{				
				$step = '+1 day';
				$output_format = 'Y-m-d';
				$dates = array();
				$current = strtotime($post['start_date']);
				$last = strtotime($post['end_date']);

				while( $current <= $last ) {

					$dates[] = date($output_format, $current);
					$current = strtotime($step, $current);
				}

				$i=0;
				foreach($dates as $x)
				{
					$array[$i]['vacation_doctor_id']=$_SESSION['user']['id'];
					$array[$i]['vacation_date']=$x;
					$i++;
				}
				//print_r($dates);
				//print_r($array);
				if($this->insert->insert_batch_table($array,'vacation'))
				{
					$this->session->set_flashdata('vacmsg','<div class="alert alert-success">Leave added successfully.</div>');
				
				}
				else
				{
					$this->session->set_flashdata('vacmsg','<div class="alert alert-danger">We are facing some technical issues.Please try after some time.</div>');
				
				}			
			}
			return redirect(base_url('Doc/leave'));
		}
		public function cancelleave()
		{
			$post	=	$this->input->post();
			$this->load->model('delete');
			if($this->delete->delete_table($post,'vacation'))
			{
					$this->session->set_flashdata('vacmsg','<div class="alert alert-success">Leave cancelled successfully.</div>');
				
			}
			else
			{
				$this->session->set_flashdata('vacmsg','<div class="alert alert-danger">We are facing some technical issues.Please try after some time.</div>');
				
			}	
		}
		public function documents(){
			$_SESSION['page']	=	'documents'; 
			$array	=	array(
									'document_user_id'	=>	$_SESSION['user']['id'],
									);
			$document 	=	$this->select->get_some_documents($array);
			$council 	=	$this->select->get_all_council();
			$array 		=	array(
									'document'	=>	$document,
									'council'	=>	$council,
								);
			$this->load->view('doc/documents',['array'	=>	$array]);
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
				$array[$i]['document_user_id']		=	$_SESSION['user']['id'];
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
						$this->session->set_flashdata('docmsg','<div class="alert alert-success">Documents added successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('docmsg','<div class="alert alert-danger">We are gfacing some technical issues. Please try later.</div>');
					}
					$i++;
				}
			}			
			return redirect(base_url('doc/Documents'));
		}
		public function myappointments(){
			$_SESSION['page']	= "myappointments";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('Doc/myappointments/'),
								'per_page'		=>		'5',
								'total_rows'	=>		$this->select->count_all_appointments($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li >",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li >",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li >",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class=' active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li class='hidden'><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li class='hidden'><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$ap	=	$this->select->get_some_doc_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"ap"	=>	$ap,
							);
			//print_r($ap);
			$this->load->view('doc/myappointments',['array'	=>	$array]);

		}
		public function findappointments(){
			if($this->uri->segment(3)==NUll || $this->uri->segment(3)=='')
			{
				return redirect(base_url('Error404'));
			}
			$_SESSION['page']	= "myappointments";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_date'		=>	$this->uri->segment(3),
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			 		
			$ap	=	$this->select->get_some_doc_appointments(1000,0,$array);
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"ap"	=>	$ap,
							);
			//echo $this->db->last_query();
			$this->load->view('doc/findappointments',['array'	=>	$array]);

		}
		public function findmonthappointments(){
			$_SESSION['page']	=	'myappointments';
			$m 	=	$_GET['m'];
			$y 	=	$_GET['y'];
			//code to get number of appointments in a month per day wise
			$d=cal_days_in_month(CAL_GREGORIAN,$m,$y);
			for($i=1;$i<=$d;$i++)
			{
				$date	=	 date($y.'-'.$m.'-'.$i);
				//echo $date."<br>";
				$array		=	array(
										'ap_payment'	=>	1,
										'ap_status'		=>	1,
										'ap_date'		=>	$date,
										'ap_doctor_id'		=>	$_SESSION['user']['id'],
									);				
				
				//print_r($array);
				$monapp[$i]	['number']	=	$this->select->count_all_appointments($array);
				$monapp[$i]['date']		=	$date;
			
			}
			 
			$array 	=	array(
								"monapp"	=>	$monapp,
								"m"			=>	$m,
								"y"			=>	$y,
						);
			$this->load->view('doc/findmonthappointments',['array'	=>	$array]	);
		}
		public function cancel(){
			$ap_id 	=	$_POST['ap_id'];
			$this->load->model('update');
			$this->load->model('select');
			$this->load->model('insert');
			$array 	=	array('ap_id'	=>	$ap_id);
			$ap 	=	$this->select->get_one_appointment($array);
			$array 	=	array(
								'ap_status'		=>	3,
							);
			if($this->update->update_table("appointment","ap_id",$ap_id,$array))
			{
				$array 		=	array('id'	=>	$ap['ap_patient_id']);
				$patient 	=	$this->select->get_one_user($array);

				$array		=	array('wallet_patient_id'	=>		$patient['id']);
				$wallet		=	$this->select->get_one_wallet($array);
				if(count($wallet))
				{
					$balance['wallet_amount'] 	=	$wallet['wallet_amount']+$ap['ap_money'];
					$this->update->update_table("wallet","wallet_patient_id",$_SESSION['user']['id'],$balance);

				}
				else{
					$balance 	=	array(
											"wallet_patient_id"	=>	$patient['id'],
											"wallet_amount"		=>	$ap['ap_money'],
										);
					$this->insert->insert_table($balance,"wallet");
				}
				$data	=	'<html>

								<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
									
									<div style="width:100%;background:#3f5267;color:white;padding:5px;">
										<h2 style="text-align:center">Appointment Cancelled</h2>
									</div>
									<div style="width:100%;padding:10px;">
										<h3><b>Dear '.$patient['user_name'].',</b></h3>

										<p>The doctor has cancelled your appointment . Your amount of Rs. '.$ap['ap_money'].' has been refunded to your bookmediz wallet. </p>

										<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>

										<hr>
										<p>Regards : BOOKMEDIZ Team<br>
										Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
										<hr>
									</div>
								</div>
							</html>';
				$this->sendmail($patient['user_email'],"Bookmediz Appointment Cancelled",$data,"Appointment Cancelled");			
				$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"The doctor has cancelled your appointment with appointment id- ".$ap_id." . The amount has been refunded to your Bookmediz wallet.");
				$this->session->set_flashdata('apmsg',"<div class='alert alert-success'><p><b>The doctor cancelled your appointment ".$ap_id.". </b></p></div>");
				echo 1;
			}
			else{
				$this->session->set_flashdata('apmsg',"<div class='alert alert-danger'><p><b>We are facing some technical issues. Please try later.</b></p></div>");
				echo 0;
			}	
		}
		public function reschedule(){
			$ap_id 	=	$this->uri->segment(3);
			$array 	=	array(
								'ap_id'			=>	$ap_id,
								'ap_status'		=>	1,
								'ap_payment'	=>	1,
								'ap_doctor_id'	=>	$_SESSION['user']['id'],
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
				//print_r($shiftstarttime);
				$shiftstarttime 	= 	($shiftstarttime[0]*3600)+($shiftstarttime[1]*60)+($shiftstarttime[2]);
				$now 				= 	explode(":",date("H:i:s"));
				//print_r($now);
				$now 				= 	($now[0]*3600)+($now[1]*60)+($now[2]);
				$maxlimit 			= 	$now 	+ 	$now;
				//echo $now;
				//print_r($shiftstarttime);
				if($shiftstarttime<$maxlimit)
				{
					$this->session->set_flashdata('apmsg',"<div class='alert alert-danger'><p style='color:white !important;'><b>You can not reschedule this appointment. The appointment can only be rescheduled 2 hours prior to the appointment shift.</b></p></div>");
						return redirect (base_url('Doc/myappointments'));
					 
				} 
			}
			//exit();
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
		public function changeapstatus(){
			$post 	=	$_POST;
			$this->load->model('update');
			$this->update->update_table("appointment","ap_id",$post['ap_id'],$post);
			if($_POST['ap_current_status']==2)
			{
				$ap 		= 	$this->home->get_one_row("appointment",array("ap_id"	=> 	$post['ap_id']),"*");
				$array		=	array('wallet_patient_id'	=>		$ap['ap_patient_id']);
				$wallet		=	$this->select->get_one_wallet($array);
				if(count($wallet))
				{
					$balance['wallet_amount'] 	=	$wallet['wallet_amount']+$ap['ap_money'];
					$this->update->update_table("wallet","wallet_patient_id",$ap['ap_patient_id'],$balance);
					 
				}
				else{
					$balance 	=	array(
											"wallet_patient_id"	=>	$ap['ap_patient_id'],
											"wallet_amount"		=>	$ap['ap_money'],
										);
					$this->insert->insert_table($balance,"wallet");
					 
				}
			}
		}
		public function myrevenue(){
			$_SESSION['page']	=	"myrevenue";
			$date 	=	 $this->uri->segment(3);
			$date   = 	 explode("-",$date);
			$m =	$date[1];
			$y =	$date[0];
			//echo gettype ($y);
			if($m == '' || $y=='' || $y >(date('Y')+1))
			{
				return redirect(base_url('Error404'));
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
										'ap_doctor_id'			=>	$_SESSION['user']['id'],
									);				
				
				//print_r($array);
				$monrev[$i]		=	$this->select->get_added_revenue($array);
				$monrev[$i]['date']		=	$date;
				 
			}
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array); 
			$array 	=	array(
								'monrev'	=>	$monrev,
								'm'			=>	$m,
								'y'			=>	$y,
								'settings'	=>	$settings,
								);
			$this->load->view('doc/myrevenue',['array'	=>	$array]);
		}
		public function questions(){
			$_SESSION['page']	= "questions";
			$array 	=	array(
								'question_doc_clear'	=>	0,
								'question_doctor_id'		=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('Doc/questions/'),
								'per_page'		=>		10,
								'total_rows'	=>		$this->select->count_all_questions($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li >",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li >",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li >",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class=' active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li class='hidden'><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li class='hidden'><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$que	=	$this->select->get_some_questions($config['per_page'],$this->uri->segment(3),$array);
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"que"	=>	$que,
							);
			//echo "<pre>";
			//print_r($que);
			$this->load->view('doc/questions',['array'	=>	$array]);
		}
		public function storeans(){
			$post 	=	$this->input->post();
			$post['question_ans_add_time']	=	date('Y-m-d H:i:s');
			if($this->update->update_table('question','question_id',$post['question_id'],$post))
			{
				$array 	=	array(
									'id'	=>	$post['question_patient_id']
								);
				$patient 	=	$this->select->get_one_user($array);
				$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"Hello ".$patient['user_name']." , The question that you asked from one of our doctors has been answered. Please login to BOOKMEDIZ to view the answer.");
				$this->session->set_flashdata('qmsg',"<div class='alert alert-success'>Answer added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('qmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later. </div>");
			}

			return redirect(base_url('Doc/questions'));
		}
		public function clearquestion(){
			$post 	=	$this->input->post();
			$post['question_doc_clear']	=	1;
			if($this->update->update_table('question','question_id',$post['question_id'],$post))
			{
				 echo 1;
			}
			else{
				echo 0;
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
			return redirect (base_url('Doc/profile'));
		}
		public function mypatients(){
			$_SESSION['page']	= "mypatients";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_status'		=>	1,
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');
			$config		=	array(
								'base_url'		=>		base_url('Doc/mypatients/'),
								'per_page'		=>		'10',
								'total_rows'	=>		$this->select->count_patientwise_appointments($array),
								'full_tag_open'	=>		"<ul class='pagination pull-right'>",
								'full_tag_close'=>		"</ul>",
								'next_tag_open'=>		"<li >",
								'next_tag_close'=>		"</li>",
								'prev_tag_open'=>		"<li >",
								'prev_tag_close'=>		"</li>",
								'num_tag_open'=>		"<li >",
								'num_tag_close'=>		"</li>",
								'cur_tag_open'=>		"<li class=' active'><a>",
								'cur_tag_close'=>		"</a></li>",
								'first_tag_close'=>		"</a></li>",
								'first_tag_open'=>		"<li class='hidden'><a>",
								'last_tag_close'=>		"</a></li>",
								'last_tag_open'=>		"<li class='hidden'><a>",
								 
								
							);
			$this->pagination->initialize($config);			
			$ap	=	$this->select->get_some_patientwise_appointments($config['per_page'],$this->uri->segment(3),$array);
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"ap"	=>	$ap,
							);
			//echo "<pre>";
			//print_r($ap);
			$this->load->view('doc/mypatients',['array'	=>	$array]);
		}
		public function storeinditimings(){
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
			$new_array['user_id']  = $_SESSION['user']['id'];
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
			return redirect(base_url('Doc/doctiming'));
		}
		public function delspecilaity(){
			$post 	= 	$_POST;
			$this->load->model('delete');
			if($this->delete->delete_table($post,'qualification'))
			{
					$this->session->set_flashdata('docdetailmsg','<div class="alert alert-success">Specialisation deleted successfully.</div>');
				
			}
			else
			{
				$this->session->set_flashdata('docdetailmsg','<div class="alert alert-danger">We are facing some technical issues.Please try after some time.</div>');
				
			}
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
			return redirect(base_url('Doc/profile'));
		}
		public function test(){
			$ap_id 	=	'APID15275889371644'; 
			$array 	=	array('ap_id'	=>	$ap_id);
			$ap 	=	$this->select->get_one_appointment($array);
			$array 	=	array(
								'ap_status'		=>	3,
							);
			 	$array 		=	array('id'	=>	$ap['ap_patient_id']);
				$patient 	=	$this->select->get_one_user($array);
				$data	=	'<html>

								<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
									
									<div style="width:100%;background:#3f5267;color:white;padding:5px;">
										<h2 style="text-align:center">Appointment Cancelled</h2>
									</div>
									<div style="width:100%;padding:10px;">
										<h3><b>Dear '.$patient['user_name'].',</b></h3>

										<p>The doctor has cancelled your appointment . Your amount of Rs. '.$ap['ap_money'].' has been refunded to your bookmediz wallet. </p>

										<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
										

										<hr>
										<p>Regards : BOOKMEDIZ Team<br>
										Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
										<hr>
									</div>
								</div>
							</html>';
							echo $data;
				//$this->sendmail($patient['user_email'],"Bookmediz Appointment Cancelled",$data,"Appointment Cancelled");			
				//$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"The doctor has cancelled your appointment with appointment id- ".$ap_id." . The amount has been refunded to your Bookmediz wallet.");
				$this->session->set_flashdata('apmsg',"<div class='alert alert-success'><p><b>The doctor cancelled your appointment ".$ap_id.". </b></p></div>");
			 	
		}
	}

?>