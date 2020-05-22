<?php
//session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;
date_default_timezone_set("Asia/Singapore"); 
?>
<?php include('../dist/includes/dbcon.php');

  // $query=mysqli_query($con,"select ip from printer_cfg where id=1")or die(mysqli_error($con));
  // $row=mysqli_fetch_array($query);
  // $ip1=$row['ip'];
  // $query=mysqli_query($con,"select ip from printer_cfg where id=2")or die(mysqli_error($con));
  // $row=mysqli_fetch_array($query);
  // $ip2=$row['ip'];
?>

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container-fluid">
            <div class="navbar-header" style="padding-left:20px">
              <a href="box_start.php" class="navbar-brand"><b><i class="glyphicon glyphicon-home"></i> Beyonics | Carling </b></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                  <?php if($_SESSION['admin']==1){ ?>

                  
                    <li class="">
                    
                    <a href="ictmanual.php" class="dropdown-toggle">
                      <i class="glyphicon glyphicon-warning-sign text-orange"></i> Manual ICT Test 
                      
                    </a>
                  </li>
                  
                  <?php } ?>
                  <li class="">
                    
                    <a href="searchrecord.php" >
                      <i class="glyphicon glyphicon-search text-green"></i> SN Record
                      
                    </a>
                  </li>
                  <li class="">
                    
                    <a href="box_report.php" >
                      <i class="glyphicon glyphicon-file text-green"></i> Box Report
                      
                    </a>
                  </li>
                  <li class="">
                    
                    <a href="#boxprint" class="dropdown-toggle" data-target="#boxprint" data-toggle="modal">
                      <i class="glyphicon glyphicon-barcode text-blue"></i> Reprint Label
                      
                    </a>
                  </li>
                  <li class="dropdown notifications-menu">
                    
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="glyphicon glyphicon-cog text-red"></i>
                      Configuration
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <!-- Inner Menu: contains the notifications -->
                        <ul class="menu">

                          <li>
                              <a href="profile.php">
                                <i class="glyphicon glyphicon-user text-orange"></i>
                                User profile ( <?php echo $_SESSION['name'];?> )
                              </a>
                          </li>
                          <li>
                              <a href="#">
                                <i class="glyphicon glyphicon-th-list text-orange"></i>Box Configuration
                              </a>
                          </li>
                          <li>
                              <a href="#printerip" class="dropdown-toggle" data-target="#printerip" data-toggle="modal">
                                <i class="glyphicon glyphicon-print text-orange"></i>Printer IP
                              </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="">
                    
                    <a href="logout.php" class="dropdown-toggle">
                      <i class="glyphicon glyphicon-off text-red"></i> Logout 
                      
                    </a>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>


<!--start of REPORT modal--> 
<div id="reportmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Report by Box/Pallet ID</h4>
      </div>
      <div style="font-size:11px" class="modal-body">
        <form class="form-horizontal" id="form_report" method="post" action="report_box.php" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="control-label col-lg-2" for="box">Box ID</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="box_id" name="box_id" placeholder="Box ID">  
            </div>
          </div><hr>
          <div class="form-group">
            <label class="control-label col-lg-2" for="pallet">Pallet ID</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="pallet_id" name="pallet_id" placeholder="Pallet ID">  
            </div>
          </div>
          <div class="form-group control-label text-red">*Please insert ONE(1) field only</div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_submit">Send</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>  
  </div><!--end of modal-dialog-->
</div> 
<!--end of REPORT modal--> 


<!--start of LABEL PRINTING modal--> 
<div id="boxprint" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Print Label (Box)</h4>
      </div>
      <div style="font-size:11px" class="modal-body">
        <form class="form-horizontal" id="form_report" method="post" action="lblreprint.php" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="control-label col-lg-2" for="box">Box ID</label>
            <div class="col-lg-7">
              <input autocomplete="off" type="text" class="form-control" id="box_id" name="box_id" placeholder="Box ID">  
            </div>
          </div><hr>
          <!-- <div class="form-group">
            <label class="control-label col-lg-2" for="printer_ip">Printer IP</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="printer_ip" name="printer_ip" placeholder="Printer IP" value="<?php echo $ip1; ?>">  
            </div>
          </div> -->
          <!-- <div class="form-group control-label text-red">*Please insert ONE(1) field only</div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_submit">Send</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>  
  </div><!--end of modal-dialog-->
</div> 
<!--end of BOX LABEL PRINTING modal--> 


<!--start of Carton LABEL PRINTING modal--> 
<div id="cartonprint" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Print Label (Carton)</h4>
      </div>
      <div style="font-size:11px" class="modal-body">
        <form class="form-horizontal" id="form_report" method="post" action="print_carton.php" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="control-label col-lg-2" for="box">Carton ID</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="carton_id" name="carton_id" placeholder="Carton ID">  
            </div>
          </div><hr>
          <div class="form-group">
            <label class="control-label col-lg-2" for="printer_ip">Printer IP</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="printer_ip" name="printer_ip" placeholder="Printer IP" value="<?php echo $ip2; ?>">  
            </div>
          </div>
          <!-- <div class="form-group control-label text-red">*Please insert ONE(1) field only</div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_submit">Send</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>  
  </div><!--end of modal-dialog-->
</div> 
<!--end of Carton LABEL PRINTING modal--> 



<!--start of PRINTER IP CONFIG modal--> 
<div id="printerip" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Printer IP Setup</h4>
      </div>
      <div style="font-size:11px" class="modal-body">
        <form class="form-horizontal" id="form_report" method="post" action="printer_cfg.php" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="control-label col-lg-2" for="printer_ip">Printer IP (Box)</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="printer_ip" name="printer_ip" placeholder="Printer IP for Box" value="<?php echo $ip1; ?>">  
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-2" for="printer_ip">Printer IP (Carton)</label>
            <div class="col-lg-7">
              <input type="text" class="form-control" id="printer_ip2" name="printer_ip2" placeholder="Printer IP for Carton" value="<?php echo $ip2; ?>">  
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn_submit">Send</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>  
  </div><!--end of modal-dialog-->
</div> 
<!--end of LABEL PRINTING modal--> 