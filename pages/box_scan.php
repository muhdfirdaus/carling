<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;
// include('../pages/logupdate.php');
// logupd();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home | <?php include('../dist/includes/title.php');include('../dist/includes/dbcon.php');?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <style>
      .col-lg-3{
        margin:50px 0px;
      }
      
    </style>
 </head>
  <script language="javascript">
           var message="This function is not allowed here.";
           function clickIE4(){
                 if (event.button==2){
                     alert(message);
                     return false;
                 }
           }
           function clickNS4(e){
                if (document.layers||document.getElementById&&!document.all){
                        if (e.which==2||e.which==3){
                                  alert(message);
                                  return false;
                        }
                }
           }
           if (document.layers){
                 document.captureEvents(Event.MOUSEDOWN);
                 document.onmousedown=clickNS4;
           }
           else if (document.all&&!document.getElementById){
                 document.onmousedown=clickIE4;
           }
           document.oncontextmenu=new Function("alert(message);return false;")
</script>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-black layout-top-nav" onload="myFunction()">
    <div class="wrapper">
      <?php include('../dist/includes/header.php');?>
      <!-- Full Width Column -->
      <div class="content-wrapper">
      <?php 
        $query=mysqli_query($con,"select lastupdate from ict_test order by lastupdate desc limit 1")or die(mysqli_error($con));
        $row=mysqli_fetch_array($query);
        $rawdata=$row['lastupdate'];
        $lupd=date('d M Y h:iA',$rawdata);
      ?>
      <div class="alert alert-success" role="alert">Log data last updated on: <?php echo $lupd;?> &nbsp;<a href="icttest.php">CLICK TO UPDATE AGAIN</a></div>
        <div class="container">
          <!-- Content Header (Page header) -->
          <?php 
          $id = $_GET['id'];
          $query2=mysqli_query($con,"select * from box_master where id=$id")or die(mysqli_error($con));
          $row2=mysqli_fetch_array($query2);
          $model=$row2['model'];
          $qty=$row2['qty'];
          $box_id=$row2['box_id'];
          $wo=$row2['wo'];
          $lot=$row2['lot'];
          
          $query=mysqli_query($con,"select count(*) as tot from box_sn where box_id=$box_id")or die(mysqli_error($con));
          $row=mysqli_fetch_array($query);
          $scanned = $row['tot'];

          $dif = $qty-$scanned;

          $maxrow = 1;
          
          ?>
          <!-- Main content -->
          <section class="content">
            <div class="panel panel-default">
              <div class="panel-heading">Box Details</div>
              <div class="panel-body">
                <form id="form_box" class="form-horizontal" method="post" action="box_scan_in.php" enctype='multipart/form-data'>
                  <p>Carton ID: <b><?php echo $box_id; ?></b></p>
                  <p>Model: <b><?php echo $model;?></b></p>
                  <p>Quantity: <b><?php echo $scanned.'/'.$qty;?></b></p>
                  <p>WO Number: <b><?php echo $wo; ?></b></p>
                  <p>Lot Number: <b><?php echo $lot; ?></b></p><br>
                  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"></input>
                  <input type="hidden" name="box_id" id="box_id" value="<?php echo $box_id; ?>"></input>
                  <input type="hidden" name="qty" id="qty" value="<?php echo $qty; ?>"></input>
                  <input type="hidden" name="model" id="model" value="<?php echo $model;?>"></input>
                  <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $maxrow;?>"></input>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <th class="info text-center">Item</th>
                      <th class="info text-center">Serial Number</th>
                    </thead>
                    <tbody>
                      <?php for ($i=1; $i<=$maxrow; $i++) {
                          echo '<tr><td class="text-center">'.$i.'</td>
                          <td class="text-center"><input autocomplete="off" autofocus class="form-control text-center" maxlength="40" required name="sn'.$i.'" id="sn'.$i.'" </td>';
                      }
                      ?>
                    </tbody>
                  </table>
                </form>
                <button type="button" id="btn_box" class="btn btn-primary" style="float: right;">Next</button>
              </div>
            </div>

	        </section><!-- /.content -->
          
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <?php include('../dist/includes/footer.php');?>
    </div><!-- ./wrapper -->


	<script>
    $(function() {
      $(".btn_delete").click(function(){
      var element = $(this);
      var id = element.attr("id");
      var dataString = 'id=' + id;
      if(confirm("Sure you want to delete this item?"))
      {
	$.ajax({
	type: "GET",
	url: "temp_trans_del.php",
	data: dataString,
	success: function(){
		
	      }
	  });
	  
	  $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
	  .animate({ opacity: "hide" }, "slow");
      }
      return false;
      });

      });
    </script>
	
	<script type="text/javascript" src="autosum.js"></script>
  
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../dist/js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/select2/select2.full.min.js"></script>
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
        
        $("#btn_box").click(function () {
          document.getElementById("form_box").submit();
          // var valid = true;
          // var i;
          // for (i = 1; i < 21; i++) { 
          //   var sn_name = "sn"+i;
          //   var pass1 = document.getElementById(sn_name).value;
          //   var pass_t = pass1.trim();
          //   if(pass_t.length < 1 || pass_t == ""){
          //     valid = false;
          //   }
          // }
          // if(valid = false){
          //   alert("Product is not enough");
          // }
        });
        
      });  
    </script>
  </body>
</html>
