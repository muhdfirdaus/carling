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
    <title>Temperature Test | <?php include('../dist/includes/title.php');?></title>
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

    

    </head>

    <body class="hold-transition skin-black layout-top-nav" onload="myFunction()">
    <div class="wrapper">
        <?php include('../dist/includes/header.php');?>
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Tray Registration</b></div>
                        <div class="panel-body">
                        
                        <form id="form_temp" class="form-horizontal" method="post" action="temp_in.php" enctype='multipart/form-data'>
                        <table class="table-bordered table-striped" width="50%">
                            <tr>
                                <td>Temperature : </td>
                                <td>
                                    <select id="temp" name="temp" class="form-control">
                                        <option value="1">Cold</option>
                                        <option value="2">Hot</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td >Tray : </td>
                                <td><input type="text" id="tray" name="tray" placeholder="Tray Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td>SN : </td>
                                <td><input type="text" id="sn1" name="sn1" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn2" name="sn2" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn3" name="sn3" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn4" name="sn4" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn5" name="sn5" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn6" name="sn6" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn7" name="sn7" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn8" name="sn8" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn9" name="sn9" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" id="sn10" name="sn10" placeholder="Serial Number" class="form-control"></input></td>
                            </tr>
                        </table>

                        <br><br>

                        <div>
                            <button id="btn_start" name="btn_start" style="display: block; margin: 0 auto;" class="btn btn-primary">Save</button>
                        </div>

                        </form>

                
                        </div><!-- /.panel body -->
                    </div><!-- /.panel -->
                </section><!-- /.content -->
            
            </div><!-- /.container -->
        </div><!-- /.content-wrapper -->
        <?php include('../dist/includes/footer.php');?>
    </div><!-- ./wrapper -->

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
        
            $("#btn_start").click(function () {
                document.getElementById("form_temp").submit();
            });
        });
        
        </script>

    </body>
</html>
