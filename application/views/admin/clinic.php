<?php
	$pendingclinic		=	$array['pendingclinic'];
	$activeclinic		=	$array['activeclinic'];
	$countactiveclinic	=	$array['countactiveclinic'];
	$countpendingclinic	=	$array['countpendingclinic'];
	$pendingclinicdoc	=	$array['pendingclinicdoc'];
	$activeclinicdoc	=	$array['activeclinicdoc'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Clinic</title>
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
         Clinic  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active"> Clinic</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<?php
			if($this->session->flashdata('usermsg'))
			{
				echo $this->session->flashdata('usermsg');
			}
		  ?>
		 	<div class="row">

	  			<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-user-md"></i></span>

					<div class="info-box-content"> 
					  <span class="info-box-text">Pending Clinic</span>
					  <span class="info-box-number"><?= $countpendingclinic; ?><small></small></span>
					   
					</div>
					<!-- /.info-box-content -->
				  </div>
				  <!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-medkit"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Active Clinic</span>
					  <span class="info-box-number"><?= $countactiveclinic; ?> </span>
					</div>
					<!-- /.info-box-content -->
				  </div>
				  <!-- /.info-box -->
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-user-md"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Active Clinic Doctors</span>
					  <span class="info-box-number"><?= $activeclinicdoc; ?> </span>
					</div>
					<!-- /.info-box-content -->
				  </div>
				  <!-- /.info-box -->
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-user-md"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Pending Clinic Doctors</span>
					  <span class="info-box-number"><?= $pendingclinicdoc; ?> </span>
					</div>
					<!-- /.info-box-content -->
				  </div>
				  <!-- /.info-box -->
				</div>

			</div>
		<?php
      	if(count($pendingclinic))
      	{	
      		?>	
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title"> Pending Clinic  </h3>
			          <div class="box-tools pull-right">
			          		<a href="<?= base_url('hosadmin/pendingclinic');?>">View All</a>
			          </div>
			        </div>
			        <div class="box-body"> 
      		<?php
      		foreach ($pendingclinic as $x) {
      			?> 	
      				<div class="col-md-8 col-md-offset-2">			
					<div class="panel panel-primary">
					  <div class="panel-heading"><a href="<?= base_url('Hosadmin/clinicdetails/'.$x['id']);?>" style="color:white;font-size:16px;"> <?= $x['user_name'];?></a></div>
					  <div class="panel-body">
					  	<div class="row">
					  	<div class="col-md-3">
					  		<center>
					  		<?php
					  			if($x['user_image']!='')
					  			{
					  				?>
					  					<img src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" style="height:130px;" class="img img-responsive img-thumbnail" >
					  				<?php
					  			}
					  			else{
					  				?>
					  					<img src="<?= base_url('img/expert.jpg');?>" style="height:130px;" class="img img-responsive img-thumbnail" >
					  				<?php
					  			}
					  		?>
					  		</center>
					  	</div>
					  	<div class="col-md-9">
					  	 
					  		<div class="col-sm-6">
					  			<table class="table table-responsive">
					  				
					  				<tr>
					  					<th>Email</th>
					  					<td><?= $x['user_email'];?></td>
					  				</tr>
					  				<tr>
					  					<th>Mobile</th>
					  					<td><?= $x['user_mob'];?></td>
					  				</tr>
					  				<tr>
					  					<th>Doctors</th>
					  					<td><?= $x['doccount'];?></td>
					  				</tr>
					  				

					  				 
					  				 
					  				
					  			</table>
					  		</div>
					  		<div class="col-sm-6">
					  		<?php
					  			if($x['is_active'] == 1)
					  			{
					  				?>
					  					<button class="btn btn-danger btn-block" onclick="changestatus('<?= $x['id'];?>','0');">Deactivate</button>
					  				<?php
					  			}
					  			else{
					  				?>
					  					<button class="btn btn-success btn-block" onclick="changestatus('<?= $x['id'];?>','1');">Activate</button>
					  				<?php
					  			}
					  		?>
					  		<br>
					  		<a href="<?= base_url('Hosadmin/clinicdetails/'.$x['id']);?>" class="btn btn-primary btn-block">Details</a>
					 	 	</div>
					  	</div>
					  	</div>
					  </div>
					</div>	
					</div>   
			         
      			<?php
      		}
      		?>
      			 	       			 
			        </div> 
			      </div>
      		<?php
      	}
      ?>
      <?php
      	if(count($activeclinic))
      	{	
      		?>	
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title"> Active Clinic  </h3>
			          <div class="box-tools pull-right">
			          		<a href="<?= base_url('hosadmin/activeclinic');?>">View All</a>
			          </div>
			        </div>
			        <div class="box-body"> 
      		<?php
      		foreach ($activeclinic as $x) {
      			?> 	
      				<div class="col-md-8 col-md-offset-2">			
					<div class="panel panel-primary">
					  <div class="panel-heading"><a href="<?= base_url('Hosadmin/clinicdetails/'.$x['id']);?>" style="color:white;font-size:16px;"> <?= $x['user_name'];?></a></div>
					  <div class="panel-body">
					  	<div class="row">
					  	<div class="col-md-3">
					  		<center>
					  		<?php
					  			if($x['user_image']!='')
					  			{
					  				?>
					  					<img src="<?= base_url('images/user/'.$x['id'].'/'.$x['user_image']);?>" style="height:130px;" class="img img-responsive img-thumbnail" >
					  				<?php
					  			}
					  			else{
					  				?>
					  					<img src="<?= base_url('img/expert.jpg');?>" style="height:130px;" class="img img-responsive img-thumbnail" >
					  				<?php
					  			}
					  		?>
					  		</center>
					  	</div>
					  	<div class="col-md-9">
					  	 
					  		<div class="col-sm-6">
					  			<table class="table table-responsive">
					  				
					  				<tr>
					  					<th>Email</th>
					  					<td><?= $x['user_email'];?></td>
					  				</tr>
					  				<tr>
					  					<th>Mobile</th>
					  					<td><?= $x['user_mob'];?></td>
					  				</tr>
					  				<tr>
					  					<th>Doctors</th>
					  					<td><?= $x['doccount'];?></td>
					  				</tr>
					  				 
					  				
					  			</table>
					  		</div>
					  		<div class="col-sm-6">
					  		<?php
					  			if($x['is_active'] == 1)
					  			{
					  				?>
					  					<button class="btn btn-danger btn-block" onclick="changestatus('<?= $x['id'];?>','0');">Deactivate</button>
					  				<?php
					  			}
					  			else{
					  				?>
					  					<button class="btn btn-success btn-block" onclick="changestatus('<?= $x['id'];?>','1');">Activate</button>
					  				<?php
					  			}
					  		?>
					  		<br>
					  		<a href="<?= base_url('Hosadmin/clinicdetails/'.$x['id']);?>" class="btn btn-primary btn-block">Details</a>
					 	 	</div>
					  	</div>
					  	</div>
					  </div>
					</div>	
					</div>  
			         
      			<?php
      		}
      		?>
      			 	       			 
			        </div> 
			      </div>
      		<?php
      	}
      ?>
      
      
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- Trigger the modal with a button -->
	 
 
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
