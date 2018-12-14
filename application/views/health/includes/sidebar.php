<div class="sidebar" data-color="purple" data-image="<?= base_url('assets/health/');?>/assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="<?= base_url(); ?>" class="simple-text">
                    <!-- <?= substr($_SESSION['user']['user_name'],0,15);?>  -->
                     <center><img src="<?= base_url('img/');?>logo4.png" style="    height: 60px;zoom: 1.3;" class="logo img img-responsive" alt="BOOKMEDIZ"></center>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li <?php if($_SESSION['page']=='dashboard'){echo "class='active'";}?> >
                        <a href="<?= base_url('Health/dashboard');?>">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='profile'){echo "class='active'";}?> >
                        <a href="<?= base_url('Health/Profile');?>">
                            <i class="material-icons">person</i>
                            <p> Profile</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='timings'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/timings');?>">
                            <i class="material-icons">content_paste</i>
                            <p>Timings</p>
                        </a>
                    </li>
                    <?php 
                        if($_SESSION['user']['user_type']=='3'){
                            ?>
                                <li <?php if($_SESSION['page']=='department'){echo "class='active'";}?>>
                                    <a href="<?= base_url('Health/department');?>">
                                        <i class="material-icons">tab</i>
                                        <p>Department</p>
                                    </a>
                                </li>
                                <li  <?php if($_SESSION['page']=='doctors'){echo "class='active'";}?>>
                                    <a href="<?= base_url('Health/selectdepartment');?>">
                                       <i class="material-icons">camera_enhance</i>
                                        <p>Doctors</p>
                                    </a>
                                </li>
                                <!-- <li  <?php if($_SESSION['page']=='revenue'){echo "class='active'";}?>>
                                    <a href="<?= base_url('Health/selectrevenuedepartment/');?>">
                                       <i class="material-icons">camera_enhance</i>
                                        <p>Revenue</p>
                                    </a>
                                </li> -->
                            <?php
                        }
                        else{
                            ?>
                            <li  <?php if($_SESSION['page']=='doctors'){echo "class='active'";}?>>
                                <a href="<?= base_url('Health/doctors');?>">
                                   <i class="material-icons">camera_enhance</i>
                                    <p>Doctors</p>
                                </a>
                            </li>
                             <!-- <li  <?php if($_SESSION['page']=='revenue'){echo "class='active'";}?>>
                                <a href="<?= base_url('Health/revenue/'.date('Y-m'));?>">
                                   <i class="material-icons">camera_enhance</i>
                                    <p>Revenue</p>
                                </a>
                            </li> -->
                            <?php
                        }
                    ?>
                   
                    
                   
                    <li  <?php if($_SESSION['page']=='appointments'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/appointments');?>">
                           <i class="material-icons">camera_enhance</i>
                            <p>Appointments</p>
                        </a>
                    </li>

                    <li  <?php if($_SESSION['page']=='specialities'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/specialities');?>">
                            <i class="material-icons">bubble_chart</i>
                            <p>Specialities</p>
                        </a>
                    </li>
                     <li  <?php if($_SESSION['page']=='services'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/services');?>">
                            <i class="material-icons">bubble_chart</i>
                            <p>Services</p>
                        </a>
                    </li>
                    <li  <?php if($_SESSION['page']=='gallery'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/gallery');?>">
                           <i class="material-icons">camera_enhance</i>
                            <p>Gallery</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='certificates'){echo "class='active'";}?>>
                        <a href="<?= base_url('Health/certificates');?>">
                            <i class="material-icons">location_on</i>
                            <p>Certificates </p>
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
