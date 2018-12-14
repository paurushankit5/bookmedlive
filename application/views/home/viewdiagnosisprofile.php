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
  <title>Bookmediz:   <?= $doc['user_name'];?></title>
  
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
 -->  <style>
  	.checked {
	    color: orange;
	}
	.product-details .content .nav .nav-item{
		margin-bottom: 10px;
	}
	.white{
		color: white;
	}
	#sticky-footer {
    position: fixed;
    clear: both;
    width: 100%;
    height: 150px;
    bottom: 0;
    border: none;
    padding: 13px 0 0 0;
    text-align: center;
    color: white;    
    background-color: rgba(249, 86, 86, 0.75);
    border-top: #EA2E0D solid 4px;
    z-index: 1039;
    z-index: 1039;
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
				<h3>  <?= $doc['user_name'];?></h3>
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
					<div class="widget price text-center price hidden-xs" style="display:none;">
						<h4>Appointment Charge</h4>
						<p>&#x20B9;  10</p> 
						<h4>&#x20B9;  <span class="pricefield"></span> to be paid at diagnosis center</h4>
						

						<br> 
						<button class="btn btn-transparent-white " onClick="makepayment();">Book Appointment</button>
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
						<h4><a href="">  <?= $doc['user_name'];?></a></h4>
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
									$percentagerating = 		$totalratings *20;
								
													 
													
												  
							?>
							<br>
							<span style="font-size: 14px;">(<?= $percentagerating;?>% votes from <?= $doc['user_rated'];?> reviews)</span>
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
								<a class="nav-link" id="pills-test-tab" data-toggle="pill" href="#pills-test" role="tab" aria-controls="pills-tab" aria-selected="false">Tests</a>
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
								 

									 
								
								<h3 class="tab-title"> Info</h3>
								<table class="table table-bordered product-table">
								  <tbody>
								    <tr>
								    	<td>Available Days</td>
								    	<td>
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
												echo "<br>";
												echo date("g:i a", strtotime($doc['path_morning_start']))." to ". date("g:i a", strtotime($doc['path_morning_end']));
												echo "<br>";
												echo date("g:i a", strtotime($doc['path_evening_start']))." to ". date("g:i a", strtotime($doc['path_evening_end']));									
											?>
									</b>
								</p>
								    	</td>
								    </tr>
								    <tr>
								      <td>Location</td>
								      <td>
								      		<?php
								      			if($doc['user_clinic_id']!='0')
								      			{
								      				?>
								      				<h3><a href="<?= base_url('Medical/profile/'.$doc['user_clinic_id']);?>"><?= $doc['clinic_name'];?></a></h3>
								      				<?php

								      			}
								      		?>
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
											<h3 class="tab-title">About Me</h3>
											<p class="text text-justify"><?= $doc['user_about'];?></p>
										<?php
									}
								?>
								

								 
								<p></p>
								<?php
									if(count($doc['gallery']))
							        {
							     ?>
							     <br>
							     <br>
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
							<div class="tab-pane fade" id="pills-test" role="tabpanel" id="tests" aria-labelledby="pills-test-tab">
								<h3 class="tab-title">Test We Perform ( &#x20B9; 10 as appointment charge ) </h3>
								<?php
									if(count($doc['cat']))
									{
										?>
										<table class="table table-bordered " style="width:100%;"  >
										<?php
										foreach($doc['cat'] as $x)
										{
											?>
											<tr>
												<td><a href="#tests" onClick="showtests(this,'<?= $x['cat_id'];?>');" class="clicknow" style="color:#5672f9;"><b><?= $x['cat_name']; ?></a></b></td>
												 
											</tr>
											<?php
										}
									}
									?>
										</table>
									<?php
								?>
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
						  					<form action="<?= base_url('Testcenter/storeratings');?>" method="post" class="row">
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
								<h3 class="tab-title">Diagnosis Review</h3>
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
<div id="sticky-footer" style="display: none;" class="hidden-lg hidden-md hidden-sm price">
	<div class="col-md-12">
		<h4 class="white">Appointment Charge is &#x20B9;  10</h4>
		<h4 class="white">&#x20B9;  <span class="pricefield"></span> to be paid at diagnosis center</h4>
		<button class="btn btn-transparent-white btn-block" onClick="makepayment();">Book Appointment</button>
	</div>
</div>
<?php
	include('includes/footer.php');
?>
	<script type="text/javascript">
		var number 	=	1;
		var testprice = 0;
		var alltest = [];
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
						$('.ratingdiv').html(data);
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
									"url"				: 	"<?= base_url('Testcenter/viewprofile/'.$doc['id']);?>?q=pills-profile-tab",
									
					},
					success :  function(data){
						//console.log(data);
						data 	=	data.trim();
						location.href="<?= base_url('login');?>";
					}
				});
		}
		function showtests(a,cat_id){
			$.ajax({
				type 	: 'POST',
				url 	: "<?= base_url('Testcenter/gettests');?>",
				data 	: {
							"cat_id" 	: 	cat_id,
							"user_id" 	: 	"<?= $this->uri->segment(3); ?>",
				},
				success : 	function(data){
					$(a).parent().parent().append("<td>"+data+"</td>");
					 
					$(a).prop('onclick', null);
				}	
			});			
		}
		function addtest(a,test_id,test_name,test_price){
			
			$('.price').show();
			
			if(alltest.includes(test_id)==false)
			{
				alltest.push(test_id);
				$(a).removeClass('btn-primary');
				$(a).addClass('btn-danger');
				$(a).html("<i class='fa fa-times'></i>");
				testprice = ((testprice*10)+(test_price* 10))/10;

			}
			else{
				alltest = alltest.filter(function(item) { 
				    return item !== test_id;
				});
				$(a).addClass('btn-primary');
				$(a).removeClass('btn-danger');
				$(a).html("<i class='fa fa-plus'></i>");
				testprice = ((testprice*10)-(test_price* 10))/10;
				if(testprice=='0')
				{
					$('.price').hide();
				}
			}
			setTimeout(function(){$('.pricefield').html(testprice);},200); 
			console.log(alltest);
		}
		function makepayment(){
			$.ajax({
				type : 	'POST',
				url  :  '<?= base_url('Testcenter/storepayment');?>',
				data :   {
							"alltest"	: 	alltest,
							"path_id"	: 	'<?= $doc['id'];?>',
				},
				beforeSend : function(){
		  			$('#loadingDiv').show();
		  		},
		  		success : 	function(data){
		  			$('#loadingDiv').hide();
		  			if(data == 0)
		  			{
		  				window.location.href="<?= base_url('Error404');?>";
		  			}	 
		  			else{
		  				window.location.href="<?= base_url('Testcenter/booktestnow');?>";
		  			} 			
		  		}
			});
		}
		window.onload = function() {
		  $('.clicknow').click();
		  //alert('hello');
		  checkurl();
		}; 
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