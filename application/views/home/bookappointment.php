<?php
	$doc		=	$array['doctor'];
	$timing		=	$array['time'];
	$settings	=	$array['settings'];
	$wallet		=	$array['wallet'];
	$charge		=	($settings['settings_service_charge']*$doc['user_fee'])/100;
	$gst		=	($settings['settings_gst']*$charge)/100;
	//$vacations	=	$array['vacations'];
	$totalamount	=	$charge+$gst+$doc['user_fee'];
	$totalamount	=	 ceil($totalamount);
	$extracharge	=	$totalamount-$doc['user_fee'];

	//this is the new total amount
	 
	$totalamount 	= 	 $array['totalamount'];
	if($wallet['wallet_amount']=='')
	{
		$wallet['wallet_amount']=0;
	}
	//echo $wallet['wallet_amount'];
	if($timing['mon']==1)
	{
		$day[]=1;
		$day2[]='Monday';
	}
	if($timing['tue']==1)
	{
		$day[]=2;
		$day2[]='Tuesday';
	}
	if($timing['wed']==1)
	{
		$day[]=3;
		$day2[]='Wednesday';
	}
	if($timing['thu']==1)
	{
		$day[]=4;
		$day2[]='Thursday';
	}
	if($timing['fri']==1)
	{
		$day[]=5;
		$day2[]='Friday';
	}
	if($timing['sat']==1)
	{
		$day[]=6;
		$day2[]='Saturday';
	}
	if($timing['sun']==1)
	{
		$day[]=0;
		$day2[]='Sunday';
	}
	//print_r($day);
	$data	=	'day==';
	$data	.=	implode("|| day==",$day);
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz:  Book an appointment with Dr. <?= $doc['user_name'];?></title>
  
  <!-- PLUGINS CSS STYLE -->
 <!--  <link href="<?= base_url('web/');?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
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
  <!-- CUSTOM CSS -->
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> 
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <!-- Javascript -->
  <script>
		var jq = jQuery.noConflict();
		jq(function() {
			jq( "#datepicker" ).datepicker({
				minDate: 0, maxDate: "+15D",
				dateFormat: 'yy-mm-dd',
				beforeShowDay: function(date){ 
				  var day = date.getDay(); 
				  return [<?= $data; ?>,""];				  
				}
			});		 
         });
    </script>
    <style type="text/css">
    	.red{
    		background: red;
    		color:white;
    	}
    </style>
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
				<h3>Book Appointment</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<section class="dashboard section">
	<!-- Container Start -->
	<div class="container">
		<!-- Row Start -->
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
					<div class="widget user-dashboard-profile">
						<div class="profile-thumb">
						<center>
						<?php
							if($doc['user_image']!='')
							{
								?>
									<img src="<?= base_url('images/user/'.$doc['id'].'/'.$doc['user_image']);?>" class=" rounded-circle img img-responsive img-rounded" alt="<?= $doc['user_name'];?>"  style="height:150px;width:150px;" />
								<?php
							}
							else{
								?>
									<img src="<?= base_url('img/expert.jpg');?>" style="height:150px;width:150px;" class="rounded-circle img img-responsive img-rounded" alt="<?= $doc['user_name'];?>"/>
								<?php
							}
							
						?>
						</center>
						</div>
						<!-- User Name -->
						<h5 class="text-center">Dr. <?= $doc['user_name'];?></h5>
						 
						<a href="<?= base_url('doctor/viewprofile/'.$doc['id']);?>" class="btn btn-main-sm">View Profile</a>
					</div>
					<!-- Dashboard Links -->
					<!-- <div class="widget user-dashboard-menu">
						<ul>
							<li class="active" ><a href="#"><i class="fa fa-user"></i> My Ads</a></li>
							<li><a href=""><i class="fa fa-bookmark-o"></i> Favourite Ads <span>5</span></a></li>
							<li><a href=""><i class="fa fa-file-archive-o"></i>Archived Ads <span>12</span></a></li>
							<li><a href=""><i class="fa fa-bolt"></i> Pending Approval<span>23</span></a></li>
							<li><a href=""><i class="fa fa-cog"></i> Logout</a></li>
							<li><a href=""><i class="fa fa-power-off"></i>Delete Account</a></li>
						</ul>
					</div> -->
				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0">
				<!-- Recently Favorited -->
				<div class="widget dashboard-container my-adslist">
					<h3 class="widget-header">Book An Appointment <span class="text-warning">( &#x20B9; 10 as appointment charge )</span></h3>
					<div class="col-sm-12">
					<div class="col-sm-8" style="padding-top: 20px;">
						<input type = "text" readonly id = "datepicker" name="appointment_date" class="form-control" placeholder="Select A Date (YYYY-MM-DD)">
						<input type = "hidden" readonly id = "ap_time" name="ap_time" >
						<input type = "hidden" readonly id = "shift" name="shift" >
					</div>
					<div class="col-sm-4" style="padding-top: 20px;">
						<center><button class="btn btn-primary" onclick="showtimeslots();">Show Time Slots</button></center>
					</div>
					
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12 maindata"></div>
					<div class="clearfix"></div>		
				</div>
			</div>
			<!-- Trigger the modal with a button -->
			<button type="button" id="modalbtn" class="hidden" data-toggle="modal" style="display: none;" data-target="#paymodal"></button>

			<!-- Modal -->
			<div id="paymodal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content" style="padding-top: 90px;">
			      <div class="modal-header" > 
			        <h4 class="modal-title">Book Appointment by paying &#x20B9; 10</h4>
			      </div>
			      <div class="modal-body">	
			      	<div class="" >
						<!-- Recently Favorited -->
						<div class="widget dashboard-container my-adslist">
							<div class="col-sm-12">

							 	<center>
							 		<h4 class="text text-primary">Book Appointment by paying &#x20B9; 10</h4>
							 		Total Amount : <b>  &#x20B9; <?= $totalamount; ?></b><br>
							 		<?php 
							 			if($wallet['wallet_amount']>=$totalamount)
							 			{
							 				?>
							 					Your Wallet balance is <b>&#x20B9; <?= $wallet['wallet_amount']; ?></b><br>
							 					<label><input type="checkbox" checked id="usewallet"> Use Wallet Balance</label><br>
							 					<button type="submit" class="btn btn-primary" onclick="booknow();">Book Now</button>
							 				<?php
							 			}
							 			else if($wallet['wallet_amount']<$totalamount and $wallet['wallet_amount']!='0')
							 			{
							 				?>
							 					Your Wallet balance is <b>&#x20B9; <?= $wallet['wallet_amount']; ?></b><br>
							 					<label><input type="checkbox" checked id="usewallet"/> Use Wallet Balance</label><br>
							 					<button type="submit" class="btn btn-primary" onclick="jq('.pgdiv').slideDown('slow');">Book Now</button><br>
								 				
							 				<?php
							 			}
							 			else{
							 				?>
							 				<input type="checkbox" style="display: none;" id="usewallet"/>
							 				<button type="submit" class="btn btn-primary" onclick="jq('.pgdiv').slideDown('slow');">Book Now</button><br>
							 				
							 				<?php
							 			}	
							 		?>
							 		<div class="pgdiv" style="display: none;">
					 				<h4>Pay Using</h4>
					 				<div class="col-xs-6"><img src="<?= base_url('img/ebs.png');?>" onclick="payusingebs();" style="width:100px;height:100px;cursor:pointer;" class="img img-responsive img-thumbnail"></div>
					 				<div class="col-xs-6"><img src="<?= base_url('img/paytm.png');?>" onclick="payusingpaytm();" style="width:100px;height:100px;cursor:pointer;" class="img img-responsive img-thumbnail"></div>
					 				</div>
							 		
							 		<br><br>

							 	</center>
							</div>
							<div class="clearfix"></div>
							 	
						</div>
					</div> 
			      </div>
			       
			    </div>

			  </div>
			</div>
			
			
			</div>
		</div>
		<!-- Row End -->
	</div>
	<!-- Container End -->
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
  <script>
  	function showtimeslots(){
  		var date = jq('#datepicker').val();
  		if(date == '')
  		{
  			alert("Please Select a Date");
  		}
  		else
  		{
	  		jq.ajax({
	  			type 	: 	'POST',
	  			url 	: 	'<?= base_url('Timeslots/showtimeslots');?>',
	  			data 	: 	{
	  							'date' 	: date,
	  							'id' 	: "<?= $doc['id'];?>",
	  			},
	  			beforeSend : function(){jq('.loadingDiv').show();},
	  			success : function(data){
	  				jq('.loadingDiv').hide();
	  				data = data.trim();
	  				jq(".maindata").html(data);
	  				//jq("#paydiv").hide();
	  			},
	  		});
  		}  		
  	}
  	function dateselected(id,ap_time,shift){
  		console.log(id);
  		jq('*').removeClass('btn-danger');
  		jq("#"+id).addClass('btn-danger');
  		jq("#ap_time").val(ap_time);
  		jq("#shift").val(shift);
  		//jq("#paydiv").show();
  		jq("#modalbtn").click();
  	}
  	function booknow(){
  		var ap_date = jq("#datepicker").val();
  		var ap_shift = jq("#shift").val();
  		var ap_time = jq("#ap_time").val();
  		var ap_patient_id = "<?= $_SESSION['user']['id'];?>";
  		var ap_doctor_id = "<?= $doc['id']; ?>";
  		if(jq("#usewallet").is(":checked"))
  		{
  			var usewallet = 1;
  			jq.ajax({
	  			type : 'POST',
	  			url  :  "<?= base_url('payment/booknow');?>",
	  			data :  {
	  						"ap_date"  		: ap_date,
	  						"ap_shift"  	: ap_shift,
	  						"ap_patient_id" : ap_patient_id,
	  						"ap_doctor_id"  : ap_doctor_id,
	  						"ap_time"       : ap_time,
	  						"usewallet"		: usewallet,
	  						"ap_amount_to_be_paid"		: "<?= $doc['user_fee'];?>",
	  			},
	  			beforeSend : function(){jq(".loadingDiv").show();},
	  			success    : function(data){
	  				//console.log(data);
	  				//jq(".loadingDiv").hide();
	  				data =JSON.parse(data);
	  				location.href= data.url;

	  			}
	  		});
  		}
  		else{
  			jq('.pgdiv').slideDown();
  		}
  		
  	}
  	function payusingpaytm(){
  		var ap_date = jq("#datepicker").val();
  		var ap_shift = jq("#shift").val();
  		var ap_time = jq("#ap_time").val();
  		var ap_patient_id = "<?= $_SESSION['user']['id'];?>";
  		var ap_doctor_id = "<?= $doc['id']; ?>";
  		if(jq("#usewallet").is(":checked"))
  		{
  			var usewallet = 1;
  		}
  		else{
  			var usewallet = 0;
  		}
  		jq.ajax({
  			type : 'POST',
  			url  :  "<?= base_url('payment/payusingpaytm');?>",
  			data :  {
  						"ap_date"  		: ap_date,
  						"ap_shift" 		: ap_shift,
  						"ap_patient_id" : ap_patient_id,
  						"ap_doctor_id"  : ap_doctor_id,
  						"ap_time"       : ap_time,
  						"usewallet"		: usewallet,
  						"ap_amount_to_be_paid"		: "<?= $doc['user_fee'];?>",
  			},
  			beforeSend : function(){jq(".loadingDiv").show();},
  			success    : function(data){
  				jq(".loadingDiv").hide();
  				console.log(data);
  				data 	= JSON.parse(data);
  				if(data.status==0){
  					alert("we are facing some technical issues. Please try later");
  				}
  				else if( data.status==1)
  				{
  					location.href= data.url;
  				}
  			}
  		});
  	}
  	function payusingebs(){
  		var ap_date = jq("#datepicker").val();
  		var ap_shift = jq("#shift").val();
  		var ap_time = jq("#ap_time").val();
  		var ap_patient_id = "<?= $_SESSION['user']['id'];?>";
  		var ap_doctor_id = "<?= $doc['id']; ?>";
  		if(jq("#usewallet").is(":checked"))
  		{
  			var usewallet = 1;
  		}
  		else{
  			var usewallet = 0;
  		}
  		jq.ajax({
  			type : 'POST',
  			url  :  "<?= base_url('payment/payusingebs');?>",
  			data :  {
  						"ap_date"  		: ap_date,
  						"ap_shift"  		: ap_shift,
  						"ap_patient_id" : ap_patient_id,
  						"ap_doctor_id"  : ap_doctor_id,
  						"ap_time"       : ap_time,
  						"usewallet"		: usewallet,
  						"ap_amount_to_be_paid"		: "<?= $doc['user_fee'];?>",
  			},
  			beforeSend : function(){jq(".loadingDiv").show();},
  			success    : function(data){
  				jq(".loadingDiv").hide();
  				console.log(data);
  				data 	= JSON.parse(data);
  				if(data.status==0){
  					alert("we are facing some technical issues. Please try later");
  				}
  				else if( data.status==1)
  				{
  					location.href= data.url;
  				}
  			}
  		});
  	}
  </script>
</body>

</html>