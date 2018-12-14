<?php
	$doctor				=	$array['doctor'];
	$documents			=	$array['documents'];
	 
	$specialities		=	$array['specialities'];
	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Education & Specialization</title>
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
        Documents & Registration
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active">Documents & Registration</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Documents & Registration</h3>

          <div class="box-tools pull-right">
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Documents & Registration</button>

          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('documentmsg'))
				{
					echo $this->session->flashdata('documentmsg');
				}
			  ?>
			  <form method="post" action="<?= base_url('doctordashboard/updatedocument');?>"/>
			 <?php
				if(count($documents))
				{
					foreach($documents as $x)
					{
						?>
							<div class="row">
								
								<div class="col-sm-4">
									<input type="text" value="<?= $x['document_reg_no'];?>" name="document_reg_no[]" placeholder="Council Registration Number " class="form-control"/>
								</div>
								<div class="col-sm-4">
									<select class="form-control" name="document_council_name[]"/>
										<option value="">Select Council Name</option>
										<option <?php if($x['document_council_name']=='Maharastra Medical Council'){echo"selected";} ?>value="Maharastra Medical Council">Maharastra Medical Council</option>
										<option <?php if($x['document_council_name']=='Delhi Medical Council'){echo"selected";} ?> value="Delhi Medical Council">Delhi Medical Council</option>
										<option <?php if($x['document_council_name']=='Karnataka  Medical Council'){echo"selected";} ?> value="Karnataka Medical Council">Karnataka  Medical Council</option>
										<option <?php if($x['document_council_name']=='Maharastra State Dental Council'){echo"selected";} ?> value="Maharastra State Dental Council">Maharastra State Dental Council</option>
										<option <?php if($x['document_council_name']=='Tamilnadu Medical Council'){echo"selected";} ?> value="Tamilnadu Medical Council">Tamilnadu Medical Council</option>
										<option <?php if($x['document_council_name']=='Andhra Pradesh Medical Council'){echo"selected";} ?> value="Andhra Pradesh Medical Council">Andhra Pradesh Medical Council</option>
										<option <?php if($x['document_council_name']=='Karnataka State Dental Council'){echo"selected";} ?> value="Karnataka State Dental Council">Karnataka State Dental Council</option>
										<option <?php if($x['document_council_name']=='Maharastra Council of India'){echo"selected";} ?> value="Maharastra Council of India">Maharastra Council of India</option>
										<option <?php if($x['document_council_name']=='Medical Council of India(MCI)'){echo"selected";} ?> value="Medical Council of India(MCI)">Medical Council of India(MCI)</option>
										<option <?php if($x['document_council_name']=='Delhi State Dental Council'){echo"selected";} ?> value="Delhi State Dental Council">Delhi State Dental Council</option>
									</select>
								</div>
								<div class="col-sm-4">
									<input type="text" name="document_year[]" value="<?= $x['document_year'];?>" placeholder="Year Completed" class="form-control"/>
									<input type="hidden" name="document_id[]" value="<?= $x['document_id'];?>" placeholder="Year Completed" class="form-control"/>
								</div>
								
							</div>
							<br>
						<?php
						//echo "<pre>";
						//print_r($x);
						//	echo "</pre>";
					}
				}
			 ?>
			 <input type="submit" class="btn btn-primary"/>
			</form> 
			
			
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

  <?php include('includes/footer.php');?>
  <SCRIPT language="javascript">
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}
			}
			}catch(e) {
				alert(e);
			}
		}

	</SCRIPT>
	<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Education</h4>
				  </div>
				  <div class="modal-body">
					 <form class="form-horizontal" method="post" action="<?= base_url('doctordashboard/storedocuments');?>">
						  <div class="col-sm-12 "> 
								 <label class="control-label" for="notes"><br><br>Add Education:</label> <br>
								 
								<INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable')" />
								<INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable')" />	  
								<TABLE id="dataTable"   class="table table-striped">			
									<tr>
										<td><INPUT type="checkbox"  name="chk[]"/></td>
										<td>
											<input type="text" name="document_reg_no[]" placeholder="Council Registration Number " class="form-control"/>
										</td>
										<td>
											<select class="form-control" name="document_council_name[]"/>
												<option value="">Select Council Name</option>
												<option value="Maharastra Medical Council">Maharastra Medical Council</option>
												<option value="Delhi Medical Council">Delhi  Medical Council</option>
												<option value="Karnataka Medical Council">Karnataka  Medical Council</option>
												<option value="Maharastra State Dental Council">Maharastra State Dental Council</option>
												<option value="Tamilnadu Medical Council">Tamilnadu Medical Council</option>
												<option value="Andhra Pradesh Medical Council">Andhra Pradesh Medical Council</option>
												<option value="Karnataka State Dental Council">Karnataka State Dental Council</option>
												<option value="Maharastra Council of India">Maharastra Council of India</option>
												<option value="Delhi State Dental Council">Delhi State Dental Council</option>
												<option value="Medical Council of India(MCI)">Medical Council of India(MCI)</option>
											</select>
										</td>
											<td>
											<input type="text" name="document_year[]" placeholder="Year Completed" class="form-control"/>
										</td>										
								</TABLE>
							   </div>
					<div class="clearfix"></div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</form>
				  </div>
				</div>

			  </div>
			</div>
</body>
</html>
