<?php
	$department	=	$array['department'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Department</title>
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
         Services  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      Services
        <li class="active">  Department</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">  </h3>

          <div class="box-tools pull-right">
			  <button class="btn btn-warning"  data-toggle="modal" data-target="#specmodal"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('depmsg'))
				{
					echo $this->session->flashdata('depmsg');
				}
			  ?>
			  <table class="table table-responsive">
			  	 
			  	<?php
			  		if(count($department))
			  		{
			  			$i=1;
			  			foreach ($department as $y) {
			  				?>
			  					<tr>
			  					 
			  						<td><center><h3 class="text text-primary"><b><?= $y['name'];?></b></h3></center></td>
			  						 
			  					</tr>
			  					<tr class=" smalltr" style="display: ;">
			  						<td colspan="2">
			  							<table class="table table-responsive table-bordered table-striped">
			  								<tr>
			  									<td><b>#</b></td>
			  									<td><b>Subdepartment</b></td>
			  									<td><b>Action</b></td>
			  								</tr>
			  								<?php
			  									if(count($y['subdept']))
			  									{
			  										$j=1;
			  										foreach ($y['subdept'] as $x) {
			  											?>
			  												<tr>
			  													<td><?= $j++; ?></td>
			  													<td><?= $x['name']; ?></td>
			  													<td>
										  							 <button onclick="editnow('<?= $x['id'];?>','<?= $x['name'];?>');"  class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button>
										  							<button onclick="delnow('<?= $x['id'];?>');" title="Delete" class="btn btn-danger"><i class="fa fa-trash "></i></button>
										  						</td>
			  												</tr>
			  											<?php
			  										}
			  									}
			  								?>
			  							</table>
			  						</td>
			  					</tr>
			  				<?php
			  			}
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
	 

	<!-- Modal -->
	<div id="specmodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	  	<form class="form " method="post" action="<?= base_url('hosadmin/storesubdepartment');?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add Sub-Department</h4>
	      </div>
	      <div class="modal-body">
	        	<div class="form-group">
	        		<label>Department Name</label>
	        		<select class="form-control" name="department_id" required>
	        			<?php
	        				if(count($department))
	        				{
	        					foreach ($department as $x) {
	        						?>
	        							<option value="<?= $x['id'];?>"><?= $x['name'];?></option>
	        						<?php
	        					}
	        				}
	        			?>
	        		</select>
	        	</div>
	        	<div class="form-group">
	        		<label>Sub-Department Name</label>
	        		<input type="text" class="form-control" required name="name">
	        	</div>

	         
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary" >Save</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
		</form>
	  </div>
	</div>
	<div id="editspecmodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	  	<form class="form " method="post" action="<?= base_url('hosadmin/updatesubdepartment');?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Edit Speciality</h4>
	      </div>
	      <div class="modal-body">
	        
	        	<div class="form-group">
	        		<label>Speciality Name</label>
	        		<input type="text" class="form-control" required name="name" id="ser_name">
	        		<input type="hidden" class="form-control" required name="id" id="ser_id">
	        	</div>

	         
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary" >Save</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
		</form>
	  </div>
	</div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
  	function delnow(id){
  		var r = 	confirm("Are you sure, you want to delete this?");
  		if(r==true)
  		{
  			$.ajax({
  				type 	: 	"POST",
  				url 	: 	"<?= base_url('hosadmin/delsubdepartment');?>",
  				data	: 	{
  								"id"	: 	id
  				},
  				success : 	function(data){
  					location.reload();
  				}
  			});
  		}
  	}
  	function editnow(id,name){
  		$('#ser_name').val(name);
  		$('#ser_id').val(id);
  		$('#editspecmodal').modal('toggle');
  	}
   
  </script>
  <?php include('includes/footer.php');?>
</body>
 
</html>
