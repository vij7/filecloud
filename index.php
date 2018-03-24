<?php 
require("db.php");
session_start();
$sql = "SELECT * FROM expiry";
$expiry = $conn->query($sql);
$title = "FileCloud - Secured file sharing with cloud storage";
require_once("header.php");
$sql = "SELECT * FROM files ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $lastfile = $row["id"];
    }
    $_SESSION['newfile'] = $lastfile+1;
}
else if($result->num_rows == 0) {
$lastfile = 0;
$_SESSION['newfile'] = $lastfile+1;
}
function lastrow(){
  require("db.php");
  $sql = "SELECT * FROM files ORDER BY id DESC LIMIT 1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      $lastrow = $row["id"];
      }

  }
  return $lastrow;
}
?>
<body class="bg-green">
  <div class="container">
    <?php
      include("nav.php");
    ?>
    <!-- Uploader Dropzone -->
    <script>
    
</script>
    <form action="upload.php" class="fileuploader center-align" id="zdrop" name="zdrop">
      <div id="upload-label" style="width: 200px;">
        <i class="fa fa-cloud-download"></i>
      </div><span class="tittle">Click the Button or Drop Files below</span>
      <div class="complete">
        <i class="fa fa-check"></i> <span class="done">Got it!</span>
      </div>
    </form><!-- Preview collection of uploaded documents -->
    <div class="preview-container">
      <div class="collection card" id="previews">
        <div class="collection-item clearhack valign-wrapper item-template" id="zdrop-template">
          <div class="left pv zdrop-info" data-dz-thumbnail="">
        <?php
          if(isset($_GET['d']) && $_GET['d']=="drive") {
                          echo "<div class='alert alert-success'>You are now uploading files to your drive</div>";
          }
                          ?>
            <div>
              Filename: <span data-dz-name=""></span><br>
              Size: <span data-dz-size=""></span>
            </div><!-- <div class="progress">
                    <div class="determinate" style="width:0" data-dz-uploadprogress></div>
                  </div> -->
            <div class="progress">
              <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" class="progress-bar progress-bar-success progress-bar-striped active" data-dz-uploadprogress="" role="progressbar" style="width:0%"></div>
            </div>
            <div class="dz-error-message">
              <span data-dz-errormessage=""></span>
            </div>
            <div id="encrypt"></div>
            <div class="shareoption">
              <div class="row">
                <div class="col-md-6"><label class="duration">Expiry 
                <select name="duration" id="duration">
                    <?php while($row = $expiry->fetch_assoc()) {?>
                    <option value="<?php echo $row["id"];?>"><?php echo $row["valid_till"];?></option>
                    <?php }?>
                  </select>
              </label></div>
                <div class="col-md-6"><label class="radiowrap">One Time Download ? <input type="checkbox" value="1" id="one_time"> <span class="checkmark"></span></label></div>
                   <?php
                        if(isset($_GET['d']) && $_GET['d']=="drive") {
                          ?>
                          <div class="col-md-12"><label class="radiowrap">Keep this file in drive? (Never expires + No download limit) ? <input type="checkbox" name="drive" id="storage" value="drive"> <span class="checkmark"></span></label></div>
                          <!-- <input type="hidden" name="drive" id="drive" value="drive" /> -->
                    <?php      
                        }
                   ?>
              </div>
               
            </div>
          </div>
          <div class="secondary-content actions text-center">
                        

          <!-- /**************  Load buttons after encryption  ******************/ -->
          <script type="text/javascript">
            var autoLoad = setInterval(
            function ()
            {
                $('#load_post').load('loading.php');
            }, 1000); // refresh page every 1 seconds
          </script>
          <div id="load_post"></div>
          <!-- /**************  Load buttons after encryption  ******************/ -->
          
         

          </div>
        </div>
      </div>
    </div>
  </div><!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js">
  </script> 
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js">
  </script> <!-- Core plugin JavaScript-->
   
  <script src="vendor/jquery-easing/jquery.easing.min.js">
  </script> 
  <script src='js/dropzone.js'>
  </script> 
  <script src="js/index.js">
  </script>
</body>
</html>