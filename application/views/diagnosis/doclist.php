<?php
    $doc    =   $array['doc'];
    $department    =   $array['department'];
    
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: Doctor's List</title>
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
                        <div class="col-md-12" style="min-height:400px;">
                            <?php
                                if(count($doc)){
                                    ?>
                                        
                                       <div class="card">
                                            <div class="card-header" data-background-color="purple">
                                                <h4 class="title"><?= $department['name'];?> Department <a href="<?= base_url('Health/adddoc');?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Doctors</a></h4>
                                                <p class="category">List of Doctors in <?= $department['name'];?> Department</p>
                                            </div>
                                            <div class="card-content table-responsive">
                                       <table class="table table-responsive table-striped">
                                    <?php
                                    $i=0;
                                    foreach($doc as $x)
                                    {
                                    	?>
                                    		<tr>
                                    			<th> <?= ++$i; ?></th>
                                    			<th>
                                    				<a href="<?= base_url('Health/docdetails/'.$x['id']);?>">Dr. <?= $x['user_name'];?></a>
                                    			</th>
                                    			<th>
                                    				 
                                    				<?= $x['user_email'];?><br>
                                    				<?= $x['user_mob'];?><br>
                                    			</th>
                                    			<th>
                                    				<?php
                                                        if($x['is_active']==0)
                                                        {
                                                            echo "Pending";
                                                        }
                                                        else if($x['is_active']==1)
                                                        {
                                                            echo "Active";
                                                        }
                                                        else{
                                                            echo "Rejected";
                                                        }
                                                    ?>
                                    			</th>
                                    		</tr>
                                    	<?php

                                    }
                                    ?>
                                    </table>
                                    </div>	 
                                    </div>	 
                                    <?php
                                }
                                else{
                                    ?>
                                        <div class="card">
                                            <div class="card-header" data-background-color="purple">
                                                <h4 class="title">No Doctors Found in <?= $department['name'];?> Department <a href="<?= base_url('Health/adddoc');?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Doctors</a></h4>
                                                <p class="category">PLease add doctors to your hospital</p>
                                            </div>
                                            <div class="card-content table-responsive">
                                                 
                                                
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
 