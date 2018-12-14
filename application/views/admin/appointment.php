<?php
  	$clinic 	= $array['clinic'];
	$hospital	=	$array['hospital'];
	$indidoc	=	$array['indidoc'];
	$diagnosis	=	$array['diagnosis'];
	$monrev		=	$array['monrev'];
	$m 	 		= 	$_GET['m'];
	$y 	 		= 	$_GET['y'];
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
	$totaltoday = 0;
	$totalmonth = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Appointment for <?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></title>
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
  	th,td{
  		width:33%;
  	}
  	.highcharts-button , .highcharts-credits{
  		display: none;
  	}
  </style>
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
        My Appointment for <?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        
       
        <li class="active">  Appointment for <?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <?php
		if($this->session->flashdata('citymsg'))
		{
			echo $this->session->flashdata('citymsg');
		}
	  ?>
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
                                   		<button class="btn btn-warning btn-block" onClick="findappointments();">  Find Revenue</button>
                                    </div>	
		        	<div class="col-md-6"></div>	
		        </div>
		      </div>
      	</div>
      </div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Individual Doctor </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">
			 
			  <table class="table table-responsive">
			  	<tr>
			  		<th>Name</th>
			  		<th>Today</th>
			  		<th><?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></th>
			  	</tr>
			  	 <?php
			  	 	if(count($indidoc))
			  	 	{
			  	 		$doctoday  = 0;
			  	 		$docmonth  = 0;
			  	 		foreach ($indidoc as $doc) {
			  	 			if($doc['today']=='')
			  	 			{
			  	 				$doc['today']=0;
			  	 			}
			  	 			if($doc['month']=='')
			  	 			{
			  	 				$doc['month']=0;
			  	 			}
			  	 			?>
			  	 			<tr>
			  	 				<th><a href="<?= base_url('hosadmin/docdetails/'.$doc['id']);?>">Dr. <?= $doc['user_name'];?></a></th>
			  	 				<td><b>  <?= $doc['today'];?></b></td>
			  	 				<td><b>  <?= $doc['month'];?></b></td>
			  	 			</tr>
			  	 			<?php
			  	 			$totaltoday += $doc['today'];
			  	 			$doctoday   += $doc['today'];
			  	 			$totalmonth += $doc['month'];
			  	 			$docmonth   += $doc['month'];
			  	 		}
			  	 		?>
			  	 			<tr>
			  	 				<th>Total</th>
			  	 				<td><b><?= $doctoday; ?></b></td>
			  	 				<td><b><?= $docmonth; ?></b></td>
			  	 			</tr>
			  	 		<?php
			  	 	}
			  	 ?>
			  	 
			  </table>
        </div>

        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Diagnosis Center </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">
			 
			  <table class="table table-responsive">
			  	<tr>
			  		<th>Name</th>
			  		<th>Today</th>
			  		<th><?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></th>
			  	</tr>
			  	 <?php
			  	 	if(count($diagnosis))
			  	 	{
			  	 		$doctoday  = 0;
			  	 		$docmonth  = 0;
			  	 		foreach ($diagnosis as $doc) {
			  	 			if($doc['today']=='')
			  	 			{
			  	 				$doc['today']=0;
			  	 			}
			  	 			if($doc['month']=='')
			  	 			{
			  	 				$doc['month']=0;
			  	 			}
			  	 			?>
			  	 			<tr>
			  	 				<th><a href="<?= base_url('hosadmin/diagnosisdetails/'.$doc['id']);?>"><?= $doc['user_name'];?></a></th>
			  	 				<td><b>  <?= $doc['today'];?></b></td>
			  	 				<td><b>  <?= $doc['month'];?></b></td>
			  	 			</tr> 
			  	 			<?php
			  	 			$totaltoday += $doc['today'];
			  	 			$doctoday   += $doc['today'];
			  	 			$totalmonth += $doc['month'];
			  	 			$docmonth   += $doc['month'];
			  	 		}
			  	 		?>
			  	 			<tr>
			  	 				<th>Total</th>
			  	 				<td><b><?= $doctoday; ?></b></td>
			  	 				<td><b><?= $docmonth; ?></b></td>
			  	 			</tr>
			  	 		<?php
			  	 	}
			  	 ?>
			  	 
			  </table>
        </div>

        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>


      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Clinic </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">
			 
			  <table class="table table-responsive">
			  	<tr>
			  		<th>Name</th>
			  		<th>Today</th>
			  		<th><?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></th>
			  	</tr>
			  	 <?php
			  	 	if(count($clinic))
			  	 	{
			  	 		$doctoday  = 0;
			  	 		$docmonth  = 0;
			  	 		foreach ($clinic as $doc) {
			  	 			if($doc['today']=='')
			  	 			{
			  	 				$doc['today']=0;
			  	 			}
			  	 			if($doc['month']=='')
			  	 			{
			  	 				$doc['month']=0;
			  	 			}
			  	 			?>
			  	 			<tr>
			  	 				<th><a href="<?= base_url('hosadmin/clinicdetails/'.$doc['id']);?>"><?= $doc['user_name'];?></a></th>
			  	 				<td><b>  <?= $doc['today'];?></b></td>
			  	 				<td><b>  <?= $doc['month'];?></b></td>
			  	 			</tr>
			  	 			<?php
			  	 			$totaltoday += $doc['today'];
			  	 			$doctoday   += $doc['today'];
			  	 			$totalmonth += $doc['month'];
			  	 			$docmonth   += $doc['month'];
			  	 		}
			  	 		?>
			  	 			<tr>
			  	 				<th>Total</th>
			  	 				<td><b><?= $doctoday; ?></b></td>
			  	 				<td><b><?= $docmonth; ?></b></td>
			  	 			</tr>
			  	 		<?php
			  	 	}
			  	 ?>
			  	 
			  </table>
        </div>

        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>
         <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Hospital </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">
			 
			  <table class="table table-responsive">
			  	<tr>
			  		<th>Name</th>
			  		<th>Today</th>
			  		<th><?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></th>
			  	</tr>
			  	 <?php
			  	 	if(count($hospital))
			  	 	{
			  	 		$doctoday  = 0;
			  	 		$docmonth  = 0;
			  	 		foreach ($hospital as $doc) {
			  	 			if($doc['today']=='')
			  	 			{
			  	 				$doc['today']=0;
			  	 			}
			  	 			if($doc['month']=='')
			  	 			{
			  	 				$doc['month']=0;
			  	 			}
			  	 			?>
			  	 			<tr>
			  	 				<th><a href="<?= base_url('hosadmin/hosdetails/'.$doc['id']);?>"><?= $doc['user_name'];?></a></th>
			  	 				<td><b>  <?= $doc['today'];?></b></td>
			  	 				<td><b>  <?= $doc['month'];?></b></td>
			  	 			</tr>
			  	 			<?php
			  	 			$totaltoday += $doc['today'];
			  	 			$doctoday   += $doc['today'];
			  	 			$totalmonth += $doc['month'];
			  	 			$docmonth   += $doc['month'];
			  	 		}
			  	 		?>
			  	 			<tr>
			  	 				<th>Total</th>
			  	 				<td><b><?= $doctoday; ?></b></td>
			  	 				<td><b><?= $docmonth; ?></b></td>
			  	 			</tr>
			  	 		<?php
			  	 	}
			  	 ?>
			  	 
			  </table>
        </div>

        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>

       <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Total Appointment Count </h3>

          <div class="box-tools pull-right">
           </div>
        </div>
        <div class="box-body">			 
			  <table class="table table-responsive">
			  	<tr>
			  		<th>Total</th>
			  		<th>Today</th>
			  		<th><?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?></th>
			  	</tr>			  	
  	 			<tr>
  	 				<th> </th>
  	 				<td><b><?= $totaltoday; ?></b></td>
  	 				<td><b><?= $totalmonth; ?></b></td>
  	 			</tr>			  	 
			  </table>
        </div>
      </div>











      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
 
		 
		<script type="text/javascript">
			
			var chart = Highcharts.chart('chart', {

			    title: {
			        text: ' Appointment for <?= date('F', mktime(0, 0, 0, $_GET['m'], 10)).", ".$_GET['y']; ?>'
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
 
 
  <?php include('includes/footer.php');?>
</body>
 
</html>
