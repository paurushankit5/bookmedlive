<?php
	$doc 	=	$array['doc'][0];
	//print_r($doc);
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Dr. <?= $doc['user_name'];?></title>
  
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 -->
  <style>
  	.checked {
		    color: orange;
		}

	ol li {
	  list-style-type: decimal;
	  padding:5px;
	  text-align: justify;
	}	
	
  </style>
 
</head>

<body class="body-wrapper" onload="checkurl();">
<?php
	include('includes/header.php');
?>
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center" style="padding-top:-100px;">
				<!-- Title text -->
				<h3>Dr. <?= $doc['user_name'];?></h3>
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
					<div class="widget price text-center hidden-xs">
						<h4>Appointment Charge</h4>
						<p>&#x20B9;  10</p> 
						<h4>&#x20B9;  <?= $doc['user_fee'];?> as consultancy fees to be paid at <?php if($doc['user_type'] == '6'){echo "hospital";} else{echo "clinic";} ?></h4>
						

						<br>
						<a href="<?= base_url('doctor/bookappointment/'.$doc['id']);?>" class="btn btn-transparent-white">Book Appointment</a>
					</div>
					<!-- User Profile widget -->
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
						<h4><a href="">Dr. <?= $doc['user_name'];?></a></h4>
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
						
						<ul class="list-inline mt-20">
							<li class="list-inline-item" onClick="$('#pills-profile-tab').click();"><a href="#"  class="btn btn-contact">Ask Question</a></li>
						</ul>
						</center>
					</div>
					 <div class="widget price text-center hidden-lg hidden-md hidden-sm">
						<h4>Appointment Charge</h4>
						<p>&#x20B9;  10</p> 
						<h4>&#x20B9;  <?= $doc['user_fee'];?> as consultancy fees to be paid at <?php if($doc['user_type'] == '6'){echo "hospital";} else{echo "clinic";} ?></h4>
						


						<br>
						<a href="<?= base_url('doctor/bookappointment/'.$doc['id']);?>" class="btn btn-transparent-white">Book Appointment</a>
					</div>
					 
					 
					 
					
				</div>
			</div>
			<div class="col-md-8">
				<div class="product-details">
					
					 
					<div class="content">
						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link  " id="pills-time-tab" data-toggle="pill" href="#pills-time" role="tab" aria-controls="pills-time" aria-selected="true">Timing</a>
							</li>
							<li class="nav-item">
								<a class="nav-link  " id="pills-services-tab" data-toggle="pill" href="#pills-services" role="tab" aria-controls="pills-services" aria-selected="true">Services</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Feedback</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Consult Q&A</a>
							</li>
							
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									<h3 class="tab-title">Speciality</h3>
									<p class="text text-justify">
										<?php
								    	/*if(count($doc['edu']))
								    	{
								    		foreach ($doc['edu'] as $x) {
								    			?>
								    				 
								    					 <?= $x['qualification_name'];?>-
								    					 <?= $x['qualification_specialization'];?>, 
								    					 
								    			<?php
								    		}
								    	}*/
								    	echo $doc['specialisation'];
								   	 ?>
									</p>

									<h3 class="tab-title">Available Days</h3>
									<p class="text text-justify">
										<b>
									<?php
										$day ='';
										if($doc['mon']==1)
										{
											$day .=  "Mon, ";
										}
										if($doc['tue']==1)
										{
											$day .=  "Tue,";
										}
										if($doc['wed']==1)
										{
											$day .=  " Wed,";
										}
										if($doc['thu']==1)
										{
											$day .=  " Thu,";
										}
										if($doc['fri']==1)
										{
											$day.= " Fri,";
										}
										if($doc['sat']==1)
										{
											$day.= " Sat,";
										}
										if($doc['sun']==1)
										{
											$day.= " Sun,";
										}
										echo substr($day,0,-1);										
									?>
									</b>
								</p>
								<h3 class="tab-title">More Info</h3>
								<table class="table table-bordered product-table">
								  <tbody>
								    <tr>
								      <td>Experience</td>
								      <td><?= $doc['user_experience'];?> years of experience</td>
								    </tr>
								    <tr>
								      <td>Location</td>
								      <td>
								      		<?php
								      			if($doc['user_clinic_id']!='0')
								      			{
								      				?>
								      				<h3><a href="<?= base_url('Medical/profile/'.$doc['user_clinic_id']);?>"  class="text-primary"><?= $doc['clinic_name'];?></a></h3>
								      				<?php

								      			}
								      			else{
								      				?>
								      				<h3><a href="#"  class="text-primary"><?= $doc['clinic_name'];?></a></h3>
								      				<?php
								      			}
								      		?>
								      		<?= $doc['adl1'];?>, <br>
								      		<?= $doc['adl2'];?>, <br>
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
								    <tr>
								      <td>Consultancy Fees</td>
								      <td>&#x20B9; <?= $doc['user_fee'];?> at <?php if($doc['user_type'] == '6'){echo "hospital";} else{echo "clinic";} ?></td>
								    </tr>
								    <?php
								    	if(count($doc['qualification'])){
								    		?>
								    			<td>Education</td>
								    			<td>
								    				<?php
								    					foreach ($doc['qualification'] as $x) {
								    						?>
								    						<?= $x['qualification_name']." - ".$x['qualification_college']." - ".$x['qualification_complete_year']; ?><br>
								    						<?php
								    					}
								    				?>
								    			</td>
								    		<?php
								    	}	
								    ?> 
								  </tbody>
								</table>
								<?php									
									
									if($doc['user_work']!='')
									{
										?>
											<div class="col-md-12">
											<h3 class="tab-title">Past & Present Working Details</h3>
											<p class="text text-justify"><?= $doc['user_work'];?></p>

										</div>
										<?php
									}
									if($doc['user_award']!='')
									{
										?>
											<div class="col-md-12">
											<h3 class="tab-title">Awards, Recognition & Memberships</h3>
											<p class="text text-justify"><?= $doc['user_award'];?></p>
										</div>
										<?php
									}
									if($doc['user_about']!='')
									{
										?>
											<div class="col-md-12">
											<h3 class="tab-title">About Me</h3>
											<p class="text text-justify"><?= $doc['user_about'];?></p>
											</div>
										<?php
									}
								?>
								

								 
								<div class="clearfix"></div>
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
											                    <div class="caption"></div>
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
							
							<div class="tab-pane fade" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab" >
									<h3 class="tab-title">Services Offered</h3>
									<div class="col-md-12"> <?= $doc['user_service'];?></div>
									<div class="clearfix"></div>
										 
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
								<h3 class="tab-title">Ask Question </h3>
								<?php
									if(isset($_SESSION['user']))
									{
										?>
											<div class="review-submit question-submit">
							  					 	
							  						<input type="hidden" id="question_doctor_id"  value="<?= $doc['id'];?>"> 
							  						<div class="col-sm-12">
							  							<textarea name="comment" required id="question_name" rows="4" class="form-control" placeholder="Write Your Question"></textarea>
							  						</div>
							  						<div class="col-sm-12">
							  							<br>
							  							<center><button onClick="askquestion();" class="btn btn-main btn-block">Sumbit</button></center>
							  						</div>
							  					 
							  				</div>
										<?php
									}
									else{
										?>
											<h4 class="text text-center">Please Login/Register to post your question.</h4>
											<center>
											<button class="btn btn-primary" onClick="gotologin();">Login/Register</button>
											</center>
										<?php
									}
								?>
								
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
						  					<form action="<?= base_url('doctor/storeratings');?>" method="post" class="row">
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
								<h3 class="tab-title">Doctor Review</h3>
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
		/*window.onload = function(){
			$("*:contains(More)").hide();
		    alert('hello');
		};*/
		 
		 
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
				url 	: 	"<?= base_url('Doctor/showreview');?>",
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
		function askquestion(){
			var question_name 	=	$('#question_name').val();
			var question_doctor_id 	=	$('#question_doctor_id').val();
			if(question_name =='')
			{
				alert('Please enter question first');
			}else{
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?= base_url('Doctor/storequestion');?>",
					data 	: 	{
									"question_name"				: 	question_name,
									"question_doctor_id"		: 	question_doctor_id,
									"question_doctor_id"		: 	question_doctor_id,
					},
					success :  function(data){
						//console.log(data);
						data 	=	data.trim();
						if(data == '0')
						{
							$('.question-submit').html("<div class='alert alert-danger'><b>We are facing some technical issues. Please try later.</b></div>");
						}
						else{
							$('.question-submit').html("<div class='alert alert-success'><b>Your question has been successfully received. We will get back to you with the answers.</b></div>");
						}
					}
				});
			}
		}
		function gotologin(){
			$.ajax({
					type 	: 	"POST",
					url 	: 	"<?= base_url('url/sessionurl');?>",
					data 	: 	{
									"url"				: 	"<?= base_url('doctor/viewprofile/'.$doc['id']);?>?q=pills-profile-tab",
									
					},
					success :  function(data){
						//console.log(data);
						data 	=	data.trim();
						location.href="<?= base_url('login');?>";
					}
				});
		}
		 
	</script>
	<?php
		if(isset($_GET['q']))
		{
			?>
				<script type="text/javascript">
					function checkurl(){
						var id 	= 	"<?= $_GET['q']; ?>";
						if(id!='')
						{
							$('#'+id).click();
						}
					} 
				</script>
			<?php
		}
		else{
			?>
				<script type="text/javascript">
					function checkurl(){
					}
				</script>
			<?php
		}
	?>
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