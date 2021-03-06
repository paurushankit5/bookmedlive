<?php
    $user   =   $array['doc'];
    $cities   =   $array['cities'];
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
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Edit Doctor's Profile</h4>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('profilemsg')){
                                            echo $this->session->flashdata('profilemsg');
                                        }
                                    ?>
                                    <form method="post" action="<?= base_url('Health/updatedocprofile/');?>">
                                        <div class="row">
                                             
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name*</label>
                                                    <input type="text" name="user_name" required value="<?= $user['user_name'];?>" class="form-control">
                                                    <input type="hidden" name="id" required value="<?= $user['id'];?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Gender* </label>
                                                    <label><input type="radio"  name="user_gender"   value="Male"     <?php if($user['user_gender']=="Male"){echo "checked";}?> > Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <label><input type="radio"  name="user_gender"   value="Female"  <?php if(
                                                    	$user['user_gender']=="Female"){echo "checked";}?>  > Female &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <label><input type="radio"  name="user_gender"   value="Others"  <?php if( $user['user_gender']=="Others"){echo "checked";}?>  > Others </label>
                                                </div>
                                            </div>
                                             
                                        </div>
                                        
                                         <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Consultancy fee in INR*</label>
                                                    <input type="text" name="user_fee" required   value="<?php echo $user['user_fee']; ?>"  pattern="[0-9]{3-4}" maxlength="4" class="form-control">
                                                </div>
                                            </div> 
                                         
                                            
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Consultancy Time in minutes*</label>
                                                     
                                                    <select class="form-control" name="user_time" required>
                                                        <?php
                                                            for($i=5;$i<=25;$i=$i+5)
                                                            {
                                                                ?>
                                                                    <option <?php if($_SESSION['user']['user_time']==$i){echo "selected";} ?> value="<?= $i; ?>"> <?= $i; ?></option>
                                                                <?php
                                                                //break;
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-md-6"> 
                                            <div class="form-group label-floating">
                                                <label class="control-label">Age*</label>
                                                <input type="text" name="user_age" required   value="<?php echo $user['user_age']; ?>"  pattern="[0-9]{2}" maxlength="2" class="form-control">
                                            </div>                                                           
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group label-floating">
                                                <label class="control-label">Experience*</label>
                                                <input type="number" name="user_experience" required   value="<?php echo $user['user_experience']; ?>"    maxlength="2" class="form-control">
                                            </div>                                                           
                                        </div>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Past & Present Working Details :</label>
                                                    <div class="form-group label-floating">
                                                        <textarea class="form-control" name="user_work" id="user_work" rows="3"><?= $user['user_work'];?></textarea>
                                                        <script>                                                                       
                                                                CKEDITOR.replace('user_work');                                     
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Award, Recognition & Memberships :</label>
                                                    <div class="form-group label-floating">
                                                        
                                                        <textarea class="form-control" name="user_award" id="user_award" rows="3"><?= $user['user_award'];?></textarea>
                                                         <script>                                                                       
                                                                CKEDITOR.replace('user_award');                                     
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>About Us:</label>
                                                    <div class="form-group label-floating">
                                                         
                                                        <textarea class="form-control" id="user_about" name="user_about" rows="5"><?= $user['user_about'];?></textarea>
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
                                     <h4 class="card-title">Dr. <?= $user['user_name'];?></h4>
                                     
                                    <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#picmodal">Change</a>
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
    <form method="post" action="<?= base_url('health/updatedocpic');?>" enctype="multipart/form-data">
        
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload A Pic</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                         <center><img src="<?= base_url('img/blankimg.jpg');?>" onClick="$('#img1').click();" class="img img-responsive" id="image1" style="width:auto;height:200px;"/>
                            </center><br><br>
                        <input type="hidden" name="id" value="<?= $user['id'];?>">
                        <input type="hidden" name="preimage" value="<?= $user['user_image'];?>">
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
 
<script>
    //jq  =   jQuery.noConflict();
     function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

 
</script>