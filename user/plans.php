<?php 
require_once("../db.php");
$title = "Premium Plans | FileCloud - Secured file sharing with cloud storage";
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
    <!-- Success message for registration -->
      <?php
            $name =  $_SESSION["name"];
            $name = strtok($name, " ");
            if (isset($_GET["m"]) && $_GET["m"]=="success") {
              echo $msg = "<div class='alert alert-primary'>Welcome ". $name.", Upload and share files now</div>";
            }
      ?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Plans</li>
      </ol>
      <!-- Icon Cards-->
            
<div class="snip1207">
  <div class="plan">
    <h3 class="plan-title">
      Starter
    </h3>
    <div class="plan-cost"><span class="plan-price">Free</span>
    <!-- <span class="plan-type">/ Monthly</span> -->
    </div>
    <ul class="plan-features">
      <li><i class="ion-checkmark"> </i>No validity</li>
      <li><i class="ion-checkmark"> </i>No Storage</li>
      <li><i class="ion-checkmark"> </i>Files Expires after 30 days</li>
      <li><i class="ion-checkmark"> </i>Unlimited File uploads/download</li>
      
    </ul>
    <!-- <div class="plan-select">  </div> -->
  </div>
  <div class="plan">
    <h3 class="plan-title">
      Basic
    </h3>
    <div class="plan-cost"><span class="plan-price">$19</span>
    <!-- <span class="plan-type">/ Monthly</span> -->
    </div>
    <ul class="plan-features">
    <li><i class="ion-checkmark"> </i>30 days validity</li>
    <li><i class="ion-checkmark"> </i>500 MB</li>
      <li><i class="ion-checkmark"> </i>Files never Expires</li>
      <li><i class="ion-checkmark"> </i>Unlimited File uploads/download</li>
    
    </ul>
    <div class="plan-select"><a href="premium.php?plan=1">Select Plan</a></div>
  </div>
  <div class="plan featured">
    <h3 class="plan-title">
      Professional
    </h3>
    <div class="plan-cost"><span class="plan-price">$49</span>
    <!-- <span class="plan-type">/ Monthly</span> -->
    </div>
    <ul class="plan-features">
    <li><i class="ion-checkmark"> </i>90 days validity</li>
    <li><i class="ion-checkmark"> </i>2 GB</li>
      <li><i class="ion-checkmark"> </i>Files never Expires</li>
      <li><i class="ion-checkmark"> </i>Unlimited File uploads/download</li>
    
    </ul>
    <div class="plan-select"><a href="premium.php?plan=2">Select Plan</a></div>
  </div>
  <div class="plan">
    <h3 class="plan-title">
      Ultra
    </h3>
    <div class="plan-cost"><span class="plan-price">$159</span>
    <!-- <span class="plan-type">/ Monthly</span> -->
    </div>
    <ul class="plan-features">
    <li><i class="ion-checkmark"> </i>1 Year validity</li>
    <li><i class="ion-checkmark"> </i>10 GB</li>
      <li><i class="ion-checkmark"> </i>Files never Expires</li>
      <li><i class="ion-checkmark"> </i>Unlimited File uploads/download</li>
      
    </ul>
    <div class="plan-select"><a href="premium.php?plan=3">Select Plan</a></div>
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
