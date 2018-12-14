<?php
	$cities					=	$array['cities'];
	$speciality				=	$array['speciality'];	
	$doctors				=	$array['doctors'];
	//$searched_city			=	$array['searched_city'];
	$searched_speciality	=	$array['searched_speciality'];
	$limit					=	$array['limit'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bookmediz: Book Appointments With Doctor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-180x180.png">
	
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<?php
	include('includes/header.php');
?>
<div class=" text-center">
  
	<?php 
		include('includes/header2.php');
	?>
	
</div>
 
 <div class="container-fluid" style="margin-top:-100px;">
			<div class="row" style="min-height:400px;">
				 
				 <p class="text-center text-primary" style='font-family: "Lucida Bright",Georgia,serif;font-size:36px;'><b><?= $searched_speciality; ?></b></p>
				 
				<div class="col-sm-10 col-sm-offset-1" >
				<div class="row" id="mainarea">
					
					<?php
						if(count($doctors))
						{
							
							$i=	0;
							foreach($doctors as $x)
							{
								$days	=	'';
								if($x['doctor_mon']==1)
								{
									$days	.=	' Mon ';
								}
								if($x['doctor_tues']==1)
								{
									$days	.=	' Tue ';
								}
								if($x['doctor_wed']==1)
								{
									$days	.=	' Wed ';
								}
								if($x['doctor_thurs']==1)
								{
									$days	.=	' Thur ';
								}
								if($x['doctor_fri']==1)
								{
									$days	.=	' Fri ';
								}
								if($x['doctor_sat']==1)
								{
									$days	.=	' Sat ';
								}
								if($x['doctor_sun']==1)
								{
									$days	.=	' Sun ';
								}
							?>
							<div class="col-sm-12" >
								<div class="panel panel-success" style="border-radius:0px;">
									<div class="panel-heading">
										<b><?= $x['doctor_name'];?></b> 
										<?php
											if($x['doctor_clinic_id']!=0)
											{
												echo " (".$x['clinic_name'].")";
											}
										?>
									</div>
									<div class="panel-body" style="font-size:14px;">
										<div class="col-sm-2" style="verical-align:center;">
											<center>
											<img class="img img-responsive img-thumbnail img-rounded" style="height:100px;" 
											<?php
												if($x['doctor_pic']!='')
												{
												?>
													src="<?= base_url('images/doc/'.$x['doctor_id'].'/'.$x['doctor_pic']);?>"
													
												<?php
												}
												else
												{
													?>
													src="<?= base_url('images/doc/User.png');?>"
													<?php
												}
											?>
											/>
											</center>
										</div>
										<div class="col-sm-6">
											<?php
												if($x['qualification']!='')
												{
													?>
														<hr>
														<?= $x['qualification'];	?>
													<?php
												}
												if($x['specialization']!='')
												{
													?>
														<hr>
														<?= $x['specialization'];	?>
													<?php
												}
												if($x['doctor_city']!=''|| $x['clinic_city']!='')
												{
													?>
														<hr>
														<?php
															if($x['doctor_clinic_id']!='0')
															{
																echo $x['clinic_city'];
															}
															else{
																echo $x['doctor_city'];
															}
														

														?>
													<?php
												}
												if($days!='')
												{
													?>
														<hr>
														<i class="fa fa-money"></i> &#8377; <?= $x['doctor_fee'];?>
													<?php
												}
												
											?>
											
											 
											
											
										 
											
											
										</div>
										<div class="col-sm-3" style="font-size:12px;">
											<?php
												if($x['doctor_experience']!='')
												{
													?>
													<p><i class="fa fa-medkit"></i> <?= $x['doctor_experience'];?> Years Experirence</p>
													<?php
												}
												if(trim($days)!='')
												{
													?>
													<p><i class="fa fa-clock-o"></i> Available Days <i class="fa fa-caret-down"></i></p>
													<p> <?= $days; ?> </p>
													<?php
												}
											?>
											<p> <?= date('h:i:a',strtotime($x['doctor_morning_start_time']));?> - <?= date('h:i:a',strtotime($x['doctor_morning_end_time']));?> </p>
											<p> <?= date('h:i:a',strtotime($x['doctor_evening_start_time']));?> - <?= date('h:i:a',strtotime($x['doctor_evening_end_time']));?> </p>
											 
										</div>
									</div>
									<div class="panel-footer" style="padding:0px;">
										<div class="row">
										<div class="col-sm-6" style="margin:0px;">
											<a href="<?= base_url('doctor/details/'.$x['doctor_id']);?>" target="_blank"class="btn btn-primary btn-block" style="background-color:#337ab7;">View Details</a>
										</div>
										<div class="col-sm-6" style="margin:0px;">
											<?php
												if(isset($_COOKIE['patient_id']))
												{
												?>
												<a target="_blank" href="<?= base_url('patientdashboard/makeanappointment/'.$x['doctor_id']);?>" class="btn btn-success btn-block" 
												style="">Fix an Appointmentintment</a>
												<?php
												}
												else
												{
												?>
												<button class="btn btn-success btn-block" onClick="openloginmodal('<?= base_url('patientdashboard/makeanappointment/'.$x['doctor_id']);?>');" style="">Fix an Appointment</button>
												
												<?php
												}
											?>
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									</div>
										 
										
							</div>
							<?php	
								 
							 
							}
						}
						else
						{
							?>
								<img src="<?= base_url('images/noresult.png');?>" style="width:100%;max-height:300px;" class="img img-responsive" alt="No Results Found"/>
							<?php
						}
					?>
				</div>
				<?php
					if(count($doctors)>=$limit)
					{
						?>
						<button class="btn btn-primary btn-block" id="loadmore" onClick="loadmore();">Load More	</button>
				
						<?php
					}
				?>
				<button class="btn btn-primary btn-block" style="display:none;" id="loadmorefilter" onClick="loadmorefilter();">Load More</button>
				</div>
				
			</div>
		</div>
		
		
		
		
		
		
		
		 <script>
		var count=	0;
		var offset=	0;
		var city	=	'<?= $searched_city; ?>';
			var speciality	=	'<?= $searched_speciality; ?>';
		 
		 
		function loadmore(){
			count++;
			
			limit	=	'<?= $limit; ?>';
			offset	=	((limit*10)+(offset*10))/10;
			$.ajax({
				type	:	'POST',
				data	:	{
								'city'			:	city,
								'speciality'	:	speciality,
								'offset'		:	offset,
								'limit'			:	limit,
				},
				url		:	'<?= base_url('search/ajax_find_doctor_by_popularity');?>',
				success	:	function(data){
							data	=	data.trim();
							if(data=='0')
							{
								alert('No more results');
								$('#loadmore').hide();
							}
							else{
								$('#mainarea').append(data);
							}
				}
			});
			 
			
		}
    </script>
	
 

<?php 
	include('includes/footer.php');
?>
 

 


</body>
</html>

