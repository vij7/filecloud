<?php 
require_once("../db.php");
$title = "My Drive| FileCloud - Secured file sharing with cloud storage";
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
        <li class="breadcrumb-item active">My Drive</li>
      </ol>
      <!-- Icon Cards-->
    
    
      <!-- Area Chart Example-->
      
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Your Files</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTsable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Sl.</th>
                  <th>FileName</th>
                  <th>File Size</th>
                  <th>Date</th>
                  <th>Share URL</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Sl.</th>
                  <th>FileName</th>
                  <th>File Size</th>
                  <th>Date</th>
                  <th>Share URL</th>
                </tr>
              </tfoot>
              <tbody>
                <?php 
                  $userid = $_SESSION["userid"];
                  $sql = "SELECT * FROM files where uploader='$userid' AND drive='1' ORDER BY `files`.`uploadtime` DESC";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                          $sl = 1;
                          while($row = $result->fetch_assoc()) {
                            
                            ?>
                            <tr>
                              <td><?php echo $sl; ?></td>
                              <td><?php echo $row["name"]; ?></td>
                              <td><?php echo $row["filesize"]; ?></td>
                              <td><?php echo date('h:ia, d F Y',strtotime($row["uploadtime"])); ?></td> 
                              <td><?php echo "<a class='btn btn-warning' href='/filecloud/d/?id=".$row["filename"]."'>Download</a> "; ?></td>
                            </tr>
                        <?php
                        $sl = $sl+1;
                          }
                  }

                ?>
                
                
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Updated <?php echo date('h:ia, d F Y'); ?></div>
      </div>
      
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
