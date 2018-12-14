<?php
	$cities	=	$array['cities'];
	$clinic	=	$array['clinic'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bookmediz: Doctor Registration</title>
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
		.form-control , .btn{
			border-radius:0px;
		}
	</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<?php
	include('includes/header.php');
?>
 
<div class="clearfix"></div>

<div class="col-sm-6 col-sm-offset-3" style="margin-top:50px;padding:0px 50px; background-color:white;margin-top:100px;box-shadow:0px 0px 5px 5px gray;"  >
  <h2 class="text text-center text-primary" ><b>Doctor Registration </b>	</h2>
  <?php
	if($this->session->flashdata('loginmsg'))
	{
		echo $this->session->flashdata('loginmsg');
	}
  ?>
  <form class="form-horizontal" method="post" action="<?= base_url('doctorregistration/storedoctors');?>">
	<?php
		if($this->session->flashdata('regmsg'))
		{
			echo $this->session->flashdata('regmsg');
		}
	?>
				<div class="form-group">
				<label   for="doctor_clinic_id">Select Clinic:</label>
				 
				  <select class="form-control" required id="doctor_clinic_id" name="doctor_clinic_id">
					<option value="">Select A Clinic</option>
					<?php
						if(count($clinic))
						{
							foreach($clinic as $x)
							{
								echo "<option value='".$x['clinic_id']."'>".$x['clinic_name']."</option>";
							}
						}
					?>
					<option value="0">Individual</option>
				  </select>
				 
			  </div>
			  <div class="form-group">
				<label   for="doctor_name"> Name:</label>
				<input type="text" class="form-control" required id="doctor_name" name="doctor_name" placeholder="Enter  Name">
				 
			  </div>
			  <div class="form-group">
				<label   for="doctor_email"> Email:</label>
				<input type="email" class="form-control" required id="doctor_email" name="doctor_email" placeholder="Enter Email">
				 
			  </div>
			  <div class="form-group">
				<label   for="doctor_mobile"> Mobile:</label>
				<input type="number" class="form-control" required id="doctor_mobile" name="doctor_mobile" placeholder="Enter  Mobile">
				
			  </div>
			   <div class="form-group">
				<label   for="doctor_age"> Gender:</label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <label> <input type="radio" name="doctor_gen" value="Male" checked> Male</label>
					<label><input type="radio" name="doctor_gen" value="Female"> Female</label>
					<label><input type="radio" name="doctor_gen" value="Other"> Other</label>
				 
			  </div>
			  <div class="form-group">
				<label   for="doctor_age"> Age:</label>
				 
				  <input type="number" class="form-control" required id="doctor_age" name="doctor_age" placeholder="Enter Age">
			 
			  </div>
			  
			  
			  <div class="form-group">
				<label   for="doctor_address"> City:</label>
				 
				  <select class="form-control" id="doctor_address" required name="doctor_city">
					<?php
						if(count($cities))
						{
							foreach($cities as $x)
							{
								?>
								<option value="<?= $x['city_name'];?>"><?= $x['city_name'];?></option>
								<?php
							}
						}
					?>
				  </select>
			 
			  </div>
			  <div class="form-group">
				<label   for="doctor_password">Password:</label>
				  
				  <input type="password" class="form-control" required id="doctor_password" name="doctor_password" placeholder="Enter password">
				 
			  </div>
			  <div class="form-group">
				<label    for="doctor_password">Confirm Password:</label>
				 
				  <input type="password" class="form-control" required id="doctor_password2" name="doctor_password2" placeholder="Confirm password">
				 
			  </div>
			  
			  <div class="form-group"> 
				<div class="">
					<p><a href="<?= base_url('doctorlogin');?>">Already a User?</a></p>
				  <button type="submit" class="btn btn-primary btn-block">Submit</button>
				</div>
			  </div>
			</form>
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
	