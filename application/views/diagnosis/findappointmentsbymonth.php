<?php
    $ap    =   $array['ap'];
    $doc    =   $array['doc'];
    $settings    =   $array['settings'];
    $charge     = (100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
	
    $m 		=	date('m');
    $y 		=	date('Y');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: Appointment for Dr. <?= $doc['user_name'];?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?= base_url('assets/health/');?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?= base_url('assets/health/');?>assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?= base_url('assets/health/');?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
     <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> 
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      <!-- Javascript -->
      <script>
            var jq = jQuery.noConflict();
            jq(function() {
                jq( "#datepicker" ).datepicker({
                     maxDate: "+30D",
                    dateFormat: 'yy-mm-dd',                    
                });      
             });
        </script>
	
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="<?= base_url('assets/health/');?>assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <?php
                include('includes/sidebar.php');
            ?>
        </div>
        <div class="main-panel">
           <?php
           		include('includes/header.php');
           ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="min-height: 450px;">
                        	<div class="col-md-6">
                                <div class="card">
                                    <div class="card-header" data-background-color="purple">
                                        <h4 class="title">Find Appointments for Dr. <?= $doc['user_name'];?></h4>
                                        
                                    </div>
                                    <div class="card-content"> 
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="datepicker" placeholder="Select Date">
                                        </div>
                                        <div class="col-sm-6" style="margin-top:30px;">
                                            <button class="btn btn-success" onClick="findappointments();"> <i class="material-icons">search</i> Appointments</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header" data-background-color="purple">
                                        <h4 class="title">Find Appointments by month</h4>
                                        
                                    </div>
                                    <div class="card-content"> 
                                        <div class="col-sm-4">
                                            <select class="form-control" id="month">
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
                                         <div class="col-sm-4">
                                            <select class="form-control" id="year">
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
                                        <div class="col-sm-4" style="margin-top:30px;">
                                            <button class="btn btn-success" onClick="findappointmentsbymonth();"> <i class="material-icons">search</i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                                  
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Appointment for <?= date('F', mktime(0, 0, 0, $_GET['m'], 10)); ?>,<?= $_GET['y'];?> </h4>
                                   
                                    
                                </div>
                                <div class="card-content">

                                   
                                    <?php
                                        if($this->session->flashdata('specmsg')){
                                           echo $this->session->flashdata('specmsg');
                                        }
                                    ?>
                                    <div class="col-md-12" >
                                    	<?php
                                    		if(count($ap))
                                    		{
                                    			?>
                                    			<table class="table table-hover" style="word-break: break-all;">
			                                        <thead class="text-warning">
			                                            
			                                            <th class="hidden-xs">#</th>
			                                            <th>Patient</th>
			                                            <th>Ap- ID</th>
			                                            <th>Date & Time</th>
			                                            <th  class="hidden-xs">Fees</th>
			                                            <th class="hidden-xs">Status</th>
			                                        </thead>
			                                        <tbody>
			                                            <?php
			                                            	$i= 0;
			                                                foreach ($ap as $x) {
			                                                    ?>
			                                                        <tr>
			                                                            <td class="hidden-xs"><?= ++$i;?></td>   
			                                                            <td><a href="<?= base_url('patient/details/'.$x['id']);?>"><?= $x['user_name'];?></a></td>   
			                                                            <td><?= $x['ap_id'];?></td>   
			                                                            <td>
			                                                                <?= date("d,M Y",strtotime($x['ap_date']));?> 
			                                                                <br>                                                     
			                                                                <?= $x['ap_time'];?>                                                      
			                                                            </td> 
			                                                            <td class="hidden-xs">&#x20B9; <?= floor(($x['ap_money']*100)/$charge); ?></td> 
			                                                            <td class="hidden-xs">
			                                                            	<?php
			                                                            		  $today      =   date('Y-m-d');
			                                                            		  if($x['ap_date']>$today)
			                                                            		  {
			                                                            		  	echo "--";
			                                                            		  }
			                                                            		  else{
			                                                            		  	if($x['ap_current_status']==0)
			                                                            		  	{
			                                                            		  		echo "--";
			                                                            		  	}
			                                                            		  	else if($x['ap_current_status']==1)
							                                                        {
							                                                            echo "Appointment Completed.";
							                                                        }
							                                                        else if($x['ap_current_status']==2)
							                                                        {
							                                                             echo "Appointment Incomplete.";
							                                                        }
			                                                            		  }
			                                                            	?>
			                                                            </td> 
			                                                        </tr>
			                                                    <?php
			                                                    }
			                                             	?>
			                                        </tbody>
			                                    </table>
                                    			<?php
                                    		}
                                    		else{
                                    			?>
                                    				<div class="alert alert-success">No appointments found on <?= date("d-M, Y",strtotime($this->uri->segment(4)));?> </div>
                                    			<?php
                                    		}
                                    	?>
                                    </div>                                   
                                </div>
                            </div>         
                        </div>
                         
                    </div>
                </div>
            </div>
           <?php
           		include('includes/footer.php');
           ?>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="<?= base_url('assets/health/');?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="<?= base_url('assets/health/');?>assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="<?= base_url('assets/health/');?>assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="<?= base_url('assets/health/');?>assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets/health/');?>assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?= base_url('assets/health/');?>assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url('assets/health/');?>assets/js/demo.js"></script>
<Script>
	 function findappointments(){
        var ap_date     =   $('#datepicker').val();
        if(ap_date=='')
        {
            alert('Select a date first');
        }
        else{
            location.href="<?= base_url('health/docappointment/'.$this->uri->segment(3).'/');?>"+ap_date;
        }
       }
       function findappointmentsbymonth(){
		    var year = $("#year").val();
		    var month = $("#month").val();
		    location.href="<?= base_url('Health/findappointmentsbymonth/'.$this->uri->segment(3));?>?y="+year+"&m="+month;
		}
</script>
</html>
 
     