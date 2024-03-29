<?php 

session_start();

if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Box Configuration | <?php include('../dist/includes/title.php');?></title>
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
                <?php 
                $query=mysqli_query($con,"SELECT DISTINCT m.id,m.timestamp,m.box_id,m.model,m.qty,m.wo,(SELECT COUNT(*) FROM box_sn WHERE box_id = m.box_id) AS scanned FROM box_master m WHERE m.status=0")or die(mysqli_error($con));
                if(mysqli_num_rows($query)>0){
                ?>
                    <section class="content">
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Unfinished Box</b></div>
                            <div class="panel-body">
                            
                            <form id="form_box" class="form-horizontal" method="post" action="#" enctype='multipart/form-data'>
                            <table class="table table-bordered table-striped" width="50%" align="center">
                                <tr>
                                    <th class="info text-center">Box ID</th>
                                    <th class="info text-center">Model</th>
                                    <th class="info text-center">Quantity</th>  
                                    <th class="info text-center">Work Order</th>  
                                    <th class="info text-center">Date Created</th>  
                                    <th class="info text-center">Resume</th>                                
                                </tr>
                                <?php 
                                $c = 1;
                                while($row = mysqli_fetch_array($query)){?>
                                <tr>
                                <?php
                                $id = $row['id'];
                                $box_id = $row['box_id'];
                                $model = $row['model'];
                                $qty = $row['qty'];
                                $wo = $row['wo'];
                                $timestamp = date('d-M-Y h:i:sa',$row['timestamp']);
                                $scanned = $row['scanned'];
                                echo  "<td >$box_id</td>
                                    <td >$model</td>
                                    <td >$scanned / $qty</td>
                                    <td >$wo</td>
                                    <td >$timestamp</td>
                                    <td  align='center'><a href='box_scan.php?id=$id'><i class='glyphicon glyphicon-chevron-right text-blue'></i></a></td>";
                                $c++;                        
                                ?>
                                
                                </tr>
                                <?php } ?>
                            </table>
                            
                            <br><br>

                            </form>

                    
                            </div><!-- /.panel body -->
                        </div><!-- /.panel -->
                    </section><!-- /.content -->
                <?php } ?>
                <section class="content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Box Configuration</b></div>
                        <div class="panel-body">
                        
                        <form id="form_box" class="form-horizontal" method="post" action="box_start_in.php" enctype='multipart/form-data'>
                        <table class="table-bordered table-striped" width="50%" align="center">
                            <tr>
                                <td >Model : </td>
                                <td>
                                    <select id="model" name="model" class="form-control">
                                        <option value="null">--SELECT--</option>
                                        <option value="CA-942-10027-001">CA-942-10027-001</option>
                                        <option value="CA-942-10046-003">CA-942-10046-003</option>
                                        <option value="CA-942-10046-005">CA-942-10046-005</option>
                                        <option value="CA-942-10047-001">CA-942-10047-001</option>
                                        <option value="CA-942-10047-002">CA-942-10047-002</option>
                                        <option value="CA-942-10047-003">CA-942-10047-003</option>
                                        <option value="CA-942-10047-101">CA-942-10047-101</option>
                                        <option value="CA-942-10047-102">CA-942-10047-102</option>
                                        <option value="CA-942-10047-105">CA-942-10047-105</option>
                                        <option value="CA-942-10047-126">CA-942-10047-126</option>
                                        <option value="CA-942-10047-131">CA-942-10047-131</option>
                                        <option value="CA-942-10047-136">CA-942-10047-136</option>
                                        <option value="CA-946-10053-001">CA-946-10053-001</option>
                                        <option value="CA-942-10048-001">CA-942-10048-001</option>
                                        <option value="CA-942-10048-002">CA-942-10048-002</option>
                                        <option value="CA-942-10049">CA-942-10049-E</option>
                                        <!-- <option value="CA-942-10048-002">CA-942-10048-002</option> -->
                                        <option value="CA-942-10067-001">CA-942-10067-001</option>
                                        <option value="CA-942-10067-003">CA-942-10067-003</option>
                                        <option value="CA-942-10067-005">CA-942-10067-005</option>
                                        <option value="CA-942-10067-009">CA-942-10067-009</option>
                                        <option value="CA-942-10067-011">CA-942-10067-011</option>
                                        <option value="CA-942-10067-012">CA-942-10067-012</option>
                                        <option value="CA-942-10071-002">CA-942-10071-002</option>
                                        <option value="CA-942-10085-003">CA-942-10085-003</option>
                                        <option value="CA-942-10085-009">CA-942-10085-009</option>
                                        <option value="CA-942-10128-002">CA-942-10128-002</option>
                                        <option value="CA-942-10128-003">CA-942-10128-003</option>
                                        <option value="CA-942-10129-001">CA-942-10129-001</option>
                                        <option value="CA-942-10161-001">CA-942-10161-001</option>
                                        <option value="CA-942-10161-003">CA-942-10161-003</option>
                                        <option value="CA-942-10161-005">CA-942-10161-005</option>
                                        <option value="CA-942-10168-001">CA-942-10168-001</option>
                                        <option value="CA-942-10169-001">CA-942-10169-001</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>No. of products : </td>
                                <td><input type="text" name="qty" id="qty" class="form-control"  ></td>
                            </tr>
                            <tr>
                                <td>Description : </td>
                                <td><input type="text" name="desc" id="desc" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Revision : </td>
                                <td><input type="text" name="rev" id="rev" class="form-control" autocomplete="off" readonly></td>
                            </tr>
                            <tr>
                                <td>Revision Number : </td>
                                <td><input type="text" name="rev_no" id="rev_no" class="form-control" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td>Work Order : </td>
                                <td><input type="text" name="wo" id="wo" class="form-control" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"></td>
                            </tr>
                            <!-- <tr>
                                <td>Lot : </td>
                                <td><input type="text" name="lot" id="lot" class="form-control" onkeyup="this.value = this.value.toUpperCase();"></td>
                            </tr> -->
                        </table>
                        
                        <p class="text-red text-center"><b>**Please make sure information is correct before clicking "Start"</b></p>
                        <br><br>

                        <div>
                            <button disabled id="btn_start" name="btn_start" style="display: block; margin: 0 auto;" class="btn btn-primary">Start</button>
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
                // alert($("#qty").val());
                // document.getElementById("form_box").submit();
            });
        });

        $('#model').on('change',function(){
            
            model = $("#model").val();
            
            if(model=="null"){ noprod = ""; rev=""; rev_no="";desc="";}
            if(model=="CA-942-10027-001"){ noprod = 10; rev_no="00";rev="H"; desc="942-10027-001 rev. H Bom";}
            if(model=="CA-942-10047-001"){ noprod = 300; rev_no="02";rev="J"; desc="LIN SWITCH RED FUNCTION LED REV.J ( SWITCH MODULE -LIN SLAVE )";}
            if(model=="CA-942-10047-002"){ noprod = 300; rev_no="02";rev="J"; desc="LIN SWITCH GREEN FUNCTION LED REV.J ( SWITCH MODULE -LIN SLAVE )";}
            if(model=="CA-942-10047-126"){ noprod = 600; rev_no="00";rev="J"; desc="942-10047-126_J Bom Red \ Red Led";}
            if(model=="CA-942-10047-131"){ noprod = 300; rev_no="00";rev="J"; desc="942-10047-131 Red LED Rev.J (Switch Board-DAF-KAMAZ)";}
            if(model=="CA-942-10047-136"){ noprod = 300; rev_no="00";rev="J"; desc="942-10047-136_J Bom Green \ Amber LED";}
            if(model=="CA-942-10047-102"){ noprod = 300; rev_no="00";rev="J"; desc="942-10047-102_J Bom (Amber LED)";}
            // if(model=="CA-942-10047-002"){ noprod = 300;}
            if(model=="CA-942-10047-003"){ noprod = 300; rev_no="01";rev="J";desc="LIN Switch No Function LED Rev.J (SWITCH MODULE - LIN SLAVE)";}
            if(model=="CA-942-10047-101"){ noprod = 300; rev_no="00";rev="J"; desc="942-10047-101_J (Switch Board-DAF-KAMAZ)";}
            if(model=="CA-942-10047-105"){ noprod = 300; rev_no="00";rev="J";desc="942-10047-105 Rev.J (Switch Board-DAF-KAMAZ)";}
            if(model=="CA-942-10046-003"){ noprod = 400; rev_no="00";rev="P";desc="LIN MASTER MODULE Bom Rev.P (Note : set as Phantom)";}
            if(model=="CA-942-10046-005"){ noprod = 400; rev_no="00";rev="P";desc="LIN MASTER MODULE Bom Rev.P (Note : set as Phantom)";}
            if(model=="CA-946-10053-001"){ noprod = 600;rev_no="02";rev="";desc="Finish Goods with Conformal Coating (Project 4033-001,Hazard Switch)";}
            if(model=="CA-942-10048-001"){ noprod = 600; rev_no="00";rev="H";desc="Rheostat BOM Rev.H (SWITCH MODULE - LIN SLAVE)";}
            if(model=="CA-942-10048-002"){ noprod = 600; rev_no="00";rev="H";desc="SWITCH MODULE LIN SLAVE";}
            if(model=="CA-942-10049"){ noprod = 600;rev_no="04"; rev="E";desc="SLAVE CARRIER BOARD (Rev E)";}
            if(model=="CA-942-10067-001"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Blue Halo - Red Indicators (Rev.G)";}
            if(model=="CA-942-10067-003"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Blue Halo - White Indicators (Rev.G)";}
            if(model=="CA-942-10067-005"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Blue Halo - Orange Indicators (Rev.G)";}
            if(model=="CA-942-10067-009"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Green Halo - White Indicators (Rev.G)";}
            if(model=="CA-942-10067-011"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Green Halo - Orange Indicators (Rev.G)";}
            if(model=="CA-942-10067-012"){ noprod = 600;rev_no="00"; rev="G";desc="HALO SWITCH Blue Halo (Rev.G)";}
            if(model=="CA-942-10071-002"){ noprod = 180;rev_no="05"; rev="";desc="USB EMI VCHARGER (Without Load Dump)";}
            if(model=="CA-942-10085-003"){ noprod = 600;rev_no="00"; rev="J";desc="HALO Switch Blue Halo - White Indicators (Rev.J)";}
            if(model=="CA-942-10085-009"){ noprod = 600;rev_no="00"; rev="J";desc="HALO SWITCH Green Halo - White Indicators(Rev.J)";}
            if(model=="CA-942-10128-002"){ noprod = 600;rev_no="03"; rev="";desc="Electronics Package (942-10128-002)";}
            if(model=="CA-942-10128-003"){ noprod = 600;rev_no="03"; rev="";desc="Electronics Package (942-10128-003)";}
            if(model=="CA-942-10129-001"){ noprod = 600;rev_no="02"; rev="A";desc="942-10129-001 Polaris (Carling)";}
            if(model=="CA-942-10161-001"){ noprod = 600;rev_no="05"; rev="";desc="4045-001 Polaris LED BOARD";}
            if(model=="CA-942-10161-003"){ noprod = 100;rev_no="02"; rev="A";desc="4045-001 Polaris LED BOARD";}
            if(model=="CA-942-10161-005"){ noprod = 600;rev_no="01"; rev="";desc="4045-001 Polaris LED Board";}
            if(model=="CA-942-10168-001"){ noprod = 600;rev_no="00"; rev="B";desc="94x-10168 Vent-Seat-Cabin";}
            if(model=="CA-942-10169-001"){ noprod = 100;rev_no="00"; rev="";desc="PCBA, Polaris Driver Modes Switch";}
            
            document.getElementById("qty").value = noprod;
            document.getElementById("rev").value = rev;
            document.getElementById("rev_no").value = rev_no;
            document.getElementById("desc").value = desc;
        });
        $('#wo').on('keyup',function(){
            
            var lenWO = $("#wo").val().length;
            if(lenWO != 7){ 
                document.getElementById("btn_start").disabled = true;
            }
            else{
                document.getElementById("btn_start").disabled = false;
            }
      });
        
        </script>

    </body>
</html>
