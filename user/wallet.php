<?php 
require_once("../db.php");
$title = "Wallet | FileCloud - Secured file sharing with cloud storage";
require_once("../header.php");
require_once("../functions.php");
if (empty('$_SESSION["email"]')) {
  redirect("/filecloud/user/");
}

if ($_SESSION["usertype"]!="user") {
  redirect("/filecloud/user/");
  session_destroy();
  redirect("/filecloud");
}
$name =  $_SESSION["name"];
$name = strtok($name, " ");
?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
 <?php  require_once("side-nav.php"); ?>
  <div class="content-wrapper">
    <div class="container-fluid">
    <?php 
    if (isset($_GET['m']) && $_GET['m']=="success") {
      echo $msg = "<div class='alert alert-primary'><h4>Money added successfully</h4></div>";
    }
    else if (isset($_GET['m']) && $_GET['m']=="addfund") {
      echo $msg = "<div class='alert alert-warning'><h4>Add fund to upgrade plan</h4></div>";
    }
    
    
    ?>
    <!-- Success message for registration -->
      <?php
            $name =  $_SESSION["name"];
            $name = strtok($name, " ");
           
      ?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Wallet</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
      <div class="col-md-3"> 
            <div class="col-xl-12 col-sm-6 mb-4">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-google-wallet"></i>
                </div>
                <div class="mr-5">
                <h4><?php echo premiumplan(); ?></h4>
                <h6><?php echo "Valid till ".premiumexpiry(); ?></h6>
                </div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Current plan</span>
                
                </a>
            </div>
            </div>
            <div class="col-xl-12 col-sm-6 mb-4">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-money"></i>
                </div>
                <div class="mr-5"><h4><?php echo "$".balance($_SESSION['userid']);?></h4></div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Total Balance</span>
                
                </a>
            </div>
            </div>
      </div>  
    
  <div class="col-md-4">
    <div class="card card-login mx-auto">
      <div class="card-header">Add money to wallet</div>
      <div class="card-body">
        <form action="payments.php" method="get">
          <div class="form-group">
            <label for="exampleInputPassword1">Enter Amount</label>
            <input class="form-control" id="exampleInputPassword1" type="text" name="amount" maxlength="3" placeholder="amount" <?php if(isset($_GET['amt'])){echo "value='".$_GET['amt']."' disabled"; }?>>
          </div>
          <div class="form-group">
           <input type="submit" class="btn btn-primary" style="width:100%" value="Add Money"/>
           
          </div>
        </div>
      </div>
    </div>
</div>
          
        </div>    
    
      <!-- Area Chart Example-->
      
      <!-- Example DataTables Card-->
      
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © FileCloud 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?php echo "../functions.php?logout=1"; ?>">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="../js/sb-admin-datatables.min.js"></script>
    <script src="../js/sb-admin-charts.min.js"></script>
    <script>
    $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
});



    </script>
  </div>
</body>

</html>
