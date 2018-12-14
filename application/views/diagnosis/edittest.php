<?php
    
    $cat		 =   $array['cat'];
    $test		 =   $array['test'];
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
    <title>Bookmediz: Add Test</title>
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
                        <div class="col-md-12" style="min-height: 500px;">
                             	<?php
                             		if($this->session->flashdata('testmsg'))
                             		{
                             			echo $this->session->flashdata('testmsg');
                             		}
                             	?>
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title"> Add Test
                                   
                                    </h4>
                                </div>
                                <div class="card-content">
                                     
                                        <form class="form "   method="post" action="<?= base_url('diagnosis/updatetests');?>">
                    
                                           
                                        <TABLE id="dataTable1"   class="table table-responsive table-striped">           
                                            <tr>
                                                <td>
                                                	 <select class="form-control" name="test_cat_id"/>
                                                        <option value="">Select Test Category</option>
                                                        <?php
                                                            if(count($cat))
		                                                    {
		                                                        foreach($cat as $x)
		                                                        {
		                                                            ?>
		                                                                <option 
		                                                                <?php if($test['test_cat_id']==$x['id']){echo "selected ";} ?> value="<?= $x['id'];?>"><?= ucwords($x['cat_name']);?> </option>
		                                                            <?php
		                                                        }
		                                                    }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" value="<?= $test['test_id'];?>" name="test_id">
                                                </td>
                                               
                                                <td><input type="text" value="<?= $test['test_name'];?>" required class="form-control" name="test_name" placeholder="Enter Test Name"></td>
                                                <td><input type="text" value="<?= $test['test_price'];?>" required class="form-control" name="test_price" placeholder="Enter Price in Rupees"></td>
                                                
                                            </tr>
                                            </TABLE>
                                            <div class="clearfix"></div>
                                            <input type="submit" class="btn btn-primary"> 
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
 
   
 
