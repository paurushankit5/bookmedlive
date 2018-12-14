<?php
	Class Demo extends MY_Controller
	{
		public function index()
		{
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
      $speciality = $this->getspeciality();
      $trending   = $this->select->get_questions("select u.*,location,city from users u left join address a on(a.user_id=u.id) where user_trending=1 and (user_type='2' or user_type='3') order by user_trending_order desc" ); 
      
			 
			$array	=	array(
								'locality'		=>	$locality,
                'speciality'  =>  $speciality,
								'trending'	  =>	$trending,
							);
			$this->load->view('home/index',['array'	=>	$array]);
		}
		public function test(){
			$paytm   =   $this->select->get_questions("select * from paytm");
      echo "<pre>";
      foreach($paytm as $x)
      {
        $x= json_encode($x);
        $x="https://securegw-stage.paytm.in/merchant-status/getTxnStatus?JsonData=".$x;
        echo $x;
        echo "<br>";
      } 
		}
		public function seturl(){
			$post	=	$this->input->post();
			$_SESSION['url']	=	$post['url'];
		}
		public function showallhint(){
			$post 	=	$this->input->post();
      $name   = $post['hint'];
			$city 	=	$post['current_city'];
			$sql    = 	"select speciality_name from speciality where speciality_name like '%$name%' limit 5";
			$speciality 	=	$this->select->somequery($sql);
			if(count($speciality))
      {
            
            ?>
            <div class="label">Speciality</div>
            <?php
            foreach ($speciality as $x) {
              
              $speciality_name  = $x['speciality_name'];
              
              ?>
              <div class="label-content" onclick="clickoption('<?= $x['speciality_name'];?>','speciality','0');">
                  <span class="imgdiv"><img src="<?= base_url('img/');?>speciality2.jpg" class="img img-responsive" alt=""/></span>
                  <span class="content text-center"><?= $x['speciality_name'];?></span>
                  <span class="type">Speciality</span>
              </div>
              <div class="clearfix"></div>
              <?php
              
         	}
        }
        else{
          ?>
           <!-- <div class="label-content" onclick="clickoption('<?= $name;?>','doctor','0');">
              <span class="imgdiv"><img src="<?= base_url('img/');?>search.jpg" class="img img-responsive" alt=""/></span>
              <span class="content text-center">Doctors named <?= $name;?></span>
              <span class="type">Speciality</span>
            </div> -->
            <div class="clearfix"></div>
            <div class="label-content" onclick="clickoption('<?= $name;?>','clinic','0');">
              <span class="imgdiv"><img src="<?= base_url('img/');?>search.jpg" class="img img-responsive" alt=""/></span>
              <span class="content text-center">Clinics named <?= $name;?></span>
              <span class="type">Speciality</span>
            </div>
            <div class="clearfix"></div>
            <div class="label-content" onclick="clickoption('<?= $name;?>','Hospital','0');">
              <span class="imgdiv"><img src="<?= base_url('img/');?>search.jpg" class="img img-responsive" alt=""/></span>
              <span class="content text-center">Hospitals named <?= $name;?></span>
              <span class="type">Speciality</span>
            </div>
            <div class="clearfix"></div>
          <?php
        }
            if($city !='')
            {
                $citysql  = "and a.city = '$city' ";
            }
            $sql =	"select u.user_name,u.id,u.user_image from users u 
                     inner join address a on case WHEN u.user_clinic_id!='0' Then (a.user_id=u.user_clinic_id) Else (a.user_id=u.id) END  
                     where user_name like '%$name%' and (user_type ='4' or user_type='5' or user_type='6') and is_active=1 
                     order by case 
                     when a.city='$city' then 1
                     ELSE 2
                     END 
                     limit 5";
            //echo $sql;
            $doc 	=	$this->select->somequery($sql);
			if(count($doc))
            {
                
                ?>
                <div class="label">Doctors</div>
                <?php
                foreach ($doc as $x) {
                  
                  $user_name  = $x['user_name'];
                  
                  ?>
                  <div class="label-content" onclick="clickoption('<?= $x['user_name'];?>','Doctor','<?= $x['id'];?>');">
                      <span class="imgdiv">
                      <?php
                      	if($x['user_image']!='')
                      	{
                      		?>
                      		<img src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" class="img img-responsive" alt=""/>
                      		<?php
                      	}
                      	else{
                      		?>
                      			<img src="<?= base_url('img/expert.jpg');?>" class="img img-responsive" alt=""/>
                      		<?php
                      	}
                      ?>
                      	
                      </span>
                      <span class="content text-center">Dr. <?= $x['user_name'];?></span>
                      <span class="type">Doctor</span>
                  </div>
                  <div class="clearfix"></div>
                  <?php
                  
             	}
            }
            $sql =	"select u.user_name,u.id,u.user_image from users u
                       inner join address a on case WHEN u.user_clinic_id!='0' Then (a.user_id=u.user_clinic_id) Else (a.user_id=u.id) END  
                       where user_name like '%$name%' and (user_type ='2' or user_type='3') and is_active=1
                       order by case 
                       when a.city='$city' then 1
                       ELSE 2
                       END 
                       limit 5";
            //echo $sql;
            $clinic 	=	$this->select->somequery($sql);
			if(count($clinic))
            {
                
                ?>
                <div class="label">Hospital</div>
                <?php
                foreach ($clinic as $x) {
                  
                  $user_name  = $x['user_name'];
                  
                  ?>
                  <div class="label-content" onclick="clickoption('<?= $x['user_name'];?>','Hospital','<?= $x['id'];?>');">
                      <span class="imgdiv">
                      <?php
                      	if($x['user_image']!='')
                      	{
                      		?>
                      		<img src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" class="img img-responsive" alt=""/>
                      		<?php
                      	}
                      	else{
                      		?>
                      			<img src="<?= base_url('img/expert.jpg');?>" class="img img-responsive" alt=""/>
                      		<?php
                      	}
                      ?>
                      	
                      </span>
                      <span class="content text-center"><?= $x['user_name'];?></span>
                      <span class="type">Hospital</span>
                  </div>
                  <div class="clearfix"></div>
                  <?php
                  
             	}
            }
		}
    public function getcity()
    {
      $smsgatewaycenter_com_url = "https://maps.googleapis.com/maps/api/geocode/json?"; //SMS Gateway Center API URL
       
      $parameters = 'latlng='.$_POST['lat'].",".$_POST['long'];
      $parameters.= '&sensor=true&key=AIzaSyBMcy8UfziuH2pWPitxx8jCDu9rhd9o4BI';  
      $api_url =  $smsgatewaycenter_com_url.$parameters;
      $ch = curl_init($api_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $curl_scraped_page = curl_exec($ch);
      curl_close($ch);      
      //echo "<pre>";
      echo $curl_scraped_page;

    }
    public function checkcityname(){
      //print_r($_POST);
      $this->load->model('select');
      $city = $this->select->get_user_city($_POST['name']);
      if($city!=''){
        $_SESSION['current_city'] = $city;
      }
      
      echo $city['name'];
      
       
    }
    public function getuserlocality(){
      $post = $this->input->post();
      $city   = $post['city'];
      $alloutcome = "'".implode("','",$post['alloutcome']);
      $alloutcome = substr($alloutcome, 0, -1)."'";
      //echo $alloutcome;
      $this->load->model('select');
      $locality= $this->select->get_single_row("select locality.name from locality inner join city on city.id = locality.city_id where locality.name in ($alloutcome) and city.name='$city' limit 1");
      $_SESSION['current_locality'] = $locality['name'];
      echo $locality['name'] ;
		 
	   }
     public function getcitylocality(){
        $this->load->model('select');
        $post   = $this->input->post();
        $locality= $this->select->getuserlocality($post['city']);
        if(count($locality)){
        foreach($locality as $loc){
          ?>
            <div class="option-content" onClick="printlocality('<?= $loc['name'];?>');" >
              <span><?= $loc['name'];?></span>                       
          </div>
          <?php
        }
        }
     }
    public function showlocalityhint(){
        $this->load->model('select');
        $post   = $this->input->post();
        $city   = $post['city'];
        $locality   = $post['locality'];
        $locality= $this->select->get_questions("select locality.name from locality inner join city on (city.id = locality.city_id) where city.name='$city' and locality.name like '%$locality%' limit 5");
        //echo $this->db->last_query();
      // print_r($_POST['alloutcome']);
        //$alllocality =  array_column($alllocality,"name");
      if(count($locality)){
        foreach($locality as $loc){
          ?>
            <div class="option-content" onClick="printlocality('<?= $loc['name'];?>');" >
              <span><?= $loc['name'];?></span>                       
          </div>
          <?php
        }
      }
     }

     public function getcityhint(){
        $cities   = $this->select->get_some_city($_POST['city'],10,0);
        if(count($cities))
        {
          foreach ($cities as $city) {
            ?>
              <div class="option-content" onClick="printcity('<?= $city['name'];?>');" >
                <span><?= $city['name'];?></span>                       
              </div>
            <?php
          }
        }
     }
    }
?>