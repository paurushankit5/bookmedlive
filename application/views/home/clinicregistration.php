<?php
	$cities	=	$array['cities'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bookmediz: clinic Registeration</title>
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
	<style>
		.form-control , .btn{
			border-radius:0px;
		}
	</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<?php
	include('includes/header.php');
?>
 
<div class="clearfix"></div>

<div class="col-sm-8 col-sm-offset-2" style="margin-top:50px;padding:0px 50px; background-color:white;margin-top:100px;box-shadow:0px 0px 5px 5px gray;"  >
  <h2 class="text text-center text-primary" ><b>Clinic Registration </b>	</h2>
  <?php
	if($this->session->flashdata('regmsg'))
	{
		echo $this->session->flashdata('regmsg');
	}
  ?>
  <form class="form-horizontal" method="post" action="<?=base_url('clinicregistration/storeclinic');?>">
    <div class="form-group">
      <label class="control-label col-sm-3" for="clinic_name">Clinic Name:</label>
      <div class="col-sm-9">
        <input type="text" required class="form-control" id="clinic_name" name="clinic_name" placeholder="Enter Clinic Name">
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-3" for="clinic_email">Email:</label>
      <div class="col-sm-9">
        <input type="email" required class="form-control" id="clinic_email" name="clinic_email" placeholder="Enter email">
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-3" for="clinic_mobile">Mobile:</label>
      <div class="col-sm-9">
        <input type="text" maxlength="10" required class="form-control" id="clinic_mobile" name="clinic_mobile" placeholder="Enter Clinic Mobile Number">
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-3" for="clinic_city">City:</label>
      <div class="col-sm-9">
        <select required class="form-control" id="clinic_city" name="clinic_city">
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
      </div>
    </div>
	
    <div class="form-group">
      <label class="control-label col-sm-3" for="clinic_password">Password:</label>
      <div class="col-sm-9">          
        <input type="password" required class="form-control" id="clinic_password" name="clinic_password" placeholder="Enter password">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-3" for="clinic_password2">Confirm Password:</label>
      <div class="col-sm-9">          
        <input type="password" required class="form-control" id="clinic_password2" name="clinic_password2" placeholder="Confirm password">
      </div>
    </div>
	
   <!--<div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-9">
      <div class="checkbox">
        <label><input type="checkbox" name="remember_me" value='1'> Remember me</label>
      </div>
    </div>
  </div>-->
 
    <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-9">
        <button type="submit" class="btn btn-primary">Submit</button><br>
		<a href="<?= base_url('cliniclogin');?>">Already a User?</a>
      </div>
    </div>
  </form>
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
	
