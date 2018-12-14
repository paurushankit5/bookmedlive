<?php
    
    $edu    =   $array['edu'];
    $specialities    =   $array['speciality'];
   /* echo "<pre>";
    print_r($timings);
    echo "</pre>";*/
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: Doctor's List</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <div class="col-md-12">
                             
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Edit Education & Specialisation 
                                    
                                    </h4>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <form method="post" action="<?= base_url('Doc/updatespecialisation');?>">
                                            <input type="hidden" name="qualification_id" value="<?= $edu['qualification_id'];?>"/>
                                            <div class="col-sm-3" id="select">
                                            <select class="form-control" required onchange="checkval(this);"  id="qualification_name"  name="qualification_name">
                                                 
                                                <option value="<?= $edu['qualification_name']; ?>"><?= $edu['qualification_name']; ?></option>
                                                 <option value="MBBS">MBBS</option>
                                                <option value="BDS">BDS</option>
                                                <option value="MDS">MDS</option>
                                                <option value="BHMS">BHMS</option>
                                                <option value="BAMS">BAMS</option>
                                                <option value="MS">MS</option>
                                                <option value="MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS">MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS</option>
                                                <option value="BPTH/BPT">BPTH/BPT</option>
                                                <option value="MD">MD</option>
                                                <option value="MDS-ORAL & MAXILLOFACIAL SURGERY">MDS-ORAL & MAXILLOFACIAL SURGERY</option>
                                                <option value="other"> Other</option>
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="text" class="form-control" required name="qualification_college" value="<?= $edu['qualification_college'];?>" placeholder="College Name"/>
                                            </div>
                                            <div class="col-sm-2">
                                            <select class="form-control" required name="qualification_complete_year" >
                                                <option value=''>Year Completed</option>
                                                <?php
                                                    for($i=date('Y');$i>=1950;$i--)
                                                    {
                                                        ?>
                                                        <option value='<?= $i; ?>' <?php if($i==$edu['qualification_complete_year']){echo "selected";}?>><?= $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                           </div>
                                           <div class="col-sm-2">
                                            <select class="form-control" id="qualification_specialization" required="" name="qualification_specialization">
                                                <?php
                                                    if(count($specialities))
                                                    {
                                                        foreach($specialities as $x)
                                                        {
                                                            ?>
                                                                <option value="<?= $x['speciality_name'];?>" <?php if($x['speciality_name']==$edu['qualification_specialization']){echo "selected ";}?>><?= $x['speciality_name'];?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="qualification_course_name" value="<?= $edu['qualification_course_name'];?>" placeholder="Name Of course "/> 
                                        </div>
                                         <input type="submit" class="btn btn-primary" />
                                    </form>
                                    
                                </div>
                            </div>
                             
                                
                                
                        </div>
                         
                    </div>
                </div>
            </div>
           <?php
           		include('includes/footer.php');
           ?>
           <script>
               function checkval(a){
            var val =$(a).val();
            //alert(val)
            if(val=='other')
            {
                //alert('in here');
                $('#select').html("<input type='text' class='form-control' name='qualification_name' required placeholder='Enter Your Education'/>");
            }
        }
           </script>
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
   
     
