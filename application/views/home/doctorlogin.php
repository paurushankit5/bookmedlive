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
 
<div class="clearfix"></div>
<div class="container">
	
<div class="col-sm-6 col-sm-offset-3" style="background-color:white;margin-top:100px;box-shadow:0px 0px 5px 5px gray;"  >
  <h2 class="text text-center text-primary" ><b>Doctor Login </b>	</h2>
  <?php
	if($this->session->flashdata('loginmsg'))
	{
		echo $this->session->flashdata('loginmsg');
	}
  ?>
  <form class="form-horizontal" method="post" action="<?=base_url('doctorlogin/verifylogin');?>">
    <div class="form-group">
      <label class="control-label col-sm-2" for="doctor_email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="doctor_email" name="doctor_email" placeholder="Enter email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="doctor_password">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="doctor_password" name="doctor_password" placeholder="Enter password">
      </div>
    </div>
  
 
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button><br>
		<a href="<?= base_url('doctorregistration');?>">New User?</a><br>
		<a href="#" data-toggle="modal" data-target="#myModal">Forgot Password</a>

      </div>
    </div>
  </form>
</div>

<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Forgot Password</h4>
			  </div>
			  <div class="modal-body" id="modalbody">
				 <div id="forgotdiv"></div>
				 <div class="col-sm-12">
				
					<form>
					  <div class="form-group">
						<label for="email">Email-Id:</label>
						<input type="text" id="forgotemail" style="width:100%;" placeholder="Provide Your Email-Id" class="form-control"/>
					
					  </div>
					   
					</form>
				</div>
				<div class="clearfix"></div>
			  </div>
			  <div class="modal-footer">
				
				<button type="button" onClick="forgotpassword();"class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		<script>
	function forgotpassword()
	{
		var clinic_email	=	$('#forgotemail').val();
		if(clinic_email	=='')
		{
			alert('Please enter your email id first');			
		}
		else
		{
			//alert(clinic_email);
			$.ajax({
					type		:	'POST',
					url			:	'<?= base_url('doctorlogin/forgotpassword');?>',
					data		:	'doctor_email='+clinic_email,
					beforeSend	:	function(data){
										$('#modalbody').html('<center><h3><i class="fa fa-spinner fa-4x fa-spin" style="font-size:24px"></i> Please Wait.<h3></center>');										
									},
					success		:	function(data){
										$('#modalbody').html(data);										
									},				
				});
		}
	}
</script>
</div>
<div class="clearfix"></div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
	include('includes/footer.php');
?>
 

 


</body>
</html>
	