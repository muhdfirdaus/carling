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
    <title>Temperature Test | <?php include('../dist/includes/title.php');?></title>
    
    <script type="text/javascript">
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>

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
    p {
    text-align: center;
    font-size: 60px;
    margin-top: 0px;
    color: red;
    };
    
    </style>
    </head>

    <body class="hold-transition skin-black layout-top-nav" onload="myFunction()" onbeforeunload="return confirm( 'If you leave this page, you will receive 0 points. Stay on page?' );">
    <div class="wrapper">
        <?php include('../dist/includes/header.php');?>
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Temperature Test</b></div>
                        <div class="panel-body">

                        <?php 
                        $temp = $_GET['temp'];
                        $id = $_GET['id'];

                        $now = round(microtime(true) * 1000);
                        //$expired = $now + (($temp*60) * 60 * 1000); //first number is in minute 
                        $expired = $now + (($temp*60) * 60 * 1000); //first number is in minute 

                        $temp==1?$t="Cold":$t="Hot";

                        $arrID = explode(",", $id);

                        $query=mysqli_query($con,"SELECT tray_no FROM temp_test WHERE id in ($id)")or die(mysqli_error());
                        ?>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class='col-lg-2'>Temperature : </td>
                                <td><?php echo $t; ?></td>
                            </tr>
                            <?php 
                            $i=0;
                            while($row = mysqli_fetch_assoc($query)) {
                                if($i==0){
                            ?>
                            <tr>
                                <td class='col-lg-2'>Tray : </td>
                                <td><?php echo $row['tray_no']; ?></td>
                            </tr>
                                <?php $i++; } else{ ?>
                            <tr>
                                <td></td>
                                <td> <?php echo $row['tray_no']; ?></td>
                            </tr>
                            <?php $i++;} } ?>
                        </table>

                        <table border=1 align=center>
                            <th>
                                <p id="timer"></p>
                            </th>
                        </table>
                        
                        <input id="time_now" value='<?php echo $now; ?>' hidden></input>
                        <input id="time_exp" value='<?php echo $expired; ?>' hidden></input>

                        <br><br>
                        <form id="form_temp" class="form-horizontal" method="post" action="timer_out.php" enctype='multipart/form-data'> 
                            <input id="idlist"  name="idlist"  value='<?php echo $id; ?>' hidden></input>           
                            <button type="submit" id="btn_stop" class="btn btn-danger " style="display: block; margin: 0 auto;" disabled>STOP</button>
                        </form>
                        <br><br><br><br><br><br><br><br>               

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
        // Set the date we're counting down to
        var countDownDate = document.getElementById("time_exp").value;

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
                
            // Output the result in an element with id="timer"
            document.getElementById("timer").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";
                
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "TIME UP! TAKE OUT THE TRAY NOW!";
                document.getElementById("btn_stop").disabled = false;
            }

        }, 1000);
        </script>

    </body>
</html>
