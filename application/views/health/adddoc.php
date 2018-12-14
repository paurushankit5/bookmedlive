<?php
    $class      =   "col-md-6";
    if($_SESSION['user']['user_type']==3)
    {
        $subdept    =   $array['subdept'];
        $class      =   "col-md-4";
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: Add Doctors</title>
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
                                                <h4 class="title">Add Doctors  <a href="<?= base_url('Health/doctors');?>" class="btn btn-info pull-right">View Doctors</a></h4>
                                                <p class="category">Provide basic details to your doctor</p>
                                            </div>
                                            <div class="card-content table-responsive">
                                                 <?php
                                                    if($this->session->flashdata('adddocmsg')){
                                                        echo $this->session->flashdata('adddocmsg');
                                                    }
                                                
                                                    if(validation_errors()){
                                                        echo "<div class='alert alert-danger'><p ><b>".validation_errors()."</b></p></div>";
                                                    }
                                                ?>
                                                <form method="post" action="<?= base_url('Health/storedoc');?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Email* </label>
                                                                <input type="text" value="<?php echo set_value('user_email'); ?>"     class="form-control" name="user_email" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Name*</label>
                                                                <input type="text" name="user_name" required value="<?php echo set_value('user_name'); ?>"  class="form-control">
                                                            </div>
                                                        </div>                                                         
                                                    </div>
                                                     <div class="row">
                                                        <div class="<?= $class; ?>">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Mobile* </label>
                                                                <input type="text" required  pattern="[0-9]{10}" maxlength="10"  value="<?php echo set_value('user_mob'); ?>"    class="form-control" required name="user_mob">
                                                            </div>
                                                        </div>
                                                        <div class="<?= $class; ?>">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Alternate Contact</label>
                                                                <input type="text" name="user_alt_mob"   value="<?php echo set_value('user_alt_mob'); ?>"   pattern="[0-9]{10}" maxlength="10"   class="form-control">
                                                            </div>
                                                        </div> 
                                                        <?php
                                                        if($_SESSION['user']['user_type']==3)
                                                        {
                                                            ?>
                                                            <div class="<?= $class; ?>">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Select Department*</label>
                                                                    <select name="user_subdept_id" required  class="form-control">
                                                                        <?php
                                                                            if(count($subdept))
                                                                            {
                                                                                foreach($subdept as $x)
                                                                                {
                                                                                    ?>
                                                                                        <option value="<?= $x['id'];?>"><?= $x['name'];?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <?php 
                                                        }
                                                        ?>                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Gender* </label>
                                                                <label><input type="radio"  name="user_gender"   value="Male"   name="Male" checked> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                                <label><input type="radio"  name="user_gender"   value="Female"   name="Female"  > Female &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                                <label><input type="radio"  name="user_gender"   value="Others"   name="Others"  > Others </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Age*</label>
                                                                <input type="text" name="user_age" required   value="<?php echo set_value('user_age'); ?>"  pattern="[0-9]{2}" maxlength="2" class="form-control">
                                                            </div>
                                                        </div>   
                                                         <div class="col-md-4">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Experience in years*</label>
                                                                <input type="number" name="user_experience" required   value="<?php echo set_value('user_experience'); ?>"   class="form-control">
                                                            </div>
                                                        </div>   

                                                    </div>
                                                    
                                                   
                                                    
                                                     
                                                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
</html>
 