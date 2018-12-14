<?php
	$questions		=	$array['questions'];
	$count			=	$array['count'];
	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Answered Questions</title>
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
        Answered Questions
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Answered Questions</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Answered Questions</h3>

          <div class="box-tools pull-right">
            <?php
			if(count($questions))
			{
				?>
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#clearhistory" >
             Clear History</button>
			 <?php
			}
			?>
            
          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('ansmsg'))
				{
					echo $this->session->flashdata('ansmsg');
				}
			  ?>
			  <table class="table table-responsive table-striped">
			 
				<tbody>
					<?php
						if(count($questions))
						{
							
							foreach($questions as $x)
							{
								?>
								<tr>
									<td><?= ++$count;?></td>
									<td><?= $x['question_name'];?>
										<br>
										<br>
										Asked by: <b>
										<a href="#"><?= $x['patient_name'];?></a></b>
									</td>
									<td><?= date('h:i:a d-M-Y',strtotime($x['question_add_time']));?></td>
								</tr>
								<?php
									if($x['question_ans']=='')
									{
										?>
										<tr>
											<td colspan="3"><b>Waiting  for doctor's reply....</b></td>
											 
										</tr>
										<?php
									}
									else
									{
										?>
										<tr>
											<td colspan="">Ans:</td>
											<td colspan="">
												<?= $x['question_ans'];?>
												
											</td>
											<td ><?= date('h:i:a d-M-Y',strtotime($x['question_ans_add_time']));?>
											<br><a href="<?= base_url('doctordashboard/deletechat/'.$x['question_id']);?>" class="btn btn-danger">Delete</a>
											</td>
										</tr>
										<?php
									}
								?>
								
								<?php
							}
							?>
								<tr><td colspan="3"><?= $this->pagination->create_links();?></td></tr>
							<?php
						}
						else
						{
							echo "No data found.";
							 
						}
					?>
				</tbody>
			  </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
				
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
	include('includes/footer.php');
  ?>
  
<div id="clearhistory" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Clear History</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure?</p>
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('doctordashboard/clearhistory');?>" class="btn btn-danger">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>

  </div>
</div>
 

</body>
</html>
