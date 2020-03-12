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

        var popupWin = window.open('', '_blank', 'width=600,height=850,location=no,left=150px');

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
             <a class = "btn btn-primary btn-print" href = "home.php"><i class ="glyphicon glyphicon-arrow-left"></i> Back to Homepage</a>   
               <a class = "btn btn-success btn-print" href = "" onclick="PrintDoc()"><i class ="glyphicon glyphicon-print"></i> Print</a>
			    <a class = "btn btn-primary btn-print" href = ""><i class ="glyphicon glyphicon-export"></i>Export to Excel</a>  
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Equipment</li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
	     
            
            <div class="col-xs-12">
              <div style="width:105%" class="box box-primary">
    
                <div class="box-header">
                  <h3 class="box-title">Calibration List</h3>
                </div><!-- /.box-header -->
               <div id="printarea" style="width:100%" class="box-body">
                  <table style="font-size:11px" id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                    
                        <th>No.</th>
                        <th>Name</th>
                        <th>Model</th>
						
						<th>Manufacturer</th>
                        
            						<th>Lab.</th>
									<th>Location</th>
									
									<th>Cert. No.</th>
            						<th>Creation Date</th>
									<th>Due Date</th>
									<th>PIC</th>
									<th>Remark</th>
								<th></th>
								
                      </tr>
                    </thead>
                    <tbody>
<?php
		
		$query=mysqli_query($con,"select * from product  where branch_id='$branch'  order by equip_name")or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
		
?>
                      <tr>
                      	
                        <td><?php echo $row['equip_no'];?></td>
                        <td><?php echo $row['equip_name'];?></td>
                        <td><?php echo $row['model'];?></td>
						
						<td><?php echo $row['manufacturer'];?></td>
                        <td><?php echo $row['category'];?></td>
						<td><?php echo $row['location'];?></td>
						<td><?php echo $row['cert_no'];?></td>
            			<td><?php echo $row['creation_date'];?></td>
            			<td><?php echo $row['due_date'];?></td>
						<td><?php echo $row['dept'];?></td>
						<td><?php echo $row['remark'];?></td>
						
						
                        <td>
				<a href="#updateordinance<?php echo $row['equip_id'];?>" data-target="#updateordinance<?php echo $row['equip_id'];?>" data-toggle="modal" style="color:#fff;" class="small-box-footer"><i class="glyphicon glyphicon-edit text-blue"></i></a>
			
						</td>
                      </tr>
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
          <label class="control-label col-lg-3" for="file">Interval</label>
          <div class="col-lg-9">
                <select class="form-control select2" style="width: 100%;" name="status" id="filterxx" onchange="changeValue();" required>
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
              <div class="col-lg-9">
                <select class="form-control select2" style="width: 100%;"  value="<?php echo $row['category'];?>" name="category" required>
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
          <label class="control-label col-lg-3" for="file">Remark</label>
          <div class="col-lg-9">
              <select class="form-control select2" style="width: 100%;" name="remark" value="<?php echo '$remark' ?>" required>
                <option disabled selected value>-- Please Select --</option>
<option id="Inactive" value="Inactive">Inactive</option>
<option id="PSNM" value="PSNM">PSNM Equipment</option>
<option id="OOS" value="OOS">Out of Service</option>
<option id="Consign" value="Consign">Consign</option>
<option id="Spoil" value="Spoil">Spoil</option>
<option id="Closed" value="Closed">Closed</option>
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
<?php }?>					  
                    </tbody>
                   
                  </table>
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
          <label class="control-label col-lg-3" for="equip_no">Equipment No.</label>
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
          <label class="control-label col-lg-3" for="accuracy">Accuracy</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="accuracy" name="accuracy" placeholder="Accuracy" required>  
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
        <script type="text/javascript">
function changeValues(){
    var option=document.getElementById('filterx').value;

    if(option=="six"){
            document.getElementById('field').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))); ?>";
    }
        else if(option=="one"){
            document.getElementById('field').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+1)); ?>";
        }
			else if(option=="two"){
            document.getElementById('field').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+2)); ?>";
        }
		else if(option=="three"){
            document.getElementById('field').value="<?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")+3)); ?>";
        }	
}
</script>
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
            <input type="text" class="form-control" id="dept" name="dept" placeholder="PIC" required>  
          </div>
        </div> 
		
		<div class="form-group">
          <label class="control-label col-lg-3" for="cal_no">Cert No.</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="cert_no" name="cert_no" placeholder="Certification No." required>  
          </div>
        </div> 
        <div class="form-group">
          <label class="control-label col-lg-3" for="creation_date">Creation Date</label>
          <div class="col-lg-9">
            <input type="text" class="form-control" id="creation_date" readonly="readonly"  name="creation_date" value="<?php echo date('Y-m-d'); ?>"  placeholder="Creation Date"  required>  
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-lg-3" for="due_date">Due Date</label>
          <div class="col-lg-9">
           <input type="text" class="form-control"  name="due_date" readonly="readonly" id ="field" value="" size="20" maxlength="20">
          </div>
        </div>
		  <div class="form-group">
          <label class="control-label col-lg-3" for="file">Remark</label>
          <div class="col-lg-9">
              <select class="form-control select2" style="width: 100%;" name="remark" required>
                <option disabled selected value>-- Please Select --</option>
				<option id="Active" value="Active">Active</option>
<option id="Inactive" value="Inactive">Inactive</option>
<option id="PSNM" value="PSNM">PSNM Equipment</option>
<option id="OOS" value="OOS">Out of Service</option>
<option id="Consign" value="Consign">Consign</option>
<option id="Spoil" value="Spoil">Spoil</option>
<option id="Closed" value="Repaired">Closed</option>
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
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
</html>
