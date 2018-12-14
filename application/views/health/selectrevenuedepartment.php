<?php
    $subdept   =   $array['subdept'];
    
     
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Select Department</title>
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
                    <div class="row" style="min-height: 400px;">
                        <div class="col-md-12">
                            
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Select Department to check its revenue</h4>
                                    
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('docmsg')){
                                            echo $this->session->flashdata('docmsg');
                                        }
                                    ?>
                                     <table class="table table-responsive">
                                     	<tr>
                                     		<td><b>#</b></td>
                                     		<td><b>Department</b></td>
                                     		<td><b>Doctors</b></td>
                                     	</tr>
                                     	<?php
                                     		if(count($subdept))
                                     		{
                                     			$i=0;
                                     			foreach($subdept as $x)
                                     			{
                                     				?>
                                     					<tr>
                                     						<td> <?= ++$i ; ?></td>
                                     						<td><?php if($x['doctorcount']!=0){ ?><a href="<?= base_url('Health/hospitalrevenue/'.$x['id'].'/'.date('Y-m'));?>"><b>  <?php } ?> <?= $x['name']; ?> <?php if($x['doctorcount']!=0){ ?></b></a>  <?php } ?></td>
                                     						<td> <?= $x['doctorcount']; ?></td>
                                     					</tr>
                                     				<?php
                                     			}
                                     		}
                                     	?>
                                     </table>
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
                         <center><img src="<?= base_url('img/blankimg.jpg');?>" onClick="jq('#img1').click();" class="img img-responsive" id="image1" style="width:auto;height:200px;"/>
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
    jq  =   jQuery.noConflict();
     function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              jq('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

 
</script>