<?php
	$doctor		=	$array['doctor'];
	$appointment=	$array['appointment'];
	if($doctor['doctor_mon']==1)
	{
		$day[]=1;
		$day2[]='Monday';
	}
	if($doctor['doctor_tues']==1)
	{
		$day[]=2;
		$day2[]='Tuesday';
	}
	if($doctor['doctor_wed']==1)
	{
		$day[]=3;
		$day2[]='Wednesday';
	}
	if($doctor['doctor_thurs']==1)
	{
		$day[]=4;
		$day2[]='Thursday';
	}
	if($doctor['doctor_fri']==1)
	{
		$day[]=5;
		$day2[]='Friday';
	}
	if($doctor['doctor_sat']==1)
	{
		$day[]=6;
		$day2[]='Saturday';
	}
	if($doctor['doctor_sun']==1)
	{
		$day[]=0;
		$day2[]='Sunday';
	}
	//print_r($day);
	$data	=	'day==';
	$data	.=	implode("|| day==",$day);
	//echo $data;
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reschedule Appointment</title>
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
		$(function() {
			$( "#datepicker" ).datepicker({
				minDate: 0, maxDate: "+3M",
				dateFormat: 'yy-mm-dd',
				beforeShowDay: function(date){ 
				  var day = date.getDay(); 
				  return [<?= $data; ?>,""];
				  
				}
			});
		//$( "#datepicker" ).datepicker("show");
	 
		
		
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
		Reschedule Appointment
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active"> My Appointments</li>
        <li class="active"> Reschedule Appointments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Reschedule Appointment</b></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('findmsg'))
				{
					echo $this->session->flashdata('findmsg');
				}
				//echo "<pre>";
				//print_r($doctor);
			  ?>
			  <p><b>The appointment date is <?= date('d-M-Y',strtotime($appointment['appointment_date']));?></b></p>
			  <p><b>The appointment time is &#x20B9; <?= $appointment['appointment_time'];?></b></p>
			<!--	<form class="form-horizontal" method="post" action="<?= base_url('patientdashboard/storeappointment');?>">-->
			   <div class="form-group" id="section1">
				  <label class="control-label col-sm-2" for="patient_name">Select a Date:<br> (YYYY-MM-DD)</label>
				  <div class="col-sm-6">
						  <input type = "text" id = "datepicker" readonly name="appointment_date" class="form-control" placeholder="Select Appointment Date (YYYY-MM-DD)">
						  <input type = "hidden" id = "appointment_time" name="appointment_time" class="form-control">
						  <input type = "hidden" id = "appointment_status" name="appointment_status" value="RESCHEDULED" class="form-control">
						  <input type = "hidden" id = "appointment_id" name="appointment_id" value="<?= $appointment['appointment_id'];?>" class="form-control">	
						  <input type = "hidden" id = "appointment_doctor_id" name="appointment_doctor_id" value="<?= $doctor['doctor_id'];?>" class="form-control"><br>	
						  <button type="submit" onClick="showtimeslots();" id="showopt" class="btn btn-primary">Show Available Time Slots</button>
						  
				 </div>
				  
				</div>
				 
				<div class="row" style="display:none;" id="section2">
					<div class="col-sm-12">
						<h3 class="text text-primary text-center"><b>Selected date is <span id="datefiled"></span></b></h3>
						<input type="button"  class="btn btn-info btn-lg pull-right" value="Change Date" onClick="window.location.reload()">
					</div>
				
				</div>
				<div class="form-group" id="timeslot" style="display:none;">
					<br>
					 
				  <label class="control-label col-sm-2" for="patient_name">Time Slot:</label>
				  <div class="col-sm-5">
						<a href="#" class="btn btn-warning btn btn-block disabled">Morning Shift (<?= date('h:i A', strtotime($doctor['doctor_morning_start_time']));?> to <?= date('h:i A', strtotime($doctor['doctor_morning_end_time']));?>)</a>
						<br>
						<br>
						<?php
							$i=1;
							$lasttime=0;
							$firsttime=date("H:i:A",strtotime($doctor['doctor_morning_start_time']));
							while($lasttime<date("H:i:A",strtotime($doctor['doctor_morning_end_time'])))
							{
								$times	=	$doctor['doctor_consultation_time']*$i;
								$lasttime	= date("H:i:A", strtotime('+'.$times.' minutes', strtotime($doctor['doctor_morning_start_time'])));
								//echo $lasttime."<br>";
								$lastsec = explode(":",$lasttime);
								 $lastsec = $lastsec[0]*3600+$lastsec[1]*60;

								?>
								<div class="col-sm-6">
								<button class="btn btn-info btn btn-block" data-id="<?= $lastsec; ?>" style="margin:5px;" id="<?php echo implode("",explode(":",$firsttime."to".$lasttime));?>" onClick="settime1('<?php echo $firsttime;?> to <?php echo $lasttime;?>','<?php echo implode("",explode(":",$firsttime."to".$lasttime));?>')">						
									<?php echo $firsttime;?> to 
									<?php echo $lasttime;?>
								</button>
							</div>
								<?php
									$firsttime	= date("H:i:A", strtotime('+'.$times.' minutes', strtotime($doctor['doctor_morning_start_time'])));

								$i++;
							}
							 
							 
						?>
						
				</div>
				  <div class="col-sm-5">
						<a href="#" class="btn btn-warning btn-block disabled">Evening Shift (<?= date('H:i A', strtotime($doctor['doctor_evening_start_time']));?> to <?= date('h:i A', strtotime($doctor['doctor_evening_end_time']));?>)</a>
						<br>
						<br>
						<?php
							$i=1;
							$lasttime=0;
							$firsttime=date("H:i:A",strtotime($doctor['doctor_evening_start_time']));
							while($lasttime<date("H:i:A",strtotime($doctor['doctor_evening_end_time'])))
							{
								$times	=	$doctor['doctor_consultation_time']*$i;
								$lasttime	= date("H:i:A", strtotime('+'.$times.' minutes', strtotime($doctor['doctor_evening_start_time'])));
								$lastsec = explode(":",$lasttime);
								 $lastsec = $lastsec[0]*3600+$lastsec[1]*60;
								?>
								<div class="col-sm-6">
								<button class="btn btn-info btn-block" data-id="<?= $lastsec;?>" style="margin:5px;" id="<?php echo implode("",explode(":",$firsttime."to".$lasttime));?>" onClick="settime1('<?php echo $firsttime;?> to <?php echo $lasttime;?>','<?php echo implode("",explode(":",$firsttime."to".$lasttime));?>')">						
									<?php echo $firsttime;?> to 
									<?php echo $lasttime;?>
								</button>
								</div>
								<?php
									$firsttime	= date("H:i:A", strtotime('+'.$times.' minutes', strtotime($doctor['doctor_evening_start_time'])));

								$i++;
							}
							 
							 
						?>
				</div>
				<div class="row">
				<div class="clearfix"></div>
					<br>
					 
					<div class="col-sm-2"></div>
					<div class="col-sm-10">
						<button type="submit" onClick="rescheduleappointment();" class="btn btn-success btn-lg pull-right" style="padding:20px 40px 20px 40px;"><b>Reschedule Now </b></button>
					</div>
				</div>
				
				</div>
				
	
	
	
			  
			  
			  
			 
			  
			 
			<!--</form>-->
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

  <?php
	//  include('includes/footer.php');
	?>
	<script>
		function settime1(str1,str2)
		{
			$('*').removeClass("btn-danger");
			$('#'+str2).removeClass("btn-primary").addClass("btn-danger");  
			$('#appointment_time').val(str1);
		}
		function rescheduleappointment()
		{
			var appointment_date	=	$('#datepicker').val();
			var appointment_time	=	$('#appointment_time').val();
			 
			var appointment_status	=	$('#appointment_status').val();
			 
			var appointment_id	=	$('#appointment_id').val();
			
			if(appointment_date=='')
			{
				alert('Please select appointment date');
			}
			else if(appointment_time=='')
			{
				alert('Please select a time slot');
			}
			else
			{
				$.ajax({
					url		:	'<?= base_url('doctordashboard/rescheduleappointment');?>',
					type	:	'POST',
					data	:	'appointment_date='+appointment_date+'&appointment_time='+appointment_time+'&appointment_id='+appointment_id+'&appointment_status='+appointment_status,
					success	:	function(data){
								//alert(data);
								window.location ='<?=base_url('doctordashboard/myappointments');?>';
								//window.location ='<?=base_url('patientdashboard/paynow/'.$doctor['doctor_fee'].'/');?>'+data;
								
					},
				});
			}
		}
		function showtimeslots()
		{
			
			var appointment_date		=	$('#datepicker').val();
			$('#datefiled').html(appointment_date);
			var appointment_doctor_id	=	$('#appointment_doctor_id').val();
			if(appointment_date=='')
			{
				alert('Please select appointment date first');
			}
			else
			{
				$('#section1').hide();
				$('#section2').show();
				$('#datepicker').hide();
					var today = '<?= date('Y-m-d'); ?>';
					if(today==appointment_date)
					{
						<?php
							$time =	explode(":",date("H:i:s"));
							$time = $time[0]*3600+$time[1]*60+$time[2]+3600*6;
							
						?>
						var time = '<?= $time; ?>';
						console.log(time);
						$(".btn-info").each(function () {         
						    if ($(this).attr('data-id') <= time)
						        $(this).hide();
						});
					}
					$.ajax({
					url		:	'<?= base_url('patientdashboard/checkappointments');?>',
					type	:	'POST',
					data	:	'appointment_date='+appointment_date+'&appointment_doctor_id='+appointment_doctor_id,
					success	:	function(data){
								//alert(data);
								$(''+data).hide();
								$('#timeslot').show();
								
								//$('#1100AMto1110AM,#1210PMto1220PM').hide();
								//alert(data);
								
					},
				});
			}
		}
	</script>
</body>
</html>
