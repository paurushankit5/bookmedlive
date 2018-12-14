<?php

	$monrev 	=	$array['monrev'];
	$m 		 	=	$array['m'];
	$y 		 	=	$array['y'];
  $settings   = $array['settings'];
  $charge     = (100+$settings['settings_service_charge']+($settings['settings_service_charge']*$settings['settings_gst']/100));
	if($count =count($monrev))
	{
		//echo "<pre>";
		$daterange = '';
		$moneyrange = '';
		$high = 1000;
		$total  =0;
		foreach($monrev as $x)
		{
			if($x['ap_money']=='')
			{
				$x['ap_money'] = 0;
			}
      else{
        $x['ap_money']  = floor(($x['ap_money']*100)/$charge);
      }
			if($x['ap_money']>$high)
			{
				$high = $x['ap_money'];
			}
			$moneyrange .= ", '".$x['ap_money']."'";
			$daterange .= ", '".date('d',strtotime($x['date']))."'";
			$total    = $total+floor(($x['ap_money']*100)/$charge);
		}
		$daterange = substr($daterange,1);
		$moneyrange = substr($moneyrange,1);
		//echo $daterange."<br>";
		//echo $moneyrange;
	}
	//exit();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>/assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Doctor Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?= base_url('assets/health/');?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?= base_url('assets/health/');?>/assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?= base_url('assets/health/');?>/assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="wrapper">
        <?php
            include('includes/sidebar.php');
        ?>
        <div class="main-panel">
            <?php
                include('includes/header.php');
            ?> 
            <div class="content">
                <div class="container-fluid">
                    
                     
                    <div class="row">
                        
                        <div class="col-md-12">

                            <div class="card">

                                <div class="card-header card-chart"  data-background-color="purple">
                                    <div class="ct-chart" style="height:500px;" id="emailsSubscriptionChart"></div>
                                </div>
                                <div class="card-content">
                                    <h4 class="title">My Revenue for the month of <b><?=date('M,Y',strtotime($monrev[1]['date']));?></b></h4>
                                   	
                                </div>
                                
                             
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                        	<div class="card">
                        		<div class="card-content">
                        			<div class="col-xs-6 ">                                   		 
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
                                   	<div class="col-xs-6">
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
                                   	<div class="col-sm-6 col-sm-offset-3">
                                   		<button class="btn btn-warning btn-block" onClick="findappointments();"><i class="material-icons">search</i> Find Appointments</button>
                                    </div>
                        		</div>
                        	</div>
                        </div> 
                            <div class="card">

                                <div class="card-header"  data-background-color="purple">
                                     
                                </div>
                                <div class="card-content">
                                   <?php
                                   	$half = ceil($count/2);
                                   	?>
                                   	<div class="col-sm-6">
                                   	<table class="table table-responsive table-condensed table-striped">
                                   	<?php 
                                   	$i=1;
                                   	foreach($monrev as $x)
                                   	{

                                   		if($i<=$half)
                                   		{
                                   			if($x['ap_money']=='')
                  											{
                  												$x['ap_money'] = 0;
                  											}
                                        else{
                                          $x['ap_money']  = floor(($x['ap_money']*100)/$charge);
                                        }
                                   			?>
                                   				<tr>                                   					
                                   					<th> <?= date('d,M y',strtotime($x['date']));?></th>
                                   					<th>&#x20B9; <?= $x['ap_money'];?></th>
                                   				</tr>
                                   			<?php
                                   		}
                                   		$i++;
                                   	}
                                   	?>
                                   	</table>
                                   </div>
                                   <div class="col-sm-6">
                                   	<table class="table table-responsive table-condensed table-striped">
                                   	<?php 
                                   	$i=1;
                                   	foreach($monrev as $x)
                                   	{

                                   		if($i>$half)
                                   		{
                                   			if($x['ap_money']=='')
                  											{
                  												$x['ap_money'] = 0;
                  											}
                                        else{
                                          $x['ap_money']  = floor(($x['ap_money']*100)/$charge);
                                        }
                                   			?>
                                   				<tr>                                   					
                                   					<th> <?= date('d,M y',strtotime($x['date']));?></th>
                                   					<th>&#x20B9; <?= $x['ap_money'];?></th>
                                   				</tr>
                                   			<?php
                                   		}
                                   		$i++;
                                   	}
                                   	?>
                                   	<tr>
                                   		<th><h3 class="text-primary">Total:</h3></th>
                                   		<th><h3 class="text-primary"><b>&#x20B9; <?= $total;?></b></h3></th>
                                   	</tr>
                                   	</table>
                                   </div>
                                   	<?php
                                   ?>
                                   
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
<script src="<?= base_url('assets/health/');?>/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>/assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="<?= base_url('assets/health/');?>/assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="<?= base_url('assets/health/');?>/assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="<?= base_url('assets/health/');?>/assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets/health/');?>/assets/js/bootstrap-notify.js"></script>
 
<!-- Material Dashboard javascript methods -->
<script src="<?= base_url('assets/health/');?>/assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url('assets/health/');?>/assets/js/demo1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
  //  type = ['', 'info', 'success', 'warning', 'danger'];


demo = {
     

    
    initDashboardPageCharts: function() {

       
        /* ----------==========     Emails Subscription Chart initialization    ==========---------- */

        var dataEmailsSubscriptionChart = {
            labels: [<?= $daterange; ?>],
            series: [
                [<?= $moneyrange; ?>]

            ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: '<?= $high+500; ?>',
            chartPadding: {
                top: 0,
                right: 5,
                bottom: 0,
                left: 0
            }
        };
        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value[0];
                    }
                }
            }]
        ];
        var emailsSubscriptionChart = Chartist.Bar('#emailsSubscriptionChart', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart, responsiveOptions);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);

    },

     

     



}
function findappointments(){
	var year = $("#year").val();
	var month = $("#month").val();
	location.href="<?= base_url('Health/revenue/');?>"+year+"-"+month;
}
</script>

</html>