<?php
	$monapp				=	$array['monapp'];

	
	 $d	=	$monapp[1]['date'];
	$m	=	 date('m',strtotime($d));
	$y	=	 date('Y',strtotime($d));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Doctor | Dashboard</title>
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

		<script src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
        <script src="https://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>
        <script src="https://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.zune.js"></script>
		<style>
			.raphael-group-3-creditgroup
			{
				display:none;
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
 

  $arrData = array(
        "chart" => array(
            "caption"=> "Graph of Patients",
            "subCaption"=> "Number of Patients in the month of ".date('M-Y',strtotime($monapp[1]['date'])),
            "xAxisname"=> "Date",
            "yAxisName"=> "No. Of Patients",
            "numberPrefix"=> "",
            "legendItemFontColor"=> "#666666",
            "theme"=> "zune"
            )
          );
          // creating array for categories object

          $categoryArray=array();
          $dataseries1=array();
          $dataseries2=array();
          $dataseries3=array();

          // pushing category array values
          foreach($monapp as $x) {
            array_push($categoryArray, array(
            "label" =>date('d-M', strtotime($x["date"]))
          )
        );
        array_push($dataseries1, array(
          "value" => $x["number"]
          )
        );

        

      }

      $arrData["categories"]=array(array("category"=>$categoryArray));
      // creating dataset object
      //$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue", "data"=>$dataseries1), array("seriesName"=> "Projected Revenue",  "renderAs"=>"line", "data"=>$dataseries2),array("seriesName"=> "Profit",  "renderAs"=>"area", "data"=>$dataseries3));
      $arrData["dataset"] = array(array("seriesName"=> "", "data"=>$dataseries1 ));


      /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
      $jsonEncodedData = json_encode($arrData);

      // chart object
      $msChart = new FusionCharts("mscombi2d", "chart1" , "100%", "300", "chart-container", "json", $jsonEncodedData);

      // Render the chart
      $msChart->render();

      // closing db connection
  

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Find Appointment
         
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= base_url('doctordashboard/myappointments');?>"> My Appointments</a></li>       
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="pull-right" style="padding:20px;">
				<form method="get" class="form form-inline" action="<?= base_url('doctordashboard/findappointment');?>">
					 
					<label for="email">Find Appointment</label>
				 
					 
					
					<select class="form-control" name="month" required>
						<option value="1" <?php if($m=='1') echo "selected"; ?>>Jan</option>
						<option value="2" <?php if($m=='2') echo "selected"; ?>>Feb</option>
						<option value="3" <?php if($m=='3') echo "selected"; ?>>Mar</option>
						<option value="4" <?php if($m=='4') echo "selected"; ?>>Apr</option>
						<option value="5" <?php if($m=='5') echo "selected"; ?>>May</option>
						<option value="6" <?php if($m=='6') echo "selected"; ?>>Jun</option>
						<option value="7" <?php if($m=='7') echo "selected"; ?>>Jul</option>
						<option value="8" <?php if($m=='7') echo "selected"; ?>>Aug</option>
						<option value="9" <?php if($m=='9') echo "selected"; ?>>Sept</option>
						<option value="10" <?php if($m=='10') echo "selected"; ?>>Oct</option>
						<option value="11" <?php if($m=='11') echo "selected"; ?>>Nov</option>
						<option value="12" <?php if($m=='12') echo "selected"; ?>>Dec</option>
					</select>				 
					<select class="form-control" name="year" required>
						<?php
							for($i=date('Y');$i>=2016;$i--)
							{
								?>
								<option <?php if($i==$y){echo "selected";} ?>><?= $i; ?></option>
								<?php								
							}
						?>
					</select>				 
					<button type="submit" class="btn btn-default">Submit</button>		 
			</form>
			</div>
		</div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Find Appointment</h3>

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
			 <div class="" id="chart-container"></div>
		
        </div>
		
		
		<hr>
		 
		 
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>	
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes//footer.php');?>
</body>
</html>
