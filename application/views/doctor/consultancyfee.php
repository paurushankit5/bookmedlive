<?php
	$doctor		=	$array['doctor'];
	//$doctor_qualification	=	explode(",",$doctor['doctor_qualification']);
	//echo "<pre>";
	//print_r($doctor_qualification);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Timing & Fee</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
 
  <link rel="stylesheet" href="<?= base_url('assets/');?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

<?php include('includes/header.php');?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Timing & Fee
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      
        <li class="active"> Timing & Fee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Timing & Fee</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('profilemsg'))
				{
					echo $this->session->flashdata('profilemsg');
				}
			  ?>
			<form class="form-horizontal" method="post" action="<?= base_url('doctordashboard/updatefee');?>">
			  <div class="form-group">
				<label class="control-label col-sm-2" for="doctor_fee"> Consultancy Fee:</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" required id="doctor_fee" value="<?= $doctor['doctor_fee'];?>" name="doctor_fee" placeholder="Enter Consultancy Fee">
				  <input type="hidden" class="form-control" required id="doctor_id" value="<?= $doctor['doctor_id'];?>" name="doctor_id" placeholder="Enter Practioner's Name">
				</div>
			  </div>
			  <div class="form-group">
				<label class="control-label col-sm-2" for="doctor_morning_start_time"> Morning Session:</label>
				<div class="col-sm-5">
				  <input type="time" class="form-control"   id="doctor_morning_start_time" value="<?= $doctor['doctor_morning_start_time'];?>" name="doctor_morning_start_time">
				</div>
				<div class="col-sm-5">
					<input type="time" class="form-control"   id="doctor_morning_end_time" value="<?= $doctor['doctor_morning_end_time'];?>" name="doctor_morning_end_time">
 				</div>
			  </div>
			  <div class="form-group">
				<label class="control-label col-sm-2" for="doctor_morning_start_time"> Evening Session:</label>
				<div class="col-sm-5">
				  <input type="time" class="form-control"   id="doctor_evening_start_time" value="<?= $doctor['doctor_evening_start_time'];?>" name="doctor_evening_start_time">
				</div>
				<div class="col-sm-5">
					<input type="time" class="form-control"   id="doctor_evening_end_time" value="<?= $doctor['doctor_evening_end_time'];?>" name="doctor_evening_end_time">
 				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-sm-2" for="doctor_qualification"> Consultation Duration:</label>
				<div class="col-sm-10">
					<select class="form-control"   id="doctor_consultation_time" name="doctor_consultation_time">
						<option value="5" <?php if($doctor['doctor_consultation_time']==5){echo "selected";}?>>5 Minutes</option>
						<option value="10" <?php if($doctor['doctor_consultation_time']==10){echo "selected";}?>>10 Minutes</option>
						<option value="15" <?php if($doctor['doctor_consultation_time']==15){echo "selected";}?>>15 Minutes</option>
						<option value="20" <?php if($doctor['doctor_consultation_time']==20){echo "selected";}?>>20 Minutes</option>
						<option value="25" <?php if($doctor['doctor_consultation_time']==25){echo "selected";}?>>25 Minutes</option>
						<option value="30" <?php if($doctor['doctor_consultation_time']==30){echo "selected";}?>>30 Minutes</option>				
					</select>
				</div>
			  </div>
			 
			  <div class="form-group">
				<label class="control-label col-sm-2" for="doctor_fee"> Available Days:</label>
				<div class="col-sm-10">
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_mon" <?php if($doctor['doctor_mon']=='1'){echo "checked";}?> value="1"> Monday</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_tues" <?php if($doctor['doctor_tues']=='1'){echo "checked";}?> value="1"> Tuesday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_wed" <?php if($doctor['doctor_wed']=='1'){echo "checked";}?> value="1"> Wednesday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_thurs" <?php if($doctor['doctor_thurs']=='1'){echo "checked";}?> value="1" > Thursday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_fri" <?php if($doctor['doctor_fri']=='1'){echo "checked";}?> value="1"> Friday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_sat" <?php if($doctor['doctor_sat']=='1'){echo "checked";}?> value="1"> Saturday</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <label><input type="checkbox" id="doctor_fee"  name="doctor_sun" <?php if($doctor['doctor_sun']=='1'){echo "checked";}?> value="1"> Sunday</label>
 				</div>
			  </div>
			  
			   
			  
			  
			 
			  
			  <div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-default">Submit</button>
				</div>
			  </div>
			</form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
				
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes/footer.php');?>
</body>
</html>
