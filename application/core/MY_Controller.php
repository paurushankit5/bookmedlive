<?php
class MY_Controller extends CI_Controller {
	public function __construct(){
		parent ::__construct();
		$this->load->model('select');
		
	}
	public function getspeciality(){
		if(!isset($_SESSION['speciality']))
		{
			$_SESSION['speciality']	=	$this->select->get_all_specialization();
		}
		return $_SESSION['speciality'];
	}
	public function smsgatewaycenter_com_Send($mobile, $sendmessage)
	{
		//http://apps.smslane.com/vendorsms/pushsms.aspx?user=Tarun%20Manna&password=tarun_123&msisdn=919002187227&sid=EXAGRO&msg=sms testing &fl=0&gwid=2
		$smsgatewaycenter_com_user = "nsiba1991@gmail.com"; //Your SMS Gateway Center Account Username
		$smsgatewaycenter_com_password = "Nsiba@1991";  //Your SMS Gateway Center Account Password
		$smsgatewaycenter_com_url = "http://apps.smslane.com/vendorsms/pushsms.aspx?"; //SMS Gateway Center API URL
		$smsgatewaycenter_com_mask = "BOKMED"; //Your Approved Sender Name / Mask
		$parameters = 'user='.$smsgatewaycenter_com_user;
		$parameters.= '&password='.$smsgatewaycenter_com_password;
		$parameters.= '&msisdn='.urlencode($mobile);
		$parameters.= '&sid='.urlencode($smsgatewaycenter_com_mask);
		$parameters.= '&msg='.urlencode($sendmessage);
		$parameters.= '&fl=0&gwid=2';
		$api_url =  $smsgatewaycenter_com_url.$parameters;
		$ch = curl_init($api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);			
		return($curl_scraped_page);
	}
 	public function sendmail($email,$subject,$body,$altbody)
		{
						
			require_once 'phpmailer/PHPMailerAutoload.php';
			$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtpout.asia.secureserver.net';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'donotreply@bookmediz.com';                 // SMTP username
			$mail->Password = '21@feb@1993';                           // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = '465';                                    // TCP port to connect to
			$mail->setFrom('donotreply@bookmediz.com', 'BOOKMEDIZ');
			$mail->addAddress($email);     // Add a recipient
			$mail->addReplyTo('donotreply@bookmediz.com', 'BOOKMEDIZ');
			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->AltBody = $altbody;
			if(!$mail->send()) {
				//echo 'Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				return false;
			} else {
				//echo 'Message has been sent';
				return true;
			}
		}
		public function timetosec($data){
			$data = explode(":",$data);
			return (($data[0]*3600)+($data[1]*60)+0);
		}
		public function sectotime($sec){
			
			$hr 	=	floor($sec/3600);
			$sec 	=	$sec%3600;
			$min 	=	floor($sec/60);
			 
			$sec 	=	$sec%60;
			if($hr<=9)
			{
				$hr = "0".$hr;
			}
			if($min<=9)
			{
				$min = "0".$min;
			}
			if($sec<=9)
			{
				$sec = "0".$sec;
			}

			$hr		=	$hr.":".$min.":".$sec;
			return $hr;
		}
		public function sendmailtouser($ap_id){
			$detail = 	$this->select->get_single_row("select ap_id,ap_date,ap_time,ap_shift,ap_money,a.ap_amount_to_be_paid,ap_test_ids,u.user_name,ad.* from appointment a inner join users u on (a.ap_doctor_id=u.id) inner join address ad on
						 	case WHEN u.user_clinic_id!='0' Then (ad.user_id=u.user_clinic_id) Else (ad.user_id=u.id) END where a.ap_id='$ap_id'");
			$address = $detail['adl1'].", ".$detail['adl2'].", ".$detail['location'].", ".$detail['city'].", ".$detail['state'];
			if($detail['ap_test_ids']=='')
			{
				$data	=	'<html>

							<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
								
								<div style="width:100%;background:#3f5267;color:white;padding:5px;">
									<h2 style="text-align:center">Appointment Successful</h2>
								</div>
								<div style="width:100%;padding:10px;">
									<h3><b>Dear '.$_SESSION['user']['user_name'].',</b></h3>

									<p>Congratulations!... You appointment with our doctor has been approved successfully.</p>
									<p>Doctor - <span style="font-weight:bold;">Dr. '.$detail['user_name'].'</span></p>
									<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
									<p>Date & Time - <span style="font-weight:bold;">'.$detail['ap_time']." on ".date('d-M-Y',strtotime($detail['ap_date'])).'</span></p>
									<p>Amount to be paid - <span style="font-weight:bold;"> &#x20B9; '.$detail['ap_amount_to_be_paid'].'</span></p>
									<p>Address - <span style="font-weight:bold;">'.$address.'</span></p>

									<hr>
									<p>Regards : BOOKMEDIZ Team<br>
									Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
									<hr>
								</div>
							</div>
						</html>';
						//echo $data;
						$msg= "Thank you for booking an appointment with BOOKMEDIZ. Your appointment with Dr. ".$detail['user_name']." on ".$detail['ap_time']." on ".date('d-M-Y',strtotime($detail['ap_date']))." has been approved successfully. Your appointment id is ".$ap_id." . Address- ".$address." .";
			}
			else{
				$data	=	'<html>

							<div style="width:90%; border:px solid #3f5267;margin:0px auto;">
								
								<div style="width:100%;background:#3f5267;color:white;padding:5px;">
									<h2 style="text-align:center">Appointment Successful</h2>
								</div>
								<div style="width:100%;padding:10px;">
									<h3><b>Dear '.$_SESSION['user']['user_name'].',</b></h3>

									<p>Congratulations!... You appointment with our doctor has been approved successfully.</p>
									<p>Diagnosis Center Name - <span style="font-weight:bold;"> '.$detail['user_name'].'</span></p>
									<p>Appointment Id - <span style="font-weight:bold;">'.$ap_id.'</span></p>
									<p>Amount to be paid - <span style="font-weight:bold;">'.$detail['ap_amount_to_be_paid'].'</span></p>
									<p>Date  - <span style="font-weight:bold;">'.date('d-M-Y',strtotime($detail['ap_date'])).'</span></p>
									<p>Address - <span style="font-weight:bold;">'.$address.'</span></p>

									<hr>
									<p>Regards : BOOKMEDIZ Team<br>
									Email : &nbsp;&nbsp;&nbsp;&nbsp;info@bookmediz.com</p>
									<hr>
								</div>
							</div>
						</html>';
						//echo $data;
						$msg= "Thank you for booking an appointment with BOOKMEDIZ. Your appointment with ".$detail['user_name']." on ".date('d-M-Y',strtotime($detail['ap_date']))." has been approved successfully. Your appointment id is ".$ap_id." . Address- ".$address." .";
			}
			
						//echo $msg;
			$this->sendmail($_SESSION['user']['user_email'],"Appointment Confirmed",$data,"Appointment Confirmed");
			$this->smsgatewaycenter_com_Send("91".$_SESSION['user']['user_mob'], $msg);
			 

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
			print_r($_POST);
			$this->load->model('select');
			print_r ($this->select->get_user_city($_POST['name']));
			echo $this->db->last_query();
			 
		}
		public  function delete_files($target) {
		    if(is_dir($target)){
		        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
		        
		        foreach( $files as $file )
		        {
		            $this->delete_files( $file );      
		        }
		      
		        
		    } elseif(is_file($target)) {
		        unlink( $target );  
		    }
		}
         
}
?>