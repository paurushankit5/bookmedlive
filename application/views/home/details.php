<?php
	$cities			=	$array['cities'];
	$settings		=	$array['settings'];
	$education		=	$array['education'];
	$speciality		=	$array['speciality'];
	$settings		=	$array['settings'];
	$doctor			=	$array['doctor'];
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
 <div class="container">
			<div class="row" style="min-height:400px;">
				<div class="col-md-10 col-md-offset-1" style="padding:0px;">
					<h2 class="text text-center">Doctor Details</h2>
					<div class="panel panel-primary">
						<div class="panel-heading"><b><?= $doctor['doctor_name'];?></b></div>
						<div class="panel-body">
							<div class="col-md-3">
								<center>
									<img class="img img-responsive img-thumbnail img-rounded" style="height:200px;" 
									<?php
										if($doctor['doctor_pic']!='')
										{
										?>
											src="<?= base_url('images/doc/'.$doctor['doctor_id'].'/'.$doctor['doctor_pic']);?>"
											
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
									
									<br>
									<br>
									<?php
										if(isset($_COOKIE['patient_id']))
										{
											?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" href="<?= base_url('patientdashboard/makeanappointment/'.$doctor['doctor_id']);?>" ><b>Make an Appointment</b></a>
												<br>
												<br>
												<a href="#" style="background-color:#337ab7;color:white;padding:10px 32px;width:100px;" onClick="askaquestion('<?= $doctor['doctor_id'];?>');" style="background-color:#337ab7;"><b>Ask A Question</b></a>
								
											<?php
										}
										else{
											?>
											<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" href="#" onClick="gotologin('<?= base_url('patientdashboard/makeanappointment/'.$doctor['doctor_id']);?>');" ><b>Make an Appointment</b></a>
											<br>
											<br>

												<a href="#" style="background-color:#337ab7;color:white;padding:10px 32px;width:100px;" onclick="openloginmodal();"style = " background-color:#337ab7; "><b>Ask A Question</b></a>
								
											<?php
										}
									?>
									</center>	
								<?php
									/*  echo "<pre>";
									print_r($doctor);
									echo "</pre>";  */
								?>
							</div>
							<div class="col-md-5">
								<br>
								<?php
									
									if($doctor['clinic_name']!='')
									{
										?>
											<div class="col-md-4 col-xs-4"><b>Clinic Name:</b></div>
											<div class="col-md-8 col-xs-8">
												<a href="<?= base_url('clinic/details/'.$doctor['clinic_id']);?>" target="_blank"><?= $doctor['clinic_name'];?></a><br>
												<?= $doctor['clinic_city'];?>
											</div>
											<div class="col-sm-12 col-xs-12"><hr></div>
										<?php
									}
								 	if(count($education))
									{
										?>
											<div class="col-md-4 col-xs-4"><b>Speciality:</b></div>
											<div class="col-md-8 col-xs-8">
												<?php
													/* echo "<pre>";
													print_r($education);
													echo "</pre>"; */
													foreach($education as $x)
													{
														echo $x['qualification_specialization']." (".$x['qualification_name'].")<br>";
													}
												?>
											</div>
											<div class="col-md-12 col-xs-12"><hr></div>
										<?php
									}
									
									if($doctor['doctor_city']!='')
									{
										?>
											<div class="col-md-4 col-xs-4"><b>Location:</b></div>
											<div class="col-md-8 col-xs-8"><?php
												if($doctor['doctor_clinic_id']==0){
													echo ucfirst($doctor['doctor_address'])." ";
													echo ucfirst( $doctor['doctor_city']);
												}
												else{
													echo ucfirst($doctor['clinic_address']);
													echo ucfirst($doctor['clinic_location']);
													echo ucfirst($doctor['clinic_area']);
													echo ucfirst($doctor['clinic_landmark']);
													echo ucfirst($doctor['clinic_city']);
												}
											?></div>
											<div class="col-md-12 col-xs-12"><hr></div>
										<?php
										
									}
									if($doctor['doctor_experience']!='')
									{
										?>
											<div class="col-md-4 col-xs-6"><b>Experience:</b></div>
											<div class="col-md-8 col-xs-6"><?= $doctor['doctor_experience'];?></div>
											<div class="col-md-12 col-xs-12"><hr></div>
										<?php										 
									}
									if($doctor['doctor_aboutme']!='')
									{
										?>
											<div class="col-md-4 col-xs-12"><b>About Me:</b></div>
											<div class="col-md-8 col-xs-12"><p class="text text-justify"><?= $doctor['doctor_aboutme'];?></p></div>
											<div class="col-md-12 col-xs-12"><hr></div>
										<?php										 
									}
									
									
										//echo "<pre>";
										//print_r($doctor);
										//echo "</pre>";
								?>
							</div>
							<div class="col-md-4">
								<div class="col-md-6 col-xs-6"><b>Available Days:</b></div>
								<div class="col-md-6 col-xs-6">
									<?php
										$days	=	'';
										if($doctor['doctor_mon']==1)
										{
											$days	.=	' Monday <br>';
										}
										if($doctor['doctor_tues']==1)
										{
											$days	.=	' Tuesday <br>';
										}
										if($doctor['doctor_wed']==1)
										{
											$days	.=	' Wednesday <br>';
										}
										if($doctor['doctor_thurs']==1)
										{
											$days	.=	' Thursday <br>';
										}
										if($doctor['doctor_fri']==1)
										{
											$days	.=	' Friday <br>';
										}
										if($doctor['doctor_sat']==1)
										{
											$days	.=	' Saturday <br>';
										}
										if($doctor['doctor_sun']==1)
										{
											$days	.=	' Sunday ';
										}
										echo $days;
										
									?>
								</div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<div class="col-sm-6"><b>Morning Shift</b></div>
								<div class="col-sm-6"><?= date('h:i:A',strtotime($doctor['doctor_morning_start_time']));?> to <?= date('h:i:A',strtotime($doctor['doctor_morning_end_time']));?></div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<div class="col-sm-6"><b>Evening Shift</b></div>
								<div class="col-sm-6"><?= date('h:i:A',strtotime($doctor['doctor_evening_start_time']));?> to <?= date('h:i:A',strtotime($doctor['doctor_evening_end_time']));?></div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<?php
								//$charge		=	($settings['settings_service_charge']*$doctor['doctor_fee'])/100;
								//$gst		=	($settings['settings_gst']*$charge)/100;								 
								//$totalamount	=	$charge+$gst+$doctor['doctor_fee']; 
								?>
								<div class="col-sm-6"><b>Consultancy Fee:</b></div>
								<div class="col-sm-6">
									<b>&#x20B9; <?= $doctor['doctor_fee']; ?></b>
								</div>
								<div class="col-md-12 col-xs-12"><hr></div>
								<div class="clearfix"></div>
								<br>
								<center>
								<?php
										if(isset($_COOKIE['patient_id']))
										{
											?>
												<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" class="hidden-lg hidden-sm hiden-md"   href="<?= base_url('patientdashboard/makeanappointment/'.$doctor['doctor_id']);?>" ><b>Make an Appointment</b></a>
								
											<?php
										}
										else{
											?>
											<a style="background-color:#337ab7;color:white;padding:10px;width:100px;" class="hidden-lg hidden-sm hiden-md" href="#" onClick="gotologin('<?= base_url('patientdashboard/makeanappointment/'.$doctor['doctor_id']);?>');" ><b>Make an Appointment</b></a>
								 
											<?php
										}
									?>
								</center>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	include('includes/footer.php');
?>
 <script type="text/javascript">
 	function askaquestion(id){
			$('#question_doctor_id').val(id);
			$('#questionmodal').modal('toggle');
		}
		function storequestion(){
			var question_doctor_id	=	$('#question_doctor_id').val();
			var question_name	=	$('#question_name').val();
			if(question_name=='')
			{
				$('#questionmsg').show().html('<div class="alert alert-danger">Enter Your Question please.</div>');
				setTimeout(function(){ $('#questionmsg').hide(); }, 2000);
			}
			else{
				$.ajax({
					type 	:  'POST',
					url 	: 	'<?= base_url('patientdashboard/storequestions');?>',
					data    : 	{
									"question_name" 		: question_name,
									"question_doctor_id" 	: question_doctor_id,
								},
					success :  	function(data){
									data = data.trim();
									$('#questionmsg').show().html('<div class="">'+data+'</div>');
									setTimeout(function(){ $('#questionmsg').hide(); $('#question_name').val(''); $('#question_doctor_id').val(''); $('#questionmodal').modal('toggle')  }, 2000);
					}
				});
			}
		}
     
 </script>
<div id="questionmodal" class="modal fade" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ask A Question</h4>
      </div>
      <div class="modal-body">
      	<span id="questionmsg"></span>
        <input type="hidden" id="question_doctor_id"/>
        <div class="form-group">
        	<label>Question</label>
        	<textarea class="form-control" id="question_name" placeholder="Enter Your Question"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="storequestion();"  >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> 


</body>
</html>
