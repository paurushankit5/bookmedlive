  <header class="main-header">

    <!-- Logo -->
    <a href="<?= base_url('hosadmin');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BOOKMEDIZ</b></span>
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
              <img src="<?= base_url('img/admin/admin.png?nocache='.time());?>" class="user-image"  >
              <span class="hidden-xs">Super Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url('img/admin/admin.png?nocache='.time());?>" class="img-circle"  >

                <p>
                  Super Admin 
                </p>
              </li>
               
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                   
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('hosadmin/signout');?>" class="btn btn-default btn-flat">Sign out</a>
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
          <img src="<?= base_url('img/admin/admin.png?nocache='.time());?>" class="img-circle"  >
        </div>
        <div class="pull-left info">
          <a href="<?= base_url('home');?>"><p>Super Admin</p></a>
          <a href="<?= base_url('home');?>"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="<?= base_url('hosadmin/searchbyname');?>" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" required class="form-control" placeholder="Search user by name">
              <span class="input-group-btn">
                <button type="submit"  id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        
         <li <?php if($_SESSION['page']=='dashboard'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin');?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
         <li <?php if($_SESSION['page']=='appointment'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/appointment?m='.date('m').'&y='.date('Y'));?>"><i class="fa fa-try"></i>Appointment</a></li>
         <li <?php if($_SESSION['page']=='indidoc'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/indidoc');?>"><i class="fa fa-user-md"></i>Individual Doctors</a></li>
         <li <?php if($_SESSION['page']=='clinic'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/clinic');?>"><i class="fa fa-hospital-o"></i>Clinic</a></li>
         <li <?php if($_SESSION['page']=='hospital'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/hospital');?>"><i class="fa fa-hospital-o"></i>Hospital</a></li>
         <li <?php if($_SESSION['page']=='diagnosis'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/diagnosis');?>"><i class="fa fa-plus-square"></i>Diagnosis</a></li>
         <li <?php if($_SESSION['page']=='pending_users'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/pending_users');?>"><i class="fa fa-plus-square"></i>Pending Users</a></li>
         <li <?php if($_SESSION['page']=='myrevenue'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/myrevenue?m='.date('m').'&y='.date('Y'));?>"><i class="fa fa-money"></i>My Revenue</a></li>
         <li <?php if($_SESSION['page']=='trending'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/trending');?>"><i class="fa fa-plus-square"></i>Trending Clinic & Hospital</a></li>
         <li <?php if($_SESSION['page']=='getuserbylocation'){echo "class='active '";}?>> <a href="<?= base_url('Hosadmin/getuserbylocation');?>"><i class="fa fa-search"></i>Get User by location</a></li>
         <!-- <li> <a href="<?= base_url('Hosadmin/revenue');?>"><i class="fa fa-money"></i>Revenue</a></li> -->
        
         
         <li <?php if($_SESSION['page']=='speciality'){echo "class='active '";}?> > <a href="<?= base_url('Hosadmin/speciality');?>"><i class="fa fa-try"></i>Speciality</a></li>
         <li <?php if($_SESSION['page']=='services'){echo "class='active '";}?> > <a href="<?= base_url('Hosadmin/services');?>"><i class="fa fa-try"></i>Services</a></li>
         <li <?php if($_SESSION['page']=='department'){echo "class='active '";}?> > <a href="<?= base_url('Hosadmin/department');?>"><i class="fa fa-try"></i>Department</a></li>
         <li <?php if($_SESSION['page']=='test_category'){echo "class='active '";}?> > <a href="<?= base_url('Hosadmin/test_category');?>"><i class="fa fa-try"></i>Test Category</a></li>
         <li <?php if($_SESSION['page']=='states'){echo "class='active '";}?> > <a href="<?= base_url('Hosadmin/states');?>"><i class="fa fa-try"></i>States</a></li>
         
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Doctors</span>
             
          </a>
          <ul class="treeview-menu">
            <li id="addpractitioners"><a href="<?= base_url('home/addpractitioners');?>"><i class="fa fa-circle-o"></i> Add Doctors</a></li>
            <li id="practitioners"><a href="<?= base_url('home/practitioners');?>"><i class="fa fa-circle-o"></i>  Doctors List</a></li>
             
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Clinic</span>
             
          </a>
          <ul class="treeview-menu">
            <li id="addemployee"><a href="<?= base_url('home/addemployee');?>"><i class="fa fa-circle-o"></i> Add Clinic</a></li>
            <li id="clinicemployee"><a href="<?= base_url('home/clinicemployee');?>"><i class="fa fa-circle-o"></i>  Clinic List</a></li>
             
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Pathology</span>
             
          </a>
          <ul class="treeview-menu">
            <li id="addpathology"><a href="<?= base_url('home/addpathology');?>"><i class="fa fa-circle-o"></i> Add Pathology</a></li>
            <li id="pathlist"><a href="<?= base_url('home/pathlist');?>"><i class="fa fa-circle-o"></i>  Pathology List</a></li>
             
          </ul>
		  
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Patients</span>
             
          </a>
          <ul class="treeview-menu">
            <li id="addpatient"><a href="<?= base_url('home/addpatient');?>"><i class="fa fa-circle-o"></i> Add Patient</a></li>
            <li id="patientlist"><a href="<?= base_url('home/patientlist');?>"><i class="fa fa-circle-o"></i>  Patient List</a></li>
             
          </ul>
		  
        </li> -->
		<li class="treeview <?php if($_SESSION['page']=='settings'){echo "active";} ?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Settings</span>
             
          </a>
          <ul class="treeview-menu">
            <!--<li><a href="<?= base_url('hosadmin/servicecharge');?>"><i class="fa fa-circle-o"></i> Set Service Charge</a></li>-->
            <li><a href="<?= base_url('hosadmin/changepassword');?>"><i class="fa fa-circle-o"></i> Change Password</a></li>
            <li><a href="<?= base_url('hosadmin/changeemail');?>"><i class="fa fa-circle-o"></i> Change Email</a></li>
            <li><a href="<?= base_url('hosadmin/changepic');?>"><i class="fa fa-circle-o"></i> Change Profile Pic</a></li>
            <li><a href="<?= base_url('hosadmin/changemobile');?>"><i class="fa fa-circle-o"></i> Change Mobile</a></li>
            <li><a href="<?= base_url('hosadmin/delusers');?>"><i class="fa fa-circle-o"></i> Delete Users</a></li>
          </ul>
		</li>
		<li id="logout"> <a href="<?= base_url('hosadmin/signout');?>"><i class="fa fa-try"></i>Logout</a></li>
		  
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="loadingDiv"  id="loadingDiv" style="display:none;position:fixed;top:0px;right:0px;width:100%;height:100%;background-color:#666;background-image:url('<?= base_url('img/loading.gif');?>'); background-repeat:no-repeat;background-position:center;z-index:10000000;  opacity: 0.4;">
  <div>
    
  </div>
</div>
 