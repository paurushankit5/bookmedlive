<?php
    $timings    =   $array['timings'];
   
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
                                      
                                    <form method="post" action= "<?= base_url('Diagnosis/updatetimings');?>" class="form form-horizontal">
                                        <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><b>Choose Available Days</b></label>
                                            <br>
                                             
                                            <label><input type="checkbox" name="mon"  <?php if($timings!=Null && $timings["mon"] == '1'){echo "checked"; } ?> value="1"> Mon </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox" <?php if($timings!=Null && $timings["tue"] == '1'){echo "checked"; } ?>  name="tue" value="1"> Tue </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox" <?php if($timings!=Null && $timings["wed"] == '1'){echo "checked"; } ?>  name="wed" value="1"> Wed </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox"  <?php if($timings!=Null && $timings["thu"] == '1'){echo "checked"; } ?> name="thu" value="1"> Thu </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox"  <?php if($timings!=Null && $timings["fri"] == '1'){echo "checked"; } ?> name="fri" value="1"> Fri </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox"  <?php if($timings!=Null && $timings["sat"] == '1'){echo "checked"; } ?> name="sat" value="1"> Sat </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input type="checkbox"  <?php if($timings!=Null && $timings["sun"] == '1'){echo "checked"; } ?> name="sun" value="1"> Sun </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <hr>
                                        </div>
                                        <div class="form-group">
                                             <div class="col-sm-3">
                                                <label>Morning Start Time</label>
                                                <select class="form-control" name="path_morning_start"  >
                                             
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
                                                        <option <?php if($timings!=Null && $time == $timings["path_morning_start"]){echo "selected"; }else if($time=="07:00:00" && $timings==Null){echo "selected";    }?> >
                                                            <?= $time;?>                                                         
                                                        </option>";
                                                        <?php 
                                                        $sec+=1800;
                                                        
                                                    }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Morning End Time</label>
                                                <select class="form-control" name="path_morning_end"  >
                                             
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
                                                        <option <?php if($timings!=Null && $time == $timings["path_morning_end"]){echo "selected"; }else if($time=="12:00:00" && $timings==Null){echo "selected";    }?> >
                                                            <?= $time;?>                                                         
                                                        </option>";
                                                        <?php 
                                                        $sec+=1800;
                                                        
                                                    }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Evening Start Time</label>
                                                <select class="form-control" name="path_evening_start"  >
                                             
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
                                                        <option <?php if($timings!=Null && $time == $timings["path_evening_start"]){echo "selected"; }else if($time=="15:00:00" && $timings==Null){echo "selected";    }?> >
                                                            <?= $time;?>                                                         
                                                        </option>";
                                                        <?php 
                                                        $sec+=1800;
                                                        
                                                    }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Evening End Time</label>
                                                <select class="form-control" name="path_evening_end"  >
                                             
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
                                                        <option <?php if($timings!=Null && $time == $timings["path_evening_end"]){echo "selected"; }else if($time=="20:00:00" && $timings==Null){echo "selected";    }?> >
                                                            <?= $time;?>                                                         
                                                        </option>";
                                                        <?php 
                                                        $sec+=1800;
                                                        
                                                    }
                                                ?>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <br>
                                            <input type="submit" class="btn btn-primary">
                                        </div>
                                    </form> 
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
</body>


</html>
 