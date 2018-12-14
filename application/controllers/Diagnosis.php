<?php
	class Diagnosis extends MY_Controller{
		public function __construct(){
			parent ::__construct();
			$this->load->model('insert');
            $this->load->model('select');
            $this->load->model('update');
            $this->load->model('home');
            if(!isset($_SESSION['diagnosis_id']))
			{
				return redirect(base_url('Error404'));
			}	
			$_SESSION['page'] = '';
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
			$this->load->view('diagnosis/dashboard',['array'	=> 	$array]);
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
			$this->load->view('diagnosis/profile.php',['array'	=>	$array]); 

		}
		public function updateprofile(){
			$post 	=	$this->input->post();
			$array 	=	array(
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
			return redirect(base_url('diagnosis/profile'));	
		}
		
		public function updatepic(){
			//print_r($_FILES);*/
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
			return redirect(base_url('diagnosis/profile'));			
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
			return redirect (base_url('Diagnosis/profile'));
		}
		public function gallery(){
			$_SESSION['page']	='gallery';
			$id 		=	$_SESSION['user']['id'];
			$gallery 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc");
			$array 		=	array(
									'gallery'	=>	$gallery
								);
			$this->load->view('diagnosis/gallery',['array'	=>	$array]);
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
			return redirect(base_url('Diagnosis/gallery'));
		}
		public function timings(){
			$_SESSION['page']	=	"timings";
			$timings 	=	$this->home->get_one_row('timings',array('user_id'	=>	$_SESSION['user']['id']),'*');
			$array 		=	array(
									'timings'	=>	$timings,
								);
			$this->load->view('diagnosis/timings',['array'	=>	$array]);
		}
		public function updatetimings(){
			$post 	=	$this->input->post();
			if(!isset($post['mon']))
			{
				$post['mon']	=	0;
			}
			if(!isset($post['tue']))
			{
				$post['tue']	=	0;
			}
			if(!isset($post['wed']))
			{
				$post['wed']	=	0;
			}
			if(!isset($post['thu']))
			{
				$post['thu']	=	0;
			}
			if(!isset($post['fri']))
			{
				$post['fri']	=	0;
			}
			if(!isset($post['sat']))
			{
				$post['sat']	=	0;
			}
			if(!isset($post['sun']))
			{
				$post['sun']	=	0;
			}
			$post['updated_at']	=	date("Y-m-d H:i:s");
			$post['user_id']	=	$_SESSION['user']['id'];

			$array 	=	array("user_id"	=>	$_SESSION['user']['id']);
			if($this->home->checkrow($array,"timings"))
			{
				if($this->update->update_table("timings","user_id",$_SESSION['user']['id'],$post))
				{
					$this->session->set_flashdata('timingmsg',"<div class='alert alert-success'>Timings updated successfully.</div>");
				}
				else{
					$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			else{
				$post['created_at']	=	date("Y-m-d H:i:s");
				if($this->insert->insert_table($post,"timings"))
					{
					$this->session->set_flashdata('timingmsg',"<div class='alert alert-success'>Timings added successfully.</div>");
				}
				else{
					$this->session->set_flashdata('timingmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later.</div>");
				}
			}
			return redirect(base_url('Diagnosis/timings'));
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
			$this->load->view('diagnosis/leave',['array'	=>	$array]);
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
			return redirect(base_url('Diagnosis/leave'));
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
		public function ownership(){
			$_SESSION['page']	=	"ownership";
			$array 	=	array(
								"user_id"	=>	$_SESSION['user']['id']
							);
			$certi 	=	$this->home->get_one_row("clinic",$array,"*");
			$array 	=	array(
								"certi"		=>	$certi
								);
			//print_r($array);
			$this->load->view('diagnosis/ownership',['array'	=>	$array]);	
		}	
		public function updateownership(){
			$post 	=	$this->input->post();
			$post['user_id']	=	$_SESSION['user']['id'];
			if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/'))
			{
				mkdir('./images/user/'.$_SESSION['user']['id'].'/'); 
			}
			 
			if($_FILES['path_reg_proof']['name']!='')
			{
				$post['path_reg_proof']	=	$_FILES['path_reg_proof']['name'];
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/reg/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/reg/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/reg/');
				}
				move_uploaded_file($_FILES['path_reg_proof']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/reg/'.$post['path_reg_proof']);
			}
			if($_FILES['path_owner']['name']!='')
			{
				$post['path_owner']	=	$_FILES['path_owner']['name'];
				if(!file_exists('./images/user/'.$_SESSION['user']['id'].'/owner/'))
				{
					mkdir('./images/user/'.$_SESSION['user']['id'].'/owner/'); 
				}
				else{
					$this->delete_files('./images/user/'.$_SESSION['user']['id'].'/owner/');
				}
				move_uploaded_file($_FILES['path_owner']['tmp_name'],'./images/user/'.$_SESSION['user']['id'].'/owner/'.$post['path_owner']);
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
					$this->session->set_flashdata('certimsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later</div>");
				}
			}
			else{
				if($this->insert->insert_table($post,"clinic"))
				{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-success'>Certificates added successfully.</div>");
				}	
				else{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later</div>");
				}
			}
			return redirect(base_url('Diagnosis/ownership'));
		}
		public function testwedo(){
			$_SESSION['page']	=	"tests";
			$id 				=	$_SESSION['user']['id'];
			$cat 				=	$this->select->get_questions("select t.*,(select count(test_id) as count from test where test_path_id='$id' and test_cat_id=t.id) as count from test_category t inner join diagnosis_category d on (d.cat_id = t.id) where d.user_id = '$id' order by cat_name asc");
			
			/*echo "<pre>";
			print_r($cat); */
			$array 				=	array(
											'cat'	=>	$cat
										);
			$this->load->view('diagnosis/testwedo',['array'	=>	$array]);
		}
		public function addtests(){
			$_SESSION['page']	=	"tests";
			$id 				=	$_SESSION['user']['id'];
			$cat 				=	$this->select->get_questions("select t.* from test_category t inner join diagnosis_category d on (d.cat_id = t.id) where d.user_id = '$id' order by cat_name asc");
			$array 	=	array(
								"cat"	=>	$cat,
							);
			$this->load->view('diagnosis/addtests',['array'	=>	$array]);
		}
		public function storetests(){
			$post 	=	$_POST;
			if(count($post['test_cat_id']))
			{
				$i=0;
				foreach ($post['test_cat_id'] as $x) {
					$array[$i]['test_cat_id']	=	$x;
					$array[$i]['test_name']	=	$post['test_name'][$i];
					$array[$i]['test_price']	=	$post['test_price'][$i];
					$array[$i]['test_path_id']	=	$_SESSION['user']['id'];
					$i++;
				} 
				if($this->insert->insert_batch_table($array,"test"))
				{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-success'>Tests added successfully.</div>");
					 
				}
				else{
					$this->session->set_flashdata('certimsg',"<div class='alert alert-danger'>We are facing some technical issues.Please try later.</div>");
				 
				}
			}
			return redirect(base_url('diagnosis/testwedo'));
		}
		public function showtests(){
			$post 	=	$_POST;
			$post['test_path_id']	=	$_SESSION['user']['id'];
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
						<td>
							<a href="<?= base_url('Diagnosis/edittest/'.$x['test_id']);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
							<button onClick="deltest(this,'<?= $x['test_id'];?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
						</td>
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
		public function deltest(){
			$post 	=	$_POST;
			$post['test_path_id']	=	$_SESSION['user']['id'];
			$this->load->model('delete');
			if($this->delete->delete_table($post,"test")){
				echo  1;
			}
			else{
				echo 2;
			}

		}
		public function edittest(){
			$_SESSION['page']	=	"tests";
			$post 	=	array(
								"test_id"	=>	$this->uri->segment(3),
								"test_path_id"	=>	$_SESSION['user']['id'],
							);
			$test 	=	$this->home->get_one_row("test",$post,"*");
			if(!count($test))
			{
				return redirect(base_url('Error404'));
			}
			$array 				=	array(
											"1"	=>	1
										);
			$cat 				=	$this->home->get_all_row("test_category",$array,"*",'cat_name','ASC');
			$array 				=	array(
											'cat'	=>	$cat,
											'test'	=>	$test,
										);
			$this->load->view('diagnosis/edittest',['array'	=>	$array]);
		}
		public function updatetests(){
			$post 	=	$_POST;
			if($this->update->update_table('test','test_id',$post['test_id'],$post))
			{
				$this->session->set_flashdata('testmsg',"<div class='alert alert-success'>Test updated successfully.</div>");
			}
			else{
				$this->session->set_flashdata('testmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try after some time.</div>");
			}
			return redirect(base_url('Diagnosis/edittest/'.$post['test_id']));
		}
		public function category(){
			$_SESSION['page'] 	=	'category';
			$allcat 	=	$this->home->get_all_row("test_category","1=1","*","cat_name","ASC");
			$mycat 		=	$this->home->get_all_row("diagnosis_category",array('user_id'	=>	$_SESSION['user']['id']),"cat_id");
			$array 		=	array(
									"allcat"	=>	$allcat,
									"mycat"		=>	$mycat,
								);
			$this->load->view('diagnosis/category',['array'		=>	$array]);
		}
		public function storecategory(){
			$post 	=	$this->input->post();
			//echo "<pre>";
			//print_r($post);
			if(empty($post))
			{
				return redirect (base_url('diagnosis/category'));
			}
			$delarray 	=	array('user_id'	=>	$_SESSION['user']['id']);
			$this->load->model('delete');
			//db transaction start
			$this->db->trans_start();
 			$this->delete->delete_table($delarray,"diagnosis_category");
			if(count($post['cat_id']))
			{
				$i=0;
				foreach($post['cat_id'] as $x)
				{
					$array[$i]['cat_id'] 	=		$x;
					$array[$i]['user_id'] 	=		$_SESSION['user']['id'];
					$i++;
				}
			}
			$this->insert->insert_batch_table($array,"diagnosis_category");
			$this->db->trans_complete();
			//db transaction comnplete
			if ($this->db->trans_status() === FALSE)
			{
			  	$this->session->set_flashdata('catmsg',"<div class='alert alert-success'>Oops!.. We are facing some technical issues . Please try later.</div>");
			}
			else
			{					
					 $this->session->set_flashdata('catmsg',"<div class='alert alert-success'>Profile updated successfully.</div>");
			}
			return redirect(base_url('diagnosis/category'));
		}
		public function appointments(){
			$_SESSION['page']	= "appointments";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			$this->load->library('pagination');
		
			$config		=	array(
								'base_url'		=>		base_url('Diagnosis/appointments/'),
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
			if(count($ap))
			{
				$i=0;
				foreach($ap as $x)
				{
					$test_ids 	=	$x['ap_test_ids'];
					$sql 	=	 "select GROUP_CONCAT(test_name Separator ' , ') as test_name from test where test_id in ($test_ids) ";
					//echo $sql;
					$test 	=	$this->select->get_single_row($sql);
					$ap[$i]['test'] = $test['test_name'];
					$i++;
				}
			}
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"ap"	=>	$ap,
							);
			//print_r($ap);
			$this->load->view('diagnosis/appointments',['array'	=>	$array]);
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

										<p>The diagnois center has cancelled your appointment . Your amount of Rs. '.$ap['ap_money'].' has been refunded to your bookmediz wallet. </p>

										<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>

										<hr>
										<p>Regards : BOOKMEDIZ Team<br>
										Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
										<hr>
									</div>
								</div>
							</html>';
				$this->sendmail($patient['user_email'],"Bookmediz Appointment Cancelled",$data,"Appointment Cancelled");			
				$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"The Diagnosis center has cancelled your appointment with appointment id- ".$ap_id." . The amount has been refunded to your Bookmediz wallet.");
				$this->session->set_flashdata('apmsg',"<div class='alert alert-success'><p><b>The Diagnosis cancelled your appointment ".$ap_id.". </b></p></div>");
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
		public function findappointments(){
			if($this->uri->segment(3)==NUll || $this->uri->segment(3)=='')
			{
				return redirect(base_url('Error404'));
			}
			$_SESSION['page']	= "appointments";
			$array 	=	array(
								'ap_payment'	=>	1,
								'ap_date'		=>	$this->uri->segment(3),
								'ap_doctor_id'		=>	$_SESSION['user']['id'],
							);
			 		
			$ap	=	$this->select->get_some_doc_appointments(1000,0,$array);
			if(count($ap))
			{
				$i=0;
				foreach($ap as $x)
				{
					$test_ids 	=	$x['ap_test_ids'];
					$sql 	=	 "select GROUP_CONCAT(test_name Separator ' , ') as test_name from test where test_id in ($test_ids) ";
					//echo $sql;
					$test 	=	$this->select->get_single_row($sql);
					$ap[$i]['test'] = $test['test_name'];
					$i++;
				}
			}
			$array 	=	array(
								'count'	=>	$this->uri->segment(3),	
								"ap"	=>	$ap,
							);
			//echo $this->db->last_query();
			$this->load->view('diagnosis/findappointments',['array'	=>	$array]);

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
			$this->load->view('diagnosis/myrevenue',['array'	=>	$array]);
		}
		public function findmonthappointments(){
			$_SESSION['page']	=	'appointments';
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
			$this->load->view('diagnosis/findmonthappointments',['array'	=>	$array]	);
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
			return redirect(base_url('Diagnosis/profile'));
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
				$this->smsgatewaycenter_com_Send("91".$patient['user_mob'],"Hello ".$patient['user_name']." , The question that you asked from ".$_SESSION['user']['user_name']." has been answered. Please login to BOOKMEDIZ to view the answer.");
				$this->session->set_flashdata('qmsg',"<div class='alert alert-success'>Answer added successfully.</div>");
			}
			else{
				$this->session->set_flashdata('qmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try later. </div>");
			}

			return redirect(base_url('Diagnosis/questions'));
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
			$this->load->view('diagnosis/questions',['array'	=>	$array]);
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
	}
?>