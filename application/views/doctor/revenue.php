<?php
	$revenue1		=	$array['revenue1'];
	$revenue2		=	$array['revenue2'];
	$revenue3		=	$array['revenue3'];
	$revenue4		=	$array['revenue4'];
	$revenue5		=	$array['revenue5'];
	$revenue6		=	$array['revenue6'];
	$revenue7		=	$array['revenue7'];
	$revenue8		=	$array['revenue8'];
	$revenue9		=	$array['revenue9'];
	$revenue10		=	$array['revenue10'];
	$revenue11		=	$array['revenue11'];
	$settings		=	$array['settings'];
	$charge			=	(100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
	$monrev			=	$array['monrev'];
	//echo "<pre>";
	$graphdata[0]['date']	=	date('d-M', time() - 5*86400);
	$graphdata[1]['date']	=	date('d-M', time() - 4*86400);
	$graphdata[2]['date']	=	date('d-M', time() - 3*86400);
	$graphdata[3]['date']	=	date('d-M', time() - 2*86400);
	$graphdata[4]['date']	=	date('d-M', time() - 1*86400);
	$graphdata[5]['date']	=	date('d-M', time()) ;
	$graphdata[6]['date']	=	date('d-M', time() + 1*86400);
	$graphdata[7]['date']	=	date('d-M', time() + 2*86400);
	$graphdata[8]['date']	=	date('d-M', time() + 3*86400);
	$graphdata[9]['date']	=	date('d-M', time() + 4*86400);
	$graphdata[10]['date']	=	date('d-M', time() + 5*86400);
	$graphdata[0]['revenue']=	$revenue11;
	$graphdata[1]['revenue']=	$revenue10;
	$graphdata[2]['revenue']=	$revenue9;
	$graphdata[3]['revenue']=	$revenue8;
	$graphdata[4]['revenue']=	$revenue7;
	$graphdata[5]['revenue']=	$revenue1;
	$graphdata[6]['revenue']=	$revenue2;
	$graphdata[7]['revenue']=	$revenue3;
	$graphdata[8]['revenue']=	$revenue4;
	$graphdata[9]['revenue']=	$revenue5;
	$graphdata[10]['revenue']=	$revenue6;
	$cur_month		=	 date('m');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Revenue</title>
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

  <script src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
        <script src="http://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>
        <script src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.zune.js"></script>
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
       Revenue
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active"> Revenue</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="pull-right" style="padding:20px;">
				<form method="get" class="form form-inline" action="<?= base_url('doctordashboard/findrevenue');?>">
				 
					<label for="email">Find Revenue</label>
				 
					<select class="form-control" name="month" required>
						<option <?php if($cur_month==1) echo "selected";?> value="1">Jan</option>
						<option <?php if($cur_month==2) echo "selected";?> value="2">Feb</option>
						<option <?php if($cur_month==3) echo "selected";?> value="3">Mar</option>
						<option <?php if($cur_month==4) echo "selected";?> value="4">Apr</option>
						<option <?php if($cur_month==5) echo "selected";?> value="5">May</option>
						<option <?php if($cur_month==6) echo "selected";?> value="6">Jun</option>
						<option <?php if($cur_month==7) echo "selected";?> value="7">Jul</option>
						<option <?php if($cur_month==8) echo "selected";?> value="8">Aug</option>
						<option <?php if($cur_month==9) echo "selected";?> value="9">Sept</option>
						<option <?php if($cur_month==10) echo "selected";?> value="10">Oct</option>
						<option <?php if($cur_month==11) echo "selected";?> value="11">Nov</option>
						<option <?php if($cur_month==12) echo "selected";?> value="12">Dec</option>
					</select>
				 
					<select class="form-control" name="year" required>
						<?php
							for($i=2000;$i<=date('Y');$i++)
							{
								?>
								<option <?php if($i==date('Y')){echo "selected";} ?>><?= $i; ?></option>
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
			
        </div>
        <!-- /.box-body -->
         
      </div>
      <!-- /.box -->

    <div class="box">
		<div class="box-body">
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
				<div class="clearfix"></div>
				</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes/footer.php');?>
 <!-- Modal -->