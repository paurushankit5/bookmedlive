<?php
	$cities					=	$array['cities'];
	$speciality				=	$array['speciality'];	
	$doctors				=	$array['doctors'];
	$searched_city			=	$array['searched_city'];
	$searched_speciality	=	$array['searched_speciality'];
	$limit					=	$array['limit'];
	$totalresults			=	$array['totalresults'];
	$pageresults			=	$array['pageresults'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bookmediz: Book Appointments With Doctor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('assets/');?>assets/favicon/apple-touch-icon-180x180.png">
	<style>
		.list-group-item.active{
       		padding: 0px 10px;
		}
		
	</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<?php
	include('includes/header.php');
?>
<div class=" text-center">
  
	<?php 
		include('includes/header2.php');
	?>
	
</div>
 
 <div class="container-fluid" style="margin-top:-100px;">
			<div class="row" style="min-height:400px;">
				 
				 <p class="text-center text-primary" style='font-family: "Lucida Bright",Georgia,serif;font-size:36px;'><b>Search Results</b> <small style="font-size:12px;">Showing 1 - <span id="filterresultscount"><span id="pageresults"><?= $pageresults; ?></span> results of <span id="totalresults"><?= $totalresults; ?></span></span></small></p>

				 
				<div class="col-sm-3">
				
					<div class="mini-submenu">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</div>
					<div class="list-group">
						<span href="#" class="list-group-item active">
							Availbility							 
						</span>
					 	<span href="#" class="list-group-item " style="padding:10px 5px;">
						 		 
						<label>M &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_mon" class="pull-right"/></label>&nbsp;&nbsp;
						<label>T &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_tues" class="pull-right"/></label>&nbsp;&nbsp;
						<label>W &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_wed" class="pull-right"/></label>&nbsp;&nbsp;
						<label>T &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_thurs" class="pull-right"/></label>&nbsp;&nbsp;
						<label>F &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_fri" class="pull-right"/></label>&nbsp;&nbsp;
						<label>S &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_sat" class="pull-right"/></label>&nbsp;&nbsp;
						<label>S &nbsp;<input type="checkbox" style="margin-top:8px;" value="1" id="doctor_sun" class="pull-right"/></label>
						</span>
					 
							<span href="#" class="list-group-item active">
								Price Range
								 
							</span>
							<span href="#" class="list-group-item ">
								 <input id="donate-slider" style="width:100%;" type="range"  min="0" max="1000" value="500">
									 
								 
							</span>
							<span href="#" style="font-size:16px;"  class="list-group-item">
								<b>&#x20B9; <span id="donate-text"> 500</span></b>
								 
							</span>
							<span href="#"   class="list-group-item">
								<button class="btn btn-primary btn-sm btn-block" onClick="applyfilter();"> Apply Filters</button>
							</span>
							
							<script>
						// Adjust the value and glyphicon based on the value
								document.getElementById('donate-slider').addEventListener('input', function() {
									var ammount = this.value
									document.getElementById('donate-text').innerHTML = ammount
								});
							</script>
						</div> 
				</div>
				<div class="col-sm-8" >
				<div class="row" id="mainarea">
					
					<?php
						if(count($doctors))
						{
							
							$i=	0;
							foreach($doctors as $x)
							{
								$days	=	'';
								if($x['doctor_mon']==1)
								{
									$days	.=	' Mon ';
								}
								if($x['doctor_tues']==1)
								{
									$days	.=	' Tue ';
								}
								if($x['doctor_wed']==1)
								{
									$days	.=	' Wed ';
								}
								if($x['doctor_thurs']==1)
								{
									$days	.=	' Thur ';
								}
								if($x['doctor_fri']==1)
								{
									$days	.=	' Fri ';
								}
								if($x['doctor_sat']==1)
								{
									$days	.=	' Sat ';
								}
								if($x['doctor_sun']==1)
								{
									$days	.=	' Sun ';
								}
							?>
							<div class="col-sm-12" >
								<div class="panel panel-success" style="border-radius:0px;">
									<div class="panel-heading">
										<b><?= $x['doctor_name'];?></b> 
										<?php
											if($x['doctor_clinic_id']!=0)
											{
												echo " (".$x['clinic_name'].")";
											}
										?>
									</div>
									<div class="panel-body" style="font-size:14px;">
										<div class="col-sm-2" style="verical-align:center;">
											<center>
											<img class="img img-responsive img-thumbnail img-rounded" style="height:100px;" 
											<?php
												if($x['doctor_pic']!='')
												{
												?>
													src="<?= base_url('images/doc/'.$x['doctor_id'].'/'.$x['doctor_pic']);?>"
													
												<?php
												}
												else
												{
													?>
													src="<?= base_url('images/doc/User.png');?>"
													<?php
												}
											?>
											/>
											</center>
										</div>
										<div class="col-sm-6">
											<?php
												if($x['qualification']!='')
												{
													?>
														<hr>
														<?= $x['qualification'];	?>
													<?php
												}
												if($x['specialization']!='')
												{
													?>
														<hr>
														<?= $x['specialization'];	?>
													<?php
												}
												if($x['doctor_city']!=''|| $x['clinic_city']!='')
												{
													?>
														<hr>
														<?php
															if($x['doctor_clinic_id']!='0')
															{
																echo $x['clinic_city'];
															}
															else{
																echo $x['doctor_city'];
															}
														

														?>
													<?php
												}
												if($days!='')
												{
													?>
														<hr>
														<i class="fa fa-money"></i> &#8377; <?= $x['doctor_fee'];?>
													<?php
												}
												
											?>
											
											 
											
											
										 
											
											
										</div>
										<div class="col-sm-3" style="font-size:12px;">
											<?php
												if($x['doctor_experience']!='')
												{
													?>
													<p><i class="fa fa-medkit"></i> <?= $x['doctor_experience'];?> Years Experirence</p>
													<?php
												}
												if(trim($days)!='')
												{
													?>
													<p><i class="fa fa-clock-o"></i> Available Days <i class="fa fa-caret-down"></i></p>
													<p> <?= $days; ?> </p>
													<?php
												}
											?>
											<p> <?= date('h:i:a',strtotime($x['doctor_morning_start_time']));?> - <?= date('h:i:a',strtotime($x['doctor_morning_end_time']));?> </p>
											<p> <?= date('h:i:a',strtotime($x['doctor_evening_start_time']));?> - <?= date('h:i:a',strtotime($x['doctor_evening_end_time']));?> </p>
											 
										</div>
									</div>
									<div class="panel-footer" style="padding:0px;">
										<div class="row">
										<div class="col-sm-4" style="margin:0px;">
											<a href="<?= base_url('doctor/details/'.$x['doctor_id']);?>" target="_blank"class="btn btn-primary btn-block" style="background-color:#337ab7;">View Details</a>
										</div>
										<div class="col-sm-4" style="margin:0px;">
											<?php
												if(isset($_COOKIE['patient_id']))
												{
												?>
												<a target="_blank" href="<?= base_url('patientdashboard/makeanappointment/'.$x['doctor_id']);?>" class="btn btn-success btn-block" 
												style="">Fix an Appointment</a>
												<?php
												}
												else
												{
												?>
												<button class="btn btn-success btn-block" onClick="openloginmodal('<?= base_url('patientdashboard/makeanappointment/'.$x['doctor_id']);?>');" style="">Fix an Appointment</button>
												
												<?php
												}
											?>
										</div>
										<div class="col-sm-4" style="margin:0px;">
											<?php
												if(isset($_COOKIE['patient_id']))
												{
												?>
												
											<button class="btn btn-primary btn-block" onClick="askaquestion('<?= $x['doctor_id'];?>');" style="background-color:#337ab7;">Ask A Question</button>
												<?php
												}
												else
												{
												?>
												<button class="btn btn-success btn-block" onClick="openloginmodal('');">Ask A Question</button>
												
												<?php
												}
											?>
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									</div>
										 
										
							</div>
							<?php	
								 
							 
							}
						}
						else
						{
							?>
							<!--
								<img src="<?= base_url('images/noresult.png');?>" style="width:100%;max-height:300px;" class="img img-responsive" alt="No Results Found"/>
								-->
								<div class="col-md-8 text text-center" style="border-radius:10px; border:1px solid gray;color:gray;height:250px;box-shadow: 5px 5px #888888;">
								<h3><i class="fa fa-frown-o fa-5x fa-red" aria-hidden="true"></i></h3>
								<h3> No Results Found</h3>
								</div>
							<?php
						}
					?>
					 
				</div>
				<?php
					if(count($doctors)>=$limit)
					{
						?>
						<button class="btn btn-primary btn-block" id="loadmore" onClick="loadmore();">Load More	</button>
				
						<?php
					}
				?>
				<button class="btn btn-primary btn-block" style="display:none;" id="loadmorefilter" onClick="loadmorefilter();">Load More</button>
				</div>
				
			</div>
		</div>
		
		
		
		
		
		
		
		 <script>
		var count=	0;
		var offset=	0;
		var city	=	'<?= $searched_city; ?>';
			var speciality	=	'<?= $searched_speciality; ?>';
		function applyfilter(){
			
			
			var doctor_mon	=	0;
			var doctor_tues	=	0;
			var doctor_wed	=	0;
			var doctor_thurs=	0;
			var doctor_fri	=	0;
			var doctor_sat	=	0;
			var doctor_sun	=	0;	
			if($('#doctor_mon').is(':checked')){var doctor_mon	=1};
			if($('#doctor_tues').is(':checked')){var doctor_tues	=1};
			if($('#doctor_wed').is(':checked')){var doctor_wed	=1};
			if($('#doctor_thurs').is(':checked')){var doctor_thurs	=1};
			if($('#doctor_fri').is(':checked')){var doctor_fri	=1};
			if($('#doctor_sat').is(':checked')){var doctor_sat	=1};
			if($('#doctor_sun').is(':checked')){var doctor_sun	=1};
					 
			var doctor_fee	=	$('#donate-slider').val();
			$('#loadmore').hide();
			var limit	=	'<?= $limit; ?>';
			offset	=	0;
			$.ajax({
				type	:	'POST',
				data	:	{
								'city'			:	city,
								'speciality'	:	speciality,
								'offset'		:	offset,
								'limit'			:	limit,
								'doctor_mon'	:	doctor_mon,
								'doctor_tues'	:	doctor_tues,
								'doctor_wed'	:	doctor_wed,
								'doctor_thurs'	:	doctor_thurs,
								'doctor_fri'	:	doctor_fri,
								'doctor_sat'	:	doctor_sat,
								'doctor_sun'	:	doctor_sun,
								'doctor_fee'	:	doctor_fee,
				},
				url		:	'<?= base_url('search/ajax_find_doctor_by_specilaity_filter');?>',
				success	:	function(data){
							data	=	data.trim();
							if(data=='0')
							{
								$('#noresult').html('<div class="col-md-8">No results.</div>');						
							}
							else{
								$('#mainarea').html(data);
								$('#loadmorefilter').show();
								$('#filterresultscount').html($('#mainarea .panel-success').length +' results');
							}
				}
			});
			
		}
		function loadmorefilter(){
			
			
			var doctor_mon	=	0;
			var doctor_tues	=	0;
			var doctor_wed	=	0;
			var doctor_thurs=	0;
			var doctor_fri	=	0;
			var doctor_sat	=	0;
			var doctor_sun	=	0;	
			if($('#doctor_mon').is(':checked')){var doctor_mon	=1};
			if($('#doctor_tues').is(':checked')){var doctor_tues	=1};
			if($('#doctor_wed').is(':checked')){var doctor_wed	=1};
			if($('#doctor_thurs').is(':checked')){var doctor_thurs	=1};
			if($('#doctor_fri').is(':checked')){var doctor_fri	=1};
			if($('#doctor_sat').is(':checked')){var doctor_sat	=1};
			if($('#doctor_sun').is(':checked')){var doctor_sun	=1};
					 
			var doctor_fee	=	$('#donate-slider').val();
			$('#loadmore').hide();
			var limit	=	'<?= $limit; ?>';
			
			offset	=	((limit*10)+(offset*10))/10;
			//alert(offset);
			
			$.ajax({
				type	:	'POST',
				data	:	{
								'city'			:	city,
								'speciality'	:	speciality,
								'offset'		:	offset,
								'limit'			:	limit,
								'doctor_mon'	:	doctor_mon,
								'doctor_tues'	:	doctor_tues,
								'doctor_wed'	:	doctor_wed,
								'doctor_thurs'	:	doctor_thurs,
								'doctor_fri'	:	doctor_fri,
								'doctor_sat'	:	doctor_sat,
								'doctor_sun'	:	doctor_sun,
								'doctor_fee'	:	doctor_fee,
				},
				url		:	'<?= base_url('search/ajax_find_doctor_by_specilaity_filter');?>',
				success	:	function(data){
							data	=	data.trim();
							if(data=='0')
							{
								alert('No More Results');						
								$('#loadmorefilter').hide();
							}
							else{
								$('#mainarea').append(data);
								$('#loadmorefilter').show();
								$('#filterresultscount').html($('#mainarea .panel-success').length +' results');
							}
				}
			});
			
			
		}
		function loadmore(){
			count++;
			
			limit	=	'<?= $limit; ?>';
			offset	=	((limit*10)+(offset*10))/10;
			$.ajax({
				type	:	'POST',
				data	:	{
								'city'			:	city,
								'speciality'	:	speciality,
								'offset'		:	offset,
								'limit'			:	limit,
				},
				url		:	'<?= base_url('search/ajax_find_doctor_by_speciality');?>',
				success	:	function(data){
							data	=	data.trim();
							if(data=='0')
							{
								alert('No more results');
								$('#loadmore').hide();
							}
							else{
								$('#mainarea').append(data);
								$('#pageresults').html($('#mainarea .panel-success').length);
							}
				}
			});
			 
			
		}
		function askaquestion(id){
			$('#question_doctor_id').val(id);
			$('#questionmodal').modal('toggle');
		}
		function storequestion(){
			var question_doctor_id	=	$('#question_doctor_id').val();
			var question_name	=	$('#question_name').val();
			if(question_name=='')
			{
				$('#questionmsg').show().html('<div class="alert alert-danger">Enter Your Question please.</div>');
				setTimeout(function(){ $('#questionmsg').hide(); }, 2000);
			}
			else{
				$.ajax({
					type 	:  'POST',
					url 	: 	'<?= base_url('patientdashboard/storequestions');?>',
					data    : 	{
									"question_name" 		: question_name,
									"question_doctor_id" 	: question_doctor_id,
								},
					success :  	function(data){
									data = data.trim();
									$('#questionmsg').show().html('<div class="">'+data+'</div>');
									setTimeout(function(){ $('#questionmsg').hide(); $('#question_name').val(''); $('#question_doctor_id').val(''); $('#questionmodal').modal('toggle')  }, 2000);
					}
				});
			}
		}
    </script>
	
 

<?php 
	include('includes/footer.php');
?>
 
<div id="questionmodal" class="modal fade" role="dialog" style="margin-top:100px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ask A Question</h4>
      </div>
      <div class="modal-body">
      	<span id="questionmsg"></span>
        <input type="hidden" id="question_doctor_id"/>
        <div class="form-group">
        	<label>Question</label>
        	<textarea class="form-control" id="question_name" placeholder="Enter Your Question"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="storequestion();"  >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 


</body>
</html>

