<?php
    $user   =   $_SESSION['user'];
    $gallery   =   $array['gallery'];
 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Gallery</title>
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
                    <div class="row">
                         <?php
                         	if($this->session->flashdata('gallerymsg')){
                         		echo $this->session->flashdata('gallerymsg');
                         	}
                         ?>
                        <div class="col-md-4 col-md-offset-4">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="#pablo">
                                        <img class="img"  src="<?= base_url('img/upload.png');?>" />                                      
                                    </a>
                                </div>
                                <div class="content">
                                     
                                     
                                    <a href="#" class="btn btn-primary btn-round"  data-toggle="modal" data-target="#picmodal">Upload A Picture</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card showcard">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Gallery 
                               <?php
                                if(count($gallery))
                                {
                                    ?>
                                        <button class="btn btn-warning pull-right" onclick="showeditbox();"><i class="fa fa-pencil"></i></button>
                                    <?php
                                }
                               ?> 
                            </h4> 
                            <br>
                        </div>
                        <div class="card-content table-responsive">
                            <?php
                                if(count($gallery))
                                {
                                    echo "<div class='row'>";
                                    foreach($gallery as $img)
                                    {
                                        ?>
                                            <div class="col-sm-3" style="margin-bottom: 40px;">
                                                <img src="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>" style="height:250px;width:100%;"class="img img-responsive img-thumbnail" alt="Gallery Image">
                                                 
                                            </div>
                                        <?php
                                    }
                                    echo "</div>";
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                    	if(count($gallery))
                    	{
                    		echo "<div class='row editcard'  style='display:none;'>";
                    		foreach($gallery as $img)
                    		{
                    			?>
                    				<div class="col-sm-3" style="margin-bottom: 40px;">
                    					<img src="<?= base_url('img/gallery/'.$img['id'].'/'.$img['image_name']);?>" style="height:250px;width:100%;"class="img img-responsive img-thumbnail" alt="Gallery Image">
                                        <center><button onClick="deliimage('<?= $img['id'];?>','<?= $img['image_name'];?>',this);" class="btn btn-danger"><i class="fa fa-close pull-right"></i></button></center>
                    				</div>
                    			<?php
                    		}
                    		echo "</div>";
                    	}
                    ?>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
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
    <form method="post" action="<?= base_url('Health/addgallery');?>" enctype="multipart/form-data">
        
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
                        
                       <input type="file" id="img1" accept="image/*" onchange="readURL(this,'image1');" name="image_name" class="hidden"/>
            
                        
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
    $  =   jQuery.noConflict();
     function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
        function deliimage(str1,str2,a) {
            var r = confirm("Are you sure that you want to delete this image?");
            if(r==true)
            {
                $.ajax({
                    type    :   "POST",
                    url     :   "<?= base_url('Ajax/delimage');?>",
                    data    :   {
                                    "id"            :   str1,
                                    "image_name"    :   str2,
                    },
                    success: function(data){
                         $(a).parent().parent().slideUp();
                    }


                });
            }
        }
         function showeditbox(){
            $('.showcard').fadeOut();
            $('.editcard').fadeIn();
        }
</script>