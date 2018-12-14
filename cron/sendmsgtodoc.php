<?php
	include('./config.php');
	$day = strtolower(date('D'));
	$morning = $day."_morning_start";
	$evening = $day."_evening_start";
	//echo $day;
 	$sql="select u.id,user_name,user_type,user_mob,$morning,$evening,$day from users u inner join timings t on t.user_id=u.id where user_type in ('4','5','6')  and is_active='1' and $day=1 and path_morning_start=''";  
	$result=mysqli_query($con,$sql);
	// Associative array
	$time = date("H:i:s");
	//echo $time."<br>";
	$time = converttimetosec($time);
	//echo converttimetosec($time);
	 
	while($row=mysqli_fetch_assoc($result))
	{
		if($row[$morning]!='00:00:00')
		{
			if(converttimetosec($row[$morning])-$time<=3600 && converttimetosec($row[$morning])-$time>=0)
			{
				findappointment($row,'M');
			}
		}
		if($row[$evening]!='00:00:00')
		{ 
			if(converttimetosec($row[$evening])-$time<=3600 && converttimetosec($row[$evening])-$time>=0)
			{
				findappointment($row,'E');
			}
		}

	}

	function findappointment($user,$shift){
		global $con;
		$id  = 	$user['id'];
		$mob = 	$user['user_mob'];
		$name = 	$user['user_name'];
		$today 	= 	date('Y-m-d');
		$sql = 	mysqli_query($con,"select count(ap_id) as appointment from appointment where ap_doctor_id='$id' and ap_status='1' and ap_payment='1' and ap_shift= '$shift' and ap_date='$today' ");
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
			$msg = 	" Hello Dr. $name , You have ".$row['appointment']." appointments for today's $shift_name shift from Bookmediz";
			//echo $msg;
			smsgatewaycenter_com_Send("91".$mob, $msg);
		}
	}
	 

?>