<?php
	class Find extends MY_Controller{
		public function diagnosis(){
		  ob_start();
	      $this->load->model('select');
				$this->load->model('home');
	      if(isset($_SESSION['current_city']))
	      {
	        $array    = array(
	                            "name"  =>  $_SESSION['current_city']['name']
	                          );
	        $array    = array(
	                        "city_id" =>  $this->home->get_one_row("city",$array,"id")['id'] //for rorkela city_id is 3102
	                      ); 
	      }
	      else{ 
	        $array    = array(
	                        "city_id" =>  '3102' //for rorkela city_id is 3102
	                      ); 
	      }
	        $locality   = $this->select->get_some_locality($array);
	        $array 	=	array("1"=>1);
	        	$cat = $this->home->get_all_row("test_category",$array,"*",'cat_name','ASC');
	      
				 
				$array	=	array(
									'locality'		=>	$locality,
									'cat'			=>	$cat,
								);
				if(isset($_GET['city']))
				{
					$_SESSION['current_city']['name'] 	=	$_GET['city'];
				}
				if(isset($_GET['location']))
				{
					$_SESSION['current_locality'] 	=	$_GET['location'];
				}
				$this->load->view('home/finddiagnosis',['array'	=>	$array]);
		}
	}
?>