<?php
  
	$cat			=	$array['cat'];  	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>   Test Category</title>
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
          Test Category 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li> 
      
        <li class="active"> Test Category</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<?php
			if($this->session->flashdata('catmsg'))
			{
				echo $this->session->flashdata('catmsg');
			}

		  		 
		  		?>
     			 
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title text-primary"> Test Category List  </h3>
			          <div class="box-tools pull-right"> 
			          	<button class="btn btn-primary" data-toggle="modal" data-target="#addmodal"><i class="fa fa-plus"></i></button>
			          </div>
			        </div>
			        <div class="box-body"> 
      		 			<table class="table table-responsive">
      		 				<tr>
      		 					<th>#</th>
      		 					<th>Name</th>
      		 					<th>Action</th>
      		 				</tr> 
      		 				<?php
      		 					if(count($cat))
      		 					{
      		 						$i=0;
      		 						foreach ($cat as $x) {
      		 							?>
      		 							<tr>
      		 								<td><?= ++$i ;?>.</td>
      		 								<td><?= $x['cat_name'] ;?></td>
      		 								<td>
      		 									<button class="btn btn-primary" onclick="editnow('<?= $x['id'];?>','<?= $x['cat_name'];?>');""><i class="fa fa-pencil"></i></button>
      		 									<button class="btn btn-danger" onclick="delnow('<?= $x['id'];?>');"><i class="fa fa-trash"></i></button>
      		 								</td>
      		 							</tr>
      		 							<?php
      		 						}
      		 					}
      		 					else{

      		 					}
      		 				?>
      		 			</table>
					  	 	
					</div>  
			         
      		 
      			 	       			 
			        </div> 
			 		 
						 
    </section>
    <!-- /.content -->
  </div>
  <!-- Trigger the modal with a button -->
	<div id="certimodal" class="modal fade" role="dialog" style="width:100%;">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Image</h4>
          </div>
          <div class="modal-body" id="imagemodal">
                
          </div>
          <div class="modal-footer">
           </div>
        </div>

      </div>
    </div> 
 
  <?php include('includes/footer.php');?>
</body>
 <script type="text/javascript">
 	 function delnow(id){
 	 	var r = confirm("Do you really want to delete this test catgeory");
 	 	if(r){
 	 		$.ajax({
 	 			type 	: 	"POST",
 	 			url 	: 	"<?= base_url('hosadmin/deltest_category');?>",
 	 			data	: 	{
 	 							"id" 	: 	id,
 	 			},
 	 			success : 	function(data){
 	 				//alert(data);
 	 				location.reload();
 	 			}
 	 		});
 	 	}
 	 }
 	 function editnow(id,cat_name){
 	 	$('#id').val(id);
 	 	$('#cat_name').val(cat_name);
 	 	$('#editmodal').modal('toggle');
 	 }
 </script>
 

<!-- Modal -->
<div id="addmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<form class="form form-horizontal" method="post" action="<?= base_url('hosadmin/storecat');?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Test Category</h4>
      </div>
      <div class="modal-body">
      	<label>Catgeory Name</label>
      	<input type="text" requitred class="form-control" name="cat_name" placeholder="Enter the category name">
      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  		</form>
    </div>

  </div>
</div>
<div id="editmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<form class="form form-horizontal" method="post" action="<?= base_url('hosadmin/updatecat');?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Test Category</h4>
      </div>
      <div class="modal-body">
      	<label>Catgeory Name</label>
      	<input type="text" requitred class="form-control" name="cat_name" id="cat_name" placeholder="Enter the category name">
      	<input type="hidden" requitred class="form-control" name="id" id="id" placeholder="Enter the category name">
      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  		</form>
    </div>

  </div>
</div>
</html>
