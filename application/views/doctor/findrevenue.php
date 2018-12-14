<?php
	 
	$settings		=	$array['settings'];
	$charge			=	(100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
	$monrev			=	$array['monrev'];
	$date1			=	$monrev[1]['date'];
	$m				=	date('m',strtotime($date1));
	$y				=	date('Y',strtotime($date1));
	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Find Revenue</title>
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
<!-- Site wrapper -->
<div class="wrapper">

<?php 
include('includes/header.php');
include("includes/fusioncharts.php");
?>
<?php
 

  $arrData = array(
        "chart" => array(
            "caption"=> "Revenue Analysis",
            "subCaption"=> "Revenue earned in the month of ".date('M-Y',strtotime($monrev[1]['date'])),
            "xAxisname"=> "Date",
            "yAxisName"=> "Revenues (In INR)",
            "numberPrefix"=> "Rs.",
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
          foreach($monrev as $x) {
            array_push($categoryArray, array(
            "label" =>date('d-M', strtotime($x["date"]))
          )
        );
        array_push($dataseries1, array(
          "value" => ($x['appointment_money']*100)/$charge
          )
        );

        

      }

      $arrData["categories"]=array(array("category"=>$categoryArray));
      // creating dataset object
      //$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue", "data"=>$dataseries1), array("seriesName"=> "Projected Revenue",  "renderAs"=>"line", "data"=>$dataseries2),array("seriesName"=> "Profit",  "renderAs"=>"area", "data"=>$dataseries3));
      $arrData["dataset"] = array(array("seriesName"=> "Actual Revenue", "data"=>$dataseries1));


      /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
      $jsonEncodedData = json_encode($arrData);

      // chart object
      $msChart = new FusionCharts("mscombi2d", "chart1" , "100%", "400", "chart-container", "json", $jsonEncodedData);

      // Render the chart
      $msChart->render();

      // closing db connection
  

?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		Find Revenue
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li> <a href="<?= base_url('doctordashboard/revenue');?>"> Revenue</a></li>
        <li class="active">Find Revenue</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="pull-right" style="padding:20px;">
				<form method="get" class="form form-inline" action="<?= base_url('doctordashboard/findrevenue');?>">
				 
					<label for="email">Find Revenue</label>
				 
					<select class="form-control" name="month" required>
						<option value="1" <?php if($m=='1')echo "selected"; ?>>Jan</option>
						<option value="2" <?php if($m=='2')echo "selected"; ?>>Feb</option>
						<option value="3" <?php if($m=='3')echo "selected"; ?>>Mar</option>
						<option value="4" <?php if($m=='4')echo "selected"; ?>>Apr</option>
						<option value="5" <?php if($m=='5')echo "selected"; ?>>May</option>
						<option value="6" <?php if($m=='6')echo "selected"; ?>>Jun</option>
						<option value="7" <?php if($m=='7')echo "selected"; ?>>Jul</option>
						<option value="8" <?php if($m=='8')echo "selected"; ?>>Aug</option>
						<option value="9" <?php if($m=='9')echo "selected"; ?>>Sept</option>
						<option value="10" <?php if($m=='10')echo "selected"; ?>>Oct</option>
						<option value="11" <?php if($m=='11')echo "selected"; ?>>Nov</option>
						<option value="12" <?php if($m=='12')echo "selected"; ?>>Dec</option>
					</select>
				 
					<select class="form-control" name="year" required>
						<?php
							for($i=2000;$i<=date('Y');$i++)
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
          <h3 class="box-title"> Revenue</h3>
			 <div class="box-tools pull-right">
				 
			 </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('revenuemsg'))
				{
					echo $this->session->flashdata('revenuemsg');
				}
			  ?>
			 
			  <div class="" id="chart-container"></div>
			 <div class="row">
			 <div class="box">
		<div class="box-body">
			<br>
			<br>
			<br>
			<div class="row">
			<div class="col-sm-6" >	
				<table class="table table-responsive table-striped">
					<?php
						if(count($monrev))
						{
							$total=0;
							$i=1;
							foreach($monrev as $x)
							{
								if($i<=16)
								{
								?>
									<tr>
										<td><?= date('d-M', strtotime($x['date']));?></td>
										<th><?php if($x['appointment_money']!=''){echo "Rs. ".number_format(($x['appointment_money']*100/$charge),2) ;}else{echo "Rs. 0";}?></th>									
										 
									</tr>
									 
								<?php
								$total	+=	($x['appointment_money']*100/$charge);
								
								
									 
								}
								$i++;
							}
						}
					?>
				</table>
			</div>
			<div class="col-sm-6" >
				<table class="table table-responsive table-striped">
					<?php
						if(count($monrev))
						{
							 
							$i=1;
							foreach($monrev as $x)
							{
								if($i>16)
								{
								?>
								
									<tr>
										<td><?= date('d-M', strtotime($x['date']));?></td>
										<th><?php if($x['appointment_money']!=''){echo "Rs. ".number_format(($x['appointment_money']*100/$charge),2) ;}else{echo "Rs. 0";}?></th>									
									</tr>
									 
								<?php
								$total	+=	($x['appointment_money']*100/$charge);
								
								
								
								}
								$i++;
							}
						}
					?>	
				</table>
			</div>
			
				<div class="clearfix"></div>
				
					 
			 
			</div>
		</div>
	</div>
	 
			 
				 
				<div class="col-sm-12">
				<div class="panel panel-primary">
				  <div class="panel-heading">
					<div class="col-sm-3"><h2>Total Revenue:</h2></div>
						<div class="col-sm-9"><h2>Rs. <?= number_format($total,2); ?></h2></div>
						<div class="clearfix"></div>
				</div>
				  
				</div>
				</div>
			<!--<div class="col-sm-6 col-sm-offset-3" style="box-shadow:10px 10px 10px 10px gray">
				<table class="table table-responsive table-striped table-bordered">
					<tr>
						<th colspan="2"><h2 class="text-center text-primary">Revenue Table</h2></th>
					</tr>
					<tr>
						<th>Date</th>
						<th>Amount</th>
					</tr>
					<?php
						if(count($monrev))
						{
							$total=0;
							foreach($monrev as $x)
							{
								?>
									<tr>
										<th><?= date('d-M', strtotime($x['date']));?></th>
										<td><?php if($x['appointment_money']!=''){echo "Rs. ".($x['appointment_money']*100/$charge) ;}else{echo "Rs. 0";}?></td>
									</tr>
								<?php
								$total	+=	($x['appointment_money']*100/$charge);
							}
						}
					?>
					<tr>
						<th>Total:</th>
						<th><?= $total; ?></th>
					</tr>
				</table>
			 
			</div>-->
			</div>
        </div>
        <!-- /.box-body -->
         
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes/footer.php');?>
 <!-- Modal -->