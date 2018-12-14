<?php
	class Testcenter extends MY_Controller{
		public function hello(){
			echo md5('123456');
		}
		public function viewprofile(){
			$this->load->model('home');
			$id 	=	$this->uri->Segment(3);
			$array 		=	array(
									'id'	=>	$this->uri->segment(3),
									'is_active'	=>	1,

								);
			$sql	=	"SELECT u.*,location,city,adl1,adl2,map,a.id as address_id ,u.user_clinic_id,
								mon,tue,wed,thu,fri,sat,sun,path_morning_start,path_morning_end,path_evening_start,path_evening_end
								from users u
								inner join timings t on (t.user_id=u.id)							 	 
							 	inner join address a on  (a.user_id=u.id) 	
							 	where u.id ='$id' and u.is_active=1	and u.user_type ='7'	
							";
			$doc		=	$this->select->get_questions($sql);				
			if(count($doc)){
				$sql 	=	"select * from test_category t inner join diagnosis_category d on (d.cat_id=t.id) where d.user_id='$id'";
				$doc[0]['cat'] 	=	$this->select->get_questions($sql);
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
				
				$array 		=	array(
										'doc'	=>	$doc,										 
									);
				 
				$this->load->view('home/viewdiagnosisprofile',['array'	=>	$array]);
			}
			else{
				return redirect(base_url('Error404'));
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
				return redirect(base_url('Testcenter/viewprofile/'.$post['user_id']));
			}
		}
		public function gettests(){
			$post 	=	$_POST;
			$this->load->model('home');
			$array 	=	array(
								"test_cat_id"	=>	$post['cat_id'],
								"test_path_id"	=>	$post['user_id'],
							);
			$test 	=	$this->home->get_all_row("test",$array,"test_name,test_price,test_id",'test_name','ASC');
			if(count($test))
			{
				?>
					<div class="row" style="border-bottom: .1px solid black;margin:10px;padding:10px;">
					<div class="col-sm-4 hidden-xs"><b>Test Name</b></div>
					<div class="col-sm-4 hidden-xs"><b>Price</b></div>					
					<div class="col-sm-4 hidden-xs"><b>Add/Remove</b></div>
					</div>					
				<?php
					foreach ($test as $x ) {
						?>
							<div class="row" style="border-bottom: .1px solid black;margin:10px 5px;padding:0px;">
							<div class="col-sm-4 col-xs-4"><?= $x['test_name'];?></div>
							<div class="col-sm-4 col-xs-4">&#x20B9; <?= $x['test_price'];?></div>
							<div class="col-sm-4 col-xs-4"><center><button class="btn btn-primary" onclick="addtest(this,'<?= $x['test_id'];?>','<?= $x['test_name'];?>','<?= $x['test_price'];?>');" style="padding:5px 10px;"> <i class="fa fa-plus"></i></button></center><br></div>
							</div>
						<?php
					}
			}
			else{
				echo "No tests found";
			}
		}
		public function storepayment(){
			$post 				=	$this->input->post();
			$test_ids 			=	implode(",",$post['alltest']);
			$_SESSION['ap_id']	=	"APID".strtotime(date('Y-m-d H:i:s')).rand(1111,9999);
			$array = array(
							"ap_doctor_id"  		=>  $post['path_id'],
							"ap_id"					=>  $_SESSION['ap_id'],							 
							"ap_test_ids"			=>  $test_ids,							 
							"created_at"			=>  date("Y-m-d H:i:s"),
							"updated_at"			=>  date("Y-m-d H:i:s"),
						);
			$this->load->model('insert');
			if($this->insert->insert_table($array,"appointment")){
				echo 1;
			}
			else{
				echo 0;
			}
		}
		public function booktestnow(){
			if(!isset($_SESSION['ap_id']))
			{
				return redirect(base_url('Error404'));
			}
			if(!isset($_SESSION['user']))
			{
				$_SESSION['url'] = base_url('Testcenter/booktestnow');
				$this->session->set_flashdata('logmsg',"Please login or register to book appointment with our diagnosis center");
				return redirect(base_url('Login'));
			}
			$this->load->model('home');
			$this->load->model('select');
			$array		=	array('settings_id'	=>	1);
			$settings	=	$this->select->get_settings($array);
			
			$array		=	array('wallet_patient_id'	=>		$_SESSION['user']['id']);
			$wallet		=	$this->select->get_one_wallet($array);

			$array 		=	array(
									"ap_id"	=>	$_SESSION['ap_id']
								);
			$ap 		=	$this->home->get_one_row("appointment",$array,"*");



			$ap_test_ids= 	explode(",",$ap['ap_test_ids']);
			$tests		=	$this->select->get_some_test($ap_test_ids);

			$array 		=	array(
									"user_id"	=>	$ap['ap_doctor_id']
								);
			$timing 		=	$this->home->get_one_row("timings",$array,"*");

			$array 		=	array(
									"id"	=>	$ap['ap_doctor_id']
								);
			$diagnosis 		=	$this->home->get_one_row("users",$array,"*");


			$array 			= 	array(
											"settings_id"	=> 	2,
										);
			$totalamount 	= 	$this->home->get_one_row("settings",$array,"settings_service_charge")['settings_service_charge'];

			$array 	=	array(
								"ap"			=>		$ap,
								"wallet"		=>		$wallet,
								"settings"		=>		$settings,
								"tests"			=>		$tests,
								"timing"		=>		$timing,
								"diagnosis"		=>		$diagnosis,
								"totalamount"		=>		$totalamount,
							);
			$this->load->view('home/booktestnow',['array'	=>	$array]);

		 
		}
	}	
?>