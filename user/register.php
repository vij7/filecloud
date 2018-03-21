<?php 
require_once("../db.php");
$title = "SignUp | FileCloud - Secured file sharing with cloud storage";
require_once("../header.php");
include("../functions.php");
if (!empty($_POST)) {
  $email = $_POST["email"];
  $sql = "SELECT * FROM users where email='$email'";
  $result = $conn->query($sql); 
  $count = $result->num_rows;
  if($count>=1) {
    $error = "<div class='alert alert-danger'>Signup error, email already exists.</div>";
  }
  elseif($_POST["password"]!= $_POST["confirm"]) {
    $error = "<div class='alert alert-danger'>Password mismatch, please try again.</div>";
  }
  else {
    $pass = md5($_POST["password"]);
    if (!$conn->query("INSERT INTO users(`email`,`username`,`password`,`premium`,`quota`,`usertype`) VALUES('".$_POST["email"]."','".$_POST["firstname"]." ".$_POST["lastname"]."','".$pass."','"."0"."','"."1024"."','"."user"."')")) {
      $error = "<div class='alert alert-danger'>Something went wrong<br/>".mysqli_error($conn)."</div>";
    }
    else {
      $_SESSION["email"] = strtolower("$email");
    redirect("dashboard.php?m=success");
    }

  } 
}

if (isset($_SESSION["userid"]) && $_SESSION["usertype"]=="user") {
  redirect("dashboard.php");
}


?>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php
              if(isset($error)) {
                echo $error;
              }
        ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">First name</label>
                <input class="form-control" id="exampleInputName" name="firstname" type="text" aria-describedby="nameHelp" placeholder="Enter first name">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Last name</label>
                <input class="form-control" id="exampleInputLastName" name="lastname" type="text" aria-describedby="nameHelp" placeholder="Enter last name">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputPassword1">Password</label>
                <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password">
              </div>
              <div class="col-md-6">
                <label for="exampleConfirmPassword">Confirm password</label>
                <input class="form-control" id="exampleConfirmPassword" name="confirm" type="password" placeholder="Confirm password">
              </div>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" value="Register Now"/>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="index.php">Already registered? Login here.</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
