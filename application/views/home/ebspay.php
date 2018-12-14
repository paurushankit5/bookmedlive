<?php
	$ap 	=	$array['ap'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body >
	<h1 class="text-center" style="margin-top:200px;">Please Do not press back button or refresh the page.</h1>
<form  method="post" style="display: none;" action="<?= base_url('ebs/');?>submit.php" name="frmTransaction" id="frmTransaction" onSubmit="return validate()">  	 
	<select name="channel" >
		<option value="0">Standard</option>
	</select>
	<input name="account_id" type="text" value="23264" /></td>
    <input name="reference_no" type="text" value="<?= $ap['ap_id'];?>" />
    <input name="amount" type="text" value="<?= $ap['ap_card_money'];?>" />
    <select name="currency" >
		<option value="INR">INR</option>
		<option value="USD">USD</option>
    </select>
    <select name="display_currency" >
		<option value="INR">INR</option>
		<option value="USD" selected>USD</option>
		<option value="EUR" selected>EURO</option>
		<option value="GBP" selected>GBP</option>
	</select>
	<input name="display_currency_rates" type="text" value="1" /></td>
	<input name="description" type="text" value="Appointment for doctor" /></td>
    <input name="return_url" type="text" size="60" value="<?= base_url('payment/response');?>" /> </td>
    <select name="mode" >
		<option value="TEST" >TEST</option>
		<option value="LIVE" selected >LIVE</option>
	</select> 
	<select name="payment_mode" >
		<option value="">All</option>	
		<option value="1">Credit Card</option>
		<option value="2">Debit Card</option>
		<option value="3">Net Banking</option>
		<option value="4">Cash Card</option>
		<option value="5">Credit Card - EMI</option>

		<option value="6">Credit Card - Reward Point</option>
		<option value="7">Paypal</option>
	</select>
    <select name="card_brand" >
		<option value="">All</option>	
		<option value="1">VISA</option>
		<option value="2">MasterCard</option>
		<option value="3">Maestro</option>
		<option value="4">Diners Club</option>

		<option value="5">American Express</option>
		<option value="6">JCB</option>
	</select>
    <input name="payment_option" type="text" value="" />
    <input name="bank_code" type="text" value="" />
	<input name="emi" type="text" value="" />
    <input name="page_id" type="text" value="" />
    <input name="name" type="text" value="<?= $_SESSION['user']['user_name'];?>" /></td>
    <textarea name="address">Billing Address</textarea>
    <input name="city" type="text" value="Billing City" />
    <input name="state" type="text" value="Billing State" />
	<input name="postal_code" type="text" value="600001" />
    <input name="country" type="text" value="IND" />
    <input name="email" type="text" value="<?= $_SESSION['user']['user_email'];?>" />
    <input name="phone" type="text" value="<?= $_SESSION['user']['user_mob'];?>" /></td>
    <input name="ship_name" type="text" value="Shipping Name" /></td>
    <input name="ship_address" type="text" value="Shipping Address" />
    <input name="ship_city" type="text" value="Shipping City" />
    <input name="ship_state" type="text" value="Shipping State" />
    <input name="ship_postal_code" type="text" value="600000" />
    <input name="ship_country" type="text" value="IND" /></td>
    <input name="ship_phone" type="text" value="04423452345" /></td>
    <input name="submitted" id="btn" value="Submit" type="submit" />&nbsp; 
                            
</form>
<script type="text/javascript">
	window.onload = function(){
		formsubmit();
	};
	function formsubmit(){
		$('#btn').click();
	}
</script>
</body>
</html>