<?php
	Class Search extends MY_Controller
	{		 
		public function index(){
			$post 	=	$this->input->get();
			$this->load->model('home');
			if($post['result_type']=='' )
			{
				$post['result_type'] = 'speciality';
			}
			if($post['location']=='' )
			{
				$post['location'] = 'Civil Township';
			}
			
			if($post['city']=='' )
			{
				$post['city'] = 'Rourkela';
			}
			//print_r($post);

			if($post['result_type']=='speciality')
			{
				
				$_SESSION['current_city']['name'] = $_GET['city'];
				$_SESSION['current_locality'] = $_GET['location'];
				if(isset($_SESSION['current_city']))
			      {
			        $array    = array(
			                            "name"  =>  $_SESSION['current_city']['name']
			                          );
			       // print_r($_SESSION['current_city']['name']);
			        $array    = array(
			                        "city_id" =>  $this->home->get_one_row("city",$array,"id")['id'] //for rorkela city_id is 3102
			                      ); 
			      }
			      else{
			        $array    = array(
			                        "city_id" =>  '3102' //for rorkela city_id is 3102
			                      ); 
			      }
			    $locality		=	$this->select->get_some_locality($array);
				$speciality	=	$this->getspeciality();
			 
				$array	=	array(
								'locality'		=>	$locality,
								'speciality'	=>	$speciality,
							);
				$this->load->view('home/findspeciality',['array'	=>	$array]	);	
			}
			else if($post['result_type']=='Hospital' || $post['result_type']=='clinic'){
				if($_GET['result_id']!=0)
				{
					return redirect(base_url('Medical/profile/'.$_GET['result_id']));
				} 
				$_SESSION['current_city']['name'] = $_GET['city'];
				$_SESSION['current_locality'] = $_GET['location'];

				if(isset($_SESSION['current_city']))
			      {
			        $array    = array(
			                            "name"  =>  $_SESSION['current_city']['name']
			                          );
			       // print_r($_SESSION['current_city']['name']);
			        $array    = array(
			                        "city_id" =>  $this->home->get_one_row("city",$array,"id")['id'] //for rorkela city_id is 3102
			                      ); 
			      }
			      else{
			        $array    = array(
			                        "city_id" =>  '3102' //for rorkela city_id is 3102
			                      ); 
			      }
			    $locality		=	$this->select->get_some_locality($array);
				$speciality	=	$this->getspeciality();
			 	
				$allspeciality =	$this->select->get_all_specialization();
				$array	=	array(
								'locality'		=>	$locality,
								'speciality'	=>	$speciality,
								'allspeciality'	=>	$allspeciality,
							);
				$this->load->view('home/findclinic',['array'	=>	$array]	);
			}
			else if($post['result_type']=='Doctor'){
				///echo "<pre>";
				//print_r($post);
				if($_GET['result_id']!=0)
				{
					return redirect(base_url('doctor/viewprofile/'.$_GET['result_id']));
				}
			}

			
		}
		public function createsqlfordoctor($location,$specialisation,$city,$offset='0',$day,$price){
			$limit  = 20;
			$offset =	$limit*$offset;
			$daysql ='';
			if($day	!='')
			{	
				$daysql  .= " (";
				foreach($day as $x)
				{
					$daysql 	.=	"$x = 1 or ";
				}
				$daysql 	=	substr(trim($daysql), 0, -2);
				$daysql 	.= 	" ) and";
			}
			//echo $daysql;
			$sql	=	"SELECT u.id as user_id,u.user_name,u.user_gender,u.user_experience, u.user_age,u.user_image,u.user_about,u.user_rating,u.user_rated,u.user_star,location,city,adl1,adl2,u.user_clinic_id, coalesce(uc.user_name,u.user_indi_clinic_name) as clinic_name,u.user_fee
							 
							,mon,tue,wed,thu,fri,sat,sun,
							(select count(*) from rating r where r.user_id=u.id) as reviews
							from users u
						 	left join qualification q		on q.qualification_doctor_id = u.id
						 	left join users uc on (uc.id = u.user_clinic_id)
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on
						 	case WHEN u.user_clinic_id!='0' Then (a.user_id=u.user_clinic_id) Else (a.user_id=u.id) END								
							where 
							u.user_fee !='0' and u.user_fee<=$price and $daysql
							CASE 
								When u.is_active='1' and (u.user_type in ('4','5','6')) and a.location='$location' and q.qualification_specialization='$specialisation' and  a.city='$city' then 1
								WHEN u.is_active='1' and (u.user_type in ('4','5','6')) and q.qualification_specialization='$specialisation' and a.city='$city' then 2
							END
						group by u.id 
						order by  case 
							when a.location='$location' and q.qualification_specialization='$specialisation' then 1
							when  q.qualification_specialization='$specialisation' then 2
							END ,u.user_star desc
							limit $offset,$limit";
 
			$sql2	 =	"SELECT u.id  
							from users u
						 	left join qualification q		on q.qualification_doctor_id = u.id
						 	left join users uc on (uc.id = u.user_clinic_id)
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on
						 	case WHEN u.user_clinic_id!='0' Then (a.user_id=u.user_clinic_id) Else (a.user_id=u.id) END								
							where 
							u.user_fee !='0' and u.user_fee<=$price and $daysql
							CASE 
								When u.is_active='1' and (u.user_type in ('4','5','6')) and a.location='$location' and q.qualification_specialization='$specialisation' and  a.city='$city' then 1
								WHEN u.is_active='1' and (u.user_type in ('4','5','6')) and q.qualification_specialization='$specialisation' and a.city='$city' then 2
							END
						group by u.id 
						order by case 
							when a.location='$location' and q.qualification_specialization='$specialisation' then 1
							when  q.qualification_specialization='$specialisation' then 2
							END,u.user_star desc";
			$count =  $this->select->get_total_rows($sql2);
			$doctors =  $this->select->get_questions($sql);
			if(count($doctors))
			{
				$i=0;
				foreach ($doctors as $x) {
					$user_id = $x['user_id'];
					$doctors[$i++]['specialisation'] = $this->select->get_single_row("(select GROUP_CONCAT((somename) SEPARATOR '<br> ')as specialisation from (select concat(qualification_specialization,', ',qualification_name,' in ',qualification_course_name) as somename from (select qualification_specialization, qualification_course_name, GROUP_CONCAT((qualification_name) Separator ', ') as qualification_name from qualification q1 where q1.qualification_doctor_id='$user_id' group by qualification_course_name)  q2) q3)")['specialisation'];
				}
			}
			/*echo "<pre>";
			print_r($doctors);
			exit();*/
			$array =	 array(
								"doctors"	=>	$doctors,
								"count"		=>	$count,
								"display"	=>	$offset+count($doctors),
							);
			return $array;
			 
		}
		public function createsqlfordiagnosis($location,$city,$offset,$day,$somecat){
			$limit  = 20;
			$offset =	$limit*$offset;
			$daysql ='';
			$catsql ='';
			if($day	!='')
			{	
				$daysql  .= " (";
				foreach($day as $x)
				{
					$daysql 	.=	"$x = 1 or ";
				}
				$daysql 	=	substr(trim($daysql), 0, -2);
				$daysql 	.= 	" ) and";
			}

			if($somecat !='')
			{
				$catsql  .= " (";
				foreach($somecat as $x)
				{
					$catsql 	.= "(cat_id = $x and d.user_id = u.id) or";
				}
				$catsql 	=	substr(trim($catsql), 0, -2);
				$catsql 	.= 	" ) and";
			}
			
			$sql	=	"SELECT u.id as user_id,u.user_name,u.user_gender,u.user_experience, u.user_age,u.user_image,u.user_about,u.user_rating,u.user_rated,u.user_star,location,city,adl1,adl2,u.user_clinic_id ,mon,tue,wed,thu,fri,sat,sun,(select GROUP_CONCAT(cat_name Separator ' , ') as cat_name from diagnosis_category d inner join test_category t on (t.id = d.cat_id) where d.user_id=u.id) as catgeory, path_morning_start, path_morning_end, path_evening_start, path_evening_end
							from users u
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on (a.user_id=u.id) 							
						 	inner join diagnosis_category d on (d.user_id=u.id) 							
							where 
							$daysql $catsql
							CASE 
								When u.is_active='1' and (u.user_type = '7') and a.location='$location' and  a.city='$city' then 1
								WHEN u.is_active='1' and (u.user_type = '7')  and a.city='$city' then 2
							END
						group by u.id 
						order by case 
							when a.location='$location' and a.city='$city' then 1
							when  a.city='$city' then 2
							END ,u.user_star desc
							limit $offset,$limit";

			$sql2	 =	"SELECT u.id  
							from users u
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on (a.user_id=u.id)
						 	inner join diagnosis_category d on (d.user_id=u.id) 
							where 
							$daysql $catsql
							CASE 
								When u.is_active='1' and (u.user_type = '7') and a.location='$location' and  a.city='$city' then 1
								WHEN u.is_active='1' and (u.user_type = '7')  and a.city='$city' then 2
							END
						group by u.id 
						order by case 
							when a.location='$location' and a.city='$city' then 1
							when  a.city='$city' then 2
							END ,u.user_star desc ";
			$count =  $this->select->get_total_rows($sql2);
			$doctors =  $this->select->get_questions($sql);
			//echo $this->db->last_query();
			//exit();
			$array =	 array(
								"doctors"	=>	$doctors,
								"count"		=>	$count,
								"display"	=>	$offset+count($doctors),
							);
			return $array;
		}
		public function ajaxfindspeciality(){
			$post 	=	$this->input->post();
			
			$location 			=	$post['data']['location'];
			$specialisation 	=	$post['data']['search'];
			$city			 	=	$post['data']['city'];
			$offset				=	0;
			$price  			=	200000;
			if($post['price']!='' && $post['price']!=0)
			{
				$price =	$post['price'];
			}
		 	if(!isset($post['day']))
		 	{
		 		$post['day'] = '';
		 	}
		 	if($post['offset']!=0)
		 	{
		 		$offset	=	$post['offset'];
		 	}
			$res 	= $this->createsqlfordoctor(urldecode($location),urldecode($specialisation),urldecode($city),$offset,$post['day'],$price);
			$doctors 	=	$res['doctors'];

			//echo "<pre>";
			//echo $day."<br>";
			//print_r($post);
			//print_r($post['day']);
			//echo $this->db->last_query();
			//echo "</pre>";
			//echo "<br>".$res['count'];
			//exit();
			$this->showdocview($doctors,$post,$res);
			 
		}
		public function showdocview($doctors,$post,$res){


			if(count($doctors))
			{
				$i=0;
				foreach ($doctors as $doc) {
					$doctor_id 	=	$doc['user_id'];
					$sql 	=	"select image_name,id from gallery where image_user_id = $doctor_id limit 5";
					$doctors[$i]['images']	=	$this->select->get_questions($sql);
					$i++;
				}
			}
			if($countdoc = count($doctors))
						{
							if($post['load']==0)
							{
								echo "showing 1 - ".$res['display']." results of ".$res['count']." results";
							}
							foreach ($doctors as $doc) {
								$day = '';
								if($doc['mon']==1)
								{
									$day .="Mon, ";
								}
								if($doc['tue']==1)
								{
									$day .="Tue, ";
								}
								if($doc['wed']==1)
								{
									$day .="Wed, ";
								}
								if($doc['thu']==1)
								{
									$day .="Thu, ";
								}
								if($doc['fri']==1)
								{
									$day .="Fri, ";
								}
								if($doc['sat']==1)
								{
									$day .="Sat, ";
								}
								if($doc['sun']==1)
								{
									$day .="Sun, ";
								}
								$day 	=	substr(trim($day), 0, -1);
								?>
								<div class="content" style="margin-top: -15px;">
						 
									<div class="tab-content" id="pills-tabContent">
										<div class="tab-pane fade show active" style="margin-top: -20px;" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">		<h3 class="tab-title" style="color:#5672f9;"> Dr. <?= ucwords($doc['user_name']);?> <span class="text-warning">(&#x20B9; 10 as appointment charge)</span></h3>

											<div class="col-md-2 col-sm-3" >
												<center>
												<?php
													if($doc['user_image']!='')
													{
														?>
															<img src="<?= base_url('images/user/'.$doc['user_id'].'/'.$doc['user_image']);?>" class="img img-responsive " alt="<?= $doc['user_name'];?>"  style="height:100px;width:100px;" />
														<?php
													}
													else{
														?>
															<img src="<?= base_url('img/expert.jpg');?>" style="height:100px;width:100px;" class="img img-responsive" alt="<?= $doc['user_name'];?>"/>
														<?php
													}
													
												?>
												</center>
											</div>
											<div class="col-md-10 col-sm-9">
												<div class="col-sm-7" style="padding-top: 5px;">
													 
													
														<?php
															if($doc['user_rated']!=0)
															{	
																echo '<p class="member-time">';
																$totalrating1 = $doc['user_rating']/$doc['user_rated'];
																$totalratings = number_format($doc['user_rating']/$doc['user_rated'],1);
																//echo $totalratings;
																$starrating = 1;
																//echo $totalratings;
																$lastrating  = 5-ceil($totalratings);
																while($starrating<= $totalratings)
																{
																	?>
																		<span class="fa fa-star checked" title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$starrating++;
																}
																if (strpos($totalrating1,'.') !== false) { 
																	?> 							 
																	<span class="fa fa-star-half-o checked"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php 
																} 
																while($lastrating!=0)
																{
																	?>
																		<span class="fa fa-star"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$lastrating--;
																}
																$percentage = $totalratings*20;
															 echo "<span style='color:red;'><b>(".$percentage."% votes </b></span>".$doc['user_rated']." ratings)";
															 echo "</p>";
															}
														?>
													
												<p><?= $doc['specialisation'];?></p>
												<?php
													if($doc['user_experience']!=0)
													{
														?>
														<p><?= $doc['user_experience'];?> years of experience.</p>

														<?php
													}
													?>
													<p><b><i class="fa fa-map-marker"></i></b> <?= $doc['adl1'].", ".$doc['adl2'].", ".$doc['location'].", ".$doc['city']; ?></p>
													<?php
													if($doc['user_clinic_id']!=0)
													{
														?>
														<a href="<?= base_url('Medical/profile/'.$doc['user_clinic_id']);?>" target="_blank" ><p style="color:#5672f9;"><b><?= $doc['clinic_name'];?></b></p></a>

														<?php
													}
													else{
														?>
															<a href="<?= base_url('doctor/viewprofile/'.$doc['user_id']);?>" target="_blank" ><p style="color:#5672f9;"><b><?= $doc['clinic_name'];?></b></p></a>
														<?php	
													}
													if(count($doc['images']))
													{
														foreach ($doc['images'] as $img) {
															?>
															<img src="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>" class="img img=responisve" style="height:40px;width:40px; margin:1px; margin-top:0px;">
															<?php
														}
													}
												?>												 
												</div>
												<div class="col-sm-5" style="font-size:12px;padding-top:5px;">
													<p><b><i class="fa fa-thumbs-up"></i></b>&nbsp;&nbsp;&nbsp;&nbsp; <?= $doc['reviews'];?> reviews</p>
													<p><b><i class="fa fa-money"></i></b><span style="font-size:14px; color:red;"> &nbsp;&nbsp;&nbsp;&nbsp;<b>&#x20B9; <?= $doc['user_fee']; ?></span> at clinic</b></p>
													<p><b><i class="fa fa-clock-o"></i></b> &nbsp;&nbsp;&nbsp;&nbsp; <?= $day; ?></p>
													<a href="<?= base_url('doctor/viewprofile/'.$doc['user_id']);?>" class="btn btn-primary btn-block">Details</a>
													<a href="<?= base_url('doctor/bookappointment/'.$doc['user_id']);?>" class="btn btn-warning btn-block">Book Now</a>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<?php
							}
							if($res['count'] > $res['display'])
							{
								?>
									<br><br>
									<button class="btn btn-block btn-info" onClick="loadmore(this)">Load More</button>
								<?php
							}
						}
						else{
							?>
							<br>
							<br>
							<div class="col-md-12 " style="background: white;height:200px;"><br><br><br><h3 class="text text-center text-primary">Oops !.. No results found.</h3>
							</div>
							<?php
							//echo $this->db->last_query();
						}
		}
		public function ajaxfinddiagnosis(){
			$post 	=	$this->input->post();
			
			$location 			=	$post['data']['location'];
			$city			 	=	$post['data']['city'];
			$offset				=	0;

		 	if(!isset($post['day']))
		 	{
		 		$post['day'] = '';
		 	}
		 	if($post['offset']!=0)
		 	{
		 		$offset	=	$post['offset'];
		 	}
		 	if(!isset($post['somecat']))
		 	{
		 		$post['somecat'] = '';
		 	}

			$res 	= $this->createsqlfordiagnosis(urldecode($location),urldecode($city),$offset,$post['day'],$post['somecat']);
			$doctors 	=	$res['doctors'];

			//echo "<pre>";
			//echo $day."<br>";
			//print_r($post);
			//print_r($post['day']);
			//echo $this->db->last_query();
			//echo "</pre>";
			//echo "<br>".$res['count'];
			//exit();


			if(count($doctors))
			{
				$i=0;
				foreach ($doctors as $doc) {
					$doctor_id 	=	$doc['user_id'];
					$sql 	=	"select image_name,id from gallery where image_user_id = $doctor_id limit 5";
					$doctors[$i]['images']	=	$this->select->get_questions($sql);
					$i++;
				}
			}
			if($countdoc = count($doctors))
						{
							if($post['load']==0)
							{
								echo "showing 1 - ".$res['display']." results of ".$res['count']." results";
							}
							foreach ($doctors as $doc) {
								$day = '';
								if($doc['mon']==1)
								{
									$day .="Mon ";
								}
								if($doc['tue']==1)
								{
									$day .="Tue ";
								}
								if($doc['wed']==1)
								{
									$day .="Wed ";
								}
								if($doc['thu']==1)
								{
									$day .="Thu ";
								}
								if($doc['fri']==1)
								{
									$day .="Fri ";
								}
								if($doc['sat']==1)
								{
									$day .="Sat ";
								}
								if($doc['sun']==1)
								{
									$day .="Sun ";
								}
								
								?>
								<div class="content"  style="margin-top: -15px;">
						 
									<div class="tab-content" id="pills-tabContent">
										<div class="tab-pane fade show active" style="margin-top: -20px;" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">		<h3 class="tab-title" style="color:#5672f9;"> <?= ucwords($doc['user_name']);?> <span class="text-warning">(&#x20B9; 10 as appointment charge)</span></h3>

											<div class="col-md-2 col-sm-3" >
												<center>
												<?php
													if($doc['user_image']!='')
													{
														?>
															<img src="<?= base_url('images/user/'.$doc['user_id'].'/'.$doc['user_image']);?>" class="img img-responsive img-rounded" alt="<?= $doc['user_name'];?>"  style="height:100px;width:100px;" />
														<?php
													}
													else{
														?>
															<img src="<?= base_url('img/expert.jpg');?>" style="height:100px;width:100px;" class="img img-responsive img-rounded" alt="<?= $doc['user_name'];?>"/>
														<?php
													}
													
												?>
												</center>
											</div>
											<div class="col-md-10 col-sm-9">
												<div class="col-sm-7">
													<?php
															if($doc['user_rated']!=0)
															{	
																echo '<p class="member-time">';
																$totalrating1 = $doc['user_rating']/$doc['user_rated'];
																$totalratings = number_format($doc['user_rating']/$doc['user_rated'],1);
																//echo $totalratings;
																$starrating = 1;
																//echo $totalratings;
																$lastrating  = 5-ceil($totalratings);
																while($starrating<= $totalratings)
																{
																	?>
																		<span class="fa fa-star checked" title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$starrating++;
																}
																if (strpos($totalrating1,'.') !== false) { 
																	?> 							 
																	<span class="fa fa-star-half-o checked"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php 
																} 
																while($lastrating!=0)
																{
																	?>
																		<span class="fa fa-star"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$lastrating--;
																}
																$percentage = $totalratings*20;
															 echo "<span style='color:red;'><b>(".$percentage."% votes </b></span>".$doc['user_rated']." ratings)";
															 echo "</p>";
															}
														?>												<p><?= $doc['catgeory'];?></p>
														<p><b><i class="fa fa-map-marker"></i></b>  <?= $doc['adl1'].", ".$doc['adl2'].", ".$doc['location'].", ".$doc['city']; ?></p>
												<?php
													 
													if(count($doc['images']))
													{
														foreach ($doc['images'] as $img) {
															?>
															<img src="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>" class="img img=responisve" style="height:40px;width:40px; margin:1px; margin-top:0px;">
															<?php
														}
													}
												?>
												<?php
												/*echo "<pre>";
													print_r($doc);
													echo "</pre>";*/
												?>												 
												</div>
												<div class="col-sm-5" style="font-size:12px;">
													
													 
													<p><b><i class="fa fa-clock-o"></i></b> &nbsp;&nbsp;&nbsp;&nbsp; <?= $day; ?></p>
													<p><b><i class="fa fa-sun-o"></i></b> &nbsp;&nbsp;&nbsp;&nbsp;  <?=   date("g:i a", strtotime($doc['path_morning_start']));  ?> to <?=   date("g:i a", strtotime($doc['path_morning_end']));  ?></p>
													<p><b><i class="fa fa-sun-o"></i></b> &nbsp;&nbsp;&nbsp;&nbsp;  <?=   date("g:i a", strtotime($doc['path_evening_start']));  ?> to <?=   date("g:i a", strtotime($doc['path_evening_end']));  ?></p>

													<a href="<?= base_url('Testcenter/viewprofile/'.$doc['user_id']);?>" class="btn btn-primary btn-block">View Profile</a>
													 
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<?php
							}
							if($res['count'] > $res['display'])
							{
								?>
									<br><br>
									<button class="btn btn-block btn-info" onClick="loadmore(this)">Load More</button>
								<?php
							}
						}
						else{
							?>
							<br>
							<br>
							<div class="col-md-12 " style="background: white;height:200px;"><br><br><br><h3 class="text text-center text-primary">Oops !.. No results found.</h3>
							</div>
							<?php
							//echo $this->db->last_query();
						}
		}
		public function ajaxfindclinicbyname(){
			$post 	=	$this->input->post();

			$location 			=	$post['data']['location'];
			$clinic_name 		=	$post['data']['search'];
			$city			 	=	$post['data']['city'];
			$offset				=	0;
			 
		 	if(!isset($post['day']))
		 	{
		 		$post['day'] = '';
		 	}
		 	if($post['offset']!=0)
		 	{
		 		$offset	=	$post['offset'];
		 	}
		 	if(!isset($post['speciality']))
		 	{
		 		$post['speciality'] = '';
		 	}
			$res 	= $this->createsqlforclinic(urldecode($location),urldecode($clinic_name),urldecode($city),$offset,$post['day'],$post['speciality']);
			$doctors 	=	$res['doctors'];
			//print_r($doctors);
			if(count($doctors))
			{
				$i=0;
				foreach ($doctors as $doc) {
					$doctor_id 	=	$doc['user_id'];
					$sql 	=	"select image_name,id from gallery where image_user_id = $doctor_id limit 5";
					$doctors[$i]['images']	=	$this->select->get_questions($sql);
					$i++;
				}
			}
			if($countdoc = count($doctors))
						{
							if($post['load']==0)
							{
								echo "showing 1 - ".$res['display']." results of ".$res['count']." results";
							}
							foreach ($doctors as $doc) {
								$day = '';
								if($doc['mon']==1)
								{
									$day .="Mon, ";
								}
								if($doc['tue']==1)
								{
									$day .="Tue, ";
								}
								if($doc['wed']==1)
								{
									$day .="Wed, ";
								}
								if($doc['thu']==1)
								{
									$day .="Thu, ";
								}
								if($doc['fri']==1)
								{
									$day .="Fri, ";
								}
								if($doc['sat']==1)
								{
									$day .="Sat, ";
								}
								if($doc['sun']==1)
								{
									$day .="Sun, ";
								}
								$day 	=	substr(trim($day), 0, -1);
								?>
								<div class="content" style="margin-top: -15px;">
						 
									<div class="tab-content" id="pills-tabContent">
										<div class="tab-pane fade show active" style="margin-top: -20px;" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">		<h3 class="tab-title" style="color:#5672f9;"> <?= ucwords($doc['user_name']);?></h3>

											<div class="col-md-2 col-sm-3" >
												<center>
												<?php
													if($doc['user_image']!='')
													{
														?>
															<img src="<?= base_url('images/user/'.$doc['user_id'].'/'.$doc['user_image']);?>" class="img img-responsive " alt="<?= $doc['user_name'];?>"  style="height:100px;width:100px;" />
														<?php
													}
													else{
														?>
															<img src="<?= base_url('img/expert.jpg');?>" style="height:100px;width:100px;" class="img img-responsive" alt="<?= $doc['user_name'];?>"/>
														<?php
													}
													
												?>
												</center>
											</div>
											<div class="col-md-10 col-sm-9">
												<div class="col-sm-7" style="padding-top: 5px;">
													 
													
														<?php
															if($doc['user_rated']!=0)
															{	
																echo '<p class="member-time">';
																$totalrating1 = $doc['user_rating']/$doc['user_rated'];
																$totalratings = number_format($doc['user_rating']/$doc['user_rated'],1);
																//echo $totalratings;
																$starrating = 1;
																//echo $totalratings;
																$lastrating  = 5-ceil($totalratings);
																while($starrating<= $totalratings)
																{
																	?>
																		<span class="fa fa-star checked" title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$starrating++;
																}
																if (strpos($totalrating1,'.') !== false) { 
																	?> 							 
																	<span class="fa fa-star-half-o checked"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php 
																} 
																while($lastrating!=0)
																{
																	?>
																		<span class="fa fa-star"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
																	<?php
																	$lastrating--;
																}
																$percentage = $totalratings*20;
															 echo "<span style='color:red;'><b>(".$percentage."% votes </b></span>".$doc['user_rated']." ratings)";
															 echo "</p>";
															}
														?>
													
												 
 												<?php
													if($doc['qualification_specialization']!='')
													{
														echo "<h6>Speciality:</h6>";

														if(strlen($doc['qualification_specialization'])>=110 )
														{
															echo "<p>".substr($doc['qualification_specialization'],0,110)."...</p>";
														}
														else{
															echo "<p>".substr($doc['qualification_specialization'],0,110)."</p>";
														}	
													}
													if($doc['service']!='')
													{
														echo "<h6>Service:</h6>";
														if(strlen($doc['service'])>=110)
														{
															echo "<p>".substr($doc['service'],0,110)."...</p>";
														}
														else{
															echo "<p>".substr($doc['service'],0,110)."</p>";
														}	
													}													
												?>
												 
													
													<?php
													 
													if(count($doc['images']))
													{
														foreach ($doc['images'] as $img) {
															?>
															<img src="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>" class="img img=responisve" style="height:40px;width:40px; margin:1px; margin-top:0px;">
															<?php
														}
													}
												?>
												<?php
												/*echo "<pre>";
													print_r($doc);
													echo "</pre>";*/
												?>												 
												</div>
												<div class="col-sm-5" style="font-size:12px;padding-top:5px;">
													<p><b><i class="fa fa-thumbs-up"></i></b>&nbsp;&nbsp;&nbsp;&nbsp; <?= $doc['reviews'];?> reviews</p>
													<p><b><i class="fa fa-map-marker"></i></b>&nbsp;&nbsp;&nbsp;&nbsp; <?= $doc['adl1']." ".$doc['adl2']." ".$doc['location']." ".$doc['city']; ?></p>
													<p><b><i class="fa fa-clock-o"></i></b> &nbsp;&nbsp;&nbsp;&nbsp; <?= $day; ?></p>
													<a href="<?= base_url('Medical/profile/'.$doc['user_id']);?>" class="btn btn-primary btn-block">Details</a>
													 
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<?php
							}
							if($res['count'] > $res['display'])
							{
								?>
									<br><br>
									<button class="btn btn-block btn-info" onClick="loadmore(this)">Load More</button>
								<?php
							}
						}
						else{
							?>
							<br>
							<br>
							<div class="col-md-12 " style="background: white;height:200px;"><br><br><br><h3 class="text text-center text-primary">Oops !.. No results found.</h3>
							</div>
							<?php
							//echo $this->db->last_query();
						}
		}
		public function createsqlforclinic($location,$clinic_name,$city,$offset,$day,$speciality){
			$limit  = 20;
			$offset =	$limit*$offset;
			$daysql ='';
			$specialitysql ='';
			if($day	!='')
			{	
				$daysql  	.= " (";
				foreach($day as $x)
				{
					$daysql 	.=	"$x = 1 or ";
				}
				$daysql 	=	substr(trim($daysql), 0, -2);
				$daysql 	.= 	" ) and";
			}
			if($speciality	!='')
			{	
				$specialitysql  .= "q1.qualification_specialization in  (";
				foreach($speciality as $x)
				{
					$specialitysql 	.=	"'$x', ";
				}
				$specialitysql 	=	substr(trim($specialitysql), 0, -1);
				$specialitysql 	.= 	" ) and";
			}
			/*echo $specialitysql;
			echo "<pre>";
			//print_r($speciality);
			exit();*/
			//echo $daysql;
			$sql	=	"SELECT u.id as user_id,u.user_name,u.user_gender,u.user_experience, u.user_age,u.user_image,u.user_about,u.user_rating,u.user_rated,u.user_star,location,city,adl1,adl2,u.user_clinic_id,u.user_fee,mon,tue,wed,thu,fri,sat,sun,(select count(*) from rating r where r.user_id=u.id) as reviews,(select GROUP_CONCAT(service_name Separator ', ') as service  from clinicservice cs inner join service s on(s.id=cs.service_id) where cs.user_id=u.id) as service ,(select GROUP_CONCAT(qualification_specialization Separator ', ') as qualification_specialization  from qualification q  where q.qualification_doctor_id=u.id) as qualification_specialization 
							from users u 					 	 
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on (a.user_id=u.id) 							
						 	left  join qualification q1 on (q1.qualification_doctor_id=u.id) 							
							where 
							u.is_active='1' and $daysql $specialitysql u.user_name like  '%$clinic_name%' and u.user_type in ('2','3')
							 
						group by u.id 
						order by case 
							when a.city='$city' and a.location='$location'  then 1 
							when a.city='$city'   then 2
							END 
							limit $offset,$limit";
			//echo $sql; 
			$sql2	 =	"SELECT u.id  
							from users u 					 	 
						 	inner join timings t on (t.user_id=u.id)
						 	inner join address a on (a.user_id=u.id) 							
						 	left  join qualification q1 on (q1.qualification_doctor_id=u.id) 							
							where 
							u.is_active='1' and $daysql $specialitysql u.user_name like  '%$clinic_name%' and u.user_type in ('2','3')
							 
						group by u.id 
						order by case 
							when a.city='$city' and a.location='$location'  then 1 
							when a.city='$city'   then 2
							END ";
			$count =  $this->select->get_total_rows($sql2);
			$doctors =  $this->select->get_questions($sql);
			
			$array =	 array(
								"doctors"	=>	$doctors,
								"count"		=>	$count,
								"display"	=>	$offset+count($doctors),
							);
			return $array;
		}
	}

?>