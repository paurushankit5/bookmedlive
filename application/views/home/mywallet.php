<?php
	$wallet 	=	$array['wallet'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz My Wallet</title>
  
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

<!--================================
=            Page Title            =
=================================-->
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3>My Wallet</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!--==================================
=            Blog Section            =
===================================-->

<section class="blog section">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<?php
					if($this->session->flashdata('apmsg'))
					{
						echo $this->session->flashdata('apmsg');
					}
					 
				?>
				<div class="col-md-12" style="box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.1);padding: 30px;">
						<center>
						<label>Your wallet amount is </label>
						<h2>&#x20B9; <?= $wallet['wallet_amount'];?></h2>
						<p class="text text-justify">You get this wallet amount, if you cancel an appointment. You can easily use the same wallet amount, if you book a new appointment.</p>	 
					</center>
					 
						 
					<div class="clearfix"></div>
				</div>
			</div>	
			<div class="col-md-3">
				<?php include('includes/sidebar.php');?>
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

