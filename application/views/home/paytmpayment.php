<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Please do not refresh or press back button</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
 
window.onload = function(){
		formsubmit();
	};
	function formsubmit(){
		 $("#submit1").click();
	}
</script>
<meta name="GENERATOR" content="Evrsoft First Page">
</head>
<body>	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	 <h1><center>Please do not refresh or press back button</center></h1>
	<form method="post" class="form"  style="display:none;   ;" action="<?= base_url('paytm/pgRedirect.php');?>">		
			<input id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?= $this->uri->segment(3); ?>">
			<input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?= $array['ap']['ap_patient_id'];?>"> 
			 <input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
			<input id="CHANNEL_ID" tabindex="4" maxlength="12"size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
			<input title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT" value="<?= $array['ap']['ap_card_money'];?>">
			<input type="text" name="CALLBACK_URL" value="<?= base_url('payment/paytmresponse');?>"/>
			<input value="CheckOut" type="submit" id="submit1"	onclick="">
			 
	</form>
	 
</body>
</html>