<div class="sidebar" data-color="purple" data-image="<?= base_url('assets/health/');?>/assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="<?= base_url(); ?>" class="simple-text">
                    <!-- <?= substr($_SESSION['user']['user_name'],0,15);?>  -->
                     <img src="<?= base_url('img/');?>logo4.png" style="    height: 60px;zoom: 1.3;" class="logo img img-responsive" alt="BOOKMEDIZ">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li <?php if($_SESSION['page']=='dashboard'){echo "class='active'";}?> >
                        <a href="<?= base_url('Diagnosis/dashboard');?>">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='profile'){echo "class='active'";}?> >
                        <a href="<?= base_url('Diagnosis/Profile');?>">
                            <i class="material-icons">person</i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='timings'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/timings');?>">
                            <i class="material-icons">content_paste</i>
                            <p>Timings</p>
                        </a>
                    </li>
                   <li <?php if($_SESSION['page']=='leave'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/leave');?>">
                            <i class="material-icons">content_paste</i>
                            <p>Leave</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='category'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/category');?>">
                            <i class="material-icons">content_paste</i>
                            <p>Test Category</p>
                        </a>
                    </li>
                    
                    <li <?php if($_SESSION['page']=='tests'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/testwedo');?>">
                            <i class="material-icons">content_paste</i>
                            <p>Test We Perform</p>
                        </a>
                    </li>
                   
                    <li  <?php if($_SESSION['page']=='appointments'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/appointments');?>">
                           <i class="material-icons">camera_enhance</i>
                            <p>Appointments</p>
                        </a>
                    </li>
                    <!-- <li <?php if($_SESSION['page']=='myrevenue'){echo "class='active'";}?> >
                        <a href="<?= base_url('Diagnosis/myrevenue/'.date('Y-m'));?>">
                            <i class="material-icons">account_balance_wallet</i>
                            <p>My Revenue</p>
                        </a>
                    </li> -->
                    <li <?php if($_SESSION['page']=='questions'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/questions');?>">
                            <i class="material-icons text-gray">notifications</i>
                            <p>Questions</p>
                        </a>
                    </li>
                    
                    <li  <?php if($_SESSION['page']=='gallery'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/gallery');?>">
                           <i class="material-icons">camera_enhance</i>
                            <p>Gallery</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='ownership'){echo "class='active'";}?>>
                        <a href="<?= base_url('Diagnosis/ownership');?>">
                            <i class="material-icons">location_on</i>
                            <p>Ownership </p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('myprofile/changepassword');?>">
                            <i class="material-icons text-gray">notifications</i>
                            <p>Change Password</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('logout');?>">
                            <i class="fa fa-sign-out"></i>
                            <p>Logout</p>
                        </a>
                    </li> 
                    <li>
                        <a href="#">
                             
                        </a>
                    </li> 

                </ul>
            </div>
        </div>
