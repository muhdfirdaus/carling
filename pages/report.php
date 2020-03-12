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
			    <a class = "btn btn-primary btn-print" href = "export.php"><i class ="glyphicon glyphicon-export"></i>Export to Excel</a>  
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
                        <th>No</th>
                        <th>Serial Number</th>
                        <th>Name</th>
                        <th>Project</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
                        <th>Lab.</th>
                        <th>Location</th>
                        <th>Cert. No.</th>
                        <th>Creation Date</th>
                        <th>Due Date</th>
                        <th>PIC</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
		
		$query=mysqli_query($con,"select * from product  where branch_id='$branch' order by creation_date")or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
		
?>
                      <tr>
                        <td></td>
                        <td><?php echo $row['equip_no'];?></td>
                        <td><?php echo $row['equip_name'];?></td>
                        <td><?php echo $row['project'];?></td>
                        <td><?php echo $row['model'];?></td>
						
						<td><?php echo $row['manufacturer'];?></td>
                        <td><?php echo $row['category'];?></td>
						<td><?php echo $row['location'];?></td>
						<td><?php echo $row['cert_no'];?></td>
            			<td><?php echo $row['creation_date'];?></td>
            			<td><?php echo $row['due_date'];?></td>
						<td><?php echo $row['dept'];?></td>
						<td><?php echo $row['remark'];?></td>
						
						
                       
                      </tr>
<div id="updateordinance<?php echo $row['equip_id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	
  
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
        var t = $('#example1').DataTable( {
          "columnDefs": [ {
              "searchable": false,
              "orderable": false,
              "targets": 0
          } ],
        } );
  
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
      });
    </script>
  </body>
</html>
