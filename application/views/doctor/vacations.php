<!DOCTYPE html>
<?php
	$vacations	=	$array['vacations'];
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Leave</title>
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
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> 
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <!-- Javascript -->
  <script>
		var $j = $.noConflict();
		$j(function() {
			$j( "#datepicker" ).datepicker({
				minDate: 0, maxDate: "+3M",
				dateFormat: 'yy-mm-dd',
				 
			});
			$j( "#datepicker2" ).datepicker({
				minDate: 0, maxDate: "+3M",
				dateFormat: 'yy-mm-dd',
				 
			});		
         });
  </script>
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
		Leave
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Leave</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Leave</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('vacmsg'))
				{
					echo $this->session->flashdata('vacmsg');
				}				 
			  ?>
			  
		 	<form class="form-horizontal" method="post" action="<?= base_url('doctordashboard/storevacations');?>">
			   <div class="form-group" id="section1">
				  <label class="control-label col-sm-2" for="patient_name">Select Date:<br> (YYYY-MM-DD)</label>
				  <div class="col-sm-5">
					<input type = "text" id = "datepicker" name="start_date" class="form-control" placeholder="Start Date (YYYY-MM-DD)">
				  </div>
				  <div class="col-sm-5">
					<input type = "text" id = "datepicker2" name="end_date" class="form-control" placeholder="End Date (YYYY-MM-DD)">
				  </div>
				  
				</div>
				
				 
				<br>
				 <button type="submit" class="btn btn-primary pull-right">Submit</button>
			</form> 
				 
				
		</div>
				
	
	
	
			  
			  
			  
			 
			  
			 
			<!--</form>-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
				<?php
					if(count($vacations))
					{
						?>
							<div class="row">
							<div class="col-sm-2"><h4><b>My Vacations</b><h4></div>
							<div class="col-sm-10">
						<?php
						foreach($vacations as $x)
						{
							?>
								<div class="col-sm-2"><?= date('d-M-y',strtotime($x['vacation_date']));?></div>
							<?php
						}
						 ?>
						 </div>
						 </div>
						 <?php
					}
				?>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
	  include('includes/footer.php');
	?>
 
</body>
</html>
