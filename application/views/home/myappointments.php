<?php
	$ap 	=	$array['ap'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz My Appointments</title>
  
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
				<h3>My Appointments</h3>
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
					if(count($ap))
					{
						foreach($ap as $x)
						{
							$class1= '';
							$class2= '';
							$background 	= 	'#fff';
							if($x['ap_date']<date('Y-m-d'))
							{
								$background = "#ff00001c";
							}
						?>
							<div class="col-smd-12" style="    background: <?= $background; ?>;
							    box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.1);
							    padding: 30px;
							    margin-bottom: 30px;
							    border-radius: 2px;">
								<h2 class="text text-center">Appointment Id- <span style="color:#5672f9;"><b><?= $x['ap_id'];?></b></span></h2>
								 
											<div class="col-md-2">
											<?php
												if($x['user_image']=='')
												{
													?>
														<img  style="width:100%; height:auto;" src="<?= base_url('img/expert.jpg');?>" alt="<?= $x['user_name'];?>">
													<?php
												}
												else{
													?>
													<img style="width:100%; height:auto;" src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" alt="<?= $x['user_name'];?>">
													<?php
												}
											?>
										 	</div>
										 	<div class="col-md-7">
										 	<?php
										 		if($x['ap_test_ids']=='')
										 		{
										 			?>
										 				<h3 class="title"><a href="<?= base_url('doctor/viewprofile/'.$x['id']);?>" style="color:#5672f9;">Dr. <?= $x['user_name'];?></a></h3>
										 			<?php
										 		}
										 		else{
										 			?>
										 				<h3 class="title"><a href="<?= base_url('Testcenter/viewprofile/'.$x['id']);?>" style="color:#5672f9;"> <?= $x['user_name'];?></a></h3>
										 			<?php
										 		}
										 	?>
											
											<table class="table table-bordered">
												<tr>
													<th>Appointment Date:</th>
													<td><?=  date('d,M y',strtotime($x['ap_date']));?></td>
												</tr>
												<?php
													if($x['ap_time']!='')
													{
														?>
															<tr>
																<th>Appointment Time:</th>
																<td><?= $x['ap_time'];?></td>
															</tr>
														<?php
													}
												?>
												
												<tr>
													<th>Amount to be paid :</th>
													<td> &#x20B9; <?= $x['ap_amount_to_be_paid'];?> </td>
												</tr>
												<tr>
													<th>Booked On:</th>
													<td><?= date('d,M y',strtotime($x['created_at']));?></td>
												</tr>
												
											</table>
											 
 											</div>
 											<div class="col-md-3 col-sm-12">
 												<br>
 												<br>
 											<?php
 												if($x['ap_status']	==	2)
 												{
 													echo "<h4>Cancelled by You.</h4>";
 													echo "<p>Amount of <b>&#x20B9; ".$x['ap_money']."</b>  refunded to your bookmediz wallet.</p>";
 												}
 												else if($x['ap_status']	==	3)
 												{
 													echo "<h4>Cancelled by Doctor.</h4>";
 													echo "<p>Amount of &#x20B9; ".$x['ap_money']."  refunded to your bookmediz wallet.</p>";
 												}
 												else{
 													$today 		=	date('Y-m-d');
	 												$class1 	=	'';
	 												$class2 	=	'';
	 												if($x['ap_rescheduled']	==1)
	 												{
	 													$class2 = " hidden ";	
	 												}
	 												else if($x['ap_date']<$today)
	 												{
	 													$class1 = " hidden ";		
	 												}
	 												else if($x['ap_date']==$today)
	 												{
	 													if($x['ap_time']!='')
	 													{
	 														$time 	=	date("H:i:s");
		 													$time 	=	explode(":",$time);
		 													$time 	=   ($time[0]*3600)+($time[1]*60)+($time[2]);
		 													$maxlimit =	$time + (2*3600);
		 													//echo 	$maxlimit ;		
		 													$aptime 	=	explode(" ",$x['ap_time']);
		 													$aptime 	=	$aptime[0];
		 													$aptime 	=	explode(":",$aptime);
		 													$aptime 	=   ($aptime[0]*3600)+($aptime[1]*60);
															if($aptime<=$maxlimit)
															{
																$class1=		" hidden ";
															}
	 													}
	 													else{
	 														$class1=		" hidden ";
	 													}
	 												}
	 												?>
	 												<center>
			 											<?php 
			 											if($x['ap_rescheduled']	==1)
														{
															echo "<h3>Rescheduled</h3>";	
														}
														if($x['ap_date'] < $today){
															$class1 = "hidden";
														}
														?>
														<button class="btn btn-danger <?= $class1; ?>" style="width:140px;" onclick="cancelap('<?= $x['ap_id'];?>');">Cancel</button><br><br>
														<?php
															if($x['ap_test_ids']=='')
															{
																?>
																	<a href="<?= base_url('myappointments/reschedule/'.$x['ap_id']);?>" class="btn btn-warning <?= $class1; ?> <?= $class2; ?>" style="width:140px;">Reschedule</a>

																<?php
															}
															else{
																?>
																	<a href="<?= base_url('myappointments/rescheduletest/'.$x['ap_id']);?>" class="btn btn-warning <?= $class1; ?> <?= $class2; ?>" style="width:140px;">Reschedule</a>
																<?php
															}
														?>
														
													</center>
	 												<?php
 												}
 												
 											?>
										 	</div>
										 
								<?php
									/*echo "<pre>";
									print_r($x);
									echo "</pre>";*/
								?>
								<div class="clearfix"></div>
 								<p><span class="<?= $class1; ?> <?= $class2; ?> text-danger " style="font-weight:bold;">Reshedule of appointment only valid up to 2 hr before doctor (morning/evening) consultation time start.</span></p>

							</div>
						<?php
						}
						?>
						<nav aria-label="Page navigation example">
						 
						  <?= $this->pagination->create_links(); ?>
						</nav>
						<?php
					}
				?>
				<!-- Pagination -->
				
			</div>
			<div class="col-md-3">
				<?php 
					include('includes/sidebar.php');
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
	<script type="text/javascript">
		function cancelap(ap_id){
			$("#ap_cancel_id").val(ap_id);
			$("#cancelmodal").modal('toggle');
		}
		function cancelnow(){
			var ap_id 	=	$("#ap_cancel_id").val();
			$.ajax({
				type 	: 	"POST",
				data 	: 	{
								"ap_id"	: ap_id,

				},
				url 	: 	"<?= base_url('myappointments/cancel');?>",
				beforeSend 	: 	function(){$('.loadingDiv').show();},
				success 	: 	function(data){
					location.reload();
				}
			});
		}
	</script>
	<div id="cancelmodal" class="modal fade" role="dialog" style="margin-top:20px;padding:20px;">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header" style="padding:20px;">
	         
	        <h4 class="modal-title">Are You sure</h4>
	      </div>
	      <div class="modal-body">
	        <p>Do you really want to cancel this appointment? </p>
	        <input type="hidden" id="ap_cancel_id"/>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" onclick="cancelnow();" >Yes</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	      </div>
	    </div>

	  </div>
	</div>
	
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

