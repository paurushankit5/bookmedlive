<?php
	$cities			=	$array['cities'];
	 
	$speciality		=	$array['speciality'];
	 
	$doctors		=	$array['doctors'];
	$clinic		=	$array['clinic'];
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
<div class="text-center">
  
	<?php 
		include('includes/header2.php');
	?>
	
</div>
 
<div class="container-fluid">
				<div class="col-md-10 col-md-offset-1" style="padding:0px;margin-top:-100px;font-size:13px;">
			<div class="row" style="min-height:400px;">
					<h2 class="text text-center">Clinic Details</h2>
					<div class="panel panel-primary">
						<div class="panel-heading"><b><?= $clinic['clinic_name'];?></b></div>
						<div class="panel-body">
							<div class="col-sm-3">
								<center>
									<img class="img img-responsive  img-rounded" style="height:200px;" 
									<?php
										if($clinic['clinic_photo']!='')
										{
										?>
											src="<?= base_url('images/clinic/'.$clinic['clinic_id'].'/photo/'.$clinic['clinic_photo']);?>"
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
							<div class="col-sm-5">
								<br>
								<?php
									if($clinic['clinic_name']!='')
									{
										?>
											<div class="col-sm-4"><b>Clinic Name:</b></div>
											<div class="col-sm-8">
												<?= $clinic['clinic_name'];?><br>
												<b>(<?= $clinic['clinic_city'];?>)</b>
											</div>
											<div class="col-sm-12"><hr></div>
										<?php
									}
								 	?>
										<div class="col-sm-4"><b>Contact Details:</b></div>
										<div class="col-sm-8">
											<?= $clinic['clinic_email'];?><br>
											<?php
												if($clinic['clinic_email1']!='')
												{
													echo $clinic['clinic_email1']."<br>";
												}											
											?>											 
											<?= $clinic['clinic_mobile'];?><br>
												<?php
												if($clinic['clinic_mobile1']!='')
												{
													echo $clinic['clinic_mobile1']."";
												}											
											?>											 
										</div>
										<div class="col-sm-12"><hr></div>
										<div class="col-sm-4"><b>Address:</b></div>
										<div class="col-sm-8">
											<?= ucwords($clinic['clinic_address']);?><br>
											
											<?= ucwords($clinic['clinic_location']);?><br>
											<?= ucwords($clinic['clinic_area']);?>
											
											<?= ucwords($clinic['clinic_landmark']);?><br>
											<?= ucwords($clinic['clinic_city']);?><br>
											<?= ucwords($clinic['clinic_country']);?>  <?= $clinic['clinic_pincode'];?>
											 									
										 											 
										</div>
										 
							</div>
							<div class="col-sm-4">
								<div class="col-sm-6"><b>Available Days:</b></div>
								<div class="col-sm-6 text-left">
									<?php
										$days	=	'';
										if($clinic['clinic_opening_days']!='')
										{
											foreach(explode(",",$clinic['clinic_opening_days']) as $day)
											{
												echo $day."<br>";
											}
										}									
									?>
								</div>
								<div class="col-sm-12"><hr></div>
								<div class="col-sm-6"><b>Morning Shift</b></div>
								<div class="col-sm-6"><?= date('h:i:A',strtotime($clinic['clinic_morning_start_time']));?> to <?= date('h:i:A',strtotime($clinic['clinic_morning_end_time']));?></div>
								<div class="col-sm-12"><hr></div>
								<div class="col-sm-6"><b>Evening Shift</b></div>
								<div class="col-sm-6"><?= date('h:i:A',strtotime($clinic['clinic_evening_start_time']));?> to <?= date('h:i:A',strtotime($clinic['clinic_evening_end_time']));?></div>
								 
								 
							</div>
							<div class="col-sm-12">
								<?php
									if($clinic['clinic_about']!='')
									{
										?>
										<div class="col-sm-9 col-sm-offset-3">
										<div class="col-sm-12"><hr></div>
										<p class='text text-justify'><?= $clinic['clinic_about'];?></p>
										<div class="col-sm-12"><hr></div>
										</div>
										<?php
									}
								?>
								<?php
									if($count=count($doctors))
									{
										?>
											 
											<div class="col-sm-9 col-sm-offset-3">
												<table class="table table-responsive">
													<tr class="hidden-xs">
														<th rowspan="<?= ++$count; ?>">List of Doctors</th>
													</tr>
													<?php 
														foreach($doctors as $x)
														{
															?>
																<tr>
																<td>
																<img class="img img-responsive img-thumbnail img-rounded" style="height:60px;" 
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
																</td> 
																<td><a href="<?= base_url('doctor/details/'.$x['doctor_id']);?>"> <?= $x['doctor_name'];?></a></td> 
																  
																 </tr>
															<?php
														}
													?>
												</table>
											</div>
											
										<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	include('includes/footer.php');
?>
 

 


</body>
</html>
