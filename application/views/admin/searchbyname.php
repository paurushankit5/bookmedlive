<?php
  $users  = $array['users']; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Serach Users By Name</title>
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
         Serach Results for <?= $_GET['q']; ?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li> 
       
        <li class="active">  Search Users</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Search Results </h3>

           
        </div>
        <div class="box-body">
			 
			  <table class="table table-responsive">
			  	 
			  	<?php
			  		if(count($users))
			  		{
			  			$i=1;
			  			foreach ($users as $y) {
			  				?>
			  					<tr>
			  					 	<td><?= $i++;?></td>
			  						<td><?php if(in_array($y['user_type'],array('4','5','6'))) {echo "Dr. "; }?><?= $y['user_name'];?></td>
			  						
			  							<?php
			  								if($y['user_type']=='1')
			  								{
			  									echo "<td>Patient</td>";
			  									echo "<td><a href='".base_url('hosadmin/patientdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='2' )
			  								{
			  									echo "<td>Clinic</td>";
			  									echo "<td><a href='".base_url('Hosadmin/clinicdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='3' )
			  								{
			  									echo "<td>Hospital</td>";
			  									echo "<td><a href='".base_url('Hosadmin/hosdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='4' )
			  								{
			  									echo "<td>Individual Doc</td>";
			  									echo "<td><a href='".base_url('Hosadmin/docdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='5' )
			  								{
			  									echo "<td>Clinic Doc</td>";
			  									echo "<td><a href='".base_url('Hosadmin/docdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='6' )
			  								{
			  									echo "<td>Hospital Doc</td>";
			  									echo "<td><a href='".base_url('Hosadmin/docdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}
			  								else if($y['user_type']=='7' )
			  								{
			  									echo "<td>Diagnosis</td>";
			  									echo "<td><a href='".base_url('Hosadmin/diagnosisdetails/'.$y['id'])."' class='btn btn-primary'>Details</a></td>";
			  								}

			  							?>	 
			  							 
			  							 
			  						 
			  						 
			  					</tr>
			  					 
			  				<?php
			  			}
			  		}
			  		else{
			  			echo "No results found";
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
	 

 
 
  <?php include('includes/footer.php');?>
</body>
 
</html>
