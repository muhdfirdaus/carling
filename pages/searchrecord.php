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
                    <!-- <p>Carton ID: <b><?php echo $box_id; ?></b></p>
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"></input> -->
                    <form action="searchrecord.php" method="post">
                    <table align="center">
                        <tr>
                            <td>
                                <select name="criteria" id="criteria" class="form-control">
                                    <option value="sn" selected>Serial Number</option>
                                    <!-- <option value="boxid">Box ID</option> -->
                                </select>
                            </td>
                            <td>
                                <input type="text" name="searchval" id="searchval" class="form-control" autocomplete="off"></input>
                            </td>
                            <td>
                                <button type="submit" id="btn_search" class="btn btn-primary" >Search</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                    <br><br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th class="info text-center">SN</th>
                            <th class="info text-center">Box ID</th>
                            <th class="info text-center">Model</th>
                            <th class="info text-center">Quantity</th>
                            <th class="info text-center">User</th>
                            <th class="info text-center">Time of Packing</th>
                            <th class="info text-center">Status</th>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['searchval'])){
                          if(strlen($_POST['searchval'])>4){
                            $sn = preg_replace('/\s+/', '', $_POST["searchval"]);
                            $query2=mysqli_query($con,"SELECT bs.sn, bm.box_id, bm.model, bm.qty,bm.status, u.name, bm.timestamp
                            FROM box_sn bs
                            LEFT JOIN box_master bm ON bs.box_id = bm.box_id
                            LEFT JOIN USER u ON bm.user_id = u.user_id
                            WHERE bs.sn ='$sn'")or die(mysqli_error($con));
                            if(count($row = mysqli_fetch_array($query2))>=1){
                        ?>
                            <tr>
                                <td><?php echo $row['sn'];?></td>
                                <td><?php echo $row['box_id'];?></td>
                                <td><?php echo $row['model'];?></td>
                                <td><?php echo $row['qty'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo date('d-M-Y h:i:sa',$row['timestamp']);?></td>
                                <?php if($row['status']=="1"){echo "<td class='text-green'><b>FINISH</b>";}else echo "<td class='text-red'><b>ON GOING</b>";?></td>
                            </tr> 
                        <?php 
                            }
                            else {?>
                            <tr>
                              <td colspan="7" class="text-center">No record.</td>
                            </tr>
                        <?php
                          }
                          }
                        }?>   
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
        
        $("#asd").click(function () {
          var pass1 = document.getElementById(searchval).value;
          alert(pass1);
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
