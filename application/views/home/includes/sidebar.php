<div class="sidebar">
					 
	<!-- <div class="widget category">
		 
		<h5 class="widget-header">Important Links</h5>
		<ul class="category-list">
			<li><a href="<?= base_url('myprofile');?>" >My Profile </a></li>
			<li><a href="<?= base_url('mywallet');?>">My Wallet </a></li>
			<li><a href="<?= base_url('myquestions');?>">My Questions </a></li>
			<li><a href="<?= base_url('myappointments');?>">My Appointments</a></li>
			<li><a href="<?= base_url('myprofile/changepassword');?>">Change Password</a></li>
			
		</ul>
	</div> -->
	<div class="widget user-dashboard-menu hidden-xs">
		<h5 class="widget-header">Important Links</h5>
		<ul>
			<li <?php if($_SESSION['page']=="myprofile"){echo 'class="active"';} ?> ><a href="<?= base_url('myprofile');?>"><i class="fa fa-user"></i> My Profile</a></li>
			<li <?php if($_SESSION['page']=="mywallet"){echo 'class="active"';} ?>><a href="<?= base_url('mywallet');?>"><i class="fa fa-bookmark-o"></i> My Wallet </a></li>
			<li <?php if($_SESSION['page']=="myquestions"){echo 'class="active"';} ?>><a href="<?= base_url('myquestions');?>"><i class="fa fa-file-archive-o"></i>My Questions </a></li>
			<li <?php if($_SESSION['page']=="myappointments"){echo 'class="active"';} ?>><a href="<?= base_url('myappointments');?>"><i class="fa fa-bolt"></i> My Appointments</a></li>
			<li <?php if($_SESSION['page']=="changepassword"){echo 'class="active"';} ?>><a href="<?= base_url('myprofile/changepassword');?>"><i class="fa fa-cog"></i> Change Password</a></li>
			<li><a href="<?= base_url('logout');?>"><i class="fa fa-power-off"></i>Logout</a></li>
		</ul>
	</div>
	 
</div>