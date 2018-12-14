<?php
  $state  = $array['state']; 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Bookmediz  Get User By City Name</title>
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
         Get User By City Name
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li> 
       
        <li class="active">  Get User By City Name</li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="col-md-6 col-md-offset-3">
      	<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">  Select a City or Locality</h3>

           
        </div>
        <div class="box-body">
      	<div class="form-group">
      	<select class="form-control" id="state" onchange="showcity(this.value);">
      		<option value="">Please select a State</option>
      		<?php
      			if(count($state))
      			{
      				foreach ($state as $x) {
      					?>
      						<option value="<?= $x['name'];?>"><?= $x['name'];?></option>
      					<?php
      				}
      			}
      		?>
      	</select>
      </div>
      <div class="form-group">
      	<select class="form-control" id="city" onchange="showlocality(this.value);">
      		<option value="">Please select City</option>
      		 
      	</select>
      </div>
      <div class="form-group">
      	<select class="form-control" id="locality">
      		<option value="">Please select locality</option>
      		 
      	</select>
      </div>
      <button class="btn btn-primary" onclick="getusers();">Get Users</button>
		  </div>
		</div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 result result1"></div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- Trigger the modal with a button -->
	 

 
 
  <?php include('includes/footer.php');?>
</body>
 <script type="text/javascript">
 	function showcity(state){
 		if(state!='')
 		{
 			$.ajax({
 				type : "POST",
 				url  : "<?= base_url('ajax/getcity');?>",
 				data : {
 					"state" : state
 				},
 				beforeSend :  function(){
 					$('.loadingDiv').show();
 				},
 				success : function(data){
 					$('.loadingDiv').hide();
 					$('#city').html("<option value=''>Please Select City</option>");
 					$('#city').append(data);
 				}

 			});
 		}
 	}
 	function showlocality(city){
 		var state 	= 	$('#state').val();
 		if(city!='')
 		{
 			$.ajax({
 				type : "POST",
 				url  : "<?= base_url('ajax/getlocality');?>",
 				data : {
 					"state" : state,
 					"city" : city,
 				},
 				beforeSend :  function(){
 					$('.loadingDiv').show();
 				},
 				success : function(data){
 					$('.loadingDiv').hide();
 					$('#locality').html("<option value=''>Please Select locality</option>");
 					$('#locality').append(data);
 				}

 			});
 		}
 	}
 	function getusers(){
 		var city 	= 	$("#city").val();
 		var locality 	= 	$("#locality").val();
 		if(city =='')
 		{
 			alert("Please select a city");
 		}
 		else{
 			$.ajax({
 				type : "POST",
 				url  : "<?= base_url('hosadmin/getsomeusersbycity');?>",
 				data : {
 					"locality" : locality,
 					"city" : city,
 				},
 				beforeSend :  function(){
 					$('.loadingDiv').show();
 				},
 				success : function(data){
 					$('.loadingDiv').hide();
 					$('.result').removeClass('hidden');
 					$('.result1').html(data);
 					 
 				}

 			});
 		}
 	}
 </script>
</html>
