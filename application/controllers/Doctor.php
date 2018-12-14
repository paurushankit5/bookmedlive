<?php
	Class Doctor extends MY_Controller
	{
		public function __construct(){
			parent::__construct();
			$this->load->model('select');
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
		}
		 
		public function viewprofile(){
			$id 	=	$this->uri->Segment(3);
			$array 		=	array(
									'id'	=>	$this->uri->segment(3),
									'is_active'	=>	1,

								);
			$sql	=	"SELECT u.*,location,city,adl1,adl2,map,a.id as address_id ,u.user_clinic_id, coalesce(uc.user_name, u.user_indi_clinic_name) as clinic_name,
								mon,tue,wed,thu,fri,sat,sun,
								mon_morning_start,mon_morning_end,mon_evening_start,mon_evening_end,
								tue_morning_start,tue_morning_end,tue_evening_start,tue_evening_end,
								wed_morning_start,wed_morning_end,wed_evening_start,wed_evening_end,
								thu_morning_start,thu_morning_end,thu_evening_start,thu_evening_end,
								fri_morning_start,fri_morning_end,fri_evening_start,fri_evening_end,
								sat_morning_start,sat_morning_end,sat_evening_start,sat_evening_end,
								sun_morning_start,sun_morning_end,sun_evening_start,sun_evening_end
								from users u
								inner join timings t on (t.user_id=u.id)
							 	left join users uc on (uc.id = u.user_clinic_id)							 	 
							 	left join address a on
							 	case WHEN u.user_clinic_id!='0' Then (a.user_id=u.user_clinic_id) Else (a.user_id=u.id) END	
							 	where u.id ='$id' and u.is_active=1	and (u.user_type ='4' or u.user_type ='5' or u.user_type ='6' )	
							";
			$doc		=	$this->select->get_questions($sql);				
			if(count($doc)){
				$array 		=	array(
										'qualification_doctor_id'	=>	$this->uri->segment(3)
									);
				$doc[0]['edu'] 		=	$this->select->get_some_education($array);
				$user_id = $doc[0]['id'];
					$doc[0]['specialisation'] = $this->select->get_single_row("(select GROUP_CONCAT((somename) SEPARATOR '<br> ')as specialisation from (select concat(qualification_specialization,', ',qualification_name,' in ',qualification_course_name) as somename from (select qualification_specialization, qualification_course_name,GROUP_CONCAT((qualification_name) Separator ', ') as qualification_name from qualification q1 where q1.qualification_doctor_id='$user_id' group by qualification_course_name)  q2) q3)")['specialisation'];
				if(isset($_SESSION['user']['id']))
				{
					$array 	=	array(
										'patient_id'	=>	$_SESSION['user']['id'],
										'user_id'		=>	$doc[0]['id'],
									);
					$doc[0]['eligiblerating']		=	$this->home->checkrow($array,"rating");	

				}
				else{
					$doc[0]['eligiblerating']    	=	false;
				}

				$array 	=	array(
										"user_id"	=>	$doc[0]['id']
									);
				$doc[0]['ratings']	=	$this->select->get_some_review(5,0,$array);
				$doc[0]['countratings']	=	$this->select->count_all_review($array);
				$doc[0]['gallery'] 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc");
				$array 				= 	array(
												"document_user_id"	=> 	$doc[0]['id']
											);
				$doc[0]['document'] =  $this->home->get_all_row("document",$array,"document_council_name,document_reg_no",'id','ASC');
				$array 				=  array(
												"qualification_doctor_id" 	=> 	$doc[0]['id']
											);
				$doc[0]['qualification'] =  $this->home->get_all_row("qualification",$array,"qualification_name,qualification_complete_year,qualification_college",'qualification_id','ASC');
				
				$array 		=	array(
										'doc'	=>	$doc,										 
									);
				 
				$this->load->view('home/viewprofile',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function showreview(){
			$array 	=	array(
										"user_id"	=>	$_POST['user_id']
									);
				$rating	=	$this->select->get_some_review(5,$_POST['number']*5,$array);
				if(count($rating))
				{
					foreach($rating as $ratings)
					{
						//echo $this->db->last_query();
						?>
						<div class="media">							 
				  			<div class="media-body">
				  				<!-- Ratings -->
				  				<div class="ratings">
				  					<div class="name">
					  					<h5><?= $ratings['user_name'];?></h5>
					  				</div>
				  					 <?php
										if($ratings['ratings']!=0)
										{	
											$totalrating1 = $ratings['ratings'];
											$totalratings = $ratings['ratings'];
											//echo $totalratings;
											$starrating = 1;
											//echo $totalratings;
											$lastrating  = 5-ceil($totalratings);
											while($starrating<= $totalratings)
											{
												?>
													<span class="fa fa-star checked" ></span>
												<?php
												$starrating++;
											}																 
											while($lastrating!=0)
											{
												?>
													<span class="fa fa-star" ></span>
												<?php
												$lastrating--;
											}
										?>
									 
									<?php
										}
									?>
				  				</div>
				  				
				  				<div class="date">
				  					<p><?= date("M d, Y",strtotime($ratings['created_at']));?></p>
				  				</div>
				  				<div class="review-comment">
				  					<p class="text text-justify">
				  						<?= $ratings['comment'];?>
				  					</p>
				  				</div>
				  			</div>
				  		</div>
						<?php
					}
				}
				else{
					echo "0";
				}
		}
		public function bookappointment(){
			ob_start();
			if(!isset($_SESSION['user']))
			{
				$_SESSION['url']	=	base_url('doctor/bookappointment/').$this->uri->segment(3);
				return redirect (base_url('Login'));
			}
			$this->load->model('select');
			$array	=	array(
								'id'			=>	$this->uri->segment(3),
								'is_active'		=>	1,
								); 
			$doctor 	= 	$this->select->get_one_user($array);
			if(!count($doctor)){
				return redirect (base_url('Error404'));
			}
			if(!(in_array($doctor['user_type'], array(4,5,6)))){
				return redirect (base_url('Error404'));
			}
			$array 	=	array('user_id'	=>	$this->uri->segment(3));
			$time 	=	$this->select->get_user_time($array);
			if(!count($time)){
				return redirect(base_url('Error404'));
			}
			/*$array	=	array('vacation_doctor_id'	=>		$this->uri->segment(3));
			$vacations	=	$this->select->get_some_vacations($array);*/
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
			$wallet		=	$this->select->get_one_wallet($array);
			$array 			= 	array(
											"settings_id"	=> 	2,
										);
			$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];

			$array 		=	array(
									'doctor'	=>	$doctor,
									'totalamount'	=>	$totalamount,
									'settings'	=>	$settings,
									'wallet'	=>	$wallet,
									'time'		=>	$time,

									);
			$this->load->view('home/bookappointment',['array'	=>	$array]);
		}
		public function storeratings(){
			$post 	=	$this->input->post();
			$post['created_at']		=	date('Y-m-d H:i:s');
			$post['updated_at']		=	date('Y-m-d H:i:s');
			$post['patient_id']		=	$_SESSION['user']['id'];
			//echo "<pre>";
			//print_r($post);
			$this->load->model('insert');
			if($this->insert->insert_table($post,'rating')){
				//echo 1;
				$ratings 	=	$post['ratings'];
				$clinic_id 	=	$post['user_id'];
				$sql		=	"select user_star,user_rating,user_rated from users where id='$clinic_id'";
				$ratings	=	$this->select->get_questions($sql);
				//print_r($ratings[0]);	
				$array['user_rating'] 	=	$ratings[0]['user_rating']+$post['ratings'];
				$array['user_rated'] 	=	$ratings[0]['user_rated']+1;
				$array['user_star'] 	=	$array['user_rating']/$array['user_rated'];
				$this->load->model('update');
				$this->update->update_table("users","id",$post['user_id'],$array);
				return redirect(base_url('doctor/viewprofile/'.$post['user_id']));
			}
		}
		public function storequestion(){
			$post 	=	$this->input->post();
			$post['question_add_time']	=	date("Y-m-d H:i:s");
			$post['question_patient_id']=	$_SESSION['user']['id'];
			$this->load->model('insert');
			if($this->insert->insert_table($post,'question')){
				echo "1";
			}
			else{
				echo "0";
			}
		}
		
	}
?>