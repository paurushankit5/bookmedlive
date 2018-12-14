<?php
	$monapp				=	$array['monapp'];
	$appointments		=	$array['appointments'];
	//$questions		=	array();
	$questions			=	$array['questions'];
	$cur_month			=	 date('m');
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
        Dashboard
         
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
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
          <h3 class="box-title"> Dashboard</h3>

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
			 
        </div>
		
		<div class="" id="chart-container"></div>
		
		<hr>
		<div class="col-sm-8">
			<table class="table table-responsive table-striped table-bordered">
					<thead>
						<tr>
							<th colspan="4"><h3 class="text text-primary text-center">Today's Appointments</h3></th>
						</tr>
						<tr>
							 
							<th>Patient Name</th>
							<th>Appointment Id</th>
							<th>Appointment Date</th>
							<th>Time</th>
							 
							
						</tr>
					</thead>
					<tbody>
						<?php
							if(count($appointments))
							{
								$i=0;
							 
								foreach($appointments as $x)
								{
									?>
									<tr>
									 
										<td><?= $x['patient_name'];?></td>
										<td><?= $x['appointment_id'];?></td>
										<td><?= date('d-M-Y',strtotime($x['appointment_date']));?></td>
										<td><?= $x['appointment_time'];?></td>
										 
									 
										 
									</tr>
									<tr><td colspan="8"></td></tr>
									
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="7"><div class="alert alert-warning"><b>No appointments for today.</b></div></td>
								</tr>
								<?php
							}
						?>
						 
					</tbody>
				</table>
		</div>
		<div class="col-sm-4">
			   <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Questions</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                
              </div>
            </div>
            <div class="box-body chat" id="chat-box">
              <?php
				if(count($questions))
				{
					foreach($questions as $x)
					{
						?>
							<div class="item">
								<img src="<?= base_url('assets/');?>dist/img/user3-128x128.jpg" alt="user image" style="visibility:hidden;"class="offline">

								<p class="message">
								  <a href="#" class="name">
									<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= date('h:i:a d-M',strtotime($x['question_add_time']));?></small>
									<?= $x['patient_name'];?>
								  </a>
								  <?= $x['question_name'];?>
								</p>
								<form method="post" action="<?= base_url('doctordashboard/updatequestion');?>">
								 <div class="input-group">
									<input class="form-control" required placeholder="Type message..." name="question_ans">
									<input type="hidden" class="form-control" placeholder="Type message..." name="question_id" value="<?= $x['question_id'];?>">

									<div class="input-group-btn">
									  <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
									</div>
								  </div>
								 </form>
							  </div>
						<?php
					}
				}
				else
				{
					echo "<b>No questions found.</b>";
				}
			  ?>
              
              <!-- /.item -->
              <!-- chat item -->
              
              <!-- /.item -->
            </div>
            <!-- /.chat -->
            <div class="box-footer">
               
            </div>
          </div>
		</div>
        <!-- /.box-body -->
        <div class="box-footer">
				
        </div>
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
