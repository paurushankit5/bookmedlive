<?php
    $timings    =   $array['timings'];
   /* echo "<pre>";
    print_r($timings);
    echo "</pre>";*/
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?= $_SESSION['user']['user_name'];?> Timings</title>
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
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
     
	
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Timings Table</h4>
                                    <p class="category">Update your OPD Timings</p>
                                </div>
                                <div class="card-content table-responsive">
                                    <?php
                                        if($this->session->flashdata('timingmsg'))
                                            echo $this->session->flashdata('timingmsg');
                                    ?>
                                    <table class="table table-striped table-condensed">
                                        <thead class="text-primary">
                                            <th>Opening days</th>
                                            <th colspan="2">OPD Morning Hours</th>
                                            <th colspan="2">OPD Evening Hours</th>
                                             <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <td colspan="6">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-2">Morning Start Time</div>
                                                <div class="col-sm-2">Morning End Time</div>
                                                <div class="col-sm-2">Evening Start Time</div>
                                                <div class="col-sm-2">Evening End Time</div>
                                                <div class="col-sm-2"></div>
                                            </td>
                                            <?php

                                                for($i=1;$i<=7;$i++){
                                                    if($i==1){
                                                        $day = "mon";
                                                    }
                                                    else if($i==2){
                                                        $day = "tue";
                                                    }
                                                    else if($i==3){
                                                        $day = "wed";
                                                    }
                                                    else if($i==4){
                                                        $day = "thu";
                                                    }
                                                    else if($i==5){
                                                        $day = "fri";
                                                    }
                                                    else if($i==6){
                                                        $day = "sat";
                                                    }
                                                    else if($i==7){
                                                        $day = "sun";
                                                    }
                                                    ?>
                                                        <tr>
                                                            <td colspan="6">
                                                                 <form method="post" action="<?= base_url('health/updatetimings');?>"> 
                                                                <div class="col-sm-2">
                                                                    <?= ucwords($day);?> <br>
                                                                    <label><input type="radio" <?php if($timings==Null || $timings[$day]==1){echo "checked";}?>  onClick="enable(this);" value="1" name="<?= $day;?>" id="<?= $day;?>"/> Open</label>
                                                                    <label><input type="radio" <?php if($timings[$day]==0 && $timings !=Null){echo "checked";}?>  value="0" onClick="disable(this);" name="<?= $day;?>" id="<?= $day;?>"/> Closed</label>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control" name="morning_start" <?php if($timings[$day]==0 && $timings!=Null) {echo "disabled"; echo " style='color:white;'";} ?> >
                                                                 
                                                                    <?php
                                                                        $sec= 0;
                                                                        while($sec<=86400)
                                                                        {
                                                                            //echo "sec ".$sec;
                                                                            $hr = floor($sec/3600);
                                                                            $min = floor($sec-($hr*3600))/60;
                                                                            if($hr<10)
                                                                            {
                                                                                $hr =  "0".$hr;
                                                                            }
                                                                            if($min<10)
                                                                            {
                                                                                $min = "0".$min;
                                                                            } 
                                                                            $time = $hr.":".$min.":00";
                                                                            ?>
                                                                            <option <?php if($timings!=Null && $time == $timings[$day."_morning_start"]){echo "selected"; echo " true";}else if($time=="07:00:00" && $timings==Null){echo "selected"; echo " fasle"; }?> >
                                                                                <?= $time;?>                                                         
                                                                            </option>";
                                                                            <?php 
                                                                            $sec+=1800;
                                                                            
                                                                        }
                                                                    ?>
                                                                  </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control" name="morning_end" <?php if($timings[$day]==0 && $timings!=Null) {echo "disabled"; echo " style='color:white;'";} ?>>
                                                                 
                                                                    <?php
                                                                        $sec= 0;
                                                                        while($sec<=86400)
                                                                        {
                                                                            //echo "sec ".$sec;
                                                                            $hr = floor($sec/3600);
                                                                            $min = floor($sec-($hr*3600))/60;
                                                                            if($hr<10)
                                                                            {
                                                                                $hr =  "0".$hr;
                                                                            }
                                                                            if($min<10)
                                                                            {
                                                                                $min = "0".$min;
                                                                            } 
                                                                            $time = $hr.":".$min.":00";
                                                                            ?>
                                                                            <option <?php if($timings!=Null && $time == $timings[$day."_morning_end"]){echo "selected"; echo " true";}else if($time=="13:00:00" && $timings==Null){echo "selected"; echo " fasle"; }?> >
                                                                                <?= $time;?></option>";
                                                                            <?php 
                                                                            $sec+=1800;
                                                                            
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control" name="evening_start" <?php if($timings[$day]==0 && $timings!=Null) {echo "disabled"; echo " style='color:white;'";} ?>>
                                                                 
                                                                    <?php
                                                                        $sec= 0;
                                                                        while($sec<=86400)
                                                                        {
                                                                            //echo "sec ".$sec;
                                                                            $hr = floor($sec/3600);
                                                                            $min = floor($sec-($hr*3600))/60;
                                                                            if($hr<10)
                                                                            {
                                                                                $hr =  "0".$hr;
                                                                            }
                                                                            if($min<10)
                                                                            {
                                                                                $min = "0".$min;
                                                                            } 
                                                                            $time = $hr.":".$min.":00";
                                                                            ?>
                                                                            <option <?php if($timings!=Null && $time == $timings[$day."_evening_start"]){echo "selected"; echo " true";}else if($time=="15:00:00" && $timings==Null){echo "selected"; echo " fasle"; }?> >
                                                                                <?= $time;?></option>";
                                                                            <?php 
                                                                            $sec+=1800;
                                                                            
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control" name="evening_end" <?php if($timings[$day]==0 && $timings!=Null) {echo "disabled"; echo " style='color:white;'"; } ?>>
                                                                 
                                                                    <?php
                                                                        $sec= 0;
                                                                        while($sec<=86400)
                                                                        {
                                                                            //echo "sec ".$sec;
                                                                            $hr = floor($sec/3600);
                                                                            $min = floor($sec-($hr*3600))/60;
                                                                            if($hr<10)
                                                                            {
                                                                                $hr =  "0".$hr;
                                                                            }
                                                                            if($min<10)
                                                                            {
                                                                                $min = "0".$min;
                                                                            } 
                                                                            $time = $hr.":".$min.":00";
                                                                            ?>
                                                                            <option <?php if($timings!=Null && $time == $timings[$day."_evening_end"]){echo "selected"; echo " true";}else if($time=="21:00:00" && $timings==Null){echo "selected"; echo " fasle"; }?> >
                                                                                <?= $time;?></option>
                                                                            <?php 
                                                                            $sec+=1800;
                                                                            
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                     <button class="btn btn-primary">Submit</button>
                                                                </div>
                                                               </form>
                                                        
                                                                
                                                            
                                                            
                                                    <?php
                                                }
                                            ?>
                                            
                                                 
                                            </tr>
                                             
                                            
                                        </tbody>
                                    </table>
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

</html>
<script type="text/javascript">
    function disable(n){
        $(n).parent().parent().next().find('select').attr( "disabled", "disabled" ).css("color","white");
        $(n).parent().parent().next().next().find('select').attr( "disabled", "disabled" ).css("color","white");
        $(n).parent().parent().next().next().next().find('select').attr( "disabled", "disabled" ).css("color","white");
        $(n).parent().parent().next().next().next().next().find('select').attr( "disabled", "disabled" ).css("color","white");
    }
    function enable(n){
        $(n).parent().parent().next().find('select').removeAttr( "disabled" ).css("color","black");
        $(n).parent().parent().next().next().find('select').removeAttr( "disabled").css("color","black");
        $(n).parent().parent().next().next().next().find('select').removeAttr( "disabled" ).css("color","black");
        $(n).parent().parent().next().next().next().next().find('select').removeAttr( "disabled" ).css("color","black");
    }
</script>