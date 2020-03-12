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
                        <div class="panel-heading"><b>Temperature Test</b></div>
                        <div class="panel-body">

                        <?php include('../dist/includes/dbcon.php');
                        
                        $query=mysqli_query($con,"SELECT id, tray_no, temperature, 
                        DATE_FORMAT(FROM_UNIXTIME(`time_in`), '%d %M %Y %h:%i:%s%p') AS 'time_in',
                        DATE_FORMAT(FROM_UNIXTIME(`time_in` + (temperature*3600)),'%d %M %Y %h:%i:%s%p') AS exp_tout,
                        DATE_FORMAT(FROM_UNIXTIME(`time_out`), '%d %M %Y %h:%i:%s%p') AS 'time_out'
                        FROM temp_test WHERE status = '0' order by temperature, id asc")or die(mysqli_error());
                        
                        ?>
                        <form id="form_temp" class="form-horizontal" method="post" action="temp_selected_tray.php" enctype='multipart/form-data'>
                        <table class="table table-bordered table-striped" width="50%">
                            <tr>
                                <th class="info text-center"></th>
                                <th class="info text-center">Tray Number</th>
                                <th class="info text-center">Temperature</th>
                                <th class="info text-center">Time In</th>
                                <th class="info text-center">Time Out</th>
                            </tr>

                            <?php 
                            $rowcount=mysqli_num_rows($query);
                            if($rowcount>=1){
                            while($row = mysqli_fetch_assoc($query)) {
                            ?>

                            <tr>
                                <td class="text-center"><input type="checkbox" name="id[<?php echo $row['id']; ?>]" value="<?php echo $row['id']; ?>"> </td>
                                <td><?php echo $row['tray_no']; ?></td>
                                <td><?php if($row['temperature']==1){echo "Cold";}else{echo "Hot";} ?></td>
                                <td><?php if($row['time_in']==null){echo "-";}else{echo "<b>".$row['time_in']."</b>";} ?></td>
                                <td><?php if($row['time_out']==null&&$row['time_in']==null){
                                        echo "-";
                                    }
                                    elseif($row['time_out']==null&&$row['time_in']!=null){
                                        echo "<font color='red'>Take out at : ".$row['exp_tout']."</font>";
                                    }
                                    else{
                                        echo "<b>".$row['time_out']."</b>";
                                    } ?>
                                </td>
                                <input type="hidden" name="temp[<?php echo $row['id']; ?>]" value="<?php echo $row['temperature']; ?>"/>
                            </tr>

                            <?php } }
                            
                            else{
                            ?>
                            <tr>
                                <td></td>
                                <td class="text-center">No Data To Be Shown.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php } ?>
                            <input type="hidden" name="prc" id="prc" value=""/>
                        </table>

                        <br><br>

                        <div>
                            <input type="button" id="btn_finish" name="btn_finish" style="float: right;" class="btn btn-primary" value="Finish"></input>
                            <input type="button" id="btn_stop" name="btn_stop" style="float: right;" class="btn btn-danger" value="Stop"></input>
                            <input type="button" id="btn_start" name="btn_start" style="float: right;" class="btn btn-success" value="Start"></input>
                        </div>

                        </form><br><br><br><br><br><br><br>

                
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

            //process code(prc) 0=start, 1=stop, 2=finish
        
            $("#btn_start").click(function () {
                document.getElementById("prc").value = '0';
                document.getElementById("form_temp").submit();
            });
            $("#btn_stop").click(function () {
                document.getElementById("prc").value = '1';
                document.getElementById("form_temp").submit();
            });
            $("#btn_finish").click(function () {
                document.getElementById("prc").value = '2';
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
