<?php 
require_once("../db.php");
$title = "Edit User | FileCloud - Secured file sharing with cloud storage";
require_once("../header.php");
require_once("../functions.php");
if (empty('$_SESSION["email"]')) {
  redirect("/filecloud/user/");
}

if ($_SESSION["usertype"]!="admin") {
  redirect("/filecloud/admin/");
  session_destroy();
  redirect("/filecloud");
}
$name =  $_SESSION["name"];
$name = strtok($name, " ");

if (isset($_GET['id'])) {
    $user = $_GET['id'];
    $sql = "SELECT * FROM users where user_id='$user'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
           $editname = $row["username"];
           $editemail = $row["email"];
           $editpremium = $row["premium"];
           $editquota = $row["quota"];
           $edittype = $row["usertype"];
        }
    }
  }




?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
 <?php  require_once("side-nav.php"); ?>
  <div class="content-wrapper">
    <div class="container-fluid">
    
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
      
      <!-- Area Chart Example-->
      
      <!-- Example DataTables Card-->
      <div class="card card-login mx-auto mt-5">
      <div class="card-header">Edit user( <?php echo $editname; ?>) </div>
      <div class="card-body">
        <form action="update_user.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">User id</label>
            <input class="form-control" name="userid" value ="<?php echo $user; ?>" type="text" readonly>
          </div>
          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" name="editemail" value ="<?php //echo $editemail; ?>" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div> -->
          <div class="form-group">
            <label for="exampleInputEmail1">Edit Plan</label>
            <select class="form-control" name="plan" id="plan">
                    <?php 
                    $plan_id = $_GET['plan'];
                    if(isset($_GET['plan'])) {
                      $sql = "SELECT * FROM plans WHERE plan_id='$plan_id'";
                    }
                    else {
                      $sql = "SELECT * FROM plans";
                    }
                    $plans = $conn->query($sql);
                    $i=0;
                    while($row = $plans->fetch_assoc()) { 
                        $amount = $row["plan_amount"]; 
                        if($i==0){
                            $basic_amt = $amount;
                        }   
                    ?>
                    <option value="<?php echo $row['plan_id'];?>"   ><?php echo $row["plan_name"]." - $".$row["plan_amount"];?></option>
                    <?php 
                    
                    $i++;}
                    ?>
                  </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Edit Quota</label>
            <select class="form-control" name="quota" >
            <option value="500">500 MB</option>
            <option value="2048">2 GB</option>
            <option value="10240">10 GB</option>
            </select>
        </div>
          <!-- <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div> -->
          <input type="submit" name="edituser" class="btn btn-primary" value="Edit User"/>
        </form>
      </div>
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
