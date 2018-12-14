<?php
    
    $council		 =   $array['council'];
    $document    =   $array['document'];
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
    <title>Bookmediz: My Documents & Registration</title>
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
                             	<?php
                             		if($this->session->flashdata('docmsg'))
                             		{
                             			echo $this->session->flashdata('docmsg');
                             		}
                             	?>
                             <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title"> My Documents & Registration
                                   <button class="btn btn-warning pull-right" onClick="showdel(this);"><i class="fa fa-pencil"></i> </button>
                                   <button class="btn btn-info pull-right" onClick="showdiv();"><i class="fa fa-plus"></i> Documents</button>
                                    </h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="card-content">
                                    <div class="addiv"  style="display: none;">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url('doc/storedocuments');?>">
                    
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
                                                    <th class="hidden del">Delete</th>
                                                    
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
                                                        <td class="hidden del"><i class="fa fa-times btn btn-danger" title="Delete this doc" onClick="deldoc('<?= $ed['id'];?>','<?= $ed['document_certificate'];?>');"></i></td>
                                                        
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
        function showdel(a){
            $(a).hide();
            $('.del').removeClass('hidden');
        }
    </SCRIPT>
    <!-- Modal -->
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
 
