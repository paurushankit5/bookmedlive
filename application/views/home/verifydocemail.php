<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Register as Clinic</title>
  
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
			 
			<div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2">
				<form method="post" action="<?= base_url('Account/resetdocpassword');?>">
					
				<!-- Edit Personal Info -->
				<div class="widget personal-info">
						<h1 class="text text-center text-danger"> Reset Your Password</h1>
						<?php 
							if(validation_errors()){
								echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".validation_errors()."</b></p></div>";
							} 
							if($this->session->flashdata('verifymsg'))
							{
								echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".$this->session->flashdata('verifymsg')."</b></p></div>";
							}
							
						 ?>
						<!-- First Name -->
						 
						<div class="form-group">
						    <label for="user_pwd">Password</label>
						    <input type="password" required minlength="6" class="form-control"  name="user_pwd" id="user_pwd">
						</div>
						<!-- Confirm New Password -->
						<div class="form-group">
						    <label for="user_pwd2">Confirm Password</label>
						    <input type="password" required minlength="6" class="form-control" name="user_pwd2" id="user_pwd2">
						</div>
					 	<button type="submit"class="btn btn-transparent">Submit</button>
						 

				</div>
				<!-- Change Password -->
				 	
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