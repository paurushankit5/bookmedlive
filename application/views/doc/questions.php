<?php
    
    $que   	  =   $array['que'];
    $count    =   $array['count'];
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
    <title>Bookmediz: My Questions</title>
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
                    <div class="row" style="min-height: 500px;">
                        <div class="col-md-12">
                             	<?php
                             		if($this->session->flashdata('qmsg'))
                             		{
                             			echo $this->session->flashdata('qmsg');
                             		}
                             	?>
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">My Questions 
                                    
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <?php
                                        if(count($que))
                                        {
                                            ?>
                                            <table class='table table-responsive table-striped'>
                                            	<tr>
                                            		<td>Patient</td>
                                            		<td>Question</td>
                                            		<td>Asked On</td>
                                            		<td>Action</td>
                                            	</tr>
                                            <?php
                                            foreach($que as $q)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $q['user_name'];?>
                                                        <td><?= $q['question_name'];?></td>
                                                        
                                                        <td> <?= date('d,M Y',strtotime($q['question_add_time']));?></td>
                                                       
                                                        <td>
                                                        	<a href="#" class="btn btn-primary btn-xs" title="Show Data" onClick="showdata(this);"><i class="fa fa-arrow-down"></i></a>
                                                        	<?php
                                                    		if($q['question_ans']!='')
                                                    		{
                                                    			?>

                                                        	<a href="#" title="Clear Question" class="btn btn-danger btn-xs" onClick="deldata(this,'<?= $q['question_id'];?>');"><i class="fa fa-trash"></i></a>
															<?php
																}
															?>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none" class="datatr">
                                                    	<?php
                                                    		if($q['question_ans']=='')
                                                    		{
                                                    			?>
                                                    				<td colspan="4" style="padding:20px;">
                                                    					<form method="post" action="<?= base_url('Doc/storeans');?>">
                                                    					<input type="hidden" class="form-control" name="question_patient_id" value="<?= $q['question_patient_id'];?>">
                                                    					<input type="hidden" class="form-control" name="question_id" value="<?= $q['question_id'];?>">
                                                    					<textarea required class="form-control" name="question_ans" placeholder="Enter Your Answer Here" ></textarea>
                                                    					<br>
                                                    					<center>
                                                    						<input type="submit" class="btn btn-primary" value="Submit Answer" >
                                                    					</center>
                                                    					</form>
                                                    				</td>
                                                    			<?php
                                                    		}
                                                    		else{
                                                    			?>
                                                    			<td colspan="4" style="padding:20px;">
                                                    				<span class="pull-right">
                                                    					Answered On:<b>
                                                    					<?= date("d,M Y",strtotime($q['question_ans_add_time']));?></b>
                                                    				</span>
                                                    				<p class="text text-justify"><?= $q['question_ans'];?></p>
                                                    			</td>
                                                    			<?php
                                                    		}
                                                    	?>
                                                    </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                            	<td colspan="4">
                                            		<?= $this->pagination->create_links();?>
                                            	</td>
                                            </tr>
                                            <?php
                                            echo "</table>";
                                        }
                                        else{
                                            ?>
                                            <p>No Records Found.</p>
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
    <script type="text/javascript">
    	function showdata(a){
    		$('.datatr').slideUp();
    		$(a).parent().parent().next('.datatr').delay(200).slideDown('slow');
    	}
    	function deldata(a,question_id){
    		var r =	confirm("Are you sure, you want to clear this question?");
    		if(r==true)
    		{
    			$(a).parent().parent().slideUp('slow');
    			$.ajax({
    				type 	: 	"POST",
    				data 	: 	{
    								"question_id"	: 	question_id,
    				},
    				url 	: 	"<?= base_url('Doc/clearquestion');?>",
    				success	: 	function(data){
    					if(data == "0")
    					{
    						alert("We are facing some technical issues. Please try later.");
    					}
    				}
    			});
    		}
    	}
    </script>
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
  
    