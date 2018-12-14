<?php
	class Select extends CI_Model
	{
		public function checkadminlogin($array)
		{
			$q	=	$this->db->select('*')
								->where($array)
								->get('admin');
			if($row=$q->unbuffered_row())
			{
				return $row->admin_id;
			}
			else
			{
				return false;
			}
		}
		public function checkuser($array)
		{
			$q	=	$this->db->select('id')
								->where($array)
								->get('users');
			if($row=$q->unbuffered_row())
			{
				return $row->id;
			}
			else
			{
				return false;
			}
		}
		public function checkaddress($array)
		{
			$q	=	$this->db->select('id')
								->where($array)
								->get('address');
			if($row=$q->unbuffered_row())
			{
				return $row->id;
			}
			else
			{
				return false;
			}
		}
		public function checktimings($array)
		{
			$q	=	$this->db->select('id')
								->where($array)
								->get('timings');
			if($row=$q->unbuffered_row())
			{
				return $row->id;
			}
			else
			{
				return false;
			}
		}

		public function get_one_user($array){
			$q	=	$this->db->select('*')
								->where($array)
								->get('users');
			return $q->row_array();
		}
		public function get_user_time($array){
			$q	=	$this->db->select('*')
								->where($array)
								->get('timings');
			return $q->row_array();
		}

		public function get_one_education($array){
			$q	=	$this->db->select('*')
								->where($array)
								->get('qualification');
			return $q->row_array();
		}

		public function get_one_address($array){
			$q	=	$this->db->select('*')
								->where($array)
								->get('address');
			return $q->row_array();
		}

		public function checkdoctor($array)
		{
			$q	=	$this->db->select('doctor_id')
								->where($array)
								->get('doctor');
			if($row=$q->unbuffered_row())
			{
				return $row->doctor_id;
			}
			else
			{
				return false;
			}
		}
		 
		 
		 
		 
		
		public function get_some_locality($array)
		{
			$q	=	$this->db->select('name')
								->where($array)
								->order_by('name')
								->limit(5,0)
								->get('locality');
			return $q->result_array();
			 
		}
		public function getuserlocality($city)
		{
			$q	=	$this->db->select('locality.name')
								->where("city.name", $city)
								->join("city","city.id=locality.city_id")
								->order_by('locality.name')
								->limit(5,0)
								->get('locality');
			return $q->result_array();
			 
		}

		public function get_all_specialization()
		{
			$q	=	$this->db->select('speciality_name')
								->order_by('speciality_name')
								->get('speciality');
			return $q->result_array();
			 
		}
		
		 
		//patient question 
		public function count_patient_all_questions($array)
		{
			$q	=	$this->db->select('question_id')
						->join('users','question_doctor_id=id')
						->where($array)
						->order_by('question_id','DESC')
						->get('question');
			return $q->num_rows();			
		}		 
		public function get_some_patient_questions($limit,$offset,$array)
		{	
			$q		=	$this->db->select('*')
									->limit($limit,$offset)
									->join('users','question_doctor_id=id')
									->where($array)
									->order_by('question_id','DESC')
									->get('question');
			return $q->result_array();
		}
		//doctor question

		public function count_all_questions($array)
		{
			$q	=	$this->db->select('question_id')
						->join('users','question_patient_id=id')
						->where($array)
						->order_by('question_id','DESC')
						->get('question');
			return $q->num_rows();			
		}		 
		public function get_some_questions($limit,$offset,$array)
		{	
			$q		=	$this->db->select('*')
									->limit($limit,$offset)
									->join('users','question_patient_id=id')
									->where($array)
									->order_by('question_id','DESC')
									->get('question');
			return $q->result_array();
		}

	  	public function get_some_review($limit,$offset,$array)
		{	
			$q		=	$this->db->select('rating.*,user_name')
									->limit($limit,$offset)
									->join('users','users.id=patient_id')
									 ->where($array)
									->order_by('rating.id','DESC')
									->get('rating');
			return $q->result_array();
		}

		public function count_all_review($array)
		{
			$q	=	$this->db->select('rating.id')
							->join('users','users.id=patient_id')
							->where($array)
							->order_by('rating.id','DESC')
							->get('rating');
			return $q->num_rows();
		} 
	
		public function get_clinic_services($array)
		{
			$q	=	$this->db->select('service_id,service_name')
							->join('service','service.id=service_id')
							->where($array)
							->order_by('service_name','ASC')
							->get('clinicservice');
			return $q->result_array();
		} 
	

	  
		public function get_questions($query)
		{	
			$q		=	$this->db->query($query);
			return $q->result_array();
		}
	 public function get_total_rows($query)
		{	
			$q		=	$this->db->query($query);
				return $q->num_rows();
		}
	 
		public function get_single_row($query)
		{	
			$q		=	$this->db->query($query);
			return $q->row_array();
		}
	 
		
		 
		


		 
		

		

		 
		

		 
		 
		
		
		 
		

		public function get_one_wallet($array)
		{
			$q	=	$this->db->select('*')
								->where($array)
								->get('wallet');
			return $q->row_array();
		}
		
		 
		 	
		 
		public function get_some_appointments($limit,$offset,$array)
		{
			$q	=	$this->db->select('appointment.*,user_name,users.id,user_image,user_type,user_fee,user_type')
							->where($array)
							->limit($limit,$offset)
							->join('users','users.id=ap_doctor_id')
							->order_by('ap_id','DESC')
							->get('appointment');
			return $q->result_array();
		}
		public function get_some_doc_appointments($limit,$offset,$array)
		{
			$q	=	$this->db->select('appointment.*,user_name,users.id,user_type')
							->where($array)
							->limit($limit,$offset)
							->join('users','users.id=ap_patient_id')
							->order_by('ap_date','DESC')
							->order_by('ap_time','ASC')
							->get('appointment');
			return $q->result_array();
		}
		public function get_some_patientwise_appointments($limit,$offset,$array)
		{
			$q	=	$this->db->select('user_name,users.id,user_type')
							->where($array)
							->limit($limit,$offset)
							->join('users','users.id=ap_patient_id')
							->order_by('ap_id','DESC')
							->group_by('users.id')
							->get('appointment');
			return $q->result_array();
		}

		public function count_all_appointments($array)
		{
			$q	=	$this->db->select('ap_id')
							->where($array)	
							->join('users','users.id=ap_doctor_id')
							->order_by('ap_id','DESC')						
							->get('appointment');
			return $q->num_rows();
		} 
		public function count_patientwise_appointments($array)
		{
			$q	=	$this->db->select('ap_id')
							->where($array)	
							->join('users','users.id=ap_patient_id')
							->order_by('ap_id','DESC')						
							->group_by('users.id')						
							->get('appointment');
			return $q->num_rows();
		} 
	
		public function get_one_appointment($array)
		{
			$q	=	$this->db->select('*')
							->where($array)
							 						 
							->get('appointment');
			return $q->row_array();
		}
	
		


	   
		  
		 
		public function get_settings($array)
		{
			$q	=	$this->db->select('*')
							->where($array)							 
							->get('settings');
			return $q->row_array();
		}
		
		public function get_qualification_name($array)
		{
			$q	=	$this->db->select('qualification_name')
							->where($array)							 
							->get('qualification');
			return $q->result_array();
		}
		public function get_some_education($array)
		{
			$q	=	$this->db->select('*')
							->where($array)							 
							->get('qualification');
			return $q->result_array();
		}
		
		public function get_some_documents($array)
		{
			$q	=	$this->db->select('*')
							->where($array)							 
							->get('document');
			return $q->result_array();
		}
		 
		 
		 
		public function get_speciality_hint($name)
		{
			$q	=	$this->db->select('speciality_name')
							->like('speciality_name', $name)							 
							->get('speciality');
			return $q->result_array();
		}
		
		 
		public function get_all_cities(){
			$q 	=	$this->db->query('select name as city_name from locality where city_id =3102');
			return $q->result_array();
		} 	
		 	
		public function somequery($sql)
		{
			$q	=	$this->db->query($sql);
			return $q->result_array();
		}
		public function get_some_vacations($array)
		{
			$q	=	$this->db->select('vacation_date,vacation_id')
								->where($array)
								->order_by('vacation_date','DESC')
								->get('vacation');
			return $q->result_array();
		}
		 
		 
		public function get_all_council()
		{
			$q	=	$this->db->select('*')
							 ->get('council');
			return $q->result_array();
		}
		public function get_added_revenue($array)
		{
			$q	=	$this->db->select_sum('ap_money')
							//->join('doctor','doctor_id=appointment_doctor_id')
							->where($array)
							->get('appointment');
			return $q->row_array();
		}
		public function get_clinic_addedrevenue($array1,$str)
		{
			$q	=	$this->db->select_sum('ap_money')
							 
							//->join('money','MerchantRefNo=appointment_id')
							->where($array1)
							->where_in('ap_doctor_id', $str)
							->get('appointment');
			return $q->row_array();
		}
		public function get_user_city($array)
		{
			$q	=	$this->db->select('name')
							//->join('doctor','doctor_id=appointment_doctor_id')
							->where_in("name",$array)
							->get('city');
			return $q->row_array();
		}
		public function get_some_city($city,$limit,$offset)
		{
			$q	=	$this->db->select('name')
							->like("name",$city,"after")
							->limit($limit,$offset)
							->get('city');
			return $q->result_array();
		}
		public function get_hos_subdepartment($array)
		{
			$q	=	$this->db->select('*')
							//->join('doctor','doctor_id=appointment_doctor_id')
							->where_in("id",$array)
							->get('subdepartment');
			return $q->result_array();
		}
		public function get_some_test($test_ids){
			$q	=	$this->db->select('*')
							//->join('doctor','doctor_id=appointment_doctor_id')
							->where_in("test_id",$test_ids)
							->get('test');
			return $q->result_array();
		}
		public function count_some_users($array)
		{
			$q	=	$this->db->select('id') 
						->where($array)
						->get('users');
			return $q->num_rows();			
		}	
		public function get_some_subdepartment($array)
		{
			$q	=	$this->db->select('name')							  
							->where_in('id', $array)
							->get('subdepartment');
			return $q->result_array();
		}
		public function get_untrendingclinic($name){
			$q	=	$this->db->select('user_name,id,user_type')
							->like('user_name', $name)							 
							->where_in('user_type',array(2,3)) 
							->where('user_trending', 0)
							->where('is_active', 1)
							->order_by('user_trending_order',"DESC")
							->get('users');
			return $q->result_array();
		}
	}
?>