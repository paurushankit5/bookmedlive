<?php
	$doctor				=	$array['doctor'];
	$education			=	$array['education'];
	$documents			=	$array['documents'];
	$specialities		=	$array['specialities'];
	$council 			=	$array['council'];
	 
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
        Education & Specialization
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('doctordashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      
        <li class="active">Education & Specialization</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Education & Specialization</h3>

          <div class="box-tools pull-right">
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Education</button>

          </div>
        </div>
        <div class="box-body">
			 <?php
				if($this->session->flashdata('educationmsg'))
				{
					echo $this->session->flashdata('educationmsg');
				}
			  ?>
			  <form method="post" action="<?= base_url('doctordashboard/updateeducation');?>"/>
			 <?php
				if(count($education))
				{
					foreach($education as $x)
					{
						?>
							<div class="row">
								<div class="col-sm-3">
									<select class="form-control" required   id="doctor_qualification"  name="qualification_name[]">
										<option value="">Select Qualification</option>
										<option  <?php if($x['qualification_name']=='MBBS'){echo "selected";}?> value="MBBS">MBBS</option>
										<option  <?php if($x['qualification_name']=='BDS'){echo "selected";}?> value="BDS">BDS</option>
										<option  <?php if($x['qualification_name']=='MDS'){echo "selected";}?> value="MDS">MDS</option>
										<option  <?php if($x['qualification_name']=='BHMS'){echo "selected";}?> value="BHMS">BHMS</option>
										<option  <?php if($x['qualification_name']=='BAMS'){echo "selected";}?> value="BAMS">BAMS</option>
										<option  <?php if($x['qualification_name']=='MS'){echo "selected";}?> value="MS">MS</option>
										<option  <?php if($x['qualification_name']=='MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS'){echo "selected";}?> value="MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS">MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS</option>
										<option  <?php if($x['qualification_name']=='BPTH/BPT'){echo "selected";}?> value="BPTH/BPT">BPTH/BPT</option>
										<option  <?php if($x['qualification_name']=='MD'){echo "selected";}?> value="MD">MD</option>
										<option  <?php if($x['qualification_name']=='DM'){echo "selected";}?> value="DM">DM</option>
										<option  <?php if($x['qualification_name']=='MCH'){echo "selected";}?> value="MCH">MCH</option>
										<option  <?php if($x['qualification_name']=='MDS-ORAL & MAXILLOFACIAL SURGERY'){echo "selected";}?> value="MDS-ORAL & MAXILLOFACIAL SURGERY">MDS-ORAL & MAXILLOFACIAL SURGERY</option>
									</select>
								</div>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="qualification_college[]" value='<?= $x['qualification_college'];?>'/>
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="qualification_complete_year[]" value='<?= $x['qualification_complete_year'];?>'/>
									<input type="hidden" class="form-control" name="qualification_id[]" value='<?= $x['qualification_id'];?>'/>
								</div>
								<div class="col-sm-2">
									<select class="form-control" id="doctor_speciality" name="qualification_specialization[]">
										<?php
											if(count($specialities))
											{
												foreach($specialities as $y)
												{
													?>
														<option <?php if($y['speciality_name']==$x['qualification_specialization']){echo "selected";}?> value="<?= $y['speciality_name'];?>"><?= $y['speciality_name'];?></option>
													<?php
												}
											}
											
										?>
									</select>
								</div>
								<div class="col-sm-2">
									<a href="<?= base_url('doctordashboard/deletequalification/'.$x['qualification_id']);?>" class="btn btn-danger">Delete</a>
								</div>
								
							</div>
							<br>
							
						<?php
						//echo "<pre>";
						//print_r($x);
						//	echo "</pre>";
					}
					?>
					 <input type="submit" class="btn btn-primary"/>
					 <?php
				}
				else
				{
					echo "<div class='alert alert-warning'>No data found.</div>";
				}
			 ?>
			
			</form> 
			
			
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
				
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
	
	<section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Documents & Registration</h3>

          <div class="box-tools pull-right">
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docmodal">Add Documents & Registration</button>

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
								
								<div class="col-sm-3">
									<input type="text" value="<?= $x['document_reg_no'];?>" name="document_reg_no[]" placeholder="Council Registration Number " class="form-control"/>
								</div>
								<div class="col-sm-3">
									<select class="form-control" name="document_council_name[]"/>
										<option value="">Select Council Name</option>
										<?php
											if(count($council))
											{
												foreach($council as $co)
												{
													?>
														<option <?php if($x['document_council_name']== ucwords($co['council_name'])){echo"selected";} ?>  value="<?= ucwords($co['council_name']);?>"><?= ucwords($co['council_name']);?> </option>
													<?php
												}
											}
										?>
										 
									</select>
								</div>
								<div class="col-sm-3">
									<input type="text" name="document_year[]" value="<?= $x['document_year'];?>" placeholder="Year Completed" class="form-control"/>
									<input type="hidden" name="document_id[]" value="<?= $x['document_id'];?>" placeholder="Year Completed" class="form-control"/>
								</div>
								<div class="col-sm-3">
									<?php
										if($x['document_certificate']!='')
										{
											?>
											<a href="<?= base_url('images/certi/'.$x['document_id'].'/'.$x['document_certificate']);?>" target="_blank" class="btn btn-success">See Document</a>
											<?php
										}
									?>
									<a href="<?= base_url('doctordashboard/deletecerti/'.$x['document_id']);?>" class="btn btn-danger">Delete</a>
											
								</div>
								
							</div>
							<br>
							 
						<?php
						//echo "<pre>";
						//print_r($x);
						//	echo "</pre>";
					}
					?>
					<input type="submit" class="btn btn-primary"/>
					<?php
				}
				else
				{
					echo "<div class='alert alert-warning'>No data found.</div>";
				}
			 ?>
			 
			</form> 
			
			
        </div>
     
        <div class="box-footer">
				
        </div>
         
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
					 <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url('doctordashboard/storeeducation');?>">
						  <div class="col-sm-12 "> 
								<INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable')" />
								<INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable')" />	  
								<TABLE id="dataTable"   class="table table-striped">			
									<tr>
										<td><INPUT type="checkbox"  name="chk[]"/></td>
										<td>
											<select class="form-control" required   id="doctor_qualification"  name="qualification_name[]">
												<option value="">Select Qualification</option>
												<option value="MBBS">MBBS</option>
												<option value="BDS">BDS</option>
												<option value="MDS">MDS</option>
												<option value="BHMS">BHMS</option>
												<option value="BAMS">BAMS</option>
												<option value="MS">MS</option>
												<option value="MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS">MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS</option>
												<option value="BPTH/BPT">BPTH/BPT</option>
												<option value="MD">MD</option>
												<option value="DM">DM</option>
												<option value="MCH">MCH</option>
												<option value="MDS-ORAL & MAXILLOFACIAL SURGERY">MDS-ORAL & MAXILLOFACIAL SURGERY</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" name="qualification_college[]" placeholder="College Name"/>
										</td>
										<td>
											<select class="form-control" name="qualification_complete_year[]" >
												<option value=''>Year Completed</option>
												<?php
													for($i=date('Y');$i>=1950;$i--)
													{
														?>
														<option value='<?= $i; ?>'><?= $i;?></option>
														<?php
													}
												?>
											</select>
										</td>
										<td>
											<select class="form-control" id="doctor_speciality" name="qualification_specialization[]">
												<?php
													if(count($specialities))
													{
														foreach($specialities as $x)
														{
															?>
																<option value="<?= $x['speciality_name'];?>"><?= $x['speciality_name'];?></option>
															<?php
														}
													}
												?>
											</select>
										</td>
									</tr>		 
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
			<div id="docmodal" class="modal fade" role="dialog">
			  <div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Documents & Registration</h4>
				  </div>
				  <div class="modal-body">
					 <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url('doctordashboard/storedocuments');?>">
						  <div class="col-sm-12 "> 
								 
								<INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable1')" />
								<INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable1')" />	  
								<TABLE id="dataTable1"   class="table table-striped">			
									<tr>
										<td><INPUT type="checkbox"  name="chk[]"/></td>
										<td>
											<input required type="text" name="document_reg_no[]" placeholder="Council Registration Number " class="form-control"/>
										</td>
										<td>
											<select class="form-control" name="document_council_name[]"/>
												<option value="">Select Council Name</option>
												<?php
													if(count($council))
											{
												foreach($council as $co)
												{
													?>
														<option value="<?= ucwords($co['council_name']);?>"><?= ucwords($co['council_name']);?> </option>
													<?php
												}
											}
												?>
											</select>
										</td>
										<td>
											<input type="text" required name="document_year[]" placeholder="Year Completed" class="form-control"/>
										</td>
										<td>
											<input type="file"  name="document_certificate[]" class="form-control"/>
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
