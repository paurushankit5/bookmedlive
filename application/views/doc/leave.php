<?php
    $vacations    =   $array['vacations'];
  
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: My Leave Days</title>
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
        var $j = $.noConflict();
        $j(function() {
            $j( "#datepicker" ).datepicker({
                minDate: 0, maxDate: "+3M",
                dateFormat: 'yy-mm-dd',
                 
            });
            $j( "#datepicker2" ).datepicker({
                minDate: 0, maxDate: "+3M",
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
                        <div class="col-md-8 col-md-offset-2">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">My Leave Days</h4>
                                    <p class="category">Apply for Leaves</p>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('vacmsg'))
                                        {
                                            echo $this->session->flashdata('vacmsg');
                                        }                
                                      ?>
                                      
                                    <form class="form-horizontal" method="post" action="<?= base_url('Doc/storevacations');?>">
                                       <div class="form-group" id="section1">
                                           <div class="col-sm-6">
                                            <label for="datepicker">Select Start Date</label>
                                            <input type = "text" id = "datepicker" name="start_date" class="form-control" placeholder="Start Date (YYYY-MM-DD)">
                                          </div>
                                          <div class="col-sm-6">
                                            <label for="datepicker2">Select End Date</label>
                                            <input type = "text" id = "datepicker2" name="end_date" class="form-control" placeholder="End Date (YYYY-MM-DD)">
                                          </div>
                                          
                                        </div>
                                        
                                         
                                        <br>
                                         <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                    </form> 
                                </div>
                            </div>
                            <?php
                                if(count($vacations))
                                {
                                  $today  =  date('Y-m-d');
                                    ?>
                                        <div class="card">
                                            <div class="card-header" data-background-color="red">
                                                <h4 class="title">My Leave Days</h4>
                                                <p class="category">Applied Leaves</p>
                                            </div>
                                            <div class="card-content">
                                                
                                                <?php
                                                    foreach ($vacations as $x) {
                                                      $class='';
                                                      if($today >= $x['vacation_date'])
                                                      {
                                                        $class ="hidden";
                                                      }
                                                       ?>
                                                       <div class="col-sm-4" style="padding: 10px 20px;box-shadow:5px 5px #888888; margin-bottom: 20px;">
                                                        <?= date('d-M-y',strtotime($x['vacation_date']));?>
                                                       <i class="fa fa-times  pull-right <?= $class; ?>" onClick="cancelmodal('<?= $x['vacation_id'];?>');" aria-hidden="true"></i>

                                                      </div>
                                                       <?php
                                                    }
                                                ?>
                                                </table>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                           
                              
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
     function cancelmodal(str){
        $('#del_id').val(str);
        $('#cancelleavemodal').modal('toggle');
     }
     function cancelleave(){
        var vacation_id =   $('#del_id').val();
        if(vacation_id!='')
        {
            $.ajax({
                type    :   "POST",
                url     :   "<?= base_url('Doc/cancelleave');?>",
                data    :   {
                                'vacation_id'   :   vacation_id,
                },
                beforeSend  : function(){
                    $('#loadingDiv').show();
                },
                success : function (data)
                {
                    location.reload();
                }

            });
        }
        else{
             $('#cancelleavemodal').modal('toggle');
        }
     }
 </script>
<div id="cancelleavemodal" class="modal fade modal-xs" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        Do you really want to cancel this leave?
        <input type="hidden" id="del_id"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onClick="cancelleave();">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 
