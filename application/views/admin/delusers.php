
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Delete Users</title>
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
        Delete Users
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active"> Delete Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="col-md-6 col-md-offset-3">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Delete Users</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        <div class="box-body" style="padding:50px;">
			 <?php
				if($this->session->flashdata('delmsg'))
				{
					echo $this->session->flashdata('delmsg');
				}
			  ?>
			  <div class="form">
 				<div class="form-group">
				  <label  for="userfile">Enter Email of the user:</label>
					<input type="text" class="form-control" required   id="user_email" name="user_email" placeholder="Enter email Of the user">
				  
				</div>
				 
			  
			 
				<div class="form-group">        
				   
					<button type="submit" class="btn btn-primary" onclick="findusers();">Submit</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 
				</div>
			</div>
			   
			  <div class="result"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        
        </div>
        <!-- /.box-footer-->
      </div>
  </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
  	function findusers(){
  		var email = $("#user_email").val();
  		if(email=='')
  		{
  			alert('Please enter the email of user');
  		}
  		else{
  			$.ajax({
  			type : 	"POST",
  			url  : 	"<?= base_url('hosadmin/findsomeusers');?>",
  			data : 	{"user_email"	: 	email},
  			success : 	function(data){
  				$('.result').html(data);
  				$('.form').fadeOut();
  			}
  		});
  		}
  		
  	}
  	function delnow(id){
  		var r = confirm("Are you sure, you really want to delete this user?");
  		if(r==true)
  		{
  			$.ajax({
  				type 	: 	"POST",
  				data 	: 	{"id" 	: 	id},
  				url 	: 	"<?= base_url('hosadmin/deluser');?>",
  				success : 	function(data){
  					location.reload();
  				}

  			});
  		}
  	}
  </script>
  <?php include('includes/footer.php');?>
</body>
</html>
