<?php
	$clinic			=	$array['doc'];
	$gallery		=	$array['gallery'];
	$timings		=	$array['timings']; 
	$gallery		=	$array['gallery'];
	$certi			=	$array['certi'];  	 
	$cat			=	$array['cat'];  	 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>   <?= $clinic['user_name'];?></title>
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
          <?= $clinic['user_name'];?>  
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('hosadmin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('hosadmin/diagnosis');?>"><i class="fa fa-dashboard"></i> Diagnosis</a></li>
      
        <li class="active"> <?= $clinic['user_name'];?></li> 
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<?php
			if($this->session->flashdata('usermsg'))
			{
				echo $this->session->flashdata('usermsg');
			}

		  			if($clinic['is_active'] == 1)
		  			{
		  				?>
		  					<button class="btn btn-danger pull-right " onclick="changestatus('<?= $clinic['id'];?>','0');">Deactivate</button>
		  				<?php
		  			}
		  			else{
		  				?>
		  					<button class="btn btn-success  pull-right" onclick="changestatus('<?= $clinic['id'];?>','1');">Activate</button>
		  				<?php
		  			}
		  		?>
     			<button class="btn btn-primary pull-right" onclick="loginasuser('<?= $clinic['id'];?>');"> Edit or Add Details</button>
     			
     			<br>
     			<br>
      			<div class="box">
			        <div class="box-header with-border">
			          <h3 class="box-title text-primary"> Basic Details  </h3>
			          <div class="box-tools pull-right">
			          	Member Since <b><?= date("d-M, Y",strtotime($clinic['created_at']));?></b>
			          </div>
			        </div>
			        <div class="box-body"> 
      		 			<table class="table table-responsive">
      		 				<tr>
      		 					<th>Name</th>
      		 					<td>Dr. <?= $clinic['user_name'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Account Status</th>
      		 					<td>
      		 						<?php
      		 							if($clinic['is_active']==0)
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
      		 					<td><?= $clinic['user_email'];?></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Mobile</th>
      		 					<td> <?= $clinic['user_mob'];?> <br> <?= $clinic['user_alt_mob'];?></td>
      		 				</tr>
      		 				 
      		 				 
      		 				<!-- <tr>
      		 					<th>Experience</th>
      		 					<td><?= $clinic['user_experience'];?> year</td>
      		 				</tr>
      		 				<tr>
      		 					<th>Experience Details</th>
      		 					<td><p class="text text-justify"><?= $clinic['user_work'];?> </p></td>
      		 				</tr>
      		 				<tr>
      		 					<th>Awards, Recognition & Memberships</th>
      		 					<td><p class="text text-justify"><?= $clinic['user_award'];?> </p></td>
      		 				</tr> -->
      		 				<tr>
      		 					<th>About The clinic</th>
      		 					<td><p class="text text-justify"><?= $clinic['user_about'];?> </p></td>
      		 				</tr>
      		 				 

      		 			</table>
					  	 	
					</div>  
			         
      		 
      			 	       			 
			        </div> 
			 		 
						<div class="box">
						    <div class="box-header with-border">
						        <h3 class="box-title text-primary"> Address Details  </h3>
						        <div class="box-tools pull-right">
						          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/profile');?>');"   ><i class="fa fa-pencil"></i></button>
						        </div>
						    </div>
						    <div class="box-body"> 
						    	<table class="table table-responsive">
						    		<?php
						    			if(!count($clinic['address']))
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
						    							<?= $clinic['address']['adl1']; ?><br>
						    							<?= $clinic['address']['adl2']; ?>
						    						</td>
						    					</tr>
						    					<tr>
						    						<th>Location</th>
						    						<td><?= $clinic['address']['location']?></td>
						    					</tr>
						    					<tr>
						    						<th>City</th>
						    						<td><?= $clinic['address']['city']?></td>
						    					</tr>
						    					<tr>
						    						<th>State</th>
						    						<td><?= $clinic['address']['state']?></td>
						    					</tr>
						    					<tr>
						    						<th>Country</th>
						    						<td><?= $clinic['address']['country']?></td>
						    					</tr>
						    					<tr>
						    						<th>Pincode</th>
						    						<td><?= $clinic['address']['pin']?></td>
						    					</tr>
						    					
						    				<?php
						    			}
						    		?>
						    	</table>
						    </div>
						</div>
					
						<div class="box">
						    <div class="box-header with-border">
						        <h3 class="box-title text-primary"> Account Details  </h3>
						        <div class="box-tools pull-right">
						          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/profile');?>');"   ><i class="fa fa-pencil"></i></button>
						        </div>
						    </div>
						    <div class="box-body"> 
						    	 <table class="table table-responsive">
						    		<?php
						    			if(!count($clinic['account']))
						    			{
						    				?>
						    					<tr><td>No account Added.</td></tr>
						    				<?php
						    			}
						    			else{
						    				?>
						    					 
						    					<tr>
						    						<th>Account Holder's Name</th>
						    						<td><?= $clinic['account']['bank_ac_holder_name']?></td>
						    					</tr>
						    					<tr>
						    						<th>Account Number</th>
						    						<td><?= $clinic['account']['bank_ac_no']?></td>
						    					</tr>
						    					<tr>
						    						<th>Bank</th>
						    						<td><?= $clinic['account']['bank_ac_name']?></td>
						    					</tr>
						    					<tr>
						    						<th>IFSC Code</th>
						    						<td><?= $clinic['account']['bank_ac_ifsc_code']?></td>
						    					</tr>
						    					<tr>
						    						<th>Branch Name</th>
						    						<td><?= $clinic['account']['bank_ac_branch_name']?></td>
						    					</tr>
						    					 
						    					
						    				<?php
						    			}
						    		?>
						    	</table>
						    </div>
						</div>
					<?php
				
				
			?>       
      	 	<div class="box" id="tests">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Test We Perform  </h3>
			        <div class="box-tools pull-right">
			        	 
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/testwedo');?>');"><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    	<?php
			    		if(count($cat))
			    		{
			    			?>
			    				<table class="table table-responsive">
			    					<?php
			    						foreach ($cat as $x) {
			    							?>
			    								<tr>
			    									<th><a href="#tests" onClick="showtests(this,'<?= $x['id'];?>');"><?= $x['cat_name'];?></a></th>
			    									<td class="details"></td>
			    								</tr>
			    							<?php
			    						}
			    					?>
			    				</table>
			    			<?php
			    		}
			    	?>
			    </div>
			</div> 
      		<div class="box">
			    <div class="box-header with-border">
			        <h3 class="box-title text-primary"> Timing Details  </h3>
			        <div class="box-tools pull-right">
			        	 
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/timings');?>');"><i class="fa fa-pencil"></i></button>
			        </div>
			    </div>
			    <div class="box-body">
			    		<table class="table trable-responsive">			    			 
			    			<?php
			    				 
			    				if(!count($timings))
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
	    												<td class="<?= $class;?>"> <?= date('h:i:A', strtotime($timings['path_morning_start']));?> to <?= date('h:i:A', strtotime($timings['path_morning_end']));?></td>
	    												<td  class="<?= $class;?>"><?= date('h:i:A', strtotime($timings['path_evening_start']));?> to <?= date('h:i:A', strtotime($timings['path_evening_end']));?></td>
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
			          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/gallery');?>');"   ><i class="fa fa-pencil"></i></button>
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
      	 
		 
		<div class="box">
		    <div class="box-header with-border">
		        <h3 class="box-title text-primary"> Ownesrship Details  </h3>
		        <div class="box-tools pull-right">
		          	<button class="btn btn-primary"onclick="loginasuser('<?= $clinic['id'];?>','<?= base_url('Diagnosis/ownership');?>');"   ><i class="fa fa-pencil"></i></button>
		        </div>
		    </div>
		    <div class="box-body">
		    	<table class="table table-responsive">
		    		<tr>
		    			<th>Registration Number</th>
		    			<td><?= $certi['path_reg_no'];?></td>
		    		</tr>
		    		 
		    		<tr>
		    			<th>Registration Proof</th>
		    			<td>
		    				<?php
                                if($certi['path_reg_proof']=='')
                                {
                                   echo "N/A";
                                }else
                                {
                                    ?>
                                        <img src="<?= base_url('images/user/'.$this->uri->segment(3).'/reg/'.$certi['path_reg_proof']);?>" onclick="showimage('<?= base_url('images/user/'.$this->uri->segment(3).'/reg/'.$certi['path_reg_proof']);?>');" id="proof" style="max-height: 150px;" class="img img-responsive" alt="Reg Proof">
                                    <?php
                                }
                            ?>
		    			</td>
		    		</tr>
		    		<tr>
		    			<th>Ownership Certificate</th>
		    			<td>
		    				<?php
                                if($certi['path_owner']=='')
                                {
                                   Echo "N/A";
                                }else{
                                    ?>
                                        <img src="<?= base_url('images/user/'.$this->uri->segment(3).'/owner/'.$certi['path_owner']);?>" onclick="showimage('<?= base_url('images/user/'.$this->uri->segment(3).'/owner/'.$certi['path_owner']);?>');" id="logo" style="max-height: 150px;"  class="img img-responsive" alt="Clinic Prescription Pad">
                                    <?php
                                }
                            ?>
		    			</td>
		    		</tr>
		    		
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
    function showimage(image){
            //alert(image);
            $('#imagemodal').html("<center><img src='"+image+"' class='img img-responsive'/></center>");
            $('#certimodal').modal('toggle');
    }

    function showgallery(id,image){
           // console.log(id);
            //console.log(image);
            $('#imagemodal').html("<center><img src='<?= base_url('img/gallery/');?>"+id+"/"+image+"' class='img img-responsive'/></center>");
            $('#certimodal').modal('toggle');
    }
    function showtests(a,id){
        $('.details').html('');
        $.ajax({
            type    :   "POST",
            url     :   "<?= base_url('Hosadmin/showtests');?>",    
            data    :    {
            				"test_cat_id" 	: 	id,
            				"test_path_id"	: 	"<?= $clinic['id'];?>",
            			},
            success:   function(data){

                $(a).parent().next('td').html(data);
            }
        });
    }
 </script>
</html>
