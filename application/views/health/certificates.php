<?php
    $certi  =   $array['certi'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Edit Profile</title>
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
        .label-floating img{
            height:250px;
            border:1px solid gray;
            border-radius: 10px;
        }
        .card img{
            height:200px;
            width:auto;
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
                            <?php
                                if($this->session->flashdata('certimsg'))
                                    echo $this->session->flashdata('certimsg');
                                
                                if($this->session->flashdata('profilemsg')){
                                            echo $this->session->flashdata('profilemsg');
                                        }
                                    ?>
                            <div class="card showcard" >
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Certificates
                                    <button class="btn btn-warning pull-right" onclick="showeditbox();"><i class="fa fa-pencil"></i></button>
                                    </h4>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <table class="table table-responsive">
                                        <tr>
                                            <td><b>Registerd Name</b></td>
                                            <td><?php if($certi['clinic_reg_name']!=''){echo $certi['clinic_reg_name'];} ?> </td>
                                        </tr>
                                        <tr>
                                            <td><b>Logo</b></td>
                                            <td>
                                                <?php
                                                        if($certi['clinic_logo']=='')
                                                        {
                                                            echo "N/A";
                                                        }else{
                                                            ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/logo/'.$certi['clinic_logo']);?>" class="img img-responsive" alt=" Logo">
                                                            <?php
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Registration Proof</b></td>
                                            <td>
                                                 <?php
                                                    if($certi['clinic_reg_proof']=='')
                                                    {
                                                        echo "N/A";
                                                    }else{
                                                          ?>
                                                            <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/reg/'.$certi['clinic_reg_proof']);?>" class="img img-responsive" alt="Reg Proof">
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Prescription Pad</b></td>
                                            <td>
                                                <?php
                                                        if($certi['clinic_pres_pad']=='')
                                                        {
                                                            echo "N/A";
                                                        }else{
                                                             ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/pad/'.$certi['clinic_pres_pad']);?>" id="pad" onClick="$('#clinic_pres_pad').click();" class="img img-responsive" alt=" Pad">
                                                            <?php
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card editcard" style="display: none;">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Certificates</h4>
                                </div>
                                <div class="card-content">
                                
                                    
                                    <form method="post" enctype="multipart/form-data" action="<?= base_url('Health/updatecerti');?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Registered Name: </label>
                                                    <input type="text" required name="clinic_reg_name" value="<?php if($certi['clinic_reg_name']!=''){echo $certi['clinic_reg_name'];} ?>"  class="form-control" >
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="file" accept="image/*" style="display:none;" id="clinic_logo" name="clinic_logo" onchange="readURL(this,'logo');" name="clinic_logo"   class="form-control" >
                                                    <?php
                                                        if($certi['clinic_logo']=='')
                                                        {
                                                            ?>
                                                                <img src="<?= base_url('img/hoslogo.png');?>" id="logo" onClick="$('#clinic_logo').click();" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/logo/'.$certi['clinic_logo']);?>" id="logo" onClick="$('#clinic_logo').click();" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }
                                                    ?>
                                                    <br>
                                                    <center><a href="#" onClick="$('#clinic_logo').click();"><b>Upload Logo</b></a></center>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="file" style="display:none;" onchange="readURL(this,'proof');" id="clinic_reg_proof" name="clinic_reg_proof"   class="form-control" >
                                                    <?php
                                                        if($certi['clinic_reg_proof']=='')
                                                        {
                                                            ?>
                                                                <img src="<?= base_url('img/reg.png');?>" id="proof" onClick="$('#clinic_reg_proof').click();" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }else{
                                                              ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/reg/'.$certi['clinic_reg_proof']);?>" id="proof" onClick="$('#clinic_reg_proof').click();" class="img img-responsive" alt="Reg Proof">
                                                            <?php
                                                        }
                                                    ?>
                                                    <br>
                                                    <center><a href="#" onClick="$('#clinic_reg_proof').click();"><b>Upload Registration Proof</b></a></center>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="file" style="display:none;" onchange="readURL(this,'pad');" id="clinic_pres_pad" name="clinic_pres_pad"   class="form-control" >
                                                    <?php
                                                        if($certi['clinic_pres_pad']=='')
                                                        {
                                                            ?>
                                                                <img src="<?= base_url('img/pad.png');?>" id="pad" onClick="$('#clinic_pres_pad').click();" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }else{
                                                             ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/pad/'.$certi['clinic_pres_pad']);?>" id="pad" onClick="$('#clinic_pres_pad').click();" class="img img-responsive" alt=" Pad">
                                                            <?php
                                                        }
                                                    ?>
                                                    <br>
                                                    <center><a href="#" onClick="$('#clinic_pres_pad').click();"><b>Upload Prescription Pad </b></a></center>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <input type="file" style="display:none;"" onchange="readURL(this,'waste');" id="clinic_waste_disposal" name="clinic_waste_disposal"   class="form-control" >
                                                    <?php
                                                        if($certi['clinic_waste_disposal']=='')
                                                        {
                                                            ?>
                                                                <img src="<?= base_url('img/waste.png');?>" onClick="$('#clinic_waste_disposal').click();" id="waste" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }else{
                                                             ?>
                                                                <img src="<?= base_url('images/user/'.$_SESSION['user']['id'].'/waste/'.$certi['clinic_waste_disposal']);?>" id="waste" onClick="$('#clinic_waste_disposal').click();" class="img img-responsive" alt="Clinic Logo">
                                                            <?php
                                                        }
                                                    ?>
                                                    <br>
                                                    <center><a href="#" onClick="$('#clinic_waste_disposal').click();"><b>Upload Waste Disposal Certificate</b></a></center>
                                                </div>
                                            </div>
                                            
                                         
                                        <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                               		    </div>
                                        <div class="clearfix"></div>
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
<script>
   // jq  =   jQuery.noConflict();
     function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

    function showeditbox(){
        $('.showcard').fadeOut();
        $('.editcard').fadeIn();
    }
</script>
</html>
 
 