<?php
	class Medical extends MY_Controller{
		public function profile(){
			$id =	$this->uri->segment(3);
			$this->load->model('select');
			$this->load->model('home');
			$array 	=	array(
								"id" 			=>	$id,
								"is_active" 	=>	1,
								);
			$sql	=	"SELECT u.*,location,city,adl1,adl2,map,a.id as address_id ,u.user_clinic_id,
								mon,tue,wed,thu,fri,sat,sun,
								mon_morning_start,mon_morning_end,mon_evening_start,mon_evening_end,
								tue_morning_start,tue_morning_end,tue_evening_start,tue_evening_end,
								wed_morning_start,wed_morning_end,wed_evening_start,wed_evening_end,
								thu_morning_start,thu_morning_end,thu_evening_start,thu_evening_end,
								fri_morning_start,fri_morning_end,fri_evening_start,fri_evening_end,
								sat_morning_start,sat_morning_end,sat_evening_start,sat_evening_end,
								sun_morning_start,sun_morning_end,sun_evening_start,sun_evening_end
								from users u
								left join timings t on (t.user_id=u.id)
							 	left join users uc on (uc.id = u.user_clinic_id)							 	 
							 	left join address a on (a.user_id=u.id)
							 	where u.id ='$id' and u.is_active=1	and (u.user_type ='3' or u.user_type='2')
							";
			//$doc		=	$this->select->get_questions($sql);	
			if(count($user = $this->select->get_questions($sql)))
			{
				
				
				$array 	=	array(
										"user_id"	=>	$user[0]['id']
									);
				$user[0]['ratings']	=	$this->select->get_some_review(5,0,$array);
				$user[0]['countratings']	=	$this->select->count_all_review($array);
				if(isset($_SESSION['user']['id']))
				{
					$array 	=	array(
										'patient_id'	=>	$_SESSION['user']['id'],
										'user_id'		=>	$user[0]['id'],
									);
					$user[0]['eligiblerating']		=	$this->home->checkrow($array,"rating");	

				}
				else{
					$user[0]['eligiblerating']    	=	false;
				}
				$array 	=	array(
									'user_clinic_id'	=>	$id,
									"is_active"			=>	1
								);
				$user['0']['docs'] 	=	$this->select->get_questions("SELECT u.id, user_name, user_image,user_fee, user_experience,s.name as subdepartment FROM users u left join subdepartment s on (u.user_subdept_id  = s.id) WHERE user_clinic_id = $id AND is_active = 1 ORDER BY s.name ASC");
				if(count($user['0']['docs']))
				{
					$i=0;
					foreach ($user['0']['docs'] as $x) {
						$user_id = $x['id'];
						$user['0']['docs'][$i++]['specialisation'] = $this->select->get_single_row("(select GROUP_CONCAT((somename) SEPARATOR ', ')as specialisation from (select concat(qualification_specialization,', ',qualification_name,' in ',qualification_course_name) as somename from (select qualification_specialization, qualification_course_name, GROUP_CONCAT((qualification_name) Separator ', ') as qualification_name from qualification q1 where q1.qualification_doctor_id='$user_id' group by qualification_course_name)  q2) q3)")['specialisation'];
					}
				} 
				$array 				=	array(
											"user_id"	=>	$id
										);
				$user['0']['services'] 			=	$this->select->get_clinic_services($array);
				$array 	=	array(
							'qualification_doctor_id'		=>		$id,
							);
				$user['0']['qualification'] 	=	$this->select->get_some_education($array);
				$user['0']['gallery'] 	=	$this->select->somequery("select * from gallery  where image_user_id='$id' order by image_order desc");
				$array 	=	array('hos'	=>	$user['0']);
				$this->load->view('home/hosprofile',['array'	=>	$array]); 
			}
			else{
				return redirect (base_url('Error404'));
			}
		}
		public function storeratings(){
			$post 	=	$this->input->post();
			$post['created_at']		=	date('Y-m-d H:i:s');
			$post['updated_at']		=	date('Y-m-d H:i:s');
			$post['patient_id']		=	$_SESSION['user']['id'];
			//echo "<pre>";
			//print_r($post);
			$this->load->model('insert');
			$this->load->model('update');
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
				return redirect(base_url('Medical/profile/'.$post['user_id']));
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
	}
	
?>