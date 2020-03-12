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

    <body class="hold-transition skin-black layout-top-nav" onload="myFunction()" >
    <div class="wrapper">
        <?php include('../dist/includes/header.php');?>
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Temperature Test Result</b></div>
                        <div class="panel-body">

                        <?php include('../dist/includes/dbcon.php');
                        $idlist = $_GET['id'];
                        $query=mysqli_query($con,"SELECT tt.id AS id, tt.tray_no AS tray_no, tt.temperature AS temperature, 
                        DATE_FORMAT(FROM_UNIXTIME(`time_in`),'%d %M %Y %h:%i:%s%p') AS 'time_in',
                        DATE_FORMAT(FROM_UNIXTIME(`time_out`), '%d %M %Y %h:%i:%s%p') AS 'time_out',
                        ts.sn AS sn, ts.id AS sn_id
                        FROM temp_test AS tt
                        LEFT JOIN temp_test_sn AS ts ON ts.batch_id = tt.id
                        WHERE tt.id in ($idlist) and ts.id is not null")or die(mysqli_error());
                        
                        ?>
                        <form id="form_temp" class="form-horizontal" method="post" action="timer_result_in.php" enctype='multipart/form-data'>
                        <table class="table table-bordered table-striped" width="50%">
                            <tr>
                                <th class="info text-center">Tray Number</th>
                                <th class="info text-center">Temperature</th>
                                <th class="info text-center">Time In</th>
                                <th class="info text-center">Time Out</th>
                                <th class="info text-center">Serial Number</th>
                                <th class="info text-center">Result</th>
                            </tr>

                            <?php 
                            while($row = mysqli_fetch_assoc($query)) {
                            ?>

                            <tr>
                                <td class="text-center"><?php echo $row['tray_no']; ?></td>
                                <td class="text-center"><?php if($row['temperature']==1){echo "Cold";}else{echo "Hot";} ?></td>
                                <td class="text-center"><?php echo $row['time_in']; ?></td>
                                <td class="text-center"><?php echo $row['time_out']; ?></td>
                                <td class="text-center"><?php echo $row['sn']; ?></td>
                                <td>
                                    <select class="form-control text-center" id="result[<?php echo $row['sn_id']; ?>]" name="result[<?php echo $row['sn_id']; ?>]">
                                        <option value="P">Pass</option>
                                        <option value="F">Fail</option>
                                    </select>
                                </td>
                                <input type="hidden" id="id[<?php echo $row['id']; ?>]" name="id[<?php echo $row['id']; ?>]" value="<?php echo $row['id']; ?>"/>
                                <input type="hidden" id="sn_id[<?php echo $row['sn_id']; ?>]" name="sn_id[<?php echo $row['sn_id']; ?>]" value="<?php echo $row['sn_id']; ?>"/>
                            </tr>

                            <?php }?>

                        </table>

                        <br><br>

                        <div>
                            <button id="btn_next" name="btn_next" style="display: block; margin: 0 auto;" class="btn btn-primary">Next</button>
                        </div>

                        </form>
                        <br><br><br><br><br><br><br><br><br><br><br><br>           
                
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
        
            $("#btn_next").click(function () {
                document.getElementById("form_temp").submit();
            });
        });
        // Set the date we're counting down to
        var countDownDate = document.getElementById("demo3").value;

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";
                
            // If the count down is over, write some text 
            if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "TIME UP! TAKE OUT THE TRAY NOW!";
            }

        }, 1000);
        </script>

    </body>
</html>
