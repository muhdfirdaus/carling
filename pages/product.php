<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calibration | <?php include('../dist/includes/title.php');?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
<link rel='stylesheet prefetch' href='http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css'>
<script type="text/javascript">

       function PrintDoc() {

        var toPrint = document.getElementById('printarea');

        var popupWin = window.open('', '_blank', 'width=1200,height=850,location=no,left=150px');
		
        popupWin.document.open();

        popupWin.document.write('<html><title>::Equipment Record::</title><link rel="stylesheet" type="text/css" href="print.css" /></head><body onload="window.print()">')

        popupWin.document.write(toPrint.innerHTML);

        popupWin.document.write('</html>');

        popupWin.document.close();

    }

</script>
    <style>
      
    </style>
 </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-<?php echo $_SESSION['skin'];?> layout-top-nav">
    <div class="wrapper">
      <?php include('../dist/includes/header.php');?>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              <a class="btn btn-lg btn-warning" href="home.php">Back</a>
              <a class="btn btn-lg btn-primary" href="#add" data-target="#add" data-toggle="modal" style="color:#fff;" class="small-box-footer"><i class="glyphicon glyphicon-plus text-blue"></i></a>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Equipment</li>
            </ol>
          </section>
        
        <?php
        //Try to get limit and start row from URL and assign default value
        isset($_GET['startrow'])? $startrow = $_GET['startrow'] : $startrow = 0;
        isset($_GET['limit'])? $limit = $_GET['limit'] : $limit = 10;
        isset($_GET['search_by'])? $search_by = $_GET['search_by'] : $search_by = null;
        isset($_GET['search_val'])? $search_val = $_GET['search_val'] : $search_val = null;

        if($search_by != null && $search_val != null)
        {
          $sql = mysqli_query($con,"select count(*) from product where branch_id='$branch' and $search_by like '%$search_val%'  order by creation_date ")or die(mysqli_error());
        }
        else
        {
          $sql = mysqli_query($con,"select count(*) from product where branch_id='$branch'  order by creation_date ")or die(mysqli_error());
        }
        
        $result = mysqli_fetch_array($sql);
        $total_list = $result[0];

        ?>

          <!-- Main content -->
          
          <section class="content">
            <div class="row">
	     
            
            <div class="col-xs-12">
              <div style="width:108%" class="box box-primary">
    
                <div class="box-header">
                  <h3 class="box-title">Calibration List</h3>
                </div><!-- /.box-header -->
                <div style="width:100%" class="box-body">
                <table width='100%' border=0>
                    <tr>
                        <td width=5% align=right>Show</td>
                        <td td width=5%>
                            <select id="limit_select">
                                <option value=10 <?php if($limit==10){echo "selected";} ?> >10</option>
                                <option value=25 <?php if($limit==25){echo "selected";} ?> >25</option>
                                <option value=50 <?php if($limit==50){echo "selected";}?>>50</option>
                                <option value=100 <?php if($limit==100){echo "selected";}?>>100</option>
                            </select>
                        </td>
                        <td width=5%>entries</td>
                        <td width=15%>  &nbsp; </td>
                        <td width=15%>  &nbsp; </td>
                        <td width=15%>  &nbsp; </td>
                        <td align=right>
                            <select id="search_by_inp" class="form-control">
                              <option value="equip_name"  >Equipment Name</option>
                              <option value="equip_no"  >Equipment No.</option>
                              <option value="model"  >Model</option>
                              <option value="manufacturer"  >Manufacturer</option>
                              <option value="location"  >Location</option>
                              <option value="project"  >Project</option>
                              <option value="dept"  >PIC</option>
                              <option value="remark"  >Status</option>
                            </select>
                        </td>
                        <td><input type="text" id="search_val_inp" class="form-control"></input></td>
                        <td><button type="button" id="btn_search" class="btn btn-primary" >Search</button>
                        </td>
                    </tr>
                </table><br>
                <form id="delete_list" method="post" name="delete_list" action="delete_list.php" enctype='multipart/form-data'>
                <table style="font-size:10px" id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="info text-center"><input type="checkbox" id="checkAll" ></th>
					              <th>No.</th>
                        <th>Serial Number</th>
                        <th>Name</th>
                        <th>Model</th>
						            <th>Manufacturer</th>
                        <th>Lab.</th>
                        <th>Location</th>
                        <th>Cert. No.</th>
                        <th>Project</th>
                        <th>Creation Date</th>
                        <th>Due Date</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th></th>
								
                      </tr>
                    </thead>
                    <tbody>
        <?php
            if($search_by != null && $search_val != null)
            {
              $query = mysqli_query($con,"select * from product where branch_id='$branch' AND $search_by LIKE '%$search_val%'  order by creation_date limit $startrow,$limit")or die(mysqli_error());
            }
            else
            {
              $query=mysqli_query($con,"select * from product where branch_id='$branch'  order by creation_date limit $startrow,$limit ")or die(mysqli_error());
            }
            $ct = $startrow;
            while($row=mysqli_fetch_array($query)){
		
        ?>
                      <tr>
                        <td class="info text-center"><input type="checkbox" class="check" name="check_id[]"id="check_id" value="<?php echo $row['equip_id'];?>"></input></td>
				      	        <td><?php echo $ct + 1; $ct++;?></td>
                        <td><?php echo $row['equip_no'];?></td>
                        <td><?php echo $row['equip_name'];?></td>
                        <td><?php echo $row['model'];?></td>						
                        <td><?php echo $row['manufacturer'];?></td>
                        <td><?php echo $row['category'];?></td>
                        <td><?php echo $row['location'];?></td>
                        <?php if($row['file_name'] != null){
                        ?><td><a target='_blank' href='../uploads/<?php echo $row['file_name']; ?>.pdf'><?php echo $row['cert_no'];?></a></td> <?php
                        } else{?>
                        <td><?php echo $row['cert_no'];}?></td>
                        <td><?php echo $row['project'];?></td>
                        <td><?php echo $row['creation_date'];?></td>
                        <td><?php echo $row['due_date'];?></td>
                        <td><?php echo $row['dept'];?></td>
                        <td><?php echo $row['remark'];?></td>						
                        <td>
				                  <a href="#updateordinance<?php echo $row['equip_id'];?>" data-target="#updateordinance<?php echo $row['equip_id'];?>" data-toggle="modal" style="color:#fff;" class="small-box-footer"><i class="glyphicon glyphicon-edit text-blue"></i></a>
			                  </td>
                      </tr></form> 
<div id="updateordinance<?php echo $row['equip_id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	
 <div class="modal-dialog">
	  <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Update Equipment Details</h4>
              </div>
              <div style="font-size:11px" class="modal-body">
        <form class="form-horizontal" method="post" action="product_update.php" enctype='multipart/form-data'>
        
                
		    <div class="form-group">
          <label class="control-label col-lg-3" for="equip_no">Equipment No.</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required>  
            <input type="text" class="form-control" id="equip_no" value="<?php echo $row['equip_no'];?>" name="equip_no" placeholder="Equipment No." required>  
          </div>
        </div>
                
        <div class="form-group">
          <label class="control-label col-lg-3" for="equip_name">Name</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="text" class="form-control" id="equip_name" value="<?php echo $row['equip_name'];?>" name="equip_name" placeholder="Equipment Name" required>  
          </div>
        </div> 
       
        <div class="form-group">
          <label class="control-label col-lg-3" for="accuracy">Tolerance</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="text" class="form-control" id="accuracy" name="accuracy" value="<?php echo $row['accuracy'];?>" placeholder="Tolerance" required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="rangee">Range</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="text" class="form-control" id="rangee" name="range" value="<?php echo $row['rangee'];?>" placeholder="Range" required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Location</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
              <select class="form-control select2" style="width: 100%;" name="location" required>
			    <option disabled selected value>-- Please Select --</option>
                <?php
            
              $query2=mysqli_query($con,"select * from location order by location_name")or die(mysqli_error());
                while($row2=mysqli_fetch_array($query2)){
                ?>
                  <option value="<?php echo $row2['location_name'];?>"<?php if($row2['location_name']==$row['location']){echo "selected";} ?>><?php echo $row2['location_name'];?></option>
                <?php }?>
              </select>
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="rangee">Project</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" > 
            <input type="text" class="form-control" id="project" name="project" value="<?php echo $row['project'];?>" placeholder="Project" >  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Interval</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" > 
                <select class="form-control select2" style="width: 100%;" name="status" id="filterxx" onchange="changeValue();" >
                  <option disabled selected value>--Please Select --</option>
                  <option id="six" value="six">6 Month(s)</option>
                  <option id="one" value="one">1 Year</option>
                  <option id="two" value="two">2 Year(s)</option>
                  <option id="three" value="three">3 Year(s)</option>
                </select>
          </div>
        </div> 
        <script type="text/javascript">
function changeValue(){
    var option=document.getElementById('filterxx').value;

    if(option=="six"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))); ?>";
    }
        else if(option=="one"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+1)); ?>";
        }
			else if(option=="two"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+2)); ?>";
        }
			else if(option=="three"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+3)); ?>";
        }
}
</script>
        <div class="form-group">
              <label class="control-label col-lg-3" >Calibration Lab.</label>
              <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" > 
                <select class="form-control select2" style="width: 100%;" name="category" >
                <option disabled value="">-- Please Select --</option>
                <?php
                $queryc=mysqli_query($con,"select * from category order by cat_name")or die(mysqli_error());
                while($rowc=mysqli_fetch_array($queryc)){
                ?>
                  <option value="<?php echo $rowc['cat_name'];?>" <?php if($rowc['cat_name']==$row['category']){echo "selected";} ?>><?php echo $rowc['cat_name'];?></option>
                <?php } ?>
              </select>
              </div><!-- /.input group -->
              </div><!-- /.form group -->
			  
			   <div class="form-group">
          <label class="control-label col-lg-3" for="dept">PIC</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="text" class="form-control" id="dept" name="dept" value="<?php echo $row['dept'];?>" placeholder="PIC" required>  
          </div>
        </div> 
		
		    <div class="form-group">
          <label class="control-label col-lg-3" for="cert_no">Cert No.</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="text" class="form-control" id="cert_no" name="cert_no" value="<?php echo $row['cert_no'];?>" placeholder="Certification No." required>  
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="creation_date">Creation Date</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
            <input type="date" class="form-control" id="creation_date"  name="creation_date"  value="<?php echo $row['creation_date'];?>"  placeholder="Creation Date"  required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="due_date">Due Date</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
           <input type="date" class="form-control"  name="due_date"  id="datepicker"  value="<?php echo $row['due_date'];?>"  size="20" maxlength="20">
          </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  

    <script  src="js/index.js"></script>


        </div>
		 <div class="form-group">
          <label class="control-label col-lg-3" for="file">Status</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
              <select class="form-control select2" style="width: 100%;"  name="remark" required>              
				        <option id="Active" value="Active" <?php if($row['remark']=="Active"){echo "selected";}?>>Active</option>
                <option id="Inactive" value="Inactive" <?php if($row['remark']=="Inactive"){echo "selected";}?>>Inactive</option>
                <!-- <option id="Closed" value="Closed">Closed</option>
                <option id="PSNM" value="PSNM">PSNM Equipment</option>
                <option id="OOS" value="OOS">Out of Service</option>
                <option id="Consign" value="Consign">Consign</option>
                <option id="Spoiled" value="Spoiled">Spoiled</option>
                <option id="Missing" value="Missing">Missing</option>
                <option id="Repair" value="Repair">Repair</option> -->
              </select>
          </div>
        </div> 
		 <div class="form-group">
          <label class="control-label col-lg-3" for="file">Remark</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['equip_id'];?>" required> 
              <select class="form-control select2" style="width: 100%;" name="validation" required>
                <option disabled selected value>-- Please Select --</option>
				        <option id="NoAccreditation" value="NoAccreditation" <?php if($row['validation']=="NoAccreditation"){echo "selected";}?>>No Accreditation</option>
                <option id="Accreditation" value="Accreditation" <?php if($row['validation']=="Accreditation"){echo "selected";}?>>Accreditation</option>
                <option id="PSNM" value="PSNM" <?php if($row['validation']=="PSNM"){echo "selected";}?>>PSNM Equipment</option>
                <option id="OOS" value="OOS" <?php if($row['validation']=="OOS"){echo "selected";}?>>Out of Service</option>
                <option id="Consign" value="Consign" <?php if($row['validation']=="Consign"){echo "selected";}?>>Consign</option>
                <option id="Spoil" value="Spoil" <?php if($row['validation']=="Spoil"){echo "selected";}?>>Spoil</option>
              </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-lg-3" for="cert_no">Certification</label>
          <div class="col-lg-9">
            <input type="hidden" class="form-control" id="file_chg" name="file_chg" value=0> 
            <?php if($row['file_name']!= null){ ?>
              <label id="lbl_cert"><?php echo $row['file_name'].".pdf";?>&nbsp;</label><button id="btn_rem"type="button" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</button> 
            <?php } else{?>
              <div class="col-lg-9">
                <input type="file" name="fileToUpload_upd" id="fileToUpload_upd">
              </div>
            <?php } ?>
          </div>
        </div>  
              
			 </div>
              <div class="modal-footer">			
                <button type="submit" id="btn_subm" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </form>
            </div>
      
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 
 
 <div id="sendordinance<?php echo $row['equip_id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	
 <div class="modal-dialog">
	  <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Print/Send Equipment Details</h4>
              </div>
              <div id="printarea" style="font-size:11px" class="modal-body">
        <form class="form-horizontal" method="post" action="mailto:someone@my.beyonics.com" enctype="text/plain">
        <div class="form-group">
          <label class="control-label col-lg-3" for="equip_no">Equipment No.</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="equip_no" value="<?php echo $row['equip_no'];?>" name="equip_no" placeholder="Equipment No." required>  
          </div>
        </div>
                
        <div class="form-group">
          <label class="control-label col-lg-3" for="equip_name">Name</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" required>  
            <input type="text" class="form-control" id="equip_name" value="<?php echo $row['equip_name'];?>" name="equip_name" placeholder="Equipment Name" required>  
          </div>
        </div> 
       
        <div class="form-group">
          <label class="control-label col-lg-3" for="accuracy">Accuracy</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="accuracy" name="accuracy" value="<?php echo $row['accuracy'];?>" placeholder="Accuracy" required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="rangee">Range</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="rangee" name="range" value="<?php echo $row['rangee'];?>" placeholder="Range" required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Location</label>
          <div class="col-lg-9">
              <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['location'];?>" placeholder="Location" required>  
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Interval</label>
          <div class="col-lg-9">
               <input type="text" class="form-control" id="status" name="status" value="<?php echo $row['status'];?>" placeholder="Interval" required>  
          </div>
        </div> 
        <script type="text/javascript">
function changeValue(){
    var option=document.getElementById('filterxx').value;

    if(option=="six"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))); ?>";
    }
        else if(option=="one"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+1)); ?>";
        }
			else if(option=="two"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+2)); ?>";
        }
			else if(option=="three"){
            document.getElementById('fieldx').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+3)); ?>";
        }
}
</script>
        <div class="form-group">
              <label class="control-label col-lg-3" >Calibration Lab.</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $row['category'];?>" placeholder="Calibration Lab." required>  
              </div><!-- /.input group -->
              </div><!-- /.form group -->
			  
			   <div class="form-group">
          <label class="control-label col-lg-3" for="dept">PIC</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="dept" name="dept" value="<?php echo $row['dept'];?>" placeholder="PIC" required>  
          </div>
        </div> 
		
		<div class="form-group">
          <label class="control-label col-lg-3" for="cert_no">Cert No.</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="cert_no" name="cert_no" value="<?php echo $row['cert_no'];?>" placeholder="Certification No." required>  
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="creation_date">Creation Date</label>
          <div class="col-lg-9">
            <input type="date" class="form-control" id="creation_date"  name="creation_date"  value="<?php echo $row['creation_date'];?>"  placeholder="Creation Date"  required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="due_date">Due Date</label>
          <div class="col-lg-9">
           <input type="date" class="form-control"  name="due_date"  id="datepicker"  value="<?php echo $row['due_date'];?>"  size="20" maxlength="20">
          </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  

    <script  src="js/index.js"></script>


        </div>
		  <div class="form-group">
          <label class="control-label col-lg-3" for="file">Status</label>
          <div class="col-lg-9">
             <input type="text" class="form-control" id="remark" name="remark" value="<?php echo $row['remark'];?>" placeholder="Remark" required>  
          </div>
        </div> 
              
			 </div>
              <div class="modal-footer">
                <button type="submit" value="Print" onclick="PrintDoc()" class="btn btn-primary">Print</button>
                <button type="submit" value="Send" class="btn btn-primary">Send Email</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </form>
            </div>
      
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 
<?php } ?>					  
                        </tbody>
                    
                    </table>

                    <input type="hidden" id="total_list" value="<?php echo $total_list; ?>"></input>
                    <input type="hidden" id="startrow" value="<?php echo $startrow; ?>"></input>
                    <input type="hidden" id="limit" value="<?php echo $limit; ?>"></input>
                    <input type="hidden" id="search_by" value="<?php echo $search_by; ?>"></input>
                    <input type="hidden" id="search_val" value="<?php echo $search_val; ?>"></input>
                    <button type="button" id="btn_delete" class="btn btn-primary" name="btn_delete">Delete selected</button>
                    <button type="button" id="btn_last" class="btn btn-primary right" style="float: right;">Last</button>
                    <button type="button" id="btn_next" class="btn btn-primary right" style="float: right;">Next</button>
                    
                    <?php
                    //setting up value and variable for js purposes

                    if(($startrow-$limit)<0)
                    {
                        $prevstartrow = 0;
                    }
                    else
                    {
                        $prevstartrow = $startrow-$limit;
                    }
                    if($startrow>0){ ?>
                        <button type="button" id="btn_prev" class="btn btn-primary" style="float: right;">Previous</button>
                        <input type="hidden" id="prevstartrow" value="<?php echo $prevstartrow; ?>"></input>
                        <input type="hidden" id="nextstartrow" value="<?php echo ($startrow+$limit); ?>"></input>
                        
                    <?php } ?> 
                
                <button type="button" id="btn_first" class="btn btn-primary right" style="float: right;">First</button>       
                </div><!-- /.box-body -->
 
            </div><!-- /.col -->
			
			
          </div><!-- /.row -->
	  
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <?php include('../dist/includes/footer.php');?>
    </div><!-- ./wrapper -->
<div id="add" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add New Equipment</h4>
              </div>
              <div style="font-size:12px" class="modal-body">
        <form class="form-horizontal" method="post" action="product_add.php" enctype='multipart/form-data'>
        <div class="form-group">
          <label class="control-label col-lg-3" for="equip_no">Serial No.</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="equip_no" name="equip_no" placeholder="Equipment No." required>  
          </div>
        </div>
                
        <div class="form-group">
          <label class="control-label col-lg-3" for="equip_name">Name</label>
          <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" required>  
            <input type="text" class="form-control" id="equip_name" name="equip_name" placeholder="Equipment Name" required>  
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="model">Model</label>
          <div class="col-lg-9">
           <input type="text" class="form-control" id="model" name="model" placeholder="Model" required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Manufacturer</label>
          <div class="col-lg-9">
              <select class="form-control select2" style="width: 100%;" name="manufacturer" required>
			    <option disabled selected value>-- Please Select --</option>
                <?php
            
              $query2=mysqli_query($con,"select * from manufacturer order by manufacturer_name")or die(mysqli_error());
                while($row2=mysqli_fetch_array($query2)){
                ?>
                  <option value="<?php echo $row2['manufacturer_name'];?>"><?php echo $row2['manufacturer_name'];?></option>
                <?php }?>
              </select>
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="accuracy">Tolerance</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="accuracy" name="accuracy" placeholder="Tolerance" required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="rangee">Range</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="rangee" name="rangee" placeholder="Range" required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Location</label>
          <div class="col-lg-9">
              <select class="form-control select2" style="width: 100%;" name="location" required>
			    <option disabled selected value>-- Please Select --</option>
                <?php
            
              $query2=mysqli_query($con,"select * from location order by location_name")or die(mysqli_error());
                while($row2=mysqli_fetch_array($query2)){
                ?>
                  <option value="<?php echo $row2['location_name'];?>"><?php echo $row2['location_name'];?></option>
                <?php }?>
              </select>
          </div>
        </div> 
         <div class="form-group">
          <label class="control-label col-lg-3" for="project">Project</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="project" name="project" placeholder="Project" value="-" required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="file">Interval</label>
          <div class="col-lg-9">
            <select class="form-control select2" style="width: 100%;" name="status" id="filterx" onchange="changeValues();" required>
                <option disabled selected value>--Please Select --</option>
                <option id="six" value="six">6 Month(s)</option>
                <option id="one" value="one">1 Year</option>
                <option id="two" value="two">2 Year(s)</option>
                <option id="three" value="three">3 Year(s)</option>
            </select>
          </div>
        </div> 
        <!--script type="text/javascript">
function changeValues(){
    var option=document.getElementById('filterx').value;

    if(option=="six"){
            document.getElementById('field').value="<!?php echo date('Y-m-d', mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))); ?>";
    }
        else if(option=="one"){
            document.getElementById('field').value="<!?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+1)); ?>";
        }
			else if(option=="two"){
            document.getElementById('field').value="<!?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+2)); ?>";
        }
		else if(option=="three"){
            document.getElementById('field').value="<!?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+3)); ?>";
        }	
}
</script-->
        <div class="form-group">
              <label class="control-label col-lg-3" >Calibration Lab.</label>
              <div class="col-lg-9">
                <select class="form-control select2" style="width: 100%;" name="category" required>
                <option disabled selected value>-- Please Select --</option>
                <?php
            
              $queryc=mysqli_query($con,"select * from category order by cat_name")or die(mysqli_error());
                while($rowc=mysqli_fetch_array($queryc)){
                ?>
                  <option value="<?php echo $rowc['cat_name'];?>"><?php echo $rowc['cat_name'];?></option>
                <?php }?>
              </select>
              </div><!-- /.input group -->
              </div><!-- /.form group -->
			  
			   <div class="form-group">
          <label class="control-label col-lg-3" for="dept">PIC</label>
          <div class="col-lg-9">
           <select class="form-control select2" style="width: 100%;" name="dept" required>
                <option disabled selected value>-- Please Select --</option>
				<option id="QA" value="QA">QA</option>
                <option id="Engineering" value="Engineering">Engineering</option>
                <option id="TEST" value="TEST">TEST ENG</option>
                <option id="Production" value="Production">Production</option>

              </select>
          </div>
        </div> 
		
		    <div class="form-group">
          <label class="control-label col-lg-3" for="cal_no">Certification No.</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="cert_no" name="cert_no" placeholder="Certification No." required>  
          </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-3" for="cert">Certification</label>
            <div class="col-lg-9">
              <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="creation_date">Creation Date</label>
          <div class="col-lg-9">
            <input type="date" class="form-control" id="creation_date_new"  name="creation_date" value="<?php echo date('Y-m-d'); ?>"  placeholder="Creation Date"  required>  
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-lg-3" for="due_date">Due Date</label>
          <div class="col-lg-9">
           <input type="date" class="form-control"  name="due_date"  id ="field" value="" size="20" maxlength="20">
          </div>
        </div>
		    <div class="form-group">
          <label class="control-label col-lg-3" for="file">Status</label>
          <div class="col-lg-9">
              <select class="form-control select2" style="width: 100%;" name="remark" required>
                <option disabled selected value>-- Please Select --</option>
				        <option id="Active" value="Active">Active</option>
                <option id="Inactive" value="Inactive">Inactive</option>
                <option id="Closed" value="Repaired">Closed</option>
              </select>
          </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-3" for="file">Remark</label>
            <div class="col-lg-9">
                <select class="form-control select2" style="width: 100%;" name="validation" required>
                  <option disabled selected value>-- Please Select --</option>
                  <option id="NoAccreditation" value="NoAccreditation">No Accreditation</option>
                  <option id="Accreditation" value="Accreditation">Accreditation</option>
                  <option id="PSNM" value="PSNM">PSNM Equipment</option>
                  <option id="OOS" value="OOS">Out of Service</option>
                  <option id="Consign" value="Consign">Consign</option>
                  <option id="Spoil" value="Spoil">Spoil</option>
                </select>
            </div>
        </div>
              </div>
			 
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </form>
            </div>
      
        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal--> 
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    
    <script>
      $(function () {
        // $("#example1").DataTable();
        // $('#example2').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false
        // });
        checkboxChecker();
        pagination_check();
        
        $("#btn_next").click(function () {
            limit = Number($("#limit").val());
            startrow = Number($("#startrow").val()) + limit;
            searchBy = $("#search_by").val();
            searchVal = $("#search_val").val();
            if(searchVal.trim() != "" && searchBy.trim() != "")
            {
              endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
            }
            else
            {
              endext = "";
            }
            window.location.href = ( "?startrow="+ startrow + "&limit=" + limit + endext);
        });

        $("#btn_prev").click(function () {
            limit = Number($("#limit").val());
            startrow = Number($("#prevstartrow").val());
            searchBy = $("#search_by").val();
            searchVal = $("#search_val").val();
            if(searchVal.trim() != "" && searchBy.trim() != "")
            {
              endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
            }
            else
            {
              endext = "";
            }
            window.location.href = ("?startrow="+ startrow + "&limit=" + limit +endext);
        });

        $("#btn_first").click(function () {
            limit = Number($("#limit").val());
            searchBy = $("#search_by").val();
            searchVal = $("#search_val").val();
            if(searchVal.trim() != "" && searchBy.trim() != "")
            {
              endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
            }
            else
            {
              endext = "";
            }
            window.location.href = ("?startrow=0&limit=" + limit + endext);
        });

        $("#btn_last").click(function () {
            limit = Number($("#limit").val());
            total_list = Number($("#total_list").val());
            if(total_list-limit >= 0)
            {
              startrow = total_list - limit;
            }
            else
            {
              startrow = 0;
            }
            searchBy = $("#search_by").val();
            searchVal = $("#search_val").val();
            if(searchVal.trim() != "" && searchBy.trim() != "")
            {
              endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
            }
            else
            {
              endext = "";
            }
            window.location.href = ("?startrow="+ startrow + "&limit=" + limit + endext);
        });

        $('#limit_select').on('change',function(){
            limit = Number($("#limit_select").val());
            startrow = Number($("#startrow").val());
            total_list = Number($("#total_list").val());
            searchBy = $("#search_by").val();
            searchVal = $("#search_val").val();
            if(searchVal.trim() != "" && searchBy.trim() != "")
            {
              endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
            }
            else
            {
              endext = "";
            }
            // if((limit + startrow)< total_list)
            // {
                window.location.href = ( "?startrow="+ startrow + "&limit=" + limit + endext);
            // }
            // else
            // {
            //     window.location.href = ( "?startrow="+ (total_list - limit) + "&limit=" + limit + endext);
            // }
        });

        $("#checkAll").click(function () {
            $(".check").not(':disabled').prop('checked', $(this).prop('checked'));
            checkboxChecker();
        });
        
        $("#btn_delete").click(function () {
            document.getElementById("delete_list").submit();
        });

        $("#btn_search").click(function () {
            searchBy = $("#search_by_inp").val();
            searchVal = $("#search_val_inp").val();
            if(searchVal.trim() == "")
            {
              alert("Please insert value in the search box.");
            }
            else
            {
              limit = Number($("#limit").val());
              if(searchVal.trim() != "" && searchBy.trim() != "")
              {
                endext = "&search_by=" + searchBy + "&search_val=" + searchVal;
              }
              else
              {
                endext = "";
              }
              window.location.href = ("?startrow=0&limit=" + limit +endext);
            }
        });

        $("#btn_rem").click(function () {
            document.getElementById("lbl_cert").innerHTML  = "File removed!";
            document.getElementById("btn_rem").style.visibility = "hidden";
            $("#file_chg").val(2);
            
        });

        $(".check").click(function () {
            checkboxChecker();
        });

        function pagination_check(){
            limit = Number($("#limit").val());
            startrow = Number($("#startrow").val());
            total_list = Number($("#total_list").val());

            if(startrow + (limit * 2 ) - 1 > total_list){
                document.getElementById("btn_next").disabled = true;
            }
            else{
                document.getElementById("btn_next").disabled = false;
            }
        }
        function checkboxChecker(){
            var valid = true, message = '';

            $('.check').each(function() {

                if ($(this).is(':checked') &&  $(this).is(':enabled')) {
                    valid = false;
                }
            });

            if(valid) {
                if(document.getElementById("btn_delete") != null){
                document.getElementById("btn_delete").disabled = true;
                }
            }else{
                if(document.getElementById("btn_delete") != null){
                document.getElementById("btn_delete").disabled = false;
                }
            }
        }
      });
    </script>
  </body>
</html>
