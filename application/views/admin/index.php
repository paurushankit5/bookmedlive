<?php
 
	$activeindidoc		= 	 $array['activeindidoc'];
	$pendingindidoc 	= 	 $array['pendingindidoc'];
	$activeclinic 		= 	 $array['activeclinic'];
	$pendingclinic 		= 	 $array['pendingclinic'];
	$activehospital 	= 	 $array['activehospital'];
	$pendinghospital 	= 	 $array['pendinghospital'];
	$activediagnosis 	= 	 $array['activediagnosis'];
	$pendingdiagnosis 	= 	 $array['pendingdiagnosis'];
	$indidocap 			= 	 $array['indidocap']['count'];
	$clinicdocap 		=	 $array['clinicdocap']['count'];
	$hosdocap			= 	 $array['hosdocap']['count'];
	$diagnosisap		= 	 $array['diagnosisap']['count'];
	$allpatient			= 	 $array['allpatient'];
	$allclinic			= 	 $array['allclinic'];
	$allhospital		= 	 $array['allhospital'];
	$allindidoc			= 	 $array['allindidoc'];
	$allclinicdoc		= 	 $array['allclinicdoc'];
	$allhosdoc			= 	 $array['allhosdoc'];
	$alldiagnosis		= 	 $array['alldiagnosis'];
	 
	$cur_month			=	 $array['m'];
	$monrev		=	$array['monrev'];
	$m 	 		= 	$array['m'];
	$y 	 		= 	$array['y'];
	$xaxis 		= 	'';
	$yaxis 		= 	'';
	foreach ($monrev as $x) {		 
		if($x['ap_money']=='')
		{
			$x['ap_money']=0;
		}
		$xaxis 	.= "'".date('d',strtotime($x['date']))."', ";
		$yaxis 	.= $x['ap_money'].", ";
	}
	$xaxis = substr_replace($xaxis, "", -2);
	$yaxis = substr_replace($yaxis, "", -2);
	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Bookmediz</title>
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
 <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>	
  <style>
  	 
  	.highcharts-button , .highcharts-credits{
  		display: none;
  	}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<?php
		include('includes/header.php');
		include("includes/fusioncharts.php");
	?>
	<?php
 
 

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
         
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
      <div class="col-md-12">
		<?php
			if($this->session->flashdata('homemsg'))
			{
				echo $this->session->flashdata('homemsg');
			}
		?>
      </div>
      </div>
      <!-- /.row -->
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					 <div class="box-header with-border"><h3 class="box-title">Individual Doctor</h3></div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">

						        <div class="col-md-4 col-md-offset-2 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-user-md"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/activeindidoc');?>">
									  <span class="info-box-text">Active Individual Doctors</span>
									  <span class="info-box-number"><?= $activeindidoc; ?><small></small></span>
									  </a>
									</div>
								  </div>
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-green"><i class="fa fa-medkit"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/pendingindidoc');?>">
									  <span class="info-box-text">Pending Individual Doctor</span>
									  <span class="info-box-number"><?= $pendingindidoc; ?></span>
									  </a>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>										 
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					 <div class="box-header with-border"><h3 class="box-title">Diagnosis Center</h3></div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">

						        <div class="col-md-4 col-md-offset-2 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-heartbeat"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/activediagnosis');?>">
									  <span class="info-box-text">Active Diagnosis Center</span>
									  <span class="info-box-number"><?= $activediagnosis; ?><small></small></span>
									  </a>
									</div>
								  </div>
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-green"><i class="fa fa-heartbeat"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/pendingdiagnosis');?>">
									  <span class="info-box-text">Pending Diagnosis Center</span>
									  <span class="info-box-number"><?= $pendingdiagnosis; ?></span>
									  </a>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>										 
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					 <div class="box-header with-border"><h3 class="box-title">Clinic</h3></div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">

						        <div class="col-md-4 col-md-offset-2 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-user-md"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/activeclinic');?>">
									  <span class="info-box-text">Active clinic</span>
									  <span class="info-box-number"><?= $activeclinic; ?><small></small></span>
									  </a>
									</div>
								  </div>
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-green"><i class="fa fa-medkit"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/pendingclinic');?>">
									  <span class="info-box-text">Pending Clinic</span>
									  <span class="info-box-number"><?= $pendingclinic; ?></span>
									  </a>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>										 
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					 <div class="box-header with-border"><h3 class="box-title">Hospital</h3></div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">

						        <div class="col-md-4 col-md-offset-2 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-user-md"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/activehospital');?>">
									  <span class="info-box-text">Active Hospital</span>
									  <span class="info-box-number"><?= $activehospital; ?><small></small></span>
									  </a>
									</div>
								  </div>
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-green"><i class="fa fa-medkit"></i></span>

									<div class="info-box-content">
										<a href="<?= base_url('hosadmin/pendinghospital');?>">
									  <span class="info-box-text">Pending Hospital</span>
									  <span class="info-box-number"><?= $pendinghospital; ?></span>
									  </a>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>										 
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		
		<!---- count of all users----->
		<div class="row">
			<div class="col-md-12">
				 <div class="box1">
					 <div class="box-header with-border">
					 <h3 class="box-title">User's Count</h3>
					  <div class="box-tools pull-right">
 						</div>
					 </div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-stethoscope"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Individual Doctor</span>
									  <span class="info-box-number"><?= $allindidoc; ?><small></small></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<!-- /.col -->
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-red"><i class="fa fa-stethoscope"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">Clinic Doctor</span>
									  <span class="info-box-number"><?= $allclinicdoc; ?> </span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<!-- /.col -->

								<!-- fix for small devices only -->
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-stethoscope"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Hospital Doctor</span>
									  <span class="info-box-number"><?= $allhosdoc; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-hospital-o"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Clinic  </span>
									  <span class="info-box-number"><?= $allclinic; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-hospital-o"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Hospital  </span>
									  <span class="info-box-number"><?= $allhospital; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-heartbeat"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Diagnosis  </span>
									  <span class="info-box-number"><?= $alldiagnosis; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<div class="clearfix visible-sm-block"></div>

								
								
										<!-- /.col -->
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		<!--Todays appointment -->
		
		<div class="row">
			<div class="col-md-12">
				 <div class="box">
					 <div class="box-header with-border">
					 <h3 class="box-title">Today's Appointments of Patient <?= date('d-M-Y');?></h3>
					  <div class="box-tools pull-right">
 						</div>
					 </div>
					 <div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-3 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-ambulance"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Individual <br>Doctor's Appointment</span>
									  <span class="info-box-number"><?= $indidocap; ?><small></small></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<!-- /.col -->
								<div class="col-md-3 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-red"><i class="fa fa-ambulance"></i></span>

									<div class="info-box-content">
										<span class="info-box-text">Clinic<br> Appointments</span>
									  <span class="info-box-number"><?= $clinicdocap; ?> </span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<!-- /.col -->

								<!-- fix for small devices only -->
								<div class="clearfix visible-sm-block"></div>
								<div class="col-md-3 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-aqua"><i class="fa fa-ambulance"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Hospital<br> Appointment</span>
									  <span class="info-box-number"><?= $hosdocap; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								<div class="clearfix visible-sm-block"></div>

								<div class="col-md-3 col-sm-6 col-xs-12">
								  <div class="info-box">
									<span class="info-box-icon bg-green"><i class="fa fa-ambulance"></i></span>

									<div class="info-box-content">
									  <span class="info-box-text">Diagnosis<br> Lab Appointment</span>
									  <span class="info-box-number"><?= $diagnosisap; ?></span>
									</div>
									<!-- /.info-box-content -->
								  </div>
								  <!-- /.info-box -->
								</div>
								
										<!-- /.col -->
							</div>
						</div>
					 </div>
				 </div>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		<!--Todays appointment -->
		
		
		
 		<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">  </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">
        	<div id="chart" class="col-md-12"></div>	
        </div>
      </div>
      <div class="row">
      	<div class="col-sm-6 col-sm-offset-3">
      		<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title"> Find Appointment </h3>

		          <div class="box-tools pull-right">
		           </div>
		        </div>
		        <div class="box-body">
		        	<form class="form">
                        			<div class="col-md-6 ">  
                                                                      		 
                                   		<select class="form-control" id="month" name="month">
                                   			 <option value="1" <?php  if($m=="01"){echo "selected";} ?>>Jan</option>
                                   			 <option value="2" <?php  if($m=="02"){echo "selected";} ?>>Feb</option>
                                   			 <option value="3" <?php  if($m=="03"){echo "selected";} ?>>Mar</option>
                                   			 <option value="4" <?php  if($m=="04"){echo "selected";} ?>>Apr</option>
                                   			 <option value="5" <?php  if($m=="05"){echo "selected";} ?>>May</option>
                                   			 <option value="6" <?php  if($m=="06"){echo "selected";} ?>>Jun</option>
                                   			 <option value="7" <?php  if($m=="07"){echo "selected";} ?>>Jul</option>
                                   			 <option value="8" <?php  if($m=="08"){echo "selected";} ?>>Aug</option>
                                   			 <option value="9" <?php  if($m=="09"){echo "selected";} ?>>Sep</option>
                                   			 <option value="10" <?php  if($m=="10"){echo "selected";} ?>>Oct</option>
                                   			 <option value="11" <?php  if($m=="11"){echo "selected";} ?>>Nov</option>
                                   			 <option value="12" <?php  if($m=="12"){echo "selected";} ?>>Dec</option>
                                   			 
                                   		</select>
                                   	</div>
                                   	<div class="col-md-6">
                                   		<select class="form-control" id="year" name="year">
                                   			<?php
                                   				for($i=2018;$i<=date('Y')+1;$i++)
                                   				{
                                   					?>
                                   						<option value="<?= $i;?>" <?php  if($i==$y){echo "selected";} ?>><?= $i; ?></option>
                                   					<?php
                                   				}
                                   			?>
                                   		</select>
                                   	</div>
                                   </form>
                                   	<div class="col-sm-6 col-sm-offset-3">
                                   		<br>
                                   		<button class="btn btn-warning btn-block" onClick="findappointments();">  Find Appointment</button>
                                    </div>	
		        	<div class="col-md-6"></div>	
		        </div>
		      </div>
      	</div>
      </div>

     
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
			
			var chart = Highcharts.chart('chart', {

			    title: {
			        text: ' Appointment for <?= date('F', mktime(0, 0, 0, $m, 10)).", ".$y; ?>'
			    },

			    subtitle: {
			        text: ''
			    },

			    xAxis: {
			        /*categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']*/
			        categories: [<?= $xaxis; ?>]
			    },

			    series: [{
			        type: 'column',
			        colorByPoint: true,
			        /*data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4,29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4,29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],*/
			        data: [<?= $yaxis; ?>],
			        showInLegend: false
			    }]

			});


			$('#plain').click(function () {
			    chart.update({
			        chart: {
			            inverted: false,
			            polar: false
			        },
			        subtitle: {
			            text: 'Plain'
			        }
			    });
			});

			function findappointments(){
				var year = $("#year").val();
				var month = $("#month").val();
				location.href="<?= base_url('Hosadmin/appointment?m=');?>"+month+"&y="+year;
			} 

		</script>

  <?php include('includes//footer.php');?>
</body>
</html>
