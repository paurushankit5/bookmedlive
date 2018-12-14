<?php
    $qualification    =   $array['qualification'];
    $demo          =     array();
    $speciality   =   $array['speciality'];
    $class= '';
   if(count($qualification))
    {
    	$class = "none";
    	foreach ($qualification as $x) {
    		$demo[]		=	$x['qualification_specialization'];
    	}
   }


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/health/');?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?= base_url('health/');?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Bookmediz: Our Specilaities</title>
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
                        <div class="col-md-12" style="min-height: 500px;">
                            
                                        
                                        
                                    
                                        <div class="card">
                                            <div class="card-header" data-background-color="purple">
                                                <h4 class="title">Specialities <button onclick="$('.form').slideDown();$('.info').hide();" class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Speciality</button></h4>
                                               <b> <p class="category">
                                                    Add/Edit Specialities 
                                                    
                                                </p></b>
                                                
                                            </div>
                                            <div class="card-content">

                                               
                                                <?php
			                                        if($this->session->flashdata('specmsg')){
			                                           echo $this->session->flashdata('specmsg');
			                                        }
			                                    ?>
                                                <div class="col-md-12  form" style="display: <?= $class; ?>">
                                                	<form class="form form-horizontal" method="post" action="<?= base_url('Health/storespeciality');?>">
                                                	<?php
                                                		if(count($speciality))
                                                		{
                                                			foreach ($speciality as $x) {
                                                				?>
                                                					<div class="col-sm-4">
	                                                					<div class="row" style="padding:10px;">
	                                                						<label><input type="checkbox" <?php if(in_array($x['speciality_name'],$demo)){echo "checked ";} ?>name="qualification_specialization[]"value="<?= $x['speciality_name'];?>"> <?= $x['speciality_name'];?></label>
	                                                					</div>
                                                					</div>
                                                				<?php
                                                			}
                                                			?>
                                                			<div class="clearfix"></div>
                                                			<div class="col-sm-12">
                                                				<button type="submit" class="btn btn-primary btn-block">Submit</button>
                                                			</div>
                                                			<?php
                                                		}
                                                	?>
                                              	  </form>
                                              	  <hr>
                                                </div>
                                                <div class="row info">
                                                <?php
				                               		if(count($qualification)){
				                                  		foreach ($qualification as $x) {
				                                  			?>
				                                  				<div class="col-sm-4">
				                                  				<div class="col-sm-12" style="padding: 10px;">
				                                  					<?= $x['qualification_specialization'];?>
				                                  						
				                                  					</div>
				                                  				</div>
				                                  			<?php
				                                  			}	
                                                	}
                                                ?>
                                            </div>
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
  <SCRIPT language="javascript">
        function addRow(tableID) {

            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var colCount = table.rows[0].cells.length;

            for(var i=0; i<colCount; i++) {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }

        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>
     