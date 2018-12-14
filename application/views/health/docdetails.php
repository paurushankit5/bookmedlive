<?php
    $doc    =   $array['doc'];
    $user    =   $array['doc'];
    $edu    =   $array['edu'];
    $specialities    =   $array['speciality'];
    $timings    =   $array['timings'];
   $council      =   $array['council'];
    $document    =   $array['document'];
    $department    =   $array['department'];

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
                            <?php
                                if(count($doc)){
                                    ?>
                                        <?php
                                            if($this->session->flashdata('docdetailmsg')){
                                                echo $this->session->flashdata('docdetailmsg');
                                            }
                                        ?>
                                        <div class="col-md-4 col-md-offset-4">
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
                                             <h4 class="card-title"><b>Dr. <?= $user['user_name'];?></b></h4>
                                             
                                            
                                        </div>
                                    </div>  
                                    </div>  
                                        <a href="<?= base_url('health/docappointment/'.$doc['id'].'/'.date('Y-m-d'));?>" class="btn btn-primary pull-right">Appointments</a>
                                        <div class="card">
                                            <div class="card-header" data-background-color="orange">
                                                <h4 class="title">Dr. <?= $doc['user_name'];?>  <a href="<?= base_url('Health/editdocdetails/'.$doc['id']);?>" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i></a></h4>
                                               <p class="category" style="color:white;">
                                                      
                                                    Status: 
                                                    <?php
                                                        if($doc['is_active']==0)
                                                        {
                                                            echo "Pending";
                                                        }
                                                        else if($doc['is_active']==1)
                                                        {
                                                            echo "Active";
                                                        }
                                                        else{
                                                            echo "Rejected";
                                                        }
                                                    ?>
                                                  
                                                </p>
                                                
                                            </div>
                                            <div class="card-content">
                                                 <div class="row">
                                                 <table class="table table-responsive">
                                                     <?php
                                                        if($doc['user_subdept_id']!='0')
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td>Department</td>
                                                                <th><?= $doc['department'];?>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#depmodal"><i class="fa fa-pencil"></i></a>
                                                                </th>
                                                            </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                    <tr>
                                                            <td>Email</td>
                                                            <th><?= $doc['user_email'];?></th>
                                                    </tr>
                                                    <tr>
                                                            <td>Mobile</td>
                                                            <th><?= $doc['user_mob']."<br> ".$doc['user_alt_mob'];?></th>
                                                    </tr>
                                                    <tr>
                                                            <td>Consultancy Fees</td>
                                                            <th>&#x20B9; <?= $doc['user_fee'];?></th>
                                                    </tr>
                                                    <tr>
                                                            <td>Consultancy Duration</td>
                                                            <th><?= $doc['user_time'];?> mins</th>
                                                    </tr>

                                                    <tr>
                                                            <td>Gender</td>
                                                            <th><?= $doc['user_gender'];?></th>
                                                    </tr>
                                                    <tr>
                                                            <td>Age</td>
                                                            <th><?= $doc['user_age'];?> yr</th>
                                                    </tr>
                                                    <tr>
                                                            <td>Experience</td>
                                                            <th><?= $doc['user_experience'];?> years of experience</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Services</td>
                                                        <td><p class="text text-justify"><?= $doc['user_service'];?></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Awards, Recognition & Memberships</td>
                                                        <td><p class="text text-justify"><?= $doc['user_award'];?></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Work Experiences</td>
                                                        <td><p class="text text-justify"><?= $doc['user_work'];?></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td>About The Doc</td>
                                                        <td><p class="text text-justify"><?= $doc['user_about'];?></p></td>
                                                    </tr>
                                                 </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                      
                                        <?php
                                    
                                }
                               
                            ?>
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Timings</h4>
                                     
                                </div>
                                <div class="card-content">

                                    <?php
                                        if(count($timings))
                                        {
                                            ?>
                                                <table class="table table-responsive">
                                            <?php
                                            $array  =   array(
                                                                "mon",
                                                                "tue",
                                                                "wed",
                                                                "thu",
                                                                "fri",
                                                                "sat",
                                                                "sun",
                                                            );
                                            foreach($array as $x)
                                            {
                                                if($timings[$x]==1)
                                                {
                                                    ?>
                                                        <tr>
                                                            <th><?= ucwords($x); ?></th>
                                                            <td>
                                                                <?= $timings[$x."_morning_start"];?> to
                                                                <?= $timings[$x."_morning_end"];?>                                              
                                                            </td>
                                                            <td>
                                                                <?= $timings[$x."_evening_start"];?> to
                                                                <?= $timings[$x."_evening_end"];?>                                              
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                            </table>
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Education & Specialisation 
                                   <button class="btn btn-info pull-right" data-toggle="modal" data-target="#addedumodal"><i class="fa fa-plus"></i> Education</button>
                                    </h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <?php

                                        if(count($edu))
                                        {
                                            ?>
                                            <table class='table table-responsive'><tr><th>Qualification</th><th>Speciality</th><th class="hidden-xs">College</th><th class="hidden-xs">Year</th></tr>
                                            <?php
                                            foreach($edu as $ed)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $ed['qualification_name'];?></td>
                                                         <td><?= $ed['qualification_specialization'];?></td>
                                                        <td class="hidden-xs"><?= $ed['qualification_college'];?></td>
                                                        <td class="hidden-xs"><?= $ed['qualification_complete_year'];?></td>
                                                       
                                                        <!-- <td class="hidden-xs"><a href="<?= base_url('Health/editeducation/'.$ed['qualification_doctor_id'].'/'.$ed['qualification_id']);?>"><i class="fa fa-pencil"></i></a></td> -->
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
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">  Documents & Registration
                                   <button class="btn btn-info pull-right" onClick="showdiv();"><i class="fa fa-plus"></i> Documents</button>
                                    </h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <div class="addiv"  style="display: none;">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url('Health/storedocuments');?>">
                    
                                        <INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable1')" />
                                        <INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable1')" />     
                                        <TABLE id="dataTable1"   class="table table-responsive table-bordered">           
                                            <tr>
                                                <td>
                                                <div class="col-sm-1" style="padding:20px;">
                                                    <INPUT type="checkbox"  name="chk[]"/>
                                                </div>
                                                <div class="col-sm-2" style="padding:20px;">
                                                    <input required type="text" name="document_reg_no[]" placeholder="Council Reg. Number " class="form-control"/>
                                                    <input required type="hidden" name="document_user_id[]" value="<?= $this->uri->segment(3);?>" placeholder="Council Reg. Number " class="form-control"/>
                                                </div>
                                                <div class="col-sm-4"  style="padding:20px;" id="select">
                                                    <select class="form-control" onchange="checkcouncil(this);" name="document_council_name[]"/>
                                                        <option value="">Select Council Name</option>
                                                        <?php
                                                            if(count($council))
                                                            {
                                                                foreach($council as $co)
                                                                {
                                                                    ?>
                                                                        <option value="<?= ucwords($co['council_name']);?>"><?= ucwords($co['council_name']);?> </option>
                                                                    <?php
                                                                }
                                                            }

                                                        ?>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2"  style="padding:20px;">
                                                    <select required name="document_year[]" class="form-control">
                                                        <option value="">Completion Year</option>
                                                        <?php
                                                            for($i=date('Y');$i>=1900;$i--)
                                                            {
                                                                echo "<option>".$i."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3"  style="padding:20px;">

                                                    <label>Upload Certificate</label>
                                                    <input type="file"  placeholder="Upload Certificate" name="document_certificate[]" accept="image/*"/>
                                                </div>
                                                 </td>
                                            </tr>
                                            </TABLE>
                                            <div class="clearfix"></div>
                                            <input type="submit" class="btn btn-primary"> 
                                            </form>  
                                    </div>
                                    <?php
                                        if(count($document))
                                        {
                                            ?>
                                            <table class='table table-responsive'>
                                                <tr>
                                                    <th>Reg No.</th>
                                                    <th class="hidden-xs">Medical Council</th>
                                                    <th class="hidden-xs">Completion Year</th>
                                                    <th>Certificate</th>
                                                    <th class="hidden-xs">Delete</th>
                                                    
                                                </tr>
                                            <?php
                                            foreach($document as $ed)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $ed['document_reg_no'];?></td>
                                                         <td class="hidden-xs"><?= $ed['document_council_name'];?></td>
                                                        <td class="hidden-xs"><?= $ed['document_year'];?></td>
                                                        <td><a href="#" onClick="showcerti('<?= $ed['id'];?>','<?= $ed['document_certificate'];?>');">View Certificate</a></td>
                                                        <td class="hidden-xs"><i class="fa fa-times btn btn-danger" title="Delete this doc" onClick="deldoc('<?= $ed['id'];?>','<?= $ed['document_certificate'];?>');"></i></td>
                                                        
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
            var val = $(a).val();
           // alert(val);
            if(val =='other')
            {
                $('#select').html("<input type='text' class='form-control' name='qualification_name[]' required placeholder='Enter Your Qualification'/>");
            }
        }
         function showdiv(){
            //alert('showdiv');
            $('.addiv').slideToggle();
        }
        function showcerti(id,image){
            console.log(id);
            console.log(image);
            $('#imagemodal').html("<center><img src='<?= base_url('images/certi/');?>"+id+"/"+image+"' class='img img-responsive'/></center>");
            $('#certimodal').modal('toggle');
        }
        function checkcouncil(a){
            var val =$(a).val();
            if(val == 'others')
            {
                //$(a).remove();
                $('#select').html("<input type='text' required placeholder='Enter Your council name' class='form-control' name='document_council_name[]'/>");

            }
        }
        function deldoc(id,image_name)
        {
            var r = confirm("Are you sure, you want to delete this document?");
            if(r==true)
            {
                $.ajax({
                    type    :   "POST",
                    data    :   {
                                    "id"    :   id,
                                    "image_name"    :   image_name,
                    },
                    url     :   "<?= base_url('Ajax/deldocuments');?>",
                    beforeSend  :   function(){$('.loadingDiv').show();},
                    success :   function(){
                        location.reload();
                    }

                });
            }
        }
    </SCRIPT>
    <div id="addedumodal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Education & Specialization</h4>
                  </div>
                  <div class="modal-body">
                     <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url('Health/storeeducation');?>">
                          <div class="col-sm-12 "> 
                                <INPUT type="button" class="btn btn-primary" value="Add Row" onclick="addRow('dataTable')" />
                                <INPUT type="button" class="btn btn-danger" value="Delete Row"   onclick="deleteRow('dataTable')" />      
                                <TABLE id="dataTable"   class="table table-responsive table-bordered">            
                                    <tr>
                                        <td><INPUT type="checkbox"  name="chk[]"/></td>
                                        <td>
                                            <input type="hidden" name="qualification_doctor_id" value="<?= $doc['id'];?>"/>

                                            <div class="col-sm-3" id="select">
                                            <select class="form-control" required   id="doctor_qualification" onchange="checkval(this);"  name="qualification_name[]">
                                                 
                                                <option value="MBBS">MBBS</option>
                                                <option value="BDS">BDS</option>
                                                <option value="MDS">MDS</option>
                                                <option value="BHMS">BHMS</option>
                                                <option value="BAMS">BAMS</option>
                                                <option value="MS-GENERAL SURGERY">MS-GENERAL SURGERY</option>
                                                <option value="MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS">MDS-ORTHODONTICS & PENTOFACIAL ORTHOPAEDICS</option>
                                                <option value="BPTH/BPT">BPTH/BPT</option>
                                                <option value="MD-GENERAL MEDICINE">MD-GENERAL MEDICINE</option>
                                                <option value="MDS-ORAL & MAXILLOFACIAL SURGERY">MDS-ORAL & MAXILLOFACIAL SURGERY</option>
                                                <option value="other">Other</option>
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="text" class="form-control" required name="qualification_college[]" placeholder="College Name"/>
                                            </div>
                                            <div class="col-sm-3">
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
                                           <div class="col-sm-3">
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
                                        </td>
                                    </tr>        
                                </TABLE>
                               </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                  </div>
                </div>

              </div>
            </div>
                <div id="certimodal" class="modal fade" role="dialog" style="width:100%;">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Cerificate</h4>
          </div>
          <div class="modal-body" id="imagemodal">
                
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <!---------------department modal------------------------->
    <div id="depmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form class="form-horizontal" action="<?= base_url('Health/updatedocdepartment');?>" method="post">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Department</h4>
      </div>
      <div class="modal-body">
        
            <div class="form-group"> 
                <select class="form-control" name="user_subdept_id">
                    <?php
                        if(count($department))
                        {
                            foreach ($department as $x) {
                                ?>
                                    <option <?php if($x['name']==$doc['department']){echo "selected";}?> value="<?= $x['id'];?>"><?= $x['name'];?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <input type="hidden" value="<?= $doc['id'];?>" name="id" >
            </div>
         
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
  </div>
</div>