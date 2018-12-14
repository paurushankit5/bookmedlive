<?php
	class Logout extends CI_Controller{
		public function index()
		{
			if(isset($_SESSION['patient_id'])){
				unset($_SESSION['patient_id']);

			}
			if(isset($_SESSION['clinic_id'])){
				unset($_SESSION['clinic_id']);

			}
			if(isset($_SESSION['doctor_id'])){
				unset($_SESSION['doctor_id']);

			}
			if(isset($_SESSION['hospital_id'])){
				unset($_SESSION['hospital_id']);

			}
			if(isset($_SESSION['diagnosis_id'])){
				unset($_SESSION['diagnosis_id']);

			}
			
			unset($_SESSION['user']);
			return redirect (base_url(''));
		}
	}
?>