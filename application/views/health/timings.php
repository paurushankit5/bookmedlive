<?php
    $timings    =   $array['timings'];
    /*echo "<pre>";
    print_r($timings);
    echo "</pre>";*/
    $count = count($timings);
   // exit();
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
    <style>
        .red{
            color:red;
            font-weight: bold;
        }
    </style>  
	
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
                                    <table class="table table-responsive">
                                        <tbody>
                                            <th>Day</th>
                                            <th>Morning Shift</th>
                                            <th>Evening Shift</th>
                                            <th>Actions</th>
                                        
                                        
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
                                                            <th><?= ucwords($day);?></th>
                                                            <td>
                                                                <?php
                                                                    if(!$count || $timings[$day."_morning_start"]=='00:00:00')
                                                                    {
                                                                        $mor = "closed";
                                                                       echo "<span class='red'>Closed</span>";
                                                                        $mor_start_1 = "08:00:00";
                                                                        $mor_end_1   = "13:00:00";
                                                                    }
                                                                    else if($timings[$day."_morning_start"]!='') {
                                                                       echo "<span class='text text-primary'><b>";
                                                                        echo date("g:i a", strtotime($timings[$day."_morning_start"])); 
                                                                        echo " - ";
                                                                        echo date("g:i a", strtotime($timings[$day."_morning_end"]));
                                                                        echo "</b></span>";
                                                                        $mor= "open";
                                                                        $mor_start_1 = $timings[$day."_morning_start"];
                                                                        $mor_end_1   = $timings[$day."_morning_end"];

                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if(!$count || $timings[$day."_evening_start"]=='00:00:00')
                                                                    {
                                                                        echo "<span class='red'>Closed</span>";
                                                                        $eve  =     "closed";
                                                                        $eve_start_1 = "16:00:00";
                                                                        $eve_end_1   = "21:00:00";

                                                                    }
                                                                    else if($timings[$day."_morning_start"]!='') {
                                                                       echo "<span class='text text-primary'><b>";
                                                                        echo date("g:i a", strtotime($timings[$day."_evening_start"])); 
                                                                        echo " - ";
                                                                        echo date("g:i a", strtotime($timings[$day."_evening_end"]));
                                                                        echo "</b></span>";
                                                                        $eve= "open";
                                                                        $eve_start_1 = $timings[$day."_evening_start"];
                                                                        $eve_end_1   = $timings[$day."_evening_end"];
                                                                    } 
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary"   onClick="showeditmodal('<?= $day; ?>','<?= $mor;?>','<?= $eve; ?>','<?= $mor_start_1;?>','<?= $mor_end_1;?>','<?= $eve_start_1;?>','<?= $eve_end_1;?>');"><i class="fa fa-pencil"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                    <br>
                                     
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
    function showeditmodal(day,mor,eve,mor_start_1,mor_end_1,eve_start_1,eve_end_1){
       // alert(mor_end_1);
        $('#presentday').val(day);
        $('#timemodal').modal('toggle'); 
        if(mor=="open")
        {
            $('.openmor').prop("checked",true);
            changemorning('1');
        }
        else{
            $('.closedmor').prop("checked",true);
            changemorning('0');
        }
        if(eve=="open")
        {
            $('.openeve').prop("checked",true);
            changeevening('1');
        }
        else{
            $('.closedeve').prop("checked",true);
            changeevening('0');
        }
        if(mor=='closed' && eve =="closed")
        {
           changestatus(0);
           $('.closed').prop("checked",true);
        }
        $('.mor_start').val(mor_start_1).change();
        $('.mor_end').val(mor_end_1).change();
        $('.eve_start').val(eve_start_1).change();
        $('.eve_end').val(eve_end_1).change();
        //$('.mor_start option[value=mor_start_1]').attr("selected", "selected");
        //$('.mor_end option[value=mor_end_1]').attr("selected", "selected");
        //$('.eve_start option[value=eve_start_1]').attr("selected", "selected");
        //$('.eve_end option[value=eve_end_1]').attr("selected", "selected");
    }
    function changestatus(a)
    { 
        changeevening(a);
        changemorning(a);
        if(a=='0')
        {             
              $('.closedeve').prop("checked",true);
              $('.closedmor').prop("checked",true);
        }
        else if (a=='1')
        { 
           $('.openmor').prop("checked",true);
           $('.openeve').prop("checked",true);
        }
    }
    function changeevening(a){
        if(a=='0')
        {             
            $('.eve').attr( "disabled", "disabled" ).css("color","white");
            //$('.closed').prop("checked",true);
        }
        else if (a=='1')
        { 
            $('.eve').removeAttr( "disabled" ).css("color","black");
             $('.open').prop("checked",true);
        }
    }
    function changemorning(a){
        if(a=='0')
        {             
            $('.mor').attr( "disabled", "disabled" ).css("color","white");
             //$('.closed').prop("checked",true);
        }
        else if (a=='1')
        { 
            $('.mor').removeAttr( "disabled" ).css("color","black");
             $('.open').prop("checked",true);
        }
    }
</script>
 

<!-- Modal -->
<div id="timemodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >

    <!-- Modal content-->
    <div class="modal-content">
      <form class="form form-horizontal" method="post" action="<?= base_url('Health/storetimings');?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add / Edit Timings</h4>
      </div>
      <div class="modal-body">
            <div class="col-md-12">
                
                    <input type="hidden" name="presentday" id="presentday">
                    <table class="table table-responsive table-bordered">
                        <tr>
                            <td colspan="2">
                                    <b><b></b></b>
                                    <label><input type="radio" name="working_day" class="open" onClick="changestatus(1);"   value="0">Open</label>
                                    <label><input type="radio" name="working_day" class="closed" onClick="changestatus(0);"   value="1">closed</label>
                                 
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Morning Shift
                                <br>
                                <label><input type="radio" name="morning_day" class="openmor" onClick="changemorning(1);"   value="0">Open</label>
                                <label><input type="radio" name="morning_day" class="closedmor" onClick="changemorning(0);"   value="1">closed</label>
                            </th>
                            <td>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control mor mor_start " name="morning_start" >
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
                                               $time2 =  date("g:i A", strtotime($time));
                                                ?>
                                                <option value="<?= $time; ?>">
                                                    <?= $time2;?>                                                         
                                                </option>";
                                                <?php 
                                                $sec+=1800;
                                                
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <select class="form-control mor mor_end" name="morning_end">
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
                                             $time2 =  date("g:i A", strtotime($time));
                                            ?>
                                            <option value="<?= $time; ?>" >
                                                <?= $time2;?>                                                         
                                            </option>";
                                            <?php 
                                            $sec+=1800;
                                            
                                        }
                                    ?>
                                    </select>   
                                    </div>
                                </div>
                            </td>
                        </tr>
                           <tr>
                            <th>
                                Evening Shift
                                <br>
                                <label><input type="radio" name="evening_day" class="openeve" onClick="changeevening(1);"   value="0">Open</label>
                                <label><input type="radio" name="evening_day" class="closedeve" onClick="changeevening(0);"   value="1">closed</label>
                            </th>
                            <td>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control eve eve_start" name="evening_start">
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
                                                 $time2 =  date("g:i A", strtotime($time));
                                                ?>
                                                <option value="<?= $time; ?>">
                                                    <?= $time2;?>                                                         
                                                </option>";
                                                <?php 
                                                $sec+=1800;
                                                
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <select class="form-control eve eve_end" name="evening_end">
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
                                             $time2 =  date("g:i A", strtotime($time));
                                            ?>
                                            <option value="<?= $time; ?>" >
                                                <?= $time2;?>                                                         
                                            </option>";
                                            <?php 
                                            $sec+=1800;
                                            
                                        }
                                    ?>
                                    </select>   
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                     
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"  >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>