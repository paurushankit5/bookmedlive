<?php
  $users  = $array['users']; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz: Pending Users</title>
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
         Pending Users
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
         
       
        <li class="active">Pending Users</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pending Users  </h3>

          <div class="box-tools pull-right">
			   
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('citymsg'))
				{
					echo $this->session->flashdata('citymsg');
				}
			  ?>
			  <table class="table table-responsive">
			  	<thead>
			  		<tr>
			  			<th>#</th>
			  			<th>Name</th>
			  			<th>User Type</th>
			  			<th>Action</th>
			  		</tr>
			  	</thead>
			  	 <?php
			  	 	if(count($users))
			  	 	{
			  	 		$i=0;
			  	 		foreach ($users as $x) {
			  	 				if($x['user_type']=='1')
			  	 				{
			  	 					$type = "Patient";
			  	 					$url = base_url('hosadmin/patientdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='2')
			  	 				{
			  	 					$type = "Clinic";
			  	 					$url = base_url('hosadmin/clinicdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='3')
			  	 				{
			  	 					$type = "Hospital";
			  	 					$url = base_url('hosadmin/hosdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='4')
			  	 				{
			  	 					$type = "Individual Doc";
			  	 					$url = base_url('hosadmin/docdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='5')
			  	 				{
			  	 					$type = "Clinic Doc";
			  	 					$url = base_url('hosadmin/docdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='6')
			  	 				{
			  	 					$type = "Hospital Doc";
			  	 					$url = base_url('hosadmin/docdetails/'.$x['id']);
			  	 				}
			  	 				else if($x['user_type']=='7')
			  	 				{
			  	 					$type = "Diagnosis Center";
			  	 					$url = base_url('hosadmin/diagnosisdetails/'.$x['id']);
			  	 				}
			  	 				 
			  	 			?>
			  	 			<tr>
			  	 				<td><?= ++$i; ?></td>
			  	 				<td>
			  	 					<a href="<?= $url; ?>"> <?php if(in_array($x['user_type'], array(4,5,6))){echo "Dr. ";} ?><?= $x['user_name'];?></a>
			  	 					<br>
			  	 					Added On : <?= date('d-M,Y',strtotime($x['created_at'])); ?>
			  	 				</td>
			  	 				<td><?= $type; ?></td>
			  	 				<td>
			  	 					<?php
			  	 					if($x['is_active'] == 1)
						  			{
						  				?>
						  					<button class="btn btn-danger" onclick="	('<?= $x['id'];?>','0');">Deactivate</button>
						  				<?php
						  			}
						  			else{
						  				?>
						  					<button class="btn btn-success" onclick="changestatus('<?= $x['id'];?>','1');">Activate</button>
						  				<?php
						  			}
						  			?>
			  	 				</td>
			  	 			</tr>
			  	 			<?php
			  	 		}
			  	 		?>
			  	 			<tr><td colspan="4"><?= $this->pagination->create_links(); ?></td></tr>
			  	 		<?php
			  	 	}
			  	 ?>			  	 
			  </table>
        </div>
        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- Trigger the modal with a button -->
	 
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
 
  <?php include('includes/footer.php');?>
</body>
 
</html>
