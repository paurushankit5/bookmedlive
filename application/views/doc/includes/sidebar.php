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
                        <a href="<?= base_url('Doc/dashboard');?>">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='profile'){echo "class='active'";}?> >
                        <a href="<?= base_url('Doc/Profile');?>">
                            <i class="material-icons">person</i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='myappointments'){echo "class='active'";}?> >
                        <a href="<?= base_url('Doc/myappointments');?>">
                            <i class="material-icons">date_range</i>
                            <p>My Appointments</p>
                        </a>
                    </li>
                    <!--<li <?php if($_SESSION['page']=='myrevenue'){echo "class='active'";}?> >
                        <a href="<?= base_url('Doc/myrevenue/'.date('Y-m'));?>">
                            <i class="material-icons">account_balance_wallet</i>
                            <p>My Revenue</p>
                        </a>
                    </li>-->
                    <li <?php if($_SESSION['page']=='mypatients'){echo "class='active'";}?> >
                        <a href="<?= base_url('Doc/mypatients/');?>">
                            <i class="material-icons">account_balance_wallet</i>
                            <p>My Patients</p>
                        </a>
                    </li>
                    <?php
                        if($_SESSION['user']['user_type']  ==  '4')
                        {
                          ?>
                            <li <?php if($_SESSION['page']=='timings'){echo "class='active'";}?>>
                                    <a href="<?= base_url('Doc/doctiming');?>">
                                        <i class="material-icons">alarm_on</i>
                                        <p>Timings</p>
                                    </a>
                            </li>
                         <?php
                        }
                        else{
                            ?>
                            <li <?php if($_SESSION['page']=='timings'){echo "class='active'";}?>>
                                    <a href="<?= base_url('Doc/timings');?>">
                                        <i class="material-icons">alarm_on</i>
                                        <p>Timings</p>
                                    </a>
                            </li>
                            <?php
                        }
                    ?>
                   

                    <li  <?php if($_SESSION['page']=='gallery'){echo "class='active'";}?>>
                        <a href="<?= base_url('Doc/gallery');?>">
                           <i class="material-icons">camera_enhance</i>
                            <p>Gallery</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='specialisation'){echo "class='active'";}?>>
                        <a href="<?= base_url('Doc/specialisation');?>">
                            <i class="material-icons">stars</i>
                            <p>Specialisation</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='documents'){echo "class='active'";}?>>
                        <a href="<?= base_url('Doc/documents');?>">
                            <i class="material-icons">assignment_late</i>
                            <p>Documents</p>
                        </a>
                    </li>

                    <li <?php if($_SESSION['page']=='leave'){echo "class='active'";}?>>
                        <a href="<?= base_url('Doc/leave');?>">
                            <i class="material-icons">all_inclusive</i>
                            <p>Leave</p>
                        </a>
                    </li>
                    <li <?php if($_SESSION['page']=='questions'){echo "class='active'";}?>>
                        <a href="<?= base_url('Doc/questions');?>">
                            <i class="material-icons text-gray">notifications</i>
                            <p>Questions</p>
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