<?php
	class Ajax extends CI_Controller{
		public function __construct(){
			parent ::__construct();
			$this->load->model('delete');
			$this->load->model('select');
		}
		public function delimage(){
			$post 	=	$this->input->post();
			
			if($this->delete->delete_table($post,"gallery"))
			{
				if(file_exists("img/gallery/".$post['id']."/".$post['image_name']))
				{
					unlink("img/gallery/".$post['id']."/".$post['image_name']);
				}
				if(file_exists("img/gallery/".$post['id']))
				{
					rmdir("img/gallery/".$post['id']);
				}
				return true;
			}
			else{
				return false;
			}
		}
		public function deldocuments(){
			$post = 	$this->input->post();
			if(isset($_SESSION['doctor_id']) || isset($_SESSION['clinic_id']) || isset($_SESSION['hospital_id']))
			{
				$array = array('id'	=>	$post['id']);
				 
				if($this->delete->delete_table($array,"document"))
				{
					if(file_exists("images/certi/".$post['id']."/".$post['image_name']))
					{
						@unlink("images/certi/".$post['id']."/".$post['image_name']);
					}
					if(file_exists("images/certi/".$post['id']))
					{
						@rmdir("images/certi/".$post['id']);
					}
					$this->session->set_flashdata('docmsg',"<div class='alert alert-success'>Document deleted successfully.</div>");
					$this->session->set_flashdata('docdetailmsg',"<div class='alert alert-success'>Document deleted successfully.</div>");
				}
				else{
						$this->session->set_flashdata('docmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try after some time.</div>");
						$this->session->set_flashdata('docdetailmsg',"<div class='alert alert-danger'>We are facing some technical issues. Please try after some time.</div>");

				}
			}
			 
		}
		public function getcity(){
			$state	 = 	$_POST['state'];
			$city 		= 	$this->select->somequery("select c.name ,c.id from city c inner join states s on (s.id=c.state_id) inner join countries co on (co.id=s.country_id) where s.name='$state' and co.id='101'");
				$current_city = 	$address['city'];
			if(count($city))
			{
				foreach ($city as $x ) {
					?>
						<option value="<?= $x['name'];?>"><?= $x['name'];?></option>
					<?php
				}
			}
		}
		public function getlocality(){
			$state	 = 	$_POST['state'];
			$city	 = 	$_POST['city'];
		 
			$locality 		= 	$this->select->somequery("select l.name from locality l inner join city c on (c.id=l.city_id) inner join states s on (s.id=c.state_id) inner join countries co on (co.id=s.country_id) where c.name='$city' and s.name='$state' and co.id='101'");
			if(count($locality))
			{
				foreach ($locality as $x ) {
					?>
						<option value="<?= $x['name'];?>"><?= $x['name'];?></option>
					<?php
				}
			}
		}
	}
?>