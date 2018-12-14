<?php
    $subdept   =   $array['subdept'];
    
     
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Select Department</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
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
                    <div class="row" style="min-height: 400px;">
                        <div class="col-md-12">
                            
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Select Department of doctor <a href="<?= base_url('Health/adddoc');?>" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Doctor</a></h4>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('docmsg')){
                                            echo $this->session->flashdata('docmsg');
                                        }
                                    ?>
                                     <table class="table table-responsive">
                                     	<tr>
                                     		<td><b>#</b></td>
                                     		<td><b>Department</b></td>
                                     		<td><b>Doctors</b></td>
                                     	</tr>
                                     	<?php
                                     		if(count($subdept))
                                     		{
                                     			$i=0;
                                     			foreach($subdept as $x)
                                     			{
                                     				?>
                                     					<tr>
                                     						<td> <?= ++$i ; ?></td>
                                     						<td><?php if($x['doctorcount']!=0){ ?><a href="<?= base_url('Health/doclist/'.$x['id']);?>"><b>  <?php } ?> <?= $x['name']; ?> <?php if($x['doctorcount']!=0){ ?></b></a>  <?php } ?></td>
                                     						<td> <?= $x['doctorcount']; ?></td>
                                     					</tr>
                                     				<?php
                                     			}
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
 