<?php
	include('./config.php');
 	$sql="select * from admin where admin_id=1";  
	$result=mysqli_query($con,$sql);
	// Associative array
	$time = date("H:i:s");
	//echo $time."<br>";
	
	 
	while($row=mysqli_fetch_assoc($result))
	{ 
		findappointment($row,'E');
	}

	function findappointment($user,$shift){
		global $con; 
		$mob = 	$user['mobile'];
		$name = 	"Admin";
		$today 	= 	date('Y-m-d');
		$sql = 	mysqli_query($con,"select count(ap_id) as appointment from appointment where ap_status='1' and ap_payment='1' and ap_shift= '$shift' and ap_date='$today' ");
		$row = 	mysqli_fetch_assoc($sql);
		if($row['appointment']>0){ 
			if($shift=='M')
			{
				$shift_name  = 'morning';
			}
			else
			{
				$shift_name = 	'evening';
			}
			$msg = 	"Hello $name , We have ".$row['appointment']." appointments for today's $shift_name shift in Bookmediz.";
			//echo $msg;
			smsgatewaycenter_com_Send("91".$mob, $msg);
		}
	}
	/*function converttimetosec($time){
		$time = explode(":",$time);
		return $time[0]*3600+$time[1]*60+$time[2];
	}*/

	

?>