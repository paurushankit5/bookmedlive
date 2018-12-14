<?php
	$cities		=	$array['cities'];
	$speciality	=	$array['speciality'];
?>
<h3>Book Your Doctor's Appointment</h3>
<div class="container">
<div class="search col-md-10 col-md-offset-1" style="border: 1px solid gray;padding: 32px;margin-top: 50px;box-shadow: 0px 0px 5px 5px #CCC;">
	<h3><b>Book Your Doctor's Appointment</b></h3>
	<ul class="nav nav-tabs">
		<li class="active" style="padding:0px;"><a data-toggle="tab" href="#menua" style="padding:10px 3px;">Speciality</a></li>
		<li style="padding:0px;" ><a data-toggle="tab" href="#menub" style="padding:10px 3px;">Doctor</a></li>
		<li style="padding:0px;"><a data-toggle="tab" href="#menu2" style="padding:10px 3px;">Clinic</a></li>
		<li style="padding:0px;"><a data-toggle="tab" href="#menu3" style="padding:10px 3px;">Diagnosis</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="menua" class="tab-pane fade in active">
			<br>
			 <form action="<?= base_url('search/findspeciality');?>" method="get" >
				<div class="col-md-5 col-sm-6" style="">
				<select class="form-control" required  name="doctor_city" id="location1">
					<option value="">Location in Rourkela</option>
					<?php
						if(count($cities))
						{
							foreach($cities as $x)
							{
								?>
								<option value="<?= $x['city_name'];?>"><?= $x['city_name'];?></option>
								<?php
							}
						}
					?>
				</select>
				<br>
				</div>
				<div class="col-md-5 col-sm-6" >
					<select class="form-control" required name="qualification_specialization" id="spcl">
						<option value="">Select Speciality</option>
						<?php 
							if(count($speciality))
							{
								foreach($speciality as $x)
								{
									?>
									<option value="<?= $x['speciality_name'];?>"><?= $x['speciality_name'];?></option>
									<?php
								}
							}
						?>
					</select>
					<br>
				</div>
				<div class="col-md-2 col-sm-12"><input class="btn btn-default btn-block" type="Submit"  value="Search">
				</div>
			</form>
		</div>
		
		<div id="menub" class="tab-pane fade ">							
			<br>
			<form method="get" action="<?= base_url('search/finddoctors');?>">
			<div class="col-md-5 col-sm-6"  >
				
				<select class="form-control"  name="doctor_city" id="location1">
					<option value="">Location in Rourkela</option>
					<?php
						if(count($cities))
						{
							foreach($cities as $x)
							{
								?>
								<option value="<?= $x['city_name'];?>"><?= $x['city_name'];?></option>
								<?php
							}
						}
					?>
				</select>
				<br>
			</div>
			<div class="col-md-5 col-sm-6">
				<input list="doctorname" placeholder="Enter Doctor Name" name="doctor_name" onkeyup="showdoctorsuggestion(this.value);" class="form-control" style="border-radius:0px;" autocomplete="off">
				  <datalist id="doctorname">
						
					 
				  </datalist>
				  <br>
			</div>
			<div class="col-md-2 col-sm-12 ">
				<input class="pd btn btn-default btn-block" type="Submit"  value="Search">
			</div>	
			</form>
		</div>
		
		<div id="menu2" class="tab-pane fade">
		
			  <br>
			<form method="get" action="<?= base_url('search/findclinic');?>">
			<div class="col-md-5 col-sm-6" >
				
				<select class="form-control"  name="clinic_city" id="location1">
					<option value="">Location in Rourkela</option>
					<?php
						if(count($cities))
						{
							foreach($cities as $x)
							{
								?>
								<option value="<?= $x['city_name'];?>"><?= $x['city_name'];?></option>
								<?php
							}
						}
					?>
				</select>
				<br>
			</div>
			<div class="col-md-5 col-sm-6 ">
				<input list="clinicname" placeholder="Enter Cinic Name" name="clinic_name" onkeyup="showclinicsuggestion(this.value);" class="form-control" style="border-radius:0px;" autocomplete="off">
				  <datalist id="clinicname">
						
					 
				  </datalist>
				  <br>
			</div>
			<div class="col-md-2 col-sm-12">
				<input class="pd btn btn-default btn-block" type="Submit"  value="Search">
			</div>	
			</form>
		</div>
		<div id="menu3" class="tab-pane fade">
			 <br>
			<form method="get" action="<?= base_url('search/finddiagnosis');?>">
			<div class="col-md-5 col-sm-6" >
				
				<select class="form-control"  name="path_city" id="path_city">
					<option value="">Location in Rourkela</option>
					<?php
						if(count($cities))
						{
							foreach($cities as $x)
							{
								?>
								<option value="<?= $x['city_name'];?>"><?= $x['city_name'];?></option>
								<?php
							}
						}
					?>
				</select>
				<br>
			</div>
			<div class="col-md-5 col-sm-6">
				<input list="path_name" placeholder="Enter Diagnosis Name" name="path_name" onkeyup="showpathsuggestion(this.value);" class="form-control" style="border-radius:0px;" autocomplete="off">
				  <datalist id="path_name">
						
					 
				  </datalist>
				  <br>
			</div>
			<div class="col-md-2 col-sm-12">
				<input class="pd btn btn-default btn-block" type="Submit"  value="Search">
			</div>	
			</form>
		</div>
					
	</div>
	<div id="msg"></div>
	<div class="clearfix"></div>
</div>

</div>
<br>
<br>
 
<script>
	function showdoctorsuggestion(str)
	{
		$.ajax({
			type	:	'POST',
			url		:	'<?= base_url('search/showdoctorsuggestion');?>',
			data	:	'doctor_name='+str,
			success	:	function(data){
							$('#doctorname').html(data);
						},
		});					
	}
	function showpathsuggestion(str)
	{
		$.ajax({
			type	:	'POST',
			url		:	'<?= base_url('search/showpathsuggestion');?>',
			data	:	'path_name='+str,
			success	:	function(data){
							$('#path_name').html(data);
						},
		});					
	}
	
	function showclinicsuggestion(str)
	{
		$.ajax({
			type	:	'POST',
			url		:	'<?= base_url('search/showclinicsuggestion');?>',
			data	:	'clinic_name='+str,
			success	:	function(data){
							$('#clinicname').html(data);
						},
		});
	}
</script>

		<!-- Trigger the modal with a button -->
<button type="button" id="loginmodalbtn" style="display:none;" data-toggle="modal" data-target="#loginmodal">Open Modal</button>

<!-- Modal -->
<div id="loginmodal" class="modal fade" role="dialog" style="margin-top:50px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
			<form class="form-horizontal">
			<div id="loginmsg"></div>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="patient_email" style="color:black;">Email:</label>
			  <div class="col-sm-10">
				<input type="email" class="form-control" id="patient_email" name="patient_email" placeholder="Enter email">
			  </div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="patient_password" style="color:black;">Password:</label>
			  <div class="col-sm-10">          
				<input type="password" class="form-control" id="patient_password" name="patient_password" placeholder="Enter password">
			  </div>
			</div>
		    </form>
			 
		  
      </div>
      <div class="modal-footer">
		<input type="hidden" id="requiredurl"/>
		<a href="#" onClick="gotoregister();" class="pull-left">New User?</a>
		<button type="button" class="btn btn-primary" style="background-color:#337ab7;"onClick="login();">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>

  </div>
</div>
<script>
	function gotoregister(){
		var url	=	$('#requiredurl').val();
		$.ajax({
			type		:	'POST',
				url			:	'<?= base_url('demo/seturl');?>',
				data		:	'url='+url,
				 
				success		:	function(data)
				{
					 location.href='<?= base_url('patientregistration');?>';
				},
		});
	}
	function openloginmodal(str){
		if(str!='')
		{
			$('#requiredurl').val(str);
		}
		
		$('#loginmodalbtn').click();
	}
	function login()
	{
		var	patient_email		=	$('#patient_email').val();
		var	patient_password	=	$('#patient_password').val();
		if(patient_email=='')
		{
			$('#loginmsg').html('<div class="alert alert-danger" style="background:red;color:white;">Please provide your email.</div>');
			$('#loginmsg').delay(3000).fadeOut();
		}
		else if(patient_password=='')
		{
			$('#loginmsg').html('<div class="alert alert-danger" style="background:red;color:white;">Please provide your password.</div>');
			$('#loginmsg').delay(3000).fadeOut();
		}
		else
		{
			$.ajax({
				type		:	'POST',
				url			:	'<?= base_url('patientlogin/checklogin');?>',
				data		:	'patient_email='+patient_email+'&patient_password='+patient_password,
				beforeSend	:	function()
								{
									$('#loginmsg').html('<div class="alert alert-danger" style="background:;color:white;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Loading.</div>');
									$('#loginmsg').delay(30000).fadeOut();
								},
				success		:	function(data)
				{
					if(data=='1')
					{
						$('#loginmsg').html('<div class="alert alert-danger" style="background:green;color:white;">Logged in!..</div>');
						$('#loginmsg').delay(3000).fadeOut();
						var url = $('#requiredurl').val();
						if(url!='')
						{
							window.location.href=url;
						}
						else{
							location.reload();
						}
					}
					else
					{
						$('#loginmsg').html('<div class="alert alert-danger" style="background:red;color:white;">Invalid Email or Password</div>');
						$('#loginmsg').delay(3000).fadeOut();
					}
				},
			});
		}
			
	}
</script>