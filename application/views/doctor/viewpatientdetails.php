<?php
	$patient		=	$array['patient'];
	$prescription	=	$array['prescription'];
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Patient Details</title>
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
        Patient Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active"> My Patients</li>
        <li class="active"> Patient Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Patient Details</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('patientmsg'))
				{
					echo $this->session->flashdata('patientmsg');
				}
			  ?>
				<table class="table table-responsive table-bordered">
					<thead>
						<tr>							 
							<td colspan="2">
							<button class="btn btn-primary pull-right" style="margin:5px;" data-toggle="modal" data-target="#myModal">Add Prescription</button>
							<a href="<?= base_url('doctordashboard/viewdiagnosisreport/'.$patient['patient_id']);?>" style="margin:5px;" class="btn btn-success pull-right">View Diagnosis Report</button>
							</td>
						</tr>							 
						<tr>							 
							<td>Patient's Name</td>
							<th><?= $patient['patient_name'];?></th>
						</tr>
						<tr>							 
							<td>Gender</td>
							<th><?= $patient['patient_gender'];?> </th>
						</tr>
						<tr>							 
							<td>Age</td>
							<th><?= $patient['patient_age'];?> Yr</th>
						</tr>
						
						<tr>							 
							<td> Email</td>
							<th><?= $patient['patient_email'];?></th>
						</tr>
						<tr>							 
							<td> Mobile</td>
							<th><?= $patient['patient_mobile'];?></th>
						</tr>
						<?php
							if(count($prescription))
							{
								foreach($prescription as $x)
								{
									?>
										<tr>
											<td>Prescribed on</td>
											<th><?= date("H:i:A, d-M-Y ",strtotime($x['prescription_add_time']));?></th>
										</tr>
										<tr>
											<td colspan="2"><img style="width:100%	" src="<?= base_url('images/pres/'.$x['prescription_id'].'/'.$x['prescription_image']);?>" class="img img-responsive img-thumbnail"/></td>
										</tr>
									<?php
								}
							}
						?>
						
						
					</thead>
					<tbody>
						 
					</tbody>
				</table>
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
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Prescription</h4>
        </div>
        <div class="modal-body">
			 <form method="post" action="<?= base_url('doctordashboard/storeprescription');?>" enctype="multipart/form-data">
				<input type="file" name="prescription_image" class="form-control"/>
				<input type="hidden" name="prescription_doctor_id" value="<?= $_COOKIE['doctor_id'];?>" class="form-control"/>
				<input type="hidden" name="prescription_patient_id" value="<?= $patient['patient_id'];?>" class="form-control"/>
				 
			 
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger" >Submit</button>
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  </form>
        </div>
      </div>
      
    </div>
  </div>