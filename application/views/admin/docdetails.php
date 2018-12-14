<?php
	$doc		=	$array['doc'];
	$edu		=	$array['edu'];
	$timings	=	$array['timings'];
	$document	=	$array['document'];
	$gallery	=	$array['gallery'];
	//$pendingdoc	=	$array['pendingdoc'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>   Dr. <?= $doc['user_name'];?></title>
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
         Dr. <?= $doc['user_name'];?>  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      
        <li class="active"> Dr. <?= $doc['user_name'];?></li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<?php
			if($this->session->flashdata('usermsg'))
			{
				echo $this->session->flashdata('usermsg');
			}

		  			if($doc['is_active'] == 1)
		  			{
		  				?>
		  					<button class="btn btn-danger pull-right " onclick="changestatus('<?= $doc['id'];?>','0');">Deactivate</button>
		  				<?php
		  			}
		  			else{
		  				?>
		  					<button class="btn btn-success  pull-right" onclick="changestatus('<?= $doc['id'];?>','1');">Activate</button>
		  				<?php
		  			}
		  		?>
     			<button class="btn btn-primary pull-right" onclick="loginasuser('<?= $doc['id'];?>');"> Edit or Add Details</button>
     			
     			<br>
     			<br>
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title text-primary"> Basic Details  </h3>
			          <div class="box-tools pull-right">
			          	Member Since <b><?= date("d-M, Y",strtotime($doc['created_at']));?></b>
			          </div>
			        </div>
			        <div class="box-body"> 
      		 			<table class="table table-responsive">
      		 				<tr>
      		 					<th>Name</th>
      		 					<td>Dr. <?= $doc['user_name'];?></td>
      		 				</tr>
      		 				<?php
      		 					if($doc['user_indi_clinic_name']!=''){
      		 						?>
      		 							<tr>
			      		 					<th>Clinic Name</th>
			      		 					<td> <?= $doc['user_indi_clinic_name'];?></td>
			      		 				</tr>
      		 						<?php
      		 					}
      		 					?>
      		 				
      		 				<tr>
      		 					<th>Account Status</th>
      		 					<td>
      		 						<?php
      		 							if($doc['is_active']==0)
      		 							{
      		 								echo "Deactive";
      		 							}
      		 							else{
      		 								echo "Active";
      		 							}
      		 						?>
      		 					</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Email</th>
      		 					<td><?= $doc['user_email'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Mobile</th>
      		 					<td> <?= $doc['user_mob'];?> <br> <?= $doc['user_alt_mob'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Consultancy Fees</th>
      		 					<td> &#x20B9; <?= $doc['user_fee'];?> for <?= $doc['user_time'];?> minutes</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Gender</th>
      		 					<td><?= $doc['user_gender'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Age</th>
      		 					<td><?= $doc['user_age'];?> years</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Experience</th>
      		 					<td><?= $doc['user_experience'];?> year</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Services</th>
      		 					<td><p class="text text-justify"><?= $doc['user_service'];?> </p></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Experience Details</th>
      		 					<td><p class="text text-justify"><?= $doc['user_work'];?> </p></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Awards, Recognition & Memberships</th>
      		 					<td><p class="text text-justify"><?= $doc['user_award'];?> </p></td>
      		 				</tr>
      		 				<tr>
      		 					<th>About The Doc</th>
      		 					<td><p class="text text-justify"><?= $doc['user_about'];?> </p></td>
      		 				</tr>
      		 				 

      		 			</table>
					  	 	
					</div>  
			         
      		 
      			 	       			 
			        </div> 
			<?php
				if(isset($doc['address']))
				{
					?>
						<div class="box">
						    <div class="box-header with-border">
						        <h3 class="box-title text-primary"> Address Details  </h3>
						        <div class="box-tools pull-right">
						          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= base_url('Doc/profile');?>');" ><i class="fa fa-pencil"></i></button>
						        </div>
						    </div>
						    <div class="box-body"> 
						    	<table class="table table-responsive">
						    		<?php
						    			if(!count($doc['address']))
						    			{
						    				?>
						    					<tr><td>No address Added.</td></tr>
						    				<?php
						    			}
						    			else{
						    				?>
						    					 
						    					<tr>
						    						<th>Address</th>
						    						<td>
						    							<?= $doc['address']['adl1']; ?><br>
						    							<?= $doc['address']['adl2']; ?>
						    						</td>
						    					</tr>
						    					<tr>
						    						<th>Location</th>
						    						<td><?= $doc['address']['location']?></td>
						    					</tr>
						    					<tr>
						    						<th>City</th>
						    						<td><?= $doc['address']['city']?></td>
						    					</tr>
						    					<tr>
						    						<th>State</th>
						    						<td><?= $doc['address']['state']?></td>
						    					</tr>
						    					<tr>
						    						<th>Country</th>
						    						<td><?= $doc['address']['country']?></td>
						    					</tr>
						    					<tr>
						    						<th>Pincode</th>
						    						<td><?= $doc['address']['pin']?></td>
						    					</tr>
						    					
						    				<?php
						    			}
						    		?>
						    	</table>
						    </div>
						</div>
					<?php
				}
				if(isset($doc['account']))
				{
					?>
						<div class="box">
						    <div class="box-header with-border">
						        <h3 class="box-title text-primary"> Account Details  </h3>
						        <div class="box-tools pull-right">
						          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= base_url('Doc/profile');?>');" ><i class="fa fa-pencil"></i></button>
						        </div>
						    </div>
						    <div class="box-body"> 
						    	 <table class="table table-responsive">
						    		<?php
						    			if(!count($doc['account']))
						    			{
						    				?>
						    					<tr><td>No account Added.</td></tr>
						    				<?php
						    			}
						    			else{
						    				?>
						    					 
						    					<tr>
						    						<th>Account Holder's Name</th>
						    						<td><?= $doc['account']['bank_ac_holder_name']?></td>
						    					</tr>
						    					<tr>
						    						<th>Account Number</th>
						    						<td><?= $doc['account']['bank_ac_no']?></td>
						    					</tr>
						    					<tr>
						    						<th>Bank</th>
						    						<td><?= $doc['account']['bank_ac_name']?></td>
						    					</tr>
						    					<tr>
						    						<th>IFSC Code</th>
						    						<td><?= $doc['account']['bank_ac_ifsc_code']?></td>
						    					</tr>
						    					<tr>
						    						<th>Branch Name</th>
						    						<td><?= $doc['account']['bank_ac_branch_name']?></td>
						    					</tr>
						    					 
						    					
						    				<?php
						    			}
						    		?>
						    	</table>
						    </div>
						</div>
					<?php
				}
				
			?>       
      	 	<div class="box">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Educational Details  </h3>
			        <div class="box-tools pull-right">
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= base_url('Doc/specialisation');?>');" ><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    		<table class="table trable-responsive">			    			 
			    			<?php
			    				if(!count($edu))
			    				{
			    					?>
			    						<tr>
			    							<td>No Educational details found.</td>
			    						</tr>
			    					<?php
			    				}
			    				else{
			    					foreach ($edu as $x) {
			    						# code...
			    					}
			    					?>
			    						<tr>
			    							<th><?= $x['qualification_name'];?> - <?= $x['qualification_specialization'];?> - <? $x['qualification_course_name'];?></th>
			    							<td><?= $x['qualification_college'];?>,   <?= $x['qualification_complete_year'];?></td>
			    						</tr>
			    					<?php
			    				}
			    			?>
			    		</table>
			    </div>
			</div>
			<div class="box">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Document Details  </h3>
			        <div class="box-tools pull-right">
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= base_url('Doc/documents');?>');" ><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    		<table class="table trable-responsive">			    			 
			    			<?php
			    				if(!count($document))
			    				{
			    					?>
			    						<tr>
			    							<td>No documents found.</td>
			    						</tr>
			    					<?php
			    				}
			    				else{
			    					foreach ($document as $x) {
			    					?>
			    						<tr>
			    							<td><?= $x['document_council_name'];?> <br> <?= $x['document_reg_no'];?></td>
			    							<td>
			    								<?= $x['document_year'];?> Batch
			    								<?php
			    									if($x['document_certificate']!='')
			    									{
			    										?>
			    											<br>
			    											<a href="#" onClick="showcerti('<?= $x['id'];?>','<?= $x['document_certificate'];?>');">View Certificate</a>
			    										<?php
			    									}
			    								?>
			    							</td>
			    						</tr>
			    					<?php
			    					}
			    					
			    				}
			    			?>
			    		</table>
			    </div>
			</div>
      		<div class="box">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Timing Details  </h3>
			        <div class="box-tools pull-right">
			        	<?php
			        		if($doc['user_type']==4)
			        		{
			        			$timingurl 	= 	base_url('Doc/doctiming');
			        		}
			        		else{
			        			$timingurl 	= 	base_url('Doc/timings');
			        		}
			        	?>
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= $timingurl;?>');" ><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    		<table class="table trable-responsive">			    			 
			    			<?php
			    				if(!isset($timings))
			    				{
			    					?>
			    						<tr>
			    							<td>No timings  found.</td>
			    						</tr>
			    					<?php
			    				}
			    				else if(!count($timings)  )
			    				{
			    					?>
			    						<tr>
			    							<td>No timings  found.</td>
			    						</tr>
			    					<?php
			    				}
			    				else{
			    					?>
			    						<tr>
			    							<td><b>Day</b></td>
			    							<td><b>Open / Closed</b></td>
			    							<td><b>Morning Shift</b></td>
			    							<td><b>Evening Shift</b></td>
			    						</tr>
			    						<tr>
			    							<!-- <td>
			    								<?php
			    									echo "<pre>";
			    									print_r($timings);
			    									echo "</pre>";			    									
			    								?>
			    							</td> -->
			    						</tr>
			    						<?php
			    							for($i=1;$i<=7;$i++)
	    									{
	    										if($i==1)
	    										{
	    											$day = "mon";
	    										}
	    										else if($i==2)
	    										{
	    											$day = "tue";
	    										}
	    										else if($i==3)
	    										{
	    											$day = "wed";
	    										}
	    										else if($i==4)
	    										{
	    											$day = "thu";
	    										}
	    										else if($i==5)
	    										{
	    											$day = "fri";
	    										}
	    										else if($i==6)
	    										{
	    											$day = "sat";
	    										}
	    										else if($i==7)
	    										{
	    											$day = "sun";
	    										}
	    										?>
	    											<tr>
	    												<td><?= ucwords($day);?></td>
	    												<td>
	    													<?php
	    														$class= '';
	    														if($timings[$day] ==0)
	    														{
	    															echo "Closed";
	    															$class="hidden";
	    														}
	    														else{
	    															echo "Open";
	    														}	
	    													?>
	    												</td>
	    												<td class="<?= $class;?>"> <?php if($timings[$day.'_morning_start']=="00:00:00"){ echo "closed"; }else{ echo date('h:i:A', strtotime($timings[$day.'_morning_start']))." to ". date('h:i:A', strtotime($timings[$day.'_morning_end'])); } ?> </td>
	    												<td  class="<?= $class;?>"><?php if($timings[$day.'_evening_start']=="00:00:00"){echo "closed"; }else{ echo date('h:i:A', strtotime($timings[$day.'_evening_start']))." to ". date('h:i:A', strtotime($timings[$day.'_evening_end'])); } ?></td>
	    											</tr>
	    										<?php
	    									}	    								   					
			    						}
			    					?>
			    		</table>
			    </div>
			</div>
			<div class="box">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Gallery  </h3>
			        <div class="box-tools pull-right">
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $doc['id'];?>','<?= base_url('Doc/gallery');?>');" ><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    	<?php
		          		if(!count($gallery))
		          		{
		          			echo "No records found.";
		          		}
		          		else{
		          			//print_r($gallery);
		          			foreach ($gallery as $x) {
		          				?>
		          					<div class="col-sm-4" style="height: 260px;">
		          						<center>
		          							<a href="#" onclick="showgallery('<?= $x['id'];?>','<?= $x['image_name'];?>');"><img src="<?= base_url('img/gallery/'.$x['id'].'/'.$x['image_name']);?>" style="max-height:250px;" alt="No image found" class="img img-responsive"></a>
		          						</center>
		          					</div>
		          				<?php
		          			}
		          		}
		          	?>
			    </div>
			</div>
      <!-- /.box -->

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
 	 function showcerti(id,image){
            //console.log(id);
            //console.log(image);
            $('#imagemodal').html("<center><img src='<?= base_url('images/certi/');?>"+id+"/"+image+"' class='img img-responsive'/></center>");
            $('#certimodal').modal('toggle');
    }
    function showgallery(id,image){
           // console.log(id);
            //console.log(image);
            $('#imagemodal').html("<center><img src='<?= base_url('img/gallery/');?>"+id+"/"+image+"' class='img img-responsive'/></center>");
            $('#certimodal').modal('toggle');
    }
 </script>
</html>
