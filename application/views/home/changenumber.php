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
  <title>Bookmediz : Change Number</title>
  
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
				<h3>Change Number</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<section class="user-profile section">
	<div class="container">
		<div class="row">
			
			<div class="col-md-6 col-md-offset-3">
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
						    <label for="user_pwd">Mobile</label>
						     <input type="text" required  pattern="[0-9]{10}" maxlength="10" value="<?= $_SESSION['user']['user_mob']; ?>" class="form-control" name="user_mob" id="user_mob">
						</div>
						<div class="form-group">
						    <label for="new_pwd">Alternate Mobile</label>
						    
						     <input type="text" required  pattern="[0-9]{10}" maxlength="10" value="<?= $_SESSION['user']['user_alt_mob']; ?>" class="form-control" name="user_alt_mob" id="user_alt_mob">
						</div>
						 
					<button type="button" onClick="sendotp();" class="btn btn-transparent">Submit</button>
						 
				</div>	
				 
				 
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
<script type="text/javascript">
	function sendotp(){
		var user_mob 		 = $('#user_mob').val();
		var user_alt_mob 	 = $('#user_alt_mob').val();
		if(user_mob=='')
		{
			alert('Please enter a moobile number');
		}
		else if(!checkmobile(user_mob))
		{
			alert('Please enter a valid mobile number');
		}
		else if(user_alt_mob!='' && (!checkmobile(user_alt_mob)))
		{
			alert('Please enter a valid alternate mobile number');
		}		
		else{
			$.ajax({
				type  : 		"POST",
				url   : 		"<?= base_url('myprofile/updatemobile');?>",
				data  : 		{
									"user_mob" 			: user_mob,
									"user_alt_mob"		 : user_alt_mob,
				},
				beforeSend : function(){
	  			$('#loadingDiv').show();
	  			//alert("hello");
	  		},
	  		success : 	function(data){	  			
	  			$('#loadingDiv').hide();
	  			console.log(data);
	  			if(data =="0")
	  			{
	  				alert("Please enter a unique mobile number.");
	  			}
	  			else if (data == "1"){
	  				window.location.href="<?= base_url('myprofile/verifyotpformobile');?>";		  			
	  			}
	  			else if(data == "2")
	  			{
	  				alert("We are facing some technical issues. Please try after some time.");
	  			}
	  		}

			});
		}
	}
function checkmobile(user_mob){
	if (/^\d{10}$/.test(user_mob)) {
		    return true;
		} else {
		    return false;		     
		}
}
</script>

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