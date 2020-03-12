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
    <title>Box Configuration | <?php include('../dist/includes/title.php'); include('product_cfg.php');?></title>
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
    <style>
      
    </style>
 </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-black layout-top-nav">
    <div class="wrapper">
      <?php include('../dist/includes/header.php');
      include('../dist/includes/dbcon.php');
      ?>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              <a class="btn btn-lg btn-warning" href="box.php">Back</a>
              
            </h1>
            <ol class="breadcrumb">
              <li><a href="box.php"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Box Configuration</li>
            </ol>
          </section>
        <?php
		    $id=$_SESSION['id'];
        $query=mysqli_query($con,"select * from box_config where id=1")or die(mysqli_error());
        $row=mysqli_fetch_array($query);
        $qty = $row['qty'];
        $id = $row['id'];
        $model = $row['model'];

		    ?>	
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Box Configuration</h3>
                  </div>
                  <div class="box-body">
                    <!-- Date range -->
                    <form id = "formE" method="post" action="box_cfg_upd.php">
    
                    <div class="form-group">
                      <label for="date">Product Name</label>
                      <div class="input-group col-md-6">
                        <select name="model" class="form-control">
                          <?php $modellist = get_modelNo2($con);

                          foreach($modellist as $key=>$value ){
                          ?>
                          <option value='<?php echo $key;?>'<?php if($model==$key){echo "selected"; }?> ><?php echo $value; ?></option>
                          <?php } ?>
                        </select>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <div class="form-group">
                      <label for="date">Quantity</label>
                      <div class="input-group col-md-2">
                        <input type="number" class="form-control pull-right" max='45' value="<?php echo $qty;?>" name="qty" placeholder="Quantity" required>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->            
                    <div class="form-group">
                      <div class="input-group">
                        <button class = "btn btn-primary" id="btn_submit">Submit</button>
                      </div>
                    </div><!-- /.form group -->
                    </form>	
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
              </div><!-- /.col (right) -->
            </div><!-- /.row -->
	  
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <?php include('../dist/includes/footer.php');?>
    </div><!-- ./wrapper -->

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
      // ('#formE').on('keyup keypress', function(e) {
      //   var keyCode = e.keyCode || e.which;
      //   if (keyCode === 13) { 
      //     e.preventDefault();
      //     return false;
      //   }
      // });
      $("#formE").keypress(function(e) {
        //Enter key
        if (e.which == 13) {
          return false;
        }
      });

      $("#btn_submit").click(function () {
          tot = 1;
          // ok = myFunction();

          // if(ok == true){
          //   tot += 1;
          // }
          //  alert("tot is : " + tot); 
          // if(tot>1){
          document.getElementById("formE").submit();
          // }
      });

      function myFunction() {
        var pass1 = document.getElementById("model").value;
        var pass2 = document.getElementById("model_no").value;
        var pass_old = document.getElementById("qty").value;
        var ok = true;
        
        if(pass_old.trim() == ""){
          alert("Please enter your current password");
          ok = false;
        }
        if ((pass1 != null || pass2 != null ) && pass1 != pass2) {
            alert("Passwords Do not match");
            document.getElementById("password").style.borderColor = "#E34234";
            document.getElementById("cfmPassword").style.borderColor = "#E34234";
            ok = false;
        }
        return ok;

      }

      function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }

	</script>
  </body>
</html>
