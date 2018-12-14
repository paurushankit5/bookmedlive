<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz : Register As Patient</title>
  
  <link href="<?= base_url('web/');?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url('web/');?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
  <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>css/select2.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 -->  <![endif]-->

</head>

<body class="body-wrapper">


<?php
	include('includes/header.php');
?>
<!--==================================
=            User Profile            =
===================================-->

<section class="user-profile section">
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
					 
					<!-- Dashboard Links -->
					<div class="widget user-dashboard-menu">
						<ul>
							<li class="active">
								<a href="<?= base_url('Register');?>"><i class="fa fa-user"></i>Register As Patient</a></li>
							<li>
								<a href="<?= base_url('Register/Clinic');?>"><i class="fa fa-heart"></i> Register as Clinic </a>
							</li>
							<li>
								<a href="<?= base_url('Register/Hospital');?>"><i class="fa fa-hospital-o"></i> Register as Hospital </a>
							</li>
							<li>
								<a href="<?= base_url('Register/Individualdoctor');?>"><i class="fa fa-user-md"></i> Register as Individual Doctor </a>
							</li>
							<li>
								<a href="<?= base_url('Register/diagnosis');?>"><i class="fa fa-medkit"></i> Register as Diagnosis Center </a>
							</li>
							 
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
				<form method="post" action="<?= base_url('register/storepatient');?>">
					
				<!-- Edit Personal Info -->
				<div class="widget personal-info">
						<h1 class="text text-center text-danger">Register As Patient</h1>
						<?php 
							if(validation_errors()){
								echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".validation_errors()."</b></p></div>";
							}
							if($this->session->flashdata('regmsg'))
							{
								echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".$this->session->flashdata('regmsg')."</b></p></div>";
							}
							
						 ?>
						<!-- First Name -->
						<div class="form-group">
						    <label for="user_name">Name</label>
						    <input type="text" required name="user_name" value="<?php echo set_value('user_name'); ?>"class="form-control" id="user_name">
						</div>
						<div class="form-group">
						    <label for="user_email">Email</label>
						    <input type="email" required class="form-control" name="user_email" value="<?php echo set_value('user_email'); ?>" id="user_email">
						</div> 
						<div class="form-group">
						    <label for="user_pwd">Password</label>
						    <input type="password" required minlength="6" class="form-control"  name="user_pwd" id="user_pwd">
						</div>
						<!-- Confirm New Password -->
						<div class="form-group">
						    <label for="user_pwd2">Confirm Password</label>
						    <input type="password" minlength="6" class="form-control" name="user_pwd2" id="user_pwd2">
						</div>
					 
				</div>
				<!-- Change Password -->
				<div class="widget change-password">
					<h3 class="widget-header user">Personal Details</h3>
					<div class="form-group">
						    <label for="user_mob">Mobile</label>
						    <input type="text" required  pattern="[0-9]{10}" maxlength="10" value="<?php echo set_value('user_mob'); ?>" class="form-control" name="user_mob" id="user_mob">
					</div>
					
					<div class="form-group">
						    <label for="user_age">Age</label>
						    <input type="text" class="form-control" value="<?php echo set_value('user_age'); ?>" id="user_age" name="user_age"  required  pattern="[0-9]{2}" maxlength="2">
						</div>
					<div class="form-check">
						  <label class="form-check-label"  >
						    <input class="form-check-input" name="user_gender" value="Male" checked  type="radio" value="" id="hide-profile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    Male
						  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						   <label class="form-check-label" >
						    <input class="form-check-input" name="user_gender" value="Female"  type="radio" value="" id="hide-profile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    Female
						  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <label class="form-check-label" >
						    <input class="form-check-input" name="user_gender" value="Others"  type="radio" value="" id="hide-profile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						    Others
						  </label>

					</div>
					<div class="form-group">
						    <label for="user_cause">Cause Of Registration</label>
						    <textarea  name="user_cause"  class="form-control" style="height:100px;" id="user_cause"><?php echo set_value('user_cause'); ?></textarea>
					</div>
					<button type="submit"class="btn btn-transparent">Submit</button>
						 
				</div>	
				</form>
				 
			</div>
		</div>
	</div>
</section>

<!--============================
=            Footer            =
=============================-->

<?php
	include('includes/footer.php');
?>

  <script src="<?= base_url('web/');?>plugins/jquery/dist/jquery.min.js"></script>
  
  <script src="<?= base_url('web/');?>plugins/tether/js/tether.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/raty/jquery.raty-fa.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/popper.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.js"></script>
  <script src="<?= base_url('web/');?>plugins/smoothscroll/SmoothScroll.min.js"></script>
  
  <script src="<?= base_url('web/');?>js/scripts.js"></script>

</body>

</html>