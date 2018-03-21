<?php 
require_once("../db.php");
$title = "Card Payment | FileCloud - Secured file sharing with cloud storage";
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

?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
 <?php  require_once("side-nav.php"); ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
      <div class="col-md-4">

    <div class="card card-login mx-auto">
      <div class="card-header">Enter your debit/credit card details </div>
      <div class="card-body">
        <form action="../functions.php" method="post">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="exampleInputEmail1">Name on card</label>
                <input class="form-control" type="text" name="cardname" required>
            </div>
            <div class="col-md-12">Add card details<br/><br/></div>
            <div class="col-md-3 form-group">
                <input class="form-control" type="text" name="card1" maxlength="4" required>
            </div>
            <div class="col-md-3 form-group">
              <input class="form-control" type="text" name="card2" maxlength="4" required>
            </div>
            <div class="col-md-3 form-group">
             <input class="form-control" type="text" name="card3" maxlength="4" required>
            </div>
            <div class="col-md-3 form-group">
              <input class="form-control" type="text" name="card4" maxlength="4" required>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="exampleInputEmail1">Expiry</label>
                  <input class="form-control" type="text" name="cardtill" maxlength="5" placeholder="06/25" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="exampleInputEmail1">CVV</label>
                    <input class="form-control" type="text" name="cardcvv" maxlength="3" required>
                </div>
              </div>
            </div>
        </div>
        <input name="cash"  type="hidden" maxlength="3" value="<?php echo $_GET['amount']; ?>"/>
          <div class="form-group">
           <input type="submit" class="btn btn-success" name="addmoney" style="width:100%" value="Pay with Card"/>
          </div>
        
        </form>
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
