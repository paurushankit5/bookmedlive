<?php
	$clinic			=	$array['user'];  	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>   <?= $clinic['user_name'];?></title>
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
  <style>
  	th{
  		width:25%;
  	}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini"  >
<!-- Site wrapper -->
<div class="wrapper">

<?php include('includes/header.php');?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          <?= $clinic['user_name'];?>  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('hosadmin/diagnosis');?>"><i class="fa fa-dashboard"></i> Diagnosis</a></li>
      
        <li class="active"> <?= $clinic['user_name'];?></li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<?php
			if($this->session->flashdata('usermsg'))
			{
				echo $this->session->flashdata('usermsg');
			}

		  			if($clinic['is_active'] == 1)
		  			{
		  				?>
		  					<button class="btn btn-danger pull-right " onclick="changestatus('<?= $clinic['id'];?>','0');">Deactivate</button>
		  				<?php
		  			}
		  			else{
		  				?>
		  					<button class="btn btn-success  pull-right" onclick="changestatus('<?= $clinic['id'];?>','1');">Activate</button>
		  				<?php
		  			}
		  		?>
     			<button class="btn btn-primary pull-right" onclick="loginasuser('<?= $clinic['id'];?>');"> Edit or Add Details</button>
     			
     			<br>
     			<br>
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title text-primary"> Basic Details  </h3>
			          <div class="box-tools pull-right">
			          	Member Since <b><?= date("d-M, Y",strtotime($clinic['created_at']));?></b>
			          </div>
			        </div>
			        <div class="box-body"> 
      		 			<table class="table table-responsive">
      		 				<tr>
      		 					<th>Name</th>
      		 					<td>Dr. <?= $clinic['user_name'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Account Status</th>
      		 					<td>
      		 						<?php
      		 							if($clinic['is_active']==0)
      		 							{
      		 								echo "Deactive";
      		 							}
      		 							else{
      		 								echo "Active";
      		 							}
      		 						?>
      		 					</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Email</th>
      		 					<td><?= $clinic['user_email'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Mobile</th>
      		 					<td> <?= $clinic['user_mob'];?> <br> <?= $clinic['user_alt_mob'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Gender</th>
      		 					<td><?= $clinic['user_gender'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Age</th>
      		 					<td><?= $clinic['user_age'];?> years</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Cause Of Registration</th>
      		 					<td><?= $clinic['user_cause'];?> </td>
      		 				</tr>
      		 				<!-- <tr>
      		 					<th>Gender</th>
      		 					<td><?php
      		 							echo "<pre>";
      		 							print_r($clinic);
      		 							echo "</pre>";
      		 						?></td>
      		 				</tr> -->
      		 				
      		 				 

      		 			</table>
					  	 	
					</div>  
			         
      		 
      			 	       			 
			        </div> 
			 		 
						 
    </section>
    <!-- /.content -->
  </div>
 
 
  <?php include('includes/footer.php');?>
</body>
 <script type="text/javascript">
 	function changestatus(id,status){
 		var r = confirm('Are you sure?');
 		if(r==true)
 		{
 			$.ajax({
 				type 	: 	"POST",
 				url 	: 	"<?= base_url('Hosadmin/changeuserstatus');?>",
 				data 	: 	{
 								id  		:  id,
 								is_active   :  status,
 				},
 				success :  	function(){
 					location.reload();
 				}
 			});
 		}
 	}
 
 </script>
</html>
