<?php
	$cities			=	$array['cities'];
	 
	$path			=	$array['path'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
 <title>Bookmediz: Book Appointments With Diagnosis Lab</title>
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
 <div class="container">
	<?php
		/* echo "<pre>";
		print_r($path);
		echo "</pre>"; */
	?>
			<div class="row" style="min-height:400px;">
				<div class="col-md-10 col-md-offset-1" style="padding:0px;">
					<h2 class="text text-center">Diagnosis Details</h2>
					<div class="panel panel-primary">
						<div class="panel-heading"><b><?= $path['path_name'];?></b></div>
						<div class="panel-body">
							<div class="col-md-3">
								<center>
									<img class="img img-responsive img-thumbnail img-rounded" style="height:150px;" 
									<?php
										if($path['path_image']!='')
										{
										?>
											src="<?= base_url('images/path/'.$path['path_id'].'/'.$path['path_image']);?>"
											
										<?php
										}
										else
										{
											?>
											src="<?= base_url('images/path.png');?>"
											<?php
										}
									?>
											/>
									
									
									<br>
									<br>
									<?php
												if(isset($_COOKIE['patient_id']))
												{
												?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" href="<?= base_url('patientdashboard/viewpathtest/'.$path['path_id']);?>" ><b>Make an Appointment</b></a>
									
												<?php
												}
												else
												{
												?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" onClick="openloginmodal('<?= base_url('patientdashboard/viewpathtest/'.$path['path_id']);?>');"  ><b>Make an Appointment</b></a>
									 
												<?php
												}
											?>
								</center>	
								<?php
									/*  echo "<pre>";
									print_r($path);
									echo "</pre>";  */
								?>
							</div>
							<div class="col-md-9">
								<br>
								<?php
									 
									
									if($path['path_city']!='' || $path['path_address']!='')
									{
										?>
											<div class="col-md-4 col-xs-4"><b>Location:</b></div>
											<div class="col-md-8 col-xs-8"><?php
												 
													echo ucfirst($path['path_address']);
													echo ucfirst( $path['path_city']);
												 
												 
											?></div>
											<div class="col-md-12 col-xs-12"><hr></div>
										<?php
										
									}
								?>
								<div class="col-md-4 col-xs-4"><b>Available Days:</b></div>
								<div class="col-md-8 col-xs-8">
									<?php
										$days	=	'';
										if($path['path_mon']==1)
										{
											$days	.=	' Monday ';
										}
										if($path['path_tues']==1)
										{
											$days	.=	' Tuesday ';
										}
										if($path['path_wed']==1)
										{
											$days	.=	' Wednesday  ';
										}
										if($path['path_thurs']==1)
										{
											$days	.=	' Thursday ';
										}
										if($path['path_fri']==1)
										{
											$days	.=	' Friday  ';
										}
										if($path['path_sat']==1)
										{
											$days	.=	' Saturday ';
										}
										if($path['path_sun']==1)
										{
											$days	.=	' Sunday ';
										}
										echo $days;
										
									?>
								</div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<div class="col-md-4 col-xs-4"><b>Morning Shift</b></div>
								<div class="col-md-8 col-xs-8"><?= date('h:i:A',strtotime($path['path_morning_start_time']));?> to <?= date('h:i:A',strtotime($path['path_morning_end_time']));?></div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<div class="col-md-4 col-xs-4"><b>Evening Shift</b></div>
								<div class="col-md-8 col-xs-8"><?= date('h:i:A',strtotime($path['path_evening_start_time']));?> to <?= date('h:i:A',strtotime($path['path_evening_end_time']));?></div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<?php
								//$charge		=	($settings['settings_service_charge']*$path['path_fee'])/100;
								//$gst		=	($settings['settings_gst']*$charge)/100;								 
								//$totalamount	=	$charge+$gst+$path['path_fee']; 
								?>
								 
								<div class="clearfix"></div>
								<br>
								<!--<center>
								 <?php
												if(isset($_COOKIE['patient_id']))
												{
												?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" class="hidden-lg hidden-sm hiden-md"   href="<?= base_url('patientdashboard/viewpathtest/'.$path['path_id']);?>" ><b>Make an Appointment</b></a>
								
												<?php
												}
												else
												{
												?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" class="hidden-lg hidden-sm hiden-md"   href="#" data-toggle="modal" data-target="#loginmodal" ><b>Make an Appointment</b></a>
								
												 
												<?php
												}
											?>
								</center>-->	
							</div>
							<div class="col-md-12">								
								<?php
									if(count($path['test']))
									{
										$i=0;
										?>
										<h4 class="text text-center">Tests we Perform</h4>
										<table class="table table-responsive table-bordered">
											<tr>
											<th>#</th>
											<th>Test </th>
											<th>Price</th>
											</tr>
										<?php
										foreach($path['test'] as $x)
										{
											?>
												<tr>
													<td><?= ++$i;?></td>
													<td><?= $x['test_name'];?></td>
													<td><?= $x['test_price'];?></td>
												</tr>
											<?php
										}
										?>
										</table>
										<?php
									}
								?>
							</div>
							</div>
							<div class="col-md-4">
								
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
