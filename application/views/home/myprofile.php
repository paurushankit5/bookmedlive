<?php
	$user 	=	$_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz : Change Password</title>
  
  <!-- PLUGINS CSS STYLE -->
   <!-- PLUGINS CSS STYLE -->
  <link href="<?= base_url('web/');?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <!-- Bootstrap -->
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- CUSTOM CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">

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
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3>My Profile</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<section class="user-profile section">
	<div class="container">
		<div class="row">
			
			<div class="col-md-9">
				<form method="post" action="<?= base_url('Myprofile/updateprofile');?>">
					
				<!-- Edit Personal Info -->
				<div class="widget personal-info">
						 
						<?php 
							 
							if($this->session->flashdata('profilemsg'))
							{
								echo $this->session->flashdata('profilemsg');
							}
							
						 ?>
						<!-- First Name -->
						<div class="form-group">
						    <label for="user_name">Name</label>
						    <input type="text" required name="user_name" value="<?= $user['user_name'];?>" class="form-control" id="user_name">
						</div>
						<div class="form-group">
						    <label for="user_email">Email</label>
						    <input type="email" required class="form-control" value="<?= $user['user_email'];?>" id="user_email">
						</div> 
						 
					 
					<div class="form-group">
						    <label for="user_mob">Mobile</label>
						    <input type="text" required  pattern="[0-9]{10}" maxlength="10" value="<?= $user['user_mob'];?>" class="form-control" name="user_mob" id="user_mob">
					</div>
					<div class="form-group">
						    <label for="user_alt_mob">Alternate Contact</label>
						    <input type="text" required  pattern="[0-9]{10}" maxlength="10" name="user_alt_mob" value="<?= $user['user_alt_mob'];?>" class="form-control" id="user_alt_mob">
					</div>
					<div class="form-group">
						    <label for="user_age">Age in years</label>
						    <input type="text" class="form-control" value="<?= $user['user_age'];?>" id="user_age" name="user_age"  required  pattern="[0-9]{2}" maxlength="2">
						</div>
					<div class="form-check">
						  <label class="form-check-label"  >
						    <input class="form-check-input" name="user_gender" value="Male" <?php if($user['user_gender']=="Male"){echo "checked";}?>   type="radio" value="MAle" id="hide-profile">
						   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Male
						  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						   <label class="form-check-label" >
						    <input class="form-check-input" name="user_gender" value="Female" <?php if($user['user_gender']=="Female"){echo "checked";}?>   type="radio" value="Female" id="hide-profile">
						    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Female
						  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <label class="form-check-label" >
						    <input class="form-check-input" name="user_gender" value="Others" <?php if($user['user_gender']=="Others"){echo "checked";}?>  type="radio" value="Others" id="hide-profile">
						   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Others
						  </label>

					</div>
					<button type="submit"class="btn btn-transparent">Submit</button>
						 
				</div>	
				</form>
				 
			</div>
			<div class="col-md-3">
				<?php
					include('includes/sidebar.php')
				?>
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

    <!-- JAVASCRIPTS -->
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