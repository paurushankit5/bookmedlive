<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookmediz: Enter OTP</title>
  
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
  <link href="<?= base_url('web/');?>css/style.css" rel="stylesheet">

  <!-- FAVICON -->
  <link href="<?= base_url('web/');?>img/favicon.png" rel="shortcut icon">

   <style>
      .partitioned {
      width:20%;
      float:left;
      padding:10px;
      text-align:center;
      font-size:20px;
      height:50px;
      border:0px;
      margin:2.5%;
      border-bottom:1px solid black;
     
}
 </style>

</head>

<body class="body-wrapper">


<?php
	include('includes/header.php');
?>
<!--==================================
=            User Profile            =
===================================-->

<section class="user-profile section">
	<div class="container">
		<div class="row">
			 
			<div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3" id="otpdiv" >
				<?php							 
					if($this->session->flashdata('otpmsg'))
					{
						echo "<div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;'><b>".$this->session->flashdata('otpmsg')."</b></p></div>";
					}
					
				 ?>	
				<!-- Edit Personal Info -->
				<div class="widget personal-info" 	>
						<h1 class="text text-center text-danger">Enter OTP</h1>
             
					     <div id="errmsg"></div>
								

						 <div class="form-group">
						     
						     <input class="partitioned" id="f1num"  onkeypress=" $(this).next().focus();"  type="text" maxlength="1" /> 
                 <input class="partitioned" id="f2num""  onkeypress=" $(this).next().focus();" type="text" maxlength="1" /> 
                 <input class="partitioned" id="f3num"  onkeypress=" $(this).next().focus();" type="text" maxlength="1" /> 
                 <input class="partitioned" id="f4num"  type="text" maxlength="1" /> 
						</div>
						 
            <br>
            <br>
				    <br>
						<button  onClick="checkotp();" class="btn btn-primary btn-block">Submit</button>
            <small style="display:none;" id="sendotpagain"><b><a href="#" onClick="sendotpagain();">(Send OTP Again)</a></b></small>
						 	 
				</div>	
				
				 
			</div>
			<div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3" style="display: none;" id="passdiv" >
				<div class="widget personal-info" 	>
				    <div class="form-group">
				      <label class="control-label col-sm-2" for="pwd">Password:</label>
				      <div class="col-sm-10">          
				        <input type="password" class="form-control" id="pwd" name="password" placeholder="Enter password" name="pwd">
				      </div>
				    </div>
				 	<div class="form-group">
				      <label class="control-label col-sm-2" for="pwd">Confirm Password:</label>
				      <div class="col-sm-10">          
				        <input type="password" class="form-control" id="pwd2" name="password" placeholder="Enter password Again" name="pwd2">
				      </div>
				    </div>
				 
				 	<div class="form-group">        
				      <div class="col-sm-offset-2 col-sm-10">
				        <button type="submit" onClick="setpasswordnow();" class="btn btn-primary">Submit</button>
				      </div>
				    </div>
				</div>
			</div>

		</div>
	</div>
</section>

<!--============================
=            Footer            =
=============================-->

<?php
	include('includes/footer.php');
?>
  <script>
  window.onload = function() {
  setTimeout(function(){$('#sendotpagain').show();},30000);
};
    function sendotpagain(){
      $.ajax({
         
          type  : 'POST',
          url   : '<?=base_url('login/sendforgototpagain');?>',
          data  :  '',
          beforeSend : function(){$('.loadingDiv').show();},
          success : function(data){
            data  = data.trim();
            data  = JSON.parse(data);
            $('.loadingDiv').hide();
            if(data.status  ==  1)
            {
              $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>New OTP Sent.</b></p></div>");
               setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
               $('#sendotpagain').hide();
               setTimeout(function(){$('#sendotpagain').show();},30000);
            }             
            else 
            {
              alert('System Failure');
            }
        }
    });
    }
    function checkotp(){
      var f1  = $("#f1num").val();
      var f2  = $('#f2num').val();
      var f3  = $('#f3num').val();
      var f4  = $('#f4num').val();
      if(f1 ==  '')
      {
        $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>Invalid OTP.</b></p></div>");
        setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
      }
      else if(f2  ==  '')
      {
         $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>Invalid OTP.</b></p></div>");
        setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
      }
      else if(f3  ==  '')
      {
         $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>Invalid OTP.</b></p></div>");
        setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
      }
      else if(f4  ==  '')
      {
         $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>Invalid OTP.</b></p></div>");
        setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
      }
      else{
        var q = f1+f2+f3+f4;
        $.ajax({
          type  : 'POST',
          url   : '<?=base_url('Login/checkforgototp');?>',
          data  : 'user_code='+q,
          success : function(data){
            data  = data.trim();
            data  = JSON.parse(data);
            console.log(data);
            if(data.status  ==  3)
            {
              $('#errmsg').fadeIn().html(" <div class='alert alert-danger' style='background-color:#000000;font-color:white;'><p style='color:white !important;' class='text text-center'><b>Invalid OTP.</b></p></div>");
               setTimeout(function(){ $('#errmsg').fadeOut(); }, 3000);
            }
            else if(data.status ==  2){
              $('#errmsg').show().html('<div class="alert alert-danger text text-center"><b><h4>We are facing some technoical issues. Please try after some time.</h4></b></div>');
              setTimeout(function(){ $('#errmsg').hide(); }, 10000);
            }
            else if(data.status ==  1)
            {
              $('#otpdiv').slideUp();
              $('#passdiv').slideDown();
            }
          }
        });
      }
      
      
    }
    function setpasswordnow(){
    	var pwd 	=	$('#pwd').val();
    	var pwd2 	=	$('#pwd2').val();
    	if(pwd.length<6)
    	{
    		alert('Password can not be less than 6 characters');
    	}
    	else if(pwd != pwd2){
    		alert('Passwords do not match');
    	}
    	else{
    		$.ajax({
    			  type  : 'POST',
		          url   : '<?=base_url('Login/setpassnow');?>',
		          data  : 'pwd='+pwd,
		          success : function(data){
		          	data  = data.trim();
		            data  = JSON.parse(data);
		            console.log(data);
		            if(data.status  ==  0)
		            {
		            	alert("We are facing some technical issues. Please try later.");
		            }
		            else{
		            	location.href="<?= base_url('login');?>"
		            }
		          }
    		});
    	}
    }
  </script>
  
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


</body>

</html>