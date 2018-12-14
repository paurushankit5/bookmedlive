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
				<h3>Change Password</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<section class="user-profile section">
	<div class="container">
		<div class="row">
			
			<div class="col-md-9">
				<form method="post" action="<?= base_url('Myprofile/updatepassword');?>">
					
				<!-- Edit Personal Info -->
				<div class="widget personal-info">
						 
						<?php 
							 
							if($this->session->flashdata('passmsg'))
							{
								echo $this->session->flashdata('passmsg');
							}
							
						 ?>
						<!-- First Name -->
						<div class="form-group">
						    <label for="user_pwd">Current Password</label>
						    <input type="password" required minlength="6" name="user_pwd" class="form-control" id="user_pwd">
						</div>
						<div class="form-group">
						    <label for="new_pwd">New Password</label>
						    <input type="password" required minlength="6" name="new_pwd" class="form-control" id="new_pwd">
						</div>
						<div class="form-group">
						    <label for="new_pwd2">Confirm Password</label>
						    <input type="password" required minlength="6" name="new_pwd2" class="form-control" id="new_pwd2">
						</div>
					<button type="submit"class="btn btn-transparent">Submit</button>
						 
				</div>	
				</form>
				 
			</div>
			<div class="col-md-3">
				<?php
					if($_SESSION['user']['user_type']==1)
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
  <!-- JAVASCRIPTS -->
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