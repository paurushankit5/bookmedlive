<?php
    
    $ap    =   $array['ap'];
    $count =    $array['count']; 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: My Appointments</title>
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
                        <div class="col-md-12">
                             	<?php
                             		if($this->session->flashdata('apmsg'))
                             		{
                             			echo $this->session->flashdata('apmsg');
                             		}
                             	?>
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="card">
                                            <div class="card-header" data-background-color="purple">
                                                <h4 class="title">Find Appointments</h4>
                                                
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
                                    <?php
                                        if(count($ap))
                                        {
                                            ?>
                                           
                                                
                                            <?php
                                            foreach($ap as $x)
                                            {
                                                
                                                if($x['ap_shift']=='M')
                                                {
                                                    $cardclass= 'purple';
                                                }
                                                else{
                                                    $cardclass= 'blue';
                                                }
                                                if(date('Y-m-d') > $x['ap_date'])
                                                {
                                                    $cardclass = "red";
                                                }
                                                ?>
                                                     
                                                        <div class="row">
                                                        
                                                            <div class="card">
                                                            <div class="card-header" data-background-color="<?= $cardclass; ?>">
                                                                <h4 class="title">
                                                                    <b><?= $x['user_name'];?> (<?= $x['ap_id'];?>)
                                                                    <span class="pull-right">
                                                                        <?php
                                                                         if($x['ap_shift']=='M'){
                                                                            echo "Morning Shift";
                                                                        }else{
                                                                            echo "Evening Shift"; 
                                                                        } 
                                                                        ?>
                                                                    </span></b>
                                                                </h4>
                                                                <br> 
                                                            </div>
                                                            <div class="card-content"> 
                                                               
                                                        
                                                         <div class="col-md-8">
                                                            <h6>Date : <b><?= date('d,M Y',strtotime($x['ap_date']));?></b></h6>
                                                            <h6>Time : <b><?= $x['ap_time'];?></b></h6>
                                                            <h6>Booked On : <b><?= date('d,M Y',strtotime($x['created_at']));?></b></h6>
                                                         </div>
                                                         <div class="col-md-4">
                                                             <?php
                                                if($x['ap_status']  ==  2)
                                                {
                                                    echo "<h4>Cancelled by patient.</h4>";
                                                    
                                                }
                                                else if($x['ap_status'] ==  3)
                                                {
                                                    echo "<h4>Cancelled by You.</h4>";
                                                }
                                                else{
                                                    $today      =   date('Y-m-d');
                                                    $class1     =   '';
                                                    $class2     =   '';
                                                    if($x['ap_rescheduled'] ==1)
                                                    {
                                                        //$class2 = " hidden ";   
                                                    }
                                                    else if($x['ap_date']<$today)
                                                    {
                                                        $class1 = " hidden ";   
                                                        if($x['ap_current_status']==0)
                                                        {
                                                            if($today<= date("Y-m-d",strtotime($x['ap_date'])+86400))
                                                            {
                                                        ?>  
                                                            <span class= " <?= $class1; ?>">
                                                            <h4>Appointment Completed ?</h4>
                                                            
                                                            <button class="btn btn-primary" onclick="changestatus('<?= $x['ap_id'];?>',1);">Yes</button>
                                                            <button class="btn btn-danger" onclick="changestatus('<?= $x['ap_id'];?>',2);">No</button>
                                                          </span>
                                                    <?php   
                                                            }
                                                            else{
                                                                //echo "<h4>Status unknown</h4>"; 
                                                            }
                                                        }

                                                        else if($x['ap_current_status']==1)
                                                        {
                                                            echo "<h4>Appointment Completed.</h4>";
                                                        }
                                                        else if($x['ap_current_status']==2)
                                                        {
                                                             echo "<h4>Appointment Incomplete.</h4>";
                                                        }
                                                    }
                                                    else if($x['ap_date']==$today)
                                                    {
                                                        $time   =   date("H:i:s");
                                                        $time   =   explode(":",$time);
                                                        $time   =   ($time[0]*3600)+($time[1]*60)+($time[2]);
                                                        $maxlimit = $time + (4*3600);
                                                        //echo  $maxlimit ;     
                                                        $aptime     =   explode(" ",$x['ap_time']);
                                                        $aptime     =   $aptime[0];
                                                        $aptime     =   explode(":",$aptime);
                                                        $aptime     =   ($aptime[0]*3600)+($aptime[1]*60);
                                                        if($aptime<=$maxlimit)
                                                        {
                                                            $class1=        " hidden ";
                                                        }
                                                        if($aptime<$time)
                                                        {                                                       
                                                            if($x['ap_current_status']==0)
                                                            {
                                                            ?>
                                                                <h4>Appointment Completed ?</h4>
                                                                
                                                                <button class="btn btn-primary" onclick="changestatus('<?= $x['ap_id'];?>',1);">Yes</button>
                                                                <button class="btn btn-danger" onclick="changestatus('<?= $x['ap_id'];?>',2);">No</button>
                                                            <?php   
                                                            }
                                                            else if($x['ap_current_status']==1)
                                                            {
                                                                echo "<h4>Appointment Completed.</h4>";
                                                            }
                                                            else if($x['ap_current_status']==2)
                                                            {
                                                                 echo "<h4>Appointment Incomplete.</h4>";
                                                            }                                                        
                                                        }
                                                    }
                                                    ?>
                                                        <?php 
                                                        if($x['ap_rescheduled'] ==1)
                                                        {
                                                            echo "<h3>Rescheduled</h3>";    
                                                        }
                                                        if($x['ap_date'] < date('Y-m-d')){
                                                            $class1 =   "hidden";
                                                        }
                                                        ?>
                                                        <button class="btn btn-danger <?= $class1; ?>" style="width:140px;" onclick="cancelap('<?= $x['ap_id'];?>');">Cancel</button><br>
                                                        <a href="<?= base_url('Doc/reschedule/'.$x['ap_id']);?>" class="btn btn-warning <?= $class1; ?> <?= $class2; ?>" style="width:140px;">Reschedule</a>

                                                        
                                                    <?php
                                                }
                                                
                                            ?>
                                                         </div>
                                                         </div>
                                                         </div>
                                                    </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="row"><?= $this->pagination->create_links();?></div>
                                            <?php
                                            
                                        }
                                        else{
                                            ?>
                                            <div class="clearfix"></div>
                                            <div class="alert alert-warning">
                                                <p class="text text-center">Whoops!.... No Records found.</p>
                                            </div>
                                            <?php
                                        }
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
<script type="text/javascript">
        function cancelap(ap_id){
            $("#ap_cancel_id").val(ap_id);
            $("#cancelmodal").modal('toggle');
        }
        function cancelnow(){
            var ap_id   =   $("#ap_cancel_id").val();
            $.ajax({
                type    :   "POST",
                data    :   {
                                "ap_id" : ap_id,

                },
                url     :   "<?= base_url('Doc/cancel');?>",
                beforeSend  :   function(){$('.loadingDiv').show();},
                success     :   function(data){
                    location.reload();
                }
            });
        }
        
    </script>

    <div id="cancelmodal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="padding:20px;">
             
            <h4 class="modal-title">Are You sure</h4>
          </div>
          <div class="modal-body">
            <p>Do you really want to cancel this appointment? </p>
            <input type="hidden" id="ap_cancel_id"/>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="cancelnow();" >Yes</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>

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

</html>
<script>
    function changestatus(ap_id,str){
           var r = confirm("Are you sure ?");
           if(r == true)
           {
                $.ajax({
                    type    :   "POST",
                    data    :   {
                                    "ap_id"                 :   ap_id,
                                    "ap_current_status"     :   str,
                    },
                    url     :   "<?= base_url('Doc/changeapstatus');?>",
                    beforeSend : function(){$('.loadingDiv').show();},
                    success    : function(data){
                                $('.loadingDiv').hide();
                                 location.reload();   
                    }
                });
           } 
           else{

           }
       }
       function findappointments(){
        var ap_date     =   $('#datepicker').val();
        if(ap_date=='')
        {
            alert('Select a date first');
        }
        else{
            location.href="<?= base_url('doc/findappointments/');?>"+ap_date;
        }
       }
</script>
  