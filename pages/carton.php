<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;
include('../dist/includes/dbcon.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carton | <?php include('../dist/includes/title.php'); include('product_cfg.php');?></title>
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
         
          <?php 
          isset($_GET['limit'])? $limit = $_GET['limit'] : $limit = 6;
          $limit>6 ? $limit=6 : $limit = $limit; 
          $query=mysqli_query($con,"select * from carton_info order by carton_id desc limit 1")or die(mysqli_error($con));
          $row=mysqli_fetch_array($query);
          $carton_id=$row['carton_id'];
          $run_no =  preg_replace("/[^0-9,.]/", "", $carton_id);         
          $next_carton_id = "IQ" . str_pad(($run_no +1), 6, '0', STR_PAD_LEFT);?>
          <!-- Main content -->
          <section class="content">
            <div class="panel panel-default">
              <div class="panel-heading">Carton Details</div>
              <div class="panel-body">
                <form id="form_box" class="form-horizontal" method="post" action="carton_in.php" enctype='multipart/form-data'>
                  <p>Product : <b>
                    <select name="model" id="model">
                      <?php $model = get_modelNo2($con);

                      foreach($model as $key=>$value){
                        echo '<option value="'.$key.'" >'.$value.'</option>';
                      }?>
                    </select>
                  </b></p>
                  <p>Pallet ID: <b><?php echo $next_carton_id; ?></b></p>
                  <p>No. of Box: 
                    <select name="no_box" id="no_box" >
                        <option value="1" <?php if($limit==1){echo"selected";} ?>>1</option>
                        <option value="2" <?php if($limit==2){echo"selected";} ?>>2</option>
                        <option value="3" <?php if($limit==3){echo"selected";} ?>>3</option>
                        <option value="4" <?php if($limit==4){echo"selected";} ?>>4</option>
                        <option value="5" <?php if($limit==5){echo"selected";} ?>>5</option>
                        <option value="6" <?php if($limit==6){echo"selected";} ?>>6</option>
                    </select>
                  </p><br>
                  <input type="hidden" name="carton_id" id="carton_id" value="<?php echo $next_carton_id; ?>"></input>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <th class="info text-center">Item</th>
                      <th class="info text-center">Box Number</th>
                    </thead>
                    <tbody>
                      <?php for ($i=1; $i<=$limit; $i++) {
                          echo '<tr><td class="text-center">'.$i.'</td>
                          <td class="text-center"><input class="form-control text-center" maxlength="8" required name="box'.$i.'" id="box'.$i.'" </td>';
                      }
                      ?>
                    </tbody>
                  </table>
                </form>
                <button type="button" id="btn_box" class="btn btn-primary" style="float: right;">Print Label</button>
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
     <script>
      $(function () {
        $('#no_box').on('change',function(){
            limit = Number($("#no_box").val());
            window.location.href = ( "?limit=" + limit);
        });
        
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
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });

        
      });
    </script>
  </body>
</html>
