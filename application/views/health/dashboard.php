<?php
    $ap     =   $array['ap'];
    $monapp =   $array['monrev'];
    $m      =   date('m');
    $y      =   date('q');
    
    $date   =   date('Y-m-d');
    if($count =count($monapp))
    {
        //echo "<pre>";
        $daterange = '';
        $moneyrange = '';
        $high = 5;
        $total  =0;
        $upcoming   =0;
        $i=1;
        $today = 0;
        foreach($monapp as $x)
        {
             
            if($x['number']>$high)
            {
                $high = $x['number'];
            }

            $moneyrange .= ", '".$x['number']."'";
            $daterange .= ", '".date('d',strtotime($x['date']))."'";
            $total    = $total+$x['number'];
            if($date        ==  date('Y-m-d',strtotime($x['date'])))
            {
                $today      =   $x['number'];
            }

             if($date <  date('Y-m-d',strtotime($x['date'])))
            {
                $upcoming      =$upcoming +   $x['number'];
            }

            if($i==1)
            {
                $moneyrangemobile['1st-10th'] = 0; 
            }
            if($i==11)
            {
                $moneyrangemobile['11th-20th'] = 0; 
            }
            if($i==21)
            {
                $moneyrangemobile['21st & Above'] = 0; 
            }
         
            
            if($i<=10)
            {
                $moneyrangemobile ['1st-10th']  +=$x['number'];
            }
            if($i<=20 && $i>11)
            {
                $moneyrangemobile ['11th-20th']  +=$x['number'];
            }
            if($i<=31 && $i>20)
            {
                $moneyrangemobile ['21st & Above']  +=$x['number'];
            }
            
            //print_r($moneyrangemobile);
            //print_r($x);
            $i++;

        }
        $moneyrange2   = '';
        $daterange2    = '';
        if(count($moneyrangemobile))
        {
            foreach ($moneyrangemobile as $mobile => $val) {
                
                $moneyrange2 .= ", '".$val."'";
                $daterange2 .= ", '".$mobile."'";
            }
        }
        $daterange = substr($daterange,1);
        $moneyrange = substr($moneyrange,1);
        $daterange2 = substr($daterange2,1);
        $moneyrange2 = substr($moneyrange2,1);
       /* echo "<pre>";
        print_r($moneyrangemobile);
        print_r($monapp);
        exit();*/
        
         
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>/assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>My Dashboard</title>
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
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">date_range</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Today</p>
                                    <h3 class="title"><?= $today; ?>
                                         
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-danger">date_range</i>
                                         Today's Appointments 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">date_range</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Upcoming</p>
                                    <h3 class="title"><?= $upcoming; ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> Upcoming Appointments
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="red">
                                    <i class="material-icons">date_range</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Month</p>
                                    <h3 class="title"><?= $total ;?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i>  This Month Appointments
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                    </div> 
                    <div class="row">
                         
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-chart" data-background-color="orange">
                                    <div class="ct-chart hidden-xs hidden-sm" style="height:300px;" id="emailsSubscriptionChart"></div>
                                    <div class="ct-chart hidden-md hidden-lg" style="height:300px;" id="emailsSubscriptionChart2"></div>
                                </div>
                                <div class="card-content">
                                    <h4 class="title"> Appointments for the month of <?= date('M Y');?></h4>
                                     
                                </div>
                                
                            </div>
                        </div>
                       
                         
                    </div>
                    <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                            <div class="card">
                                <div class="card-content">
                                    <div class="col-md-6 col-sm-6  ">  
                                        <div class="form-group label-floating">                                        
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
                                    </div>
                                    <div class="col-md-6 col-sm-6">
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
                                        <button class="btn btn-warning btn-block" onClick="findappointments();"><i class="material-icons">search</i> Appointments</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="orange">
                                    <h4 class="title">Today's Appointments</h4>
                                    <p class="category">New Appointments on <?= date('d,M Y');?></p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-warning">
                                            
                                            <th>Doctor</th>
                                            <th>Patient</th>
                                            <th>Ap Details</th>
                                             
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(count($ap))
                                                {
                                                    foreach ($ap as $x) {
                                                    ?>
                                                        <tr>
                                                            <td><b><a href="<?= base_url('Health/docdetails/'.$x['ap_doctor_id']);?>">Dr. <?= $x['doctor_name'];?></a></b>
                                                            <?php
                                                                if($_SESSION['user']['user_type']=='3')
                                                                {
                                                                    echo "<br> ( ".$x['department_name'].")";
                                                                }

                                                            ?>
                                                            </td>   
                                                            <td><a href="<?= base_url('Patient/details/'.$x['ap_patient_id']);?>"><?= $x['patient_name'];?></a></td>   
                                                            <td>
                                                                <b><?= $x['ap_id'];?></b><br>
                                                                <span>
                                                                        <?php
                                                                         if($x['ap_shift']=='M'){
                                                                            echo "Morning Shift";
                                                                        }else{
                                                                            echo "Evening Shift"; 
                                                                        } 
                                                                        ?>
                                                                    </span>
                                                                <br>
                                                                <?= date("d,M Y",strtotime($x['ap_date']));?> 
                                                                <br>                                                     
                                                                <?= $x['ap_time'];?>                                                      
                                                            </td>   
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                else{
                                                    ?>
                                                        <tr>
                                                            <td colspan="3">No appointments for today.</td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                             
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
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
        demo2.initDashboardPageCharts();

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
            high: '<?= $high+30; ?>',
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
demo2 = {
     

    
    initDashboardPageCharts: function() {

       
        /* ----------==========     Emails Subscription Chart initialization    ==========---------- */

        var dataEmailsSubscriptionChart = {
         labels: [<?= $daterange2; ?>],
            series: [
                [<?= $moneyrange2; ?>]

            ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: '<?= $high+30; ?>',
            chartPadding: {
                top: 0,
                right: 5,
                bottom: 10,
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
        var emailsSubscriptionChart = Chartist.Bar('#emailsSubscriptionChart2', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);

    },
}
function findappointments(){
    var year = $("#year").val();
    var month = $("#month").val();
    location.href="<?= base_url('Health/findmonthappointments');?>?y="+year+"&m="+month;
}
</script>

</html>