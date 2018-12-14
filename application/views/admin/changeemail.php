<?php
	//$path	=	$array['path'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Change Email</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
 
  <link rel="stylesheet" href="<?= base_url('assets/');?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

<?php include('includes/header.php');?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Change Email
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active">   Change Email</li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="col-sm-6 col-sm-offset-3">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">   Change Email</h3>

          <div class="box-tools pull-right">
			  
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('passmsg'))
				{
					echo $this->session->flashdata('passmsg');
				}
			  ?>
			 <form class="form-horizontal" method="post" action="<?= base_url('hosadmin/updateemail');?>">
				<div class="col-sm-12">
					<div class="form-group col-sm-12">
						 <label for="notes"> Old Email:</label> <br>					 
						 <input required type="text" class="form-control" id="email1" name="email1">
					</div> 
					<div class="form-group col-sm-12">
						 <label for="notes"> New Email:</label> <br>					 
						 <input required type="text" class="form-control" id="email2" name="email2">
					</div> 
					<div class="form-group col-sm-12">
						 <label for="notes"> Re-Type Email:</label> <br>					 
						 <input required type="text" class="form-control" id="email3" name="email3">
					</div> 
				  
				  <div class="form-group"> 
					<div class="col-sm-10">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
				  </div>
				</div>
			</form>
        </div>
        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('includes/footer.php');?>
</body>

</html>
