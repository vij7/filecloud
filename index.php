<?php 
require_once("db.php");
$sql = "SELECT * FROM expiry";
$expiry = $conn->query($sql);
$title = "FileCloud - Secured file sharing with cloud storage";
require_once("header.php");

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
          
           <?php 
            if(isset($_GET['d']) && $_GET['d']=="drive") {
              ?>
            <a class="btn-floating ph red white-text waves-effect waves-light"  onclick="view_drive()"><button class="btn btn-success"><i class="fa fa-link"></i> View Drive</button></a> 

            <a class="btn-floating ph red white-text waves-effect waves-light" data-dz-remove="" href="#!"><button class="btn btn-warning"><i class="fa fa-times-circle"></i> Cancel Upload</button></a>
            <?php 
            }
            else {
?>
              <a class="btn-floating ph red white-text waves-effect waves-light"  onclick="insert_exp()"  class="normal"><button class="btn btn-success"><i class="fa fa-link"></i> Get File Link</button></a> 

<a class="btn-floating ph red white-text waves-effect waves-light" data-dz-remove="" href="#!"><button class="btn btn-warning"><i class="fa fa-times-circle"></i> Cancel Upload</button></a>

<?php
            }
            ?>

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