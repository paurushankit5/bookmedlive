<?php
	$clinic	=	$array['clinic'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz Trending Clinic & Hospital</title>
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
  <script src="<?= base_url('assets/');?>plugins/jQuery/jquery-2.2.3.min.js"></script>
   <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <style>
 
  #sortable-row { list-style: none; }
  #sortable-row li { margin-bottom:4px; padding:10px; background-color:#BBF4A8;cursor:move; margin-right: 40px;}
  .btnSave{padding: 10px 20px;background-color: #09F;border: 0;color: #FFF;cursor: pointer;margin-left:40px;}  
  #sortable-row li.ui-state-highlight { height: 1.0em; background-color:#F0F0F0;border:#ccc 2px dotted;}
  </style>
  <script>
  	jq = 	jQuery.noConflict();
  jq(function() {
    jq( "#sortable-row" ).sortable({
	placeholder: "ui-state-highlight"
	});
  });
  
  function saveOrder() {
	var selectedLanguage = new Array();
	$('ul#sortable-row li').each(function() {
	selectedLanguage.push($(this).attr("id"));
	});
	document.getElementById("row_order").value = selectedLanguage;
  }
  </script>
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
         Trending Clinic & Hospitals  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
       
        <li class="active">  Trending Clinic & Hospitals</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="col-md-8 col-md-offset-2">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">  </h3>

          <div class="box-tools pull-right">
			  <button class="btn btn-warning"  data-toggle="modal" data-target="#specmodal"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('statemsg'))
				{
					echo $this->session->flashdata('statemsg');
				}
			  ?>
			  <table class="table table-responsive">
			  	 
			  	<?php 
					if(count($clinic))
					{
						$i=0;
						?>
						<form name="frmQA" method="POST" action="<?= base_url('hosadmin/saveordertrending');?>" />
						<input type = "hidden" name="row_order" id="row_order" /> 
						<ul id="sortable-row">
						<?php
						foreach($clinic as $x)
						{ 
								?>
								<li id=<?php echo $x["id"]; ?>><?php echo $x["user_name"]; ?> <button onclick="deltrending('<?= $x['id'];?>');" class="btn btn-danger btn-xs pull-right"><i class="fa fa-times"></i></button></li>
								<?php
							 
						}
						?>
						</ul>
							<input type="submit" class="btnSave" name="submit" value="Save Order" onClick="saveOrder();" />
						</form>
						<?php
					}
			  		else{
			  			?>
			  				<tr>
			  					<td><b>No Clinics or Hospital found.</b></td>
			  				</tr>
			  			<?php
			  		}
			  	?>
			  </table>
        </div>
        <!-- /.box-body -->
         
        <!-- /.box-footer-->
      </div>
  </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

<!-- Modal -->
<div id="specmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Trending Clinic & Hospitals</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label>Hopsital/clinic Name</label>
        	<input type="text" class="form-control" id="clinic" placeholder="Enter the name of clinic/hospital">
        </div>
        <div class="col-md-12 demo"></div>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="searchclinic();">Search</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
	function searchclinic(){
		var clinic 	= 	$('#clinic').val();
		if(clinic==''){
			alert('Please enter a name');
		}
		else{
			$.ajax({
				type 	: 	"POST",
				data 	: 	{
								"user_name"	: 	clinic,
				},
				url 	: 	"<?= base_url('Hosadmin/searchtrendingclinic');?>",
				success : 	function(data){
					$('.demo').html(data);
				}
			});
		}
	}
	function addtrending(id){
		var r = confirm("Are you sure?");
		if(r==true){
			//alert('yes');
			$.ajax({
				type 	: 	"POST",
				data 	: 	{"id"	: 	id, "user_trending" : 	"1"},
				url 	: 	"<?= base_url('hosadmin/addtrendingclinic');?>",
				success : 	function(){
					location.reload();
				}
			});
		}
	}
	function deltrending(id){
		var r = confirm("Are you sure, you want to remove this from trending list?");
		if(r==true){
			//alert('yes');
			$.ajax({
				type 	: 	"POST",
				data 	: 	{"id"	: 	id, "user_trending" : 	"0" ,"user_trending_order" : "0"},
				url 	: 	"<?= base_url('hosadmin/addtrendingclinic');?>",
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
