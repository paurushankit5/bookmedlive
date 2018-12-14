<section style="    margin-bottom: -25px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" style="padding-top:15px;">
        <nav class="navbar navbar-expand-lg  ">
          <a class="navbar-brand" href="<?= base_url();?>" style="font-size:20px;">
            
          <img src="<?= base_url('img/');?>logo4.png" style="    height: 60px;margin-top: -20px;zoom: 0.7;" class="logo img img-responsive" alt="BOOKMEDIZ">
          <!--  <b style="font-size: 30px;"> <span style="color:#337ab7;">BOOK</span><span style="color:#8ec44a;">MEDIZ</b> -->
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" style="border-color:#546dfd;" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <?php
              if(isset($_SESSION['patient_id']))
              {
                ?>
                   <ul class="navbar-nav ml-auto main-nav ">
                    <!-- <li class="nav-item dropdown dropdown-slide">
                      <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Account <span><i class="fa fa-angle-down"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= base_url('myappointments');?>">My Appointments</a>
                      </div>

                    </li> -->
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('myprofile');?>">My Profile</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('mywallet');?>">My Wallet</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('myquestions');?>">My Questions</a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('myappointments');?>">My Appointments</a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('myprofile/changepassword');?>">Change Password</a>
                    </li>
                    
                    
                    

                  </ul>
                  <ul class="navbar-nav ml-auto mt-10 navbar-right">
                    <li class="nav-item">
                      <a class="nav-link login-button btn-primary" href="<?= base_url('Find/diagnosis');?>" style="background:#5672f9;"><i class="fa fa-search"></i> Diagnosis</a>
                    </li> 
                    <li class="nav-item">
                      <a class="nav-link login-button btn-success" href="<?= base_url('Logout');?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                  </ul>
                <?php
              }
              else if(isset($_SESSION['clinic_id']) || isset($_SESSION['hospital_id']))
              {
                ?>
                
              <ul class="navbar-nav ml-auto main-nav ">
             
               
               
              <!-- <li class="nav-item dropdown dropdown-slide">
                <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  My Account <span><i class="fa fa-angle-down"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="<?= base_url('health/dashboard');?>">Dashboard</a>
                </div>
              </li> -->
              <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Health/dashboard');?>">My Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Health/profile');?>">My Profile</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Health/scandir(directory)ervices');?>">Services</a>
                    </li>
            </ul>
                  <ul class="navbar-nav ml-auto mt-10 navbar-right">
                    <li class="nav-item">
                      <a class="nav-link login-button btn-primary" href="<?= base_url('Find/diagnosis');?>" style="background:#5672f9;"><i class="fa fa-search"></i> Diagnosis</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link login-button btn-success" href="<?= base_url('Logout');?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                  </ul>
                <?php
              }
              else if(isset($_SESSION['doctor_id']))
              {
                ?>
                  <ul class="navbar-nav ml-auto main-nav ">
                    <!-- <li class="nav-item dropdown dropdown-slide">
                      <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Account <span><i class="fa fa-angle-down"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= base_url('Doc/dashboard');?>">Dashboard</a>
                      </div>
                    </li> -->
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Doc/dashboard');?>">My Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Doc/profile');?>">My Profile</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Doc/myappointments');?>">My Appointments</a>
                    </li>

                  </ul>
                  <ul class="navbar-nav ml-auto mt-10 navbar-right">
                    <li class="nav-item">
                      <a class="nav-link login-button btn-primary" href="<?= base_url('Find/diagnosis');?>" style="background:#5672f9;"><i class="fa fa-search"></i> Diagnosis</a>
                    </li>  
                    <li class="nav-item">
                      <a class="nav-link login-button btn-success" href="<?= base_url('Logout');?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                  </ul>
                <?php
              }
              else if(isset($_SESSION['diagnosis_id']))
              {
                ?>
                  <ul class="navbar-nav ml-auto main-nav ">
                    <!-- <li class="nav-item dropdown dropdown-slide">
                      <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Account <span><i class="fa fa-angle-down"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= base_url('Doc/dashboard');?>">Dashboard</a>
                      </div>
                    </li> -->
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Diagnosis/dashboard');?>">My Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Diagnosis/profile');?>">My Profile</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('Diagnosis/appointments');?>">My Appointments</a>
                    </li>

                  </ul>
                  <ul class="navbar-nav ml-auto mt-10 navbar-right">
                    <li class="nav-item">
                      <a class="nav-link login-button btn-primary" href="<?= base_url('Find/diagnosis');?>" style="background:#5672f9;"><i class="fa fa-search"></i> Diagnosis</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link login-button btn-success" href="<?= base_url('Logout');?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                  </ul>
                <?php
              }               
              else{
                ?>
                   <ul class="navbar-nav ml-auto mt-10 navbar-right">
                    <li class="nav-item">
                      <a class="nav-link login-button btn-primary" href="<?= base_url('Find/diagnosis');?>" style="background:#5672f9;"><i class="fa fa-search"></i> Diagnosis</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link login-button" href="<?= base_url('Login');?>">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link login-button btn-success" href="<?= base_url('Register');?>"><i class="fa fa-plus-circle"></i> Register</a>
                    </li>
                  </ul>
                <?php
              }
            ?>
            
          </div>
        </nav>
      </div>
    </div>
  </div>
</section>
<div class="loadingDiv"  id="loadingDiv" style="display:none;position:fixed;top:0px;right:0px;width:100%;height:100%;background-color:#666;background-image:url('<?= base_url('img/loading.gif');?>'); background-repeat:no-repeat;background-position:center;z-index:10000000;  opacity: 0.4;">
  <div>
    
  </div>
</div>