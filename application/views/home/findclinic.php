<?php
$date = date("d-m-Y");
$date2 =	date("d-m-Y",strtotime($date)+86400);
$today = strtolower(date('D', strtotime($date)));
$tomorrow = strtolower(date('D', strtotime($date2)));
$midprice = 1000; 
$locality =	$array['locality'];
$allspeciality =	$array['allspeciality'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BOOKMEDIZ : Find doctors By Speciality</title>
  
  <!-- PLUGINS CSS STYLE -->
  <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
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
  <link href="<?= base_url('web/');?>css/sidebar.css" rel="stylesheet">
  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="<?= base_url('web/css');?>/ninja-slider-thumbnail.css" rel="stylesheet" type="text/css" />
  <script src="<?= base_url('web/js');?>/ninja-slider-thumbnail.js" type="text/javascript"></script>
  <script>
        function lightbox(idx) {
            //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
        }

        function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }
    </script>
  <style>
  	.product-details .content p {
  		
  	}
  	.checked {
		    color: orange;
		}
	.panel-title , .list-group-item label{
		font-size: 12px;
	}
	.list-group-item{
		padding: 5px;
		border:0px;
		border-radius:0px;
		border-bottom: 1px solid #ddd;

	}
.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 10px;
    border-radius: 5px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}
 
.product-details .content p {
    font-size:12px;
    line-height: 16px;
}
 @media (max-width: 480px) {
  .maincontainer {
    margin-top:-100px;
  }
}
</style>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="body-wrapper ">
 
 
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<?php
					include('includes/header.php');
				?>
			</div>
		</div>
	</div>
</section>
<section class="page-search" style="background: #213821;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
 				<!-- Advance Search -->
				<div class="advance-search content-block">
					<?php 
						include('includes/advancesearch.php');
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!--===================================
=            Store Section            =
====================================-->
<section class="section bg-gray" style="padding: 20px 0 100px 0;">
	<!-- Container Start -->
	<div class="container">
		<div class="row maincontainer">
			<!-- Left sidebar -->
			
			<div class="col-md-3 col-sm-3 " id="" style="margin-top:110px;">
				<div id="wrapper2" class="hidden-xs">
				<div class="panel-group" id="accordion">
					  <div class="panel panel-default">
					    <div class="panel-heading" >
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					        Availability</a>
					      </h4>
					    </div>
					    <div id="collapse1" class="panel-collapse collapse in" >
					      <div class="panel-body" style="padding:0px;">
					      	<ul class="list-group">
							  <li class="list-group-item" ><label for="<?= $today; ?>">Available Today </label> <input onChange="adddday();" type="checkbox" class="pull-right" value="1" id="<?= $today; ?>"/></li>
							  <!-- <li class="list-group-item" ><label for="<?= $tomorrow; ?>">Available Tomorrow </label> <input onChange="adddday();" type="checkbox" class="pull-right" value="1" id="<?= $tomorrow; ?>"/></li> -->
							  <li class="list-group-item" <?php if($today=="mon" ){echo "style='display:none;'";} ?> ><label for="mon">Monday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="mon"/></li>
							  <li class="list-group-item"  <?php if($today=="tue"){echo "style='display:none;'";} ?> ><label for="tue">Tuesday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="tue"/></li>
							  <li class="list-group-item"  <?php if($today=="wed"){echo "style='display:none;'";} ?> ><label for="wed">Wednesday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="wed"/></li>
							  <li class="list-group-item"  <?php if($today=="thu"){echo "style='display:none;'";} ?> ><label for="thu">Thursday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="thu"/></li>
							  <li class="list-group-item"  <?php if($today=="fri"){echo "style='display:none;'";} ?> ><label for="fri">Friday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="fri"/></li>
							  <li class="list-group-item"  <?php if($today=="sat"){echo "style='display:none;'";} ?> ><label for="sat">Saturday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="sat"/></li>
							  <li class="list-group-item"  <?php if($today=="sun"){echo "style='display:none;'";} ?> ><label for="sun">Sunday </label> <input type="checkbox" onChange="adddday();"  class="pull-right" value="1" id="sun"/></li>
							</ul>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
					        Speciality</a>
					      </h4>
					    </div>
					    <div id="collapse2" class="panel-collapse collapse in">
					      <div class="panel-body">
					      	<ul class="list-group">
								<?php
									if(count($allspeciality))
									{
										foreach ($allspeciality as $x) {
											?>
												<li class="list-group-item" ><label for="<?= $x['speciality_name'];?>"><?= $x['speciality_name'];?> </label> <input onChange="adddday();"  type="checkbox" class="pull-right speciality_filter" id="<?= $x['speciality_name'];?>" value="<?= $x['speciality_name'];?>" /></li>
											<?php
										}
									}
									 
								?>
									
							</ul>	 
					      </div>
					    </div>
					  </div>
					 
				 
					</div>
				</div>
			</div>
			<div class="col-md-9 col-sm-9" style="padd">

				<center>
					<button class="btn btn-primary hidden-md hidden-lg hidden-sm" onclick="showsidebar();"  id="menu-toggle">View Filters</button>
				</center>	
				<h1 class="product-title" style="font-size: 20px;">Search results for <b>"<?= $_GET['search'];?>"</b> in <b>"<?= $_GET['location'];?>, <?= $_GET['city'];?>"</b></h1>			 
				<div class="demodata product-details">

							
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
	include ('includes/footer.php');
?>

 <!-- JAVASCRIPTS -->
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
  <script type="text/javascript">
  	var loadnow 	=	0;
  	var sidebarshow 	=	0;
  	 var queries = {};
  	  
	  $.each(document.location.search.substr(1).split('&'),function(c,q){
	    var i = q.split('=');
	    queries[i[0].toString()] = i[1].toString();
	  });
	   
	  //console.log(queries);
	  function getresults(queries,day,speciality,offset,load){
	  	 if (day === undefined) {
		    day = '';
		  }
		   if (offset === undefined) {
		    offset = '0';
		  }
		 if (speciality === undefined) {
		    speciality = '';
		  }
		  if (day === undefined) {
		    day = '';
		  }
		  if (load === undefined) {
		    load = '0';
		  }
		  if(sidebarshow!=0)
		  {
			showsidebar();
		  }
		 // alert(speciality);
			sidebarshow++;
	  	$.ajax({
	  		type 	: 	"POST",
	  		url 	: 	"<?= base_url('Search/ajaxfindclinicbyname');?>",
	  		data 	: 	{
	  						"data"			: 	queries,
	  						"day"			: 	day,
	  						"offset"		: 	offset, 
	  						"load"			: 	load,
	  						"speciality"	: 	speciality,
	  		},
	  		beforeSend : function(){
	  			$('#loadingDiv').show();
	  			//alert(data);
	  			//alert("hello");
	  		},
	  		success : 	function(data){
	  			
	  			$('#loadingDiv').hide();
	  			if(load=='0')
	  			{
	  				$('.demodata').html(data);
	  			}else{
	  				$('.demodata').append(data);
	  			}
	  			
	  		}
	  	});
	  }
	  $( document ).ready(function() {
		   getresults(queries);
		});

	  function adddday(){
	  	loadnow=0;
		var day 	=	getday(); 		 
		var speciality 	=	getspeciality(); 		 
		getresults(queries,day,speciality);
	  }
	 
	  //this will return all day filter
	  function getday()
	  {
	  	var day 	=	[];
		if ($("#mon").is(':checked')){
		    day.push('mon');
		} 
		if ($("#tue").is(':checked')){
		    day.push('tue');
		} 
		if ($("#wed").is(':checked')){
		    day.push('wed');
		} 
		if ($("#thu").is(':checked')){
		    day.push('thu');
		} 
		if ($("#fri").is(':checked')){
		    day.push('fri');
		} 
		if ($("#sat").is(':checked')){
		    day.push('sat');
		} 
		if ($("#sun").is(':checked')){
		    day.push('sun');
		} 
		else{
			day.push["test"];
		}
		return day;
	  }
	   
	  function getspeciality(){
	  	var arr = [];
		$('input.speciality_filter:checkbox:checked').each(function () {
		    arr.push($(this).val());
		});
		return arr;
	  }
	function loadmore(a){
	  	loadnow++; 
	  	$(a).hide();
	  	var day =getday();
	  	var speciality =getspeciality();
	  	 
	  	getresults(queries,day,speciality,loadnow,1);
	}   
    function showsidebar(){ 
        $("#wrapper2").toggleClass('hidden-xs'); 
    }
    </script>
</body>

</html>