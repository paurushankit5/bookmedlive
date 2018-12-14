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
    <title>Bookmediz: My Specialization</title>
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
     <style>
         .padding{
            padding:20px;
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
                             		if($this->session->flashdata('docdetailmsg'))
                             		{
                             			echo $this->session->flashdata('docdetailmsg');
                             		}
                             	?>
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Education & Specialisation 
                                  
                                   <button class="btn btn-warning pull-right" onclick="showdel(this);"><i class="fa fa-pencil"></i> </button>
                                   <button class="btn btn-info pull-right" onclick="showaddform();"><i class="fa fa-plus"></i> Education</button>
                                    </h4>

                                    <br>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <div class="  hidden addform">
                                          <form    method="post" action="<?= base_url('Doc/storeeducation');?>">
                                          <div class="col-sm-12 "> 
                                                <INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable')" />
                                                <INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable')" />      
                                                <TABLE id="dataTable"   class="table table-responsive table-bordered">            
                                                    <tr>
                                                        <td><INPUT type="checkbox"  name="chk[]"/>
                                                             <input type="hidden" name="qualification_doctor_id" value="<?= $_SESSION['user']['id'];?>"/>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3 padding" id="select">
                                                           
                                                            <select class="form-control" required  onchange="checkval(this);"  id="doctor_qualification"  name="qualification_name[]">
                                                                 
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
                                                            <div class="col-md-2 padding">
                                                            <input type="text" class="form-control" required name="qualification_college[]" placeholder="College Name"/>
                                                            </div>
                                                            <div class="col-md-2 padding">
                                                            <select class="form-control" required name="qualification_complete_year[]" >
                                                                <option value=''>Year Completed</option>
                                                                <?php
                                                                    for($i=date('Y');$i>=1950;$i--)
                                                                    {
                                                                        ?>
                                                                        <option value='<?= $i; ?>'><?= $i;?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                           </div>
                                                           <div class="col-md-3 padding">
                                                            <select class="form-control" id="doctor_speciality" required="" name="qualification_specialization[]">
                                                                <?php
                                                                    if(count($specialities))
                                                                    {
                                                                        foreach($specialities as $x)
                                                                        {
                                                                            ?>
                                                                                <option value="<?= $x['speciality_name'];?>"><?= $x['speciality_name'];?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 padding">
                                                            <input type="text" class="form-control" name="qualification_course_name[]" placeholder="Name Of course "/> 
                                                        </div>
                                                        </td>
                                                    </tr>        
                                                </TABLE>
                                                <input type="submit" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                        if(count($edu))
                                        {
                                            echo "<table class='table table-responsive'><tr><th> Speciality</th><th>College</th><th>Year</th><th class='hidden del'>Action</th></tr>";
                                            foreach($edu as $ed)
                                            {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                if($ed['qualification_course_name']!=''){
                                                                    echo $ed['qualification_course_name']." - ";
                                                                }
                                                            ?>
                                                         
                                                         <?= $ed['qualification_specialization'];?>
                                                         -
                                                         <?= $ed['qualification_name'];?>
                                                             
                                                         </td>
                                                        <td><?= $ed['qualification_college'];?></td>
                                                        <td><?= $ed['qualification_complete_year'];?></td>
                                                       
                                                        <td class="hidden del">
                                                            <a href="<?= base_url('Doc/editspecialisation/'.$ed['qualification_id']);?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                            <button class="btn btn-danger" onclick="delnow('<?= $ed['qualification_id'];?>');"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                            echo "</table>";
                                        }
                                        else{
                                            ?>
                                            <p>No Records Dound.</p>
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
        function checkval(a){
            var val =$(a).val();
            //alert(val)
            if(val=='other')
            {
                //alert('in here');
                $('#select').html("<input type='text' required class='form-control' name='qualification_name[]' placeholder='Enter Your Education'/>");
            }
        }
    </SCRIPT>
    
            </div>
            <script type="text/javascript">
                function showaddform(){
                    //alert("hello");
                    $('.addform').toggleClass('hidden');
                }
                function showdel(a){
                    $(a).hide();
                    $('.del').removeClass('hidden');
                }
                function delnow(id){
                    var r = confirm("Are you sure");
                    if(r==true)
                    {
                        $.ajax({
                            type    : "POST",
                            data    :   {
                                "qualification_id"  :   id,
                            },
                            url     :   "<?= base_url('Doc/delspecilaity');?>",
                            success :   function(){
                                location.reload();
                            }
                        });
                    }
                }
            </script>
