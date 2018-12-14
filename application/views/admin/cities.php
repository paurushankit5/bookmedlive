<?php
  $state  = $array['state'];
	$cities	=	$array['cities'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Cities in <?= $state['name'];?></title>
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
         Cities in <?= $state['name'];?> 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('hosadmin/states');?>">Indian States</a></li>
       
        <li class="active">  Cities in <?= $state['name'];?></li> 
        
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
				if($this->session->flashdata('citymsg'))
				{
					echo $this->session->flashdata('citymsg');
				}
			  ?>
			  <table class="table table-responsive">
			  	 
			  	<?php
			  		if(count($cities))
			  		{
			  			$i=1;
			  			foreach ($cities as $y) {
			  				?>
			  					<tr>
			  					 	<td><?= $i++;?></td>
			  						<td><a href="<?= base_url('hosadmin/localitylist/'.$y['id']);?>"><?= $y['name'];?></a></td>
			  						<td>
			  							<button class="btn btn-primary" onclick="editnow('<?= $y['id'];?>','<?= $y['name'];?>');"><i class="fa fa-pencil"></i></button>
			  							<button class="btn btn-danger" onclick="delstate('<?= $y['id'];?>');"><i class="fa fa-trash"></i></button>
			  							 
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
	  	<form class="form " method="post" action="<?= base_url('hosadmin/storecity');?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add city</h4>
	      </div>
	      <div class="modal-body">
	        	<div class="form-group">
	        		<label>State</label>
	        		<select class="form-control" name="state_id" required>
	        			<option value="<?= $state['id'];?>"><?= $state['name'];?></option>	        		 
	        		</select>
	        	</div>
	        	<div class="form-group">
	        		<label>City Name*</label>
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
	  	<form class="form " method="post" action="<?= base_url('hosadmin/updatecity');?>">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Edit City</h4>
	      </div>
	      <div class="modal-body">
	        
	        	<div class="form-group">
	        		<label>City Name</label>
	        		<input type="text" class="form-control" required name="name" id="ser_name">
              <input type="hidden" class="form-control" required name="id" id="ser_id">
	        		<input type="hidden" class="form-control" required name="state_id" value="<?= $state['id'];?>">
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
   	function delstate(id){
   		var r = confirm("Are you sure, you want to delete this city?");
   		if(r==true)
   		{
   			$.ajax({
   				type 	: 	"POST",
   				url 	: 	"<?= base_url('hosadmin/delcity');?>",
   				data 	: 	{"id" : id},
   				success : 	function(){
   					location.reload();
   				}

   			});
   		}
   	}
  </script>
  <?php include('includes/footer.php');?>
</body>
 
</html>
