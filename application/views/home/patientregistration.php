<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bookmediz: Book Appointments With Doctor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-180x180.png">
	<style>
	.form-horizontal .control-label {
     
    text-align: left;
}
	</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<?php
	include('includes/header.php');
?>
 
<div class="clearfix"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2" style="background-color:white;margin-top:100px;box-shadow:0px 0px 5px 5px gray;" >
			<h3 class="text text-center">Patient Registration</h3>
			<br>
			<form class="form-horizontal" method="post" action="<?=base_url('patientregistration/storeuser');?>">
				<div class="form-group">
				  <label class="control-label col-sm-3" for="patient_name">Name:</label>
				  <div class="col-sm-9">
					<input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Enter Name">
				  </div>
				</div>
				 <div class="form-group">
				  <label class="control-label col-sm-3" for="patient_email">Email:</label>
				  <div class="col-sm-9">
					<input type="email" class="form-control" id="patient_email" name="patient_email" placeholder="Enter email">
				  </div>
				</div>
				 <div class="form-group">
				  <label class="control-label col-sm-3" for="patient_mobile">Contact No:</label>
				  <div class="col-sm-9">
					<input type="number" class="form-control" id="patient_mobile" name="patient_mobile" placeholder="Enter Contact Number">
				  </div>
				</div>
				 <div class="form-group">
				  <label class="control-label col-sm-3" for="patient_age">Age:</label>
				  <div class="col-sm-9">
					<input type="number" class="form-control" id="patient_age" name="patient_age" placeholder="Enter Age">
				  </div>
				</div>
				 <div class="form-group">
				  <label class="control-label col-sm-3" for="patient_gender">Gender:</label>
				  <div class="col-sm-9">
					<select class="form-control" id="patient_gender" name="patient_gender">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="control-label col-sm-3" for="patient_password">Password:</label>
				  <div class="col-sm-9">          
					<input type="password" class="form-control" id="patient_password" name="patient_password" placeholder="Enter password">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-3" for="patient_password2">Confirm Password:</label>
				  <div class="col-sm-9">          
					<input type="password" class="form-control" id="patient_password2" name="patient_password2" placeholder="Confirm password">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-3" for="patient_cause">Cause for Registeration:</label>
				  <div class="col-sm-9">          
					<input type="text" class="form-control" id="patient_cause" name="patient_cause" placeholder="Cause for Registeration">
				  </div>
				</div>
			  
			 
				<div class="form-group">        
				  <div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-primary">Submit</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?= base_url('patientlogin');?>">Already a User?</a>
				  </div>
				</div>
			  </form>
			</div>
		</div>
	</div>
<div class="clearfix"></div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
	include('includes/footer.php');
?>
 

 


</body>
</html>
	