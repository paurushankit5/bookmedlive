<?php
    $ap  	 =   $array['ap'];
    $count   =   $array['count'];
    
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
                        <div class="col-md-12" style="min-height: 450px;">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">My Patients</h4>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('profilemsg')){
                                            echo $this->session->flashdata('profilemsg');
                                        }
                                    ?>
                                    <table class="table table-responsive">
                                    	<?php 
                                    		if(count($ap))
                                    		{
                                    			foreach ($ap as $x) {
                                    				?>
                                    					<tr>
                                    						<td><?= ++$count; ?></td>
                                    						<td><?= $x['user_name'];?></td>
                                    						<td><a href="<?= base_url('patient/details/'.$x['id']);?>" class="btn btn-primary"><i class="fa fa-info-circle"></i></a></td>
                                    					</tr>
                                    				<?php
                                    			}
                                    			
                                    			?>
                                    			<tr>
                                    				<td colspan="3"><?= $this->pagination->create_links();?></td>
                                    			</tr>
                                    			<?php
                                    		}
                                    		else{
                                    				?>
                                    					<tr>
                                    						<td colspan="3">No patients found.</td>
                                    					</tr>
                                    				<?php
	                                   			}
                                    	?>
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