<?php

	$con = mysqli_connect("localhost","root","","hos3");
	function converttimetosec($time){
		$time = explode(":",$time);
		return $time[0]*3600+$time[1]*60+$time[2];
	}

	function smsgatewaycenter_com_Send($mobile, $sendmessage)
	{
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
		return ($curl_scraped_page);
	}
?>