<?php
	$doc 	=	$array['hos'];
	//print_r($doc);
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: <?= $doc['user_name'];?></title>
  
  <!-- PLUGINS CSS STYLE -->
  <link href="<?= base_url('web/');?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="<?= base_url('web/');?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url('web/');?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <link href="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
  <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">
   <link href="<?= base_url('web/css/');?>/ninja-slider.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url('web/js/');?>ninja-slider.js" type="text/javascript"></script>
  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">

  <style>
  	.checked {
		    color: orange;
		}
	
  </style>

</head>

<body class="body-wrapper">
<?php
	include('includes/header.php');
?>
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3><?= $doc['user_name'];?></h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!--===================================
=            Store Section            =
====================================-->
<section class="section bg-gray" style="padding-top: 0px;">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<!-- Left sidebar -->
			<div class="col-md-4">
				<div class="sidebar"> 
					<br>
					<br>
						 
					<div class="widget user">

						<center>
						<?php
							if($doc['user_image']!='')
							{
								?>
									<img src="<?= base_url('images/user/'.$doc['id'].'/'.$doc['user_image']);?>" style="max-width: 200px;" class="rounded-circle" alt="<?= $doc['user_name'];?>"   />
									 
								<?php
							}
							else{
								?>
									<img src="<?= base_url('img/doc.png');?>"  style="max-width: 200px;"  class="img img-responsive" alt="<?= $doc['user_name'];?>"/>
								<?php
							}
							
						?>
					
						 <br>
						<h4><a href="#"> <?= $doc['user_name'];?></a></h4>
						<p class="member-time">
							<?php
								if($doc['user_rated']!=0)
								{	
									$totalrating1 = $doc['user_rating']/$doc['user_rated'];
									$totalratings = number_format($doc['user_rating']/$doc['user_rated'],1);
									//echo $totalratings;
									$starrating = 1;
									//echo $totalratings;
									$lastrating  = 5-ceil($totalratings);
									while($starrating<= $totalratings)
									{
										?>
											<span class="fa fa-star checked" title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
										<?php
										$starrating++;
									}
									if (strpos($totalrating1,'.') !== false) { 
										?> 							 
										<span class="fa fa-star-half-o checked"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
										<?php 
									} 
									while($lastrating!=0)
									{
										?>
											<span class="fa fa-star"  title="<?= $totalratings;?> ratings from <?= $doc['user_rated'];?> reviews"></span>
										<?php
										$lastrating--;
									}
								
								
													 
													
												  
							?>
							<br>
							<span style="font-size: 14px;">(<?= $totalratings*20;?>% votes from <?= $doc['user_rated'];?> reviews)</span>
							<?php
								}
							?>
						</p>
						<p class="member-time">Member Since <?= date("M d, Y",strtotime($doc['created_at']));?></p>
						
						 
						</center>
					</div>
					 
					 
					 
					<!-- Coupon Widget -->
					<!--<div class="widget coupon text-center">
						<p>You can book an appointment with me
						</p>
						Submii button
						<a href="<?= base_url('doctor/bookappointment/'.$doc['id']);?>" class="btn btn-transparent-white">Book Appointment</a>
					</div>-->
					
				</div>
			</div>
			<div class="col-md-8">
				<div class="product-details">
					
					 
					<div class="content">
						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Overview</a>
							</li>
							<li class="nav-item">
								<a class="nav-link  " id="pills-time-tab" data-toggle="pill" href="#pills-time" role="tab" aria-controls="pills-time" aria-selected="true">Timings</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Doctors <b>(<?= count($doc['docs']);?>)</b></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-services-tab" data-toggle="pill" href="#pills-services" role="tab" aria-controls="pills-services" aria-selected="false">Services</b></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Feedback</a>
							</li>							 
							
					 
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									
										 <?php
										 	if(count($doc['qualification']))
										 	{
										 		?>
										 		<h3 class="tab-title">Speciality</h3>
												<p class="text text-justify">
										 		<?php
										 		$test 	=	array();
										 		foreach ($doc['qualification'] as $qual) {
										 			$test[]	=	$qual['qualification_specialization'];
										 		}
										 		echo "<b>".implode(", ",$test)."</b>";
										 		//print_r($test);
										 	}
										 	
										 ?>
									</p>

									<h3 class="tab-title">Available Days</h3>
									<p class="text text-justify">
										<b>
									<?php
										if($doc['mon']==1)
										{
											echo "Mon ";
										}
										if($doc['tue']==1)
										{
											echo "Tue";
										}
										if($doc['wed']==1)
										{
											echo " Wed";
										}
										if($doc['thu']==1)
										{
											echo " Thu";
										}
										if($doc['fri']==1)
										{
											echo " Fri";
										}
										if($doc['sat']==1)
										{
											echo " Sat";
										}
										if($doc['sun']==1)
										{
											echo " Sun";
										}										
									?>
									</b>
								</p>
								<h3 class="tab-title">More Info</h3>
								<table class="table table-bordered product-table">
								  <tbody>
								    <tr>
								      <td>Contact Details</td>
								      <td>
								      		+91-<?= $doc['user_mob'];?> 
								      		<?php
								      			if($doc['user_alt_mob']!='')
								      			{
								      				echo "<br>+91-".$doc['user_alt_mob'];
								      			}
								      		?>
								      </td>
								    </tr>
								    <tr>
								      <td>Location</td>
								      <td>
								      		<?= $doc['adl1'];?> <br>
								      		<?= $doc['adl2'];?> <br>
								      		<?= $doc['location'];?> -
								      		<?= $doc['city'];?> 
								      		<?php
								      			if($doc['map']!='')
								      			{
								      				?>
								      				<img src="<?= base_url('images/address/'.$doc['address_id'].'/'.$doc['map']);?>" style="max-height:50px;cursor: pointer;" class="img img-responsive" data-toggle="modal" data-target="#mapmodal">
										      		<div id="mapmodal" class="modal fade" role="dialog">
														  <div class="modal-dialog"  style="margin-top: 150px;">

													    <!-- Modal content-->
													    <div class="modal-content">
	    												      <div class="modal-header">
														        <h4 class="modal-title">Google Map View</h4>
														        <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
														    </div>
														    <div class="modal-body">  
										      					<center><img src="<?= base_url('images/address/'.$doc['address_id'].'/'.$doc['map']);?>" class="img img-responsive"></center>
														    </div>
														    <div class="modal-footer">
															    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														    </div>
														</div>

														</div>
													</div>
								      				<?php
								      			}
								      		?>
								      </td>
								    </tr>
								     
								     
								  </tbody>
								</table>
								<?php									
									if($doc['user_about']!='')
									{
										?>
											<h3 class="tab-title">About <?= $doc['user_name'];?></h3>
											<p class="text text-justify"><?= $doc['user_about'];?></p>
										<?php
									}
								?>
								

								 
								<p></p>
								<?php
									if(count($doc['gallery']))
							        {
							    ?>
								<div id="ninja-slider">
							        <div class="slider-inner">
							            <ul>
							            	<?php							            		
						            			foreach($doc['gallery'] as $img)
						            			{
						            				?>
						            					<li>
										                    <a class="ns-img" href="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>"></a>
										                    <div class="caption">@colerise</div>
										                </li>	
						            				<?php
						            			}							            		
							            	?>                
							            </ul>
							            <div class="fs-icon" title="Expand/Close"></div>
							        </div>
							    </div>
							    <?php
							    	}
							    ?>
								 

							</div>
							<div class="tab-pane fade" id="pills-time" role="tabpanel" aria-labelledby="pills-time-tab" >
									<h3 class="tab-title">Timings</h3>
									 <div class="col-md-12">
									 	<table class="table table-bordered">
									 		<?php
									 			for($i=1;$i<=7;$i++)
									 			{
									 				if($i==1){
									 					$day =  "Monday";
									 					$day1 =  "mon";
									 				}
									 				else if($i==2){
									 					$day =  "Tuesday";
									 					$day1 =  "tue";
									 				}
									 				else if($i==3){
									 					$day =  "Wednesday";
									 					$day1 =  "wed";
									 				}
									 				else if($i==4){
									 					$day =  "Thursday";
									 					$day1 =  "thu";
									 				}
									 				else if($i===5){
									 					$day =  "Friday";
									 					$day1 =  "fri";
									 				}
									 				else if($i==6){
									 					$day =  "Saturday";
									 					$day1 =  "sat";
									 				}
									 				else if($i==7){
									 					$day =  "Sunday";
									 					$day1 =  "sun";
									 				}
									 				if($doc[$day1]==1)
									 				{									 					
									 				?>
									 				<tr>
									 					<th><?= $day; ?></th>
									 					<td>
									 						<?php
									 							if($doc[$day1."_morning_start"]!="00:00:00")
								 								{
								 									/*echo "<pre>";
								 									print_r($doc);
								 									echo "</pre>";*/
								 									?>
								 									<b>Morning Shift</b><br>
								 									<?= date("g:i a", strtotime($doc[$day1."_morning_start"])); ?>
								 									to
								 									<?= date("g:i a", strtotime($doc[$day1."_morning_end"])); ?><br>
								 									<?php
								 								}
								 								else{
								 									echo "Closed";
								 								}
								 							?>
								 						</td>
								 						<td>
								 							<?php
								 								if($doc[$day1."_evening_start"]!="00:00:00")
								 								{
								 									/*echo "<pre>";
								 									print_r($doc);
								 									echo "</pre>";*/
								 									?>
								 									<b>Evening Shift</b><br>
								 									<?= date("g:i a", strtotime($doc[$day1."_evening_start"])); ?>
								 									to
								 									<?= date("g:i a", strtotime($doc[$day1."_evening_end"])); ?>
								 									<?php
								 								}
								 								else{
								 									echo "Closed";
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
									 <div class="clearfix"></div>
										 
							</div>
							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								<h3 class="tab-title">Doctors </h3>
									<div class="review-submit question-submit col-md-12">
							  			<div class="product-review">
							  		<?php
							  			if($count = count($doc['docs']))
							  			{
							  				foreach ($doc['docs'] as $docs) {
							  					?>
							  						<div class="row ratingdiv">
							  						<div class="media">
											  			 <br>
											  			 <br>
											  			<?php
														if($docs['user_image']!='')
														{
															?>
																<img src="<?= base_url('images/user/'.$docs['id'].'/'.$docs['user_image']);?>" style="max-width: 200px;" class="img img-responsive" alt="<?= $docs['user_name'];?>"   />
																 
															<?php
														}
														else{
															?>
																<img src="<?= base_url('img/doc.png');?>"  style="max-width: 200px;"  class="img img-responsive" alt="<?= $docs['user_name'];?>"/>
															<?php
														}														
														?>
											  			  
											  			<div class="media-body">
											  				<!-- Ratings -->
											  				<div class="ratings">
											  					<div class="name">
												  					<h5><a href="<?= base_url('Doctor/viewprofile/'.$docs['id']);?>" target="_blank" style="color:#337ab7;"><b>Dr. <?= ucwords($docs['user_name']);?></b></a></h5>
												  				</div>
											  					 
											  				</div>
											  				
											  				<div class="review-content">
											  					<p>

											  						<?php
											  							if($docs['subdepartment']!='')
											  							{
											  								echo "<b>".$docs['subdepartment']." Department </b><br>";
											  							}
											  							if($docs['specialisation']!='')
											  							{
											  								echo "<b>Speciality: </b>".$docs['specialisation'],"<br>";
											  							}
											  							if($docs['user_experience']!='0')
											  							{
											  								echo $docs['user_experience']," years of experience.";
											  							}
											  							if($docs['user_fee']!='0')
											  							{
											  								echo "<br><b>&#x20B9; ".$docs['user_fee'],"</b> at clinic / hospital.";
											  							}
											  						?>
											  					</p>
											  					<a href="<?= base_url('doctor/bookappointment/'.$docs['id']);?>" class="btn btn-primary" style="font-size: 13px;">Book Appointment</a>
											  				</div>
											  				 
											  			</div>
											  		</div>
											  	</div>
							  					<?php
							  				}
							  				if($count<$doc['countratings'])
							  				{
							  					?>
							  						<center>
							  							<button onClick="loadmorereview();" class="btn btn-primary loadmorereview">Load More</button>
							  						</center>
							  					<?php
							  				}
							  			}
							  		?>
							  		
							  	</div>			 
							  					 
							  		</div>
										 
								
								<div class="clearfix"></div>  
							</div>
							<div class="tab-pane fade" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">
								<h3 class="tab-title">Services </h3>
									<div class="review-submit question-submit">
										<div class="col-md-12 lessservice">
							  			<?php
							  				if($doc['user_type']=='3')
							  				{
							  					if(count($doc['services']))
								  				{
								  					$i= 1; 
								  					foreach ($doc['services'] as $services) {
								  						if($i<=10)
								  						{
								  						?>
								  							<div class="col-sm-4" style="margin-bottom: 30px;">
								  								<?= $services['service_name'];?>
								  							</div>
								  						<?php
								  						$i++;
								  						}
								  					}
								  					if(count($doc['services'])>10)
								  					{
								  						?>
								  							<div class="col-sm-4" style="margin-bottom: 30px;">
								  								<a href="#" style="color:#5672f9;" onClick="$('.allservices').show(); $('.lessservice').hide();">Show All</a>
								  							</div>
								  						<?php	
								  					}
								  				}
							  				}
							  				else if($doc['user_type']=='2')
							  				{
							  					echo $doc['user_service'];
							  				}
								  				
							  			?>		 	
							  			</div>		 
							  			<div class="col-md-12 allservices" style="display: none;">
							  			<?php
							  				if(count($doc['services']))
							  				{
							  					foreach ($doc['services'] as $services) {
							  						?>
							  							<div class="col-sm-4" style="margin-bottom: 30px;">
							  								<?= $services['service_name'];?>
							  							</div>
							  						<?php
							  					}
							  					?>
							  						<div class="col-sm-4" style="margin-bottom: 30px;">
						  								<a href="#" style="color:#5672f9;" onClick="$('.lessservice').show(); $('.allservices').hide();">Show Less</a>
						  							</div>
							  					<?php
							  				}
							  			?>		 	
							  			</div>		 
							  					 
							  		</div>
										 
								
								<div class="clearfix"></div>  
							</div>
							<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
								<?php
							  			if(!$doc['eligiblerating'] && isset($_SESSION['patient_id']))
							  			{							  			
							  		?>
							  		<div class="review-submission">
							  			<h3 class="tab-title">Submit your review</h3>
						  				<!-- Rate -->
						  				<div class="rate">
						  					<center>
											<span class="fa fa-star checked fa-2x" onclick="rate('1');" id="star1"></span>
											<span class="fa fa-star checked fa-2x  " onclick="rate('2');" id="star2"></span>
											<span class="fa fa-star checked fa-2x  " onclick="rate('3');" id="star3"></span>
											<span class="fa fa-star checked fa-2x  " onclick="rate('4');" id="star4"></span>
											<span class="fa fa-star  checked fa-2x  " onclick="rate('5');" id="star5"></span>
											</center>
						  				</div>
						  				<div class="review-submit">
						  					<form action="<?= base_url('Medical/storeratings');?>" method="post" class="row">
						  						<input type="hidden" id="ratings" name="ratings" value="5"> 
						  						<input type="hidden" id="user_id" name="user_id" value="<?= $doc['id'];?>"> 
						  						<div class="col-12">
						  							<textarea name="comment" required id="comment" rows="4" class="form-control" placeholder="Write Your Review"></textarea>
						  						</div>
						  						<div class="col-12">
						  							<br>
						  							<button type="submit" class="btn btn-main">Sumbit</button>
						  						</div>
						  					</form>
						  				</div>
							  		</div>
							  		<?php
							  			}
							  		?>
								<h3 class="tab-title"> Feedback</h3>
								<div class="product-review">
							  		<?php
							  			if($count = count($doc['ratings']))
							  			{
							  				foreach ($doc['ratings'] as $ratings) {
							  					?>
							  						<div class="row ratingdiv">
							  						<div class="media">
											  			 
											  			<!-- <?php
														if($doc['user_image']!='')
														{
															?>
																<img src="<?= base_url('images/user/'.$doc['id'].'/'.$doc['user_image']);?>" style="max-width: 200px;" class="img img-responsive" alt="<?= $doc['user_name'];?>"   />
																 
															<?php
														}
														else{
															?>
																<img src="<?= base_url('img/doc.png');?>"  style="max-width: 200px;"  class="img img-responsive" alt="<?= $doc['user_name'];?>"/>
															<?php
														}														
														?>
											  			 --> 
											  			<div class="media-body">
											  				<!-- Ratings -->
											  				<div class="ratings">
											  					<div class="name">
												  					<h5><?= $ratings['user_name'];?></h5>
												  				</div>
											  					 <?php
																	if($ratings['ratings']!=0)
																	{	
																		$totalrating1 = $ratings['ratings'];
																		$totalratings = $ratings['ratings'];
																		//echo $totalratings;
																		$starrating = 1;
																		//echo $totalratings;
																		$lastrating  = 5-ceil($totalratings);
																		while($starrating<= $totalratings)
																		{
																			?>
																				<span class="fa fa-star checked" ></span>
																			<?php
																			$starrating++;
																		}																 
																		while($lastrating!=0)
																		{
																			?>
																				<span class="fa fa-star" ></span>
																			<?php
																			$lastrating--;
																		}
																	?>
																 
																<?php
																	}
																?>
											  				</div>
											  				
											  				<div class="date">
											  					<p><?= date("M d, Y",strtotime($ratings['created_at']));?></p>
											  				</div>
											  				<div class="review-comment">
											  					<p class="text text-justify">
											  						<?= $ratings['comment'];?>
											  					</p>
											  				</div>
											  			</div>
											  		</div>
											  	</div>
							  					<?php
							  				}
							  				if($count<$doc['countratings'])
							  				{
							  					?>
							  						<center>
							  							<button onClick="loadmorereview();" class="btn btn-primary loadmorereview">Load More</button>
							  						</center>
							  					<?php
							  				}
							  			}
							  		?>
							  		
							  	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	<!-- Container End -->
</section>
<!--============================
=            Footer            =
=============================-->
<?php
	include('includes/footer.php');
?>
	<script type="text/javascript">
		var number 	=	1;
		function rate(ratings){
			
			var star=1;
			$('#ratings').val(ratings);
			$('.fa-star').removeClass('checked');
			while (star <=ratings)
			{
				$('#star'+star).addClass('checked');
				star++;
			}
			$(this).addClass('checked');
		}
		function loadmorereview(){
			//alert(number);
			$.ajax({
				type 	: 	"POST",
				url 	: 	"<?= base_url('medical/showreview');?>",
				data 	: 	{
								"user_id"	: 	"<?= $doc['id'];?>",
								"number"	: 	number,
				},
				success :  function(data){
					console.log(data);
					data 	=	data.trim();
					if(data == '0')
					{
						$('.loadmorereview').hide();
					}
					else{
						$('.ratingdiv').append(data);
					}
				}
			});
			number++;
		}
		 
		 
	</script>
  <script src="<?= base_url('web/');?>plugins/jquery/dist/jquery.min.js"></script>
  
  <script src="<?= base_url('web/');?>plugins/tether/js/tether.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/raty/jquery.raty-fa.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/popper.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/slick-carousel/slick/slick.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
  <script src="<?= base_url('web/');?>plugins/fancybox/jquery.fancybox.pack.js"></script>
  <script src="<?= base_url('web/');?>plugins/smoothscroll/SmoothScroll.min.js"></script>
  
  <script src="<?= base_url('web/');?>js/scripts.js"></script> 

</body>

</html>