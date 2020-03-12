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
    <title>Box History | <?php include('../dist/includes/title.php');include('../dist/includes/dbcon.php');?></title>
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
        <div class="container">
        <!-- Content Header (Page header) -->
          <!-- Main content -->
        <section class="content">
            <div class="panel panel-default">
              <div class="panel-heading">Box History</div>
                <div class="panel-body">
                    <?php  $box_id = $_GET['boxid'];
                    $query=mysqli_query($con,"select * from box_master where box_id=$box_id")or die(mysqli_error($con));
                    $data = mysqli_fetch_array($query);
                    $status = $data['status'];
                     ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th class="info text-center">Box ID</th>
                            <th class="info text-center">Serial Number</th>
                            <th class="info text-center">Time Scanned</th>
                            <th class="info text-center">Status</th>
                        </thead>
                        <tbody>
                        <?php
                        // $currentdate = strtotime(date('Ymd'));           //actual current date
                        $currentdate = strtotime(date('Ymd'))-86400000;     //test purpose. use yesterday date
                        $query2=mysqli_query($con,"select * from box_sn where box_id=$box_id")or die(mysqli_error($con));
                        while($data = mysqli_fetch_array($query2)){
                        ?>
                            <tr>
                                <td><?php echo $box_id;?></td>
                                <td><?php echo $data['sn'];?></td>
                                <td><?php echo date('d-M-Y h:i:sa',$data['timestamp']);?></td>
                                <?php if($status=="1"){echo "<td class='text-green'><b>FINISH</b>";}else echo "<td class='text-red'><b>ON GOING</b>";?></td>
                            </tr> 
                        <?php } ?>   
                        </tbody>
                    </table>
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
