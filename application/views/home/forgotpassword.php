<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Forgot Password</title>
  
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
			 
			<div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3" >
					
				<!-- Edit Personal Info -->
				<div class="widget personal-info" 	>
						<h1 class="text text-center text-danger">FORGOT PASSWORD</h1>
						 <div class='alert alert-danger' id="dangermsg" style='background-color:#000000;font-color:white; display: none;'><p style='color:white !important;'><b>The Email/Mobile is not registered with Bookmediz.</b></p></div>
							 
						<!-- First Name -->
						 
				
						 <div class="form-group submitbtn">
						    <label for="user_email">Email or Mobile</label>
						    <input type="text" required class="form-control" name="user_email"  id="user_email">
						</div> 
						 
						 
				   		<div class="form-group submitbtn" >
						<button type="submit" onClick="sendotp();" class="btn btn-transparent ">Submit</button>
            			<a href="<?= base_url('login');?>" class="pull-right">Login</a>
            			</div>
						<div class="col-md-12 otpdiv" style="display: none;">  
						<form method="post" action="<?= base_url('Login/sendforgototp');?>">
						<input type="hidden" name="email" id="emailfield">
						<label><input type="radio" checked name="otpmethod" value="mobile"> Send OTP through registered mobile number.</label><br>
            			<label><input type="radio" name="otpmethod" value="mail"> Send OTP through e-Mail.</label><br>
            			<button   onClick="sendotpnow();" class="btn btn-transparent ">Send OTP</button>
            			</form>
            			</div>
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
  <script type="text/javascript">
	function sendotp(){
		var user_email 	=	$('#user_email').val();
		if(user_email=='')
		{
			alert("Please provide an email or mobile number");
		}
		else{
			$('#emailfield').val(user_email);
			$.ajax({
				type 	: 	"POST",
				data 	: 	{
								"user_email"	:	user_email,
							},
				url 	: 	"<?= base_url('login/checkemail');?>",
				success	: 	function(data){
						if(data == '0')
						{
							$('#dangermsg').slideDown();
							$('#dangermsg').delay(3000).slideUp();
						}
						else{
							$('.submitbtn').slideUp();
							$('.otpdiv').slideDown();
						}

				}
			});
		}	

	}
	 
</script>
</body>

</html>