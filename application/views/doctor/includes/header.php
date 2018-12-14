<?php
	$me	=	$array['me'];
?>
  <header class="main-header">

    <!-- Logo -->
    <a href="<?= base_url('doctordashboard');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Dashboard</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BOOKMEDIZ</b> </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img
			  <?php 
				if($me['doctor_pic']!='')
				{
				?> 
					src='<?= base_url("images/doc/".$me['doctor_id']."/".$me['doctor_pic']);?>'
				<?php
				}
				else
				{
				?>
					src="<?= base_url('assets/');?>dist/img/avatar5.png" 
				<?php
				}
			?> class="user-image"  >
              <span class="hidden-xs"><?= $me['doctor_name'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img <?php 
				if($me['doctor_pic']!='')
				{
				?> 
					src='<?= base_url("images/doc/".$me['doctor_id']."/".$me['doctor_pic']);?>'
				<?php
				}
				else
				{
				?>
					src="<?= base_url('assets/');?>dist/img/avatar5.png" 
				<?php
				}
			?> class="img-circle">

                <p>
                  <?= $me['doctor_name'];?>
                </p>
              </li>
              <!-- Menu Body -->
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= base_url('doctordashboard/myprofile');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('doctordashboard/signout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
	<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img <?php 
				if($me['doctor_pic']!='')
				{
				?> 
					src='<?= base_url("images/doc/".$me['doctor_id']."/".$me['doctor_pic']);?>'
				<?php
				}
				else
				{
				?>
					src="<?= base_url('assets/');?>dist/img/avatar5.png" 
				<?php
				}
			?> class="img-circle" >
        </div>
        <div class="pull-left info">
          <a href="<?= base_url('doctordashboard/');?>"><p><?= $me['doctor_name'];?></p></a>
          <a href="<?= base_url('doctordashboard/');?>"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
               
        <li id="myprofile"><a href="<?= base_url('doctordashboard/');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li id="myprofile"><a href="<?= base_url('doctordashboard/myprofile');?>"><i class="fa fa-circle-o text-red"></i> <span>My Profile</span></a></li>
        <li id="education"><a href="<?= base_url('doctordashboard/education');?>"><i class="fa fa-circle-o text-red"></i> <span>Education & Specialization</span></a></li>
        <li id="consultancyfee"><a href="<?= base_url('doctordashboard/consultancyfee');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Timing & Fee</span></a></li>
        <li id="mypatients"><a href="<?= base_url('doctordashboard/mypatients');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Patients</span></a></li>
        <li id="myappointments"><a href="<?= base_url('doctordashboard/myappointments');?>"><i class="fa fa-circle-o text-yellow"></i> <span>My Appointments</span></a></li>
        <li id="todaysappointments"><a href="<?= base_url('doctordashboard/todaysappointments');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Today's Appointments</span></a></li>
        <li id="revenue"><a href="<?= base_url('doctordashboard/revenue');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Revenue</span></a></li>
        <li id="answeredquestions"><a href="<?= base_url('doctordashboard/answeredquestions');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Answered Questions</span></a></li>
        <li id="vacations"><a href="<?= base_url('doctordashboard/leave');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Leave</span></a></li>
        <li id="vacations"><a href="<?= base_url('doctordashboard/signout');?>"><i class="fa fa-circle-o text-yellow"></i> <span>Logout</span></a></li>
         
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
   <script>
	//var jq = jQuery.noConflict();
	function makeactiveheader() {
		var newURL = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
		var pathArray = window.location.pathname.split( '/' );
		
		var nav_id	=	pathArray[2];
		document.getElementById(nav_id).classList.toggle("active");

		//alert(nav_id);
	}
	window.onload = makeactiveheader();
</script>
