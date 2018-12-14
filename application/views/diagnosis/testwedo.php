<?php
    $cat  =   $array['cat'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz Diagnosis Test We Do</title>
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
    <style>
        .label-floating img{
            height:250px;
            border:1px solid gray;
            border-radius: 10px;
        }
    </style>
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
                        <div class="col-md-12">
                            <?php
                                if($this->session->flashdata('certimsg'))
                                    echo $this->session->flashdata('certimsg');
                            ?>
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Test We Do  <a href="<?= base_url('Diagnosis/addtests'); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Tests</a></h4>
                                    <p class="category"></p>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if($this->session->flashdata('profilemsg')){
                                            echo $this->session->flashdata('profilemsg');
                                        }
                                    ?>
                                    <table class="table table-responsive table-bordered">  
                                    <?php
                                        if(count($cat))
                                        {
                                            foreach($cat as $x)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><a href="#" class="clicknow" onClick="showtests(this,'<?= $x['id'];?>');"><?= $x['cat_name']." (".$x['count'].")";?></a></td>
                                                        <td class="details"></td>
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
<script type="text/javascript">
    function showtests(a,id){
        $('.details').html('');
        $.ajax({
            type    :   "POST",
            url     :   "<?= base_url('Diagnosis/showtests');?>",   
            data    :    "test_cat_id="+id,
            success:   function(data){

                $(a).parent().next('td').html(data);
            }
        });
    }
    function deltest(a,id){
        //alert("hello");
        var r = confirm("Do you really want to delete this test?");
        if (r==true)
        {
            $.ajax({
                type   :    "POST",
                url    :    "<?= base_url('Diagnosis/deltest');?>",
                data   :    {
                                "test_id"   :   id,
                },
                success :   function(data)
                {
                    if(data==1)
                    {
                        $(a).parent().parent().slideUp();
                    }
                    else{
                        alert("We are facing some technical issues. Please try later.");
                    }
                }
            });
        }
    }
    window.onload = function() {
          $('.clicknow').click();
          //alert('hello');
        };
</script>
</html>
 
 