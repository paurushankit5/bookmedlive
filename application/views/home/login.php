<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Login Area</title>
  
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
 -->
</head>

<body class="body-wrapper">
 
        <?php
          include('includes/header.php');
        ?>
    
<section class="page-title">
  <!-- Container Start -->
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 text-center">
        <!-- Title text -->
        <h3>Login</h3>
      </div>
    </div>
  </div>
  <!-- Cont

<section class="user-profile section">
  ainer End -->
</section>
	<div class="container">
		<div class="row">
			 
			<div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3" >
          <br>
					<br>
				<!-- Edit Personal Info -->
				<div class="widget personal-info" 	> 
						<?php 
							 
							if($this->session->flashdata('logmsg'))
							{
								echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".$this->session->flashdata('logmsg')."</b></p></div>";
							}
							
						 ?>
						<!-- First Name -->
						<form method="post" action="<?= base_url('login/validatelogin');?>">
				
						 <div class="form-group">
						    <label for="user_email">Email or Mobile</label>
						    <input type="text" required class="form-control" name="user_email" value="<?php echo set_value('user_email'); ?>" id="user_email">
						</div> 
						<div class="form-group">
						    <label for="user_pwd">Password</label>
						    <input type="password" required minlength="6" class="form-control"  name="user_pwd" id="user_pwd">
						</div>
						<div class="row"> 
            <div class="col-sm-5 col-xs-6" style="width:50%">
              <button type="submit" class="btn btn-transparent ">Submit</button>
            </div>
				    <div class="col-sm-7 col-xs-6" style="width:50%" >
              <a href="<?= base_url('Forgot-Password');?>" class="pull-right">Reset Password</a>   <br> 
              <a href="<?= base_url('Register');?>" class="pull-right"> Register Now</a>

            </div>
						</div>
             <div class="clearfix"></div>
             
						</form>	 
            
				</div>	
				
				 
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