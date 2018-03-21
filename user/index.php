<?php 
require_once("../db.php");
$title = "User Login | FileCloud - Secured file sharing with cloud storage";
require_once("../header.php");

include("../functions.php");

if (!empty($_POST)) {
  $pass = md5($_POST["pass"]);
  if (checklogin($_POST["email"],$pass)==1) {
    session_start();
    $email = $_POST["email"];
    echo $_SESSION["email"] = strtolower("$email");
    redirect("dashboard.php");
    
  }
  else {
    $error = "<div class='alert alert-danger'>Login error, please check the login details</div>";
  }
}
if (isset($_SESSION["userid"]) && $_SESSION["usertype"]=="user") {
  redirect("dashboard.php");
}
?>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php
              if(isset($error)) {
                echo $error;
              }
        ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" type="password" name="pass" placeholder="Password">
          </div>
          <!-- <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div> -->
          <input type="submit" class="btn btn-primary" value="Login"/>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <!-- <a class="d-block small" href="forgot-password.php">Forgot Password?</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>

