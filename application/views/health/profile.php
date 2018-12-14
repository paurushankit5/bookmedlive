<?php
    $user   =   $_SESSION['user'];
    $cities   =   $array['cities'];
    $address   =   $array['address'];
    $acccount   =   $array['acccount'];
    $test     =   array(
                            "user_name","user_email","user_mob","user_alt_mob","user_about","user_image"
                        );
    if($user['user_type'] == '2')
    {
        array_push($test,"user_service");
    }
    $test1     =    array('adl1','adl2','location','city','state','pin');
    $test2     =    array('bank_ac_name','bank_ac_holder_name','bank_ac_no','bank_ac_ifsc_code','bank_ac_branch_name');
     $count = count($test)+count($test1)+count($test2);
     $point = 100/$count;
     $complete=0;
     foreach($test as $x)
     {
        if($user[$x]!='')
        {
            $complete += $point;
        }
     }
     if(count($address))
     {
         foreach($test1 as $x)
         {
            if($address[$x]!='')
            {
                $complete += $point;
            }
         }  
     }
     if(count($acccount))
     {
         foreach($test2 as $x)
         {
            if($acccount[$x]!='')
            {
                $complete += $point;
            }
         }  
     }
     $complete = ceil($complete);
     if($complete>100)
     {
        $complete=100;
     }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Edit Profile</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?= base_url('assets/health/');?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?= base_url('assets/health/');?>assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?= base_url('assets/health/');?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <script src="<?= base_url('ckeditor');?>/ckeditor.js"></script>
    <script src="<?= base_url('ckeditor/sample/');?>js/sample.js"></script> 
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="<?= base_url('assets/health/');?>assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <?php
                include('includes/sidebar.php');
            ?>
        </div>
        <div class="main-panel">
            <?php
                include('includes/header.php');
            ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 hidden-lg hidden-md">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <?php
                                        //print_r($user);
                                            if($user['user_image']=='')
                                            {
                                                ?>
                                                    <img class="img"  src="<?= base_url('img/expert.jpg');?>" />
                                                <?php
                                            }
                                            else{
                                                ?>
                                                   <img class="img" style="height:150px;" src="<?= base_url('images/user/'.$user['id'].'/'.$user['user_image']);?>" /> 
                                                <?php
                                            }
                                        ?>
                                        
                                    </a>
                                </div>
                                <div class="content">
                                     <h4 class="card-title"> <?= $user['user_name'];?></h4>
                                     
                                    <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#picmodal">Change</a>
                                </div>
                            </div>
                             
                        </div>
                        <div class="col-md-8">
                            <?php
                                if($this->session->flashdata('promsg'))
                                    echo $this->session->flashdata('promsg');
                            ?>
                            <div class="card showcard">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">My Profile
                                     <button class="btn btn-info pull-right" onclick="showedit();"><i class="fa fa-pencil"></i></button></h4>
                                    <br>
                                    
                                </div>
                                <div class="card-content">
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-primary progress-bar-" role="progressbar"
                                      aria-valuenow="<?= $complete; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $complete; ?>%">
                                        <?= $complete; ?>% Complete 
                                      </div>
                                    </div>
                                    <table class="table table-responsive">
                                        <tr>
                                            <th>Organisation Name</th>
                                            <th><?= $user['user_name'];?></th>
                                        </tr>
                                         <tr>
                                            <th>Email</th>
                                            <th><?= $user['user_email'];?></th>
                                        </tr>
                                         <tr>
                                            <th>Mobile</th>
                                             <th><?= $user['user_mob']; ?>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href='<?= base_url('myprofile/changenumber');?>'><i class='fa fa-pencil'></i></a><br>
                                                <?=$user['user_alt_mob'];?>
                                                
                                            </th>
                                        </tr>
                                        <?php

                                            if($user['user_type']=='2')
                                            {
                                                ?>
                                                    <tr>
                                                        <th>Services</th>
                                                        <th><p class="text text-justify"><?= $user['user_service'];?></p></th>
                                                    </tr> 
                                                <?php
                                            }
                                        ?>
                                        <tr>
                                            <th>About Us</th>
                                            <th><p class="text text-justify"><?= $user['user_about'];?></p></th>
                                        </tr>                                         
                                        <tr>
                                            <th>Address</th>
                                            <th>
                                                <?= $address['adl1'];?><br>
                                                <?= $address['adl2'];?><br>
                                                <?= $address['location'];?>
                                                <?= $address['city'];?>
                                                <?= $address['state'];?> -
                                                <?= $address['pin'];?>
                                            </th>
                                        </tr>
                                           
                                        
                                    </table>
                                </div>
                            </div>
                            <div class="card editcard hidden">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Edit Profile</h4>
                                    <p class="category">Complete your profile</p>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('profilemsg')){
                                            echo $this->session->flashdata('profilemsg');
                                        }
                                    ?>
                                    <form method="post" action="<?= base_url('Health/updateprofile');?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email </label>
                                                    <input type="text"   value="<?= $user['user_email'];?>" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Organisation Name</label>
                                                    <input type="text" name="user_name" required value="<?= $user['user_name'];?>" class="form-control">
                                                </div>
                                            </div>
                                             
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address Line 1</label>
                                                    <input type="text" required name="adl1" id="adl1" value="<?= $address['adl1'];?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address Line 2</label>
                                                    <input type="text" name="adl2" id="adl2" value="<?= $address['adl2'];?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Location</label>
                                                    <select class="form-control" name="location">
                                                        <?php
                                                            if(count($cities))
                                                            {
                                                                foreach($cities as $city)
                                                                {
                                                                    ?>
                                                                        <option value="<?= $city['city_name'];?>" <?php if($address['location']==$city['city_name']){echo "selected";} ?>><?= $city['city_name'];?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">City</label>
                                                    <input type="text" value="Rourkela" disabled  readonly class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Postal Code</label>
                                                    <input type="text" required name="pin" maxlength="6" value="<?= $address['pin'];?>" pattern="[0-9]{6}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                         <?php
                                            if($user['user_type']=='2')
                                            {
                                                ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Services Offered :</label>
                                                    <div class="form-group label-floating">
                                                         
                                                        <textarea class="form-control" id="editor2" name="user_service" rows="3"><?= $user['user_service'];?></textarea>
                                                        <script>                                                                       
                                                                CKEDITOR.replace('editor2');                                     
                                                        </script>
 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>About Us:</label>
                                                    <div class="form-group label-floating">
                                                         
                                                        <textarea class="form-control" name="user_about" id="user_about" rows="5"><?= $user['user_about'];?></textarea>
                                                        <script>                                                                       
                                                                CKEDITOR.replace('user_about');                                     
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile  hidden-xs hidden-sm">
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <?php
                                        //print_r($user);
                                            if($user['user_image']=='')
                                            {
                                                ?>
                                                    <img class="img"  src="<?= base_url('img/clinicdemo.jpg');?>" />
                                                <?php
                                            }
                                            else{
                                                ?>
                                                   <img class="img" style="height:150px;" src="<?= base_url('images/user/'.$user['id'].'/'.$user['user_image']);?>" /> 
                                                <?php
                                            }
                                        ?>
                                        
                                    </a>
                                </div>
                                <div class="content">
                                     <h4 class="card-title"><?= $user['user_name'];?></h4>
                                     
                                    <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#picmodal">Change</a>
                                </div>
                            </div>
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <?php
                                        //print_r($user);
                                            if($address['map']=='')
                                            {
                                                ?>
                                                    <img class="img"  src="<?= base_url('img/map.png');?>" />
                                                <?php
                                            }
                                            else{
                                                ?>
                                                   <img class="img" style="height:150px;" src="<?= base_url('images/address/'.$address['id'].'/'.$address['map']);?>" /> 
                                                <?php
                                            }
                                        ?>
                                        
                                    </a>
                                </div>
                                <div class="content">
                                     <h4 class="card-title">Add/Edit Google Map</h4>
                                     
                                    <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#mapmodal"><i class="fa fa-map-marker"></i></a>
                                </div>
                            </div>
                            <div class="card card-profile">
                                 
                                <div class="content">
                                     <h4 class="card-title">Bank Details</h4>
                                     <?php
                                        if(!count($acccount))
                                        {
                                            ?>
                                                <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#accountmodal">Add Account</a>

                                            <?php
                                        }
                                        else{
                                            ?>
                                            <table class="table table-responsive table-striped">
                                                <tr><th>Bank</th><th><?= $acccount['bank_ac_name'];?></th></tr>
                                                <tr><th>Account Holder</th><th><?= $acccount['bank_ac_holder_name'];?></th></tr>
                                                <tr><th>Account Number</th><th><?= $acccount['bank_ac_no'];?></th></tr>
                                                <tr><th>IFSC Code</th><th><?= $acccount['bank_ac_ifsc_code'];?></th></tr>
                                                <tr><th>Branch</th><th><?= $acccount['bank_ac_branch_name'];?></th></tr>
                                            </table>
                                            <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#accountmodal">Change Account</a>
                                            <?php
                                        }
                                     ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include('includes/footer.php');
            ?>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="<?= base_url('assets/health/');?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/health/');?>assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="<?= base_url('assets/health/');?>assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="<?= base_url('assets/health/');?>assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="<?= base_url('assets/health/');?>assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets/health/');?>assets/js/bootstrap-notify.js"></script>

<!-- Material Dashboard javascript methods -->
<script src="<?= base_url('assets/health/');?>assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url('assets/health/');?>assets/js/demo.js"></script>

</html>
<div id="picmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form method="post" action="<?= base_url('Health/updatepic');?>" enctype="multipart/form-data">
        
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload A Pic</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                         <center><img src="<?= base_url('img/blankimg.jpg');?>"  onClick="$('#img1').click();" class="img img-responsive" id="image1" style="width:auto;height:200px;"/>
                            </center><br><br>
                        
                       <input type="file" id="img1" accept="image/*" onchange="readURL(this,'image1');" name="user_image" class="hidden"/>
            
                        
                    </div>
                </div>
                 
                 
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div id="mapmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form method="post" action="<?= base_url('Health/storemap');?>" enctype="multipart/form-data">
        
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload A Pic for Googe Map</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                         <center><img src="<?= base_url('img/blankimg.jpg');?>"  onClick="$('#imgmap').click();" class="img img-responsive" id="imagemap" style="width:auto;height:200px;"/>
                            </center><br><br>
                        
                       <input type="file" id="imgmap" accept="image/*" onchange="readURL(this,'imagemap');" name="map" class="hidden"/>
            
                        
                    </div>
                </div>
                 
                 
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div id="accountmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
         
    <div class="modal-content">
    <form method="post" action="<?= base_url('Health/storeaccountdetails');?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Bank Account</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="bank_ac_name">Bank Name</label>              
                        <input type="text" required class="form-control" <?php if(count($acccount)){ echo 'value="'.$acccount['bank_ac_name'].'"';}?> name="bank_ac_name" id="bank_ac_name"/>
                    </div>
                    <div class="form-group">
                        <label for="bank_ac_holder_name">Account Holder's Name</label>              
                        <input type="text" <?php if(count($acccount)){ echo 'value="'.$acccount['bank_ac_holder_name'].'"';}?> required class="form-control" name="bank_ac_holder_name" id="bank_ac_holder_name"/>
                    </div>
                    <div class="form-group">
                        <label for="bank_ac_no">Account Number</label>              
                        <input type="text" <?php if(count($acccount)){ echo 'value="'.$acccount['bank_ac_no'].'"';}?> required class="form-control" name="bank_ac_no" id="bank_ac_no"/>
                    </div>
                    <div class="form-group">
                        <label for="bank_ac_ifsc_code">IFSC Code</label>              
                        <input type="text" <?php if(count($acccount)){ echo 'value="'.$acccount['bank_ac_ifsc_code'].'"';}?> required class="form-control" name="bank_ac_ifsc_code" id="bank_ac_ifsc_code"/>
                    </div>
                    <div class="form-group">
                        <label for="bank_ac_branch_name">Branch Name</label>              
                        <input type="text" <?php if(count($acccount)){ echo 'value="'.$acccount['bank_ac_branch_name'].'"';}?> required class="form-control" name="bank_ac_branch_name" id="bank_ac_branch_name"/>
                    </div>

                </div>
                 
                 
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
     </form>
    </div>
     
  </div>
</div>
<script>
   // jq  =   jQuery.noConflict();
     function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
        function showedit(){
            $('.showcard').fadeOut();
            $('.editcard').removeClass('hidden');
        }

 
</script>