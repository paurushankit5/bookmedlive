<?php
	$appointments		=	$array['appointments'];
	$count				=	$array['count'];
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Appointment History</title>
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
        Appointment History
        <small></small>
      </h1>
      <ol class="breadcrumb">
       <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li><a href="<?= base_url('doctordashboard/myappointments');?>"><i class="fa fa-dashboard"></i> My Appointments</a></li>
      
       <li class="active"> Appointment History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Appointment History</h3>

          <div class="box-tools pull-right">
			
		  </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('profilemsg'))
				{
					echo $this->session->flashdata('profilemsg');
				}
			  ?>
				<table class="table table-responsive table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Patient Name</th>
							<th>Appointment Id</th>
							<th>Appointment Date</th>
							<th>Time</th>
							<th>Status</th>
							  
							
						</tr>
					</thead>
					<tbody>
						<?php
							if(count($appointments))
							{
								$i=$count;
							 
								foreach($appointments as $x)
								{
									?>
									<tr>
										<td><?= ++$i;?></td>
										<td><?= $x['patient_name'];?></td>
										<td><?= $x['appointment_id'];?></td>
										<td><?= date('d-M-Y',strtotime($x['appointment_date']));?></td>
										<td><?= $x['appointment_time'];?></td>
										 
										<td><?= $x['appointment_status'];?></td>
									 
										 
									</tr>
									<tr><td colspan="6"></td></tr>
									
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="6"><div class="alert alert-warning"><b>No appointments found.</b></div></td>
								</tr>
								<?php
							}
						?>
						<tr>
							<td colspan="7"><?= $this->pagination->create_links();?></td>
						</tr>
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
  <script type="text/javascript">
	function confirmcancel(str)
	{
		$('#del_id').val(str);
		 
		$('#modalbtn').click();
	}
	function cancelappointment()
	{
		var appointment_id	=	$('#del_id').val();
		var appointment_money	=	$('#appointment_money').val();
		$.ajax({
			type	:	'POST',
			url		:	'<?= base_url('doctordashboard/cancelappointment');?>',
			data	:	'appointment_id='+appointment_id,
			success	:	function (data)
			{
				location.reload();
			}
		});
	}
  </script>
</body>
</html>
 <button type="button" class="btn btn-info btn-lg" style="display:none;"  data-toggle="modal" data-target="#myModal"  id="modalbtn" >Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are you sure?</h4>
        </div>
        <div class="modal-body">
			<p><b>Do you really want to cancel appointment?</b></p>
          <p><input type="hidden" id="del_id"/></p>
         
        </div>
        <div class="modal-footer">
          <button type="button" onClick="cancelappointment();" class="btn btn-danger" >Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>
  