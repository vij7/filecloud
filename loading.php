<?php
session_start();
if ($_SESSION['newfile'] != $_SESSION['lastId']) {
?>

<a class="btn-floating ph red white-text waves-effect waves-light"  href="#"  class="normal"><button class="btn btn-warning"><i class="fa fa-refresh fa-spin" style="font-size:18px"></i> <strong>Encryption in progress. Please wait.</strong></button></a> <br/>



<!-- <a class="btn-floating ph red white-text waves-effect waves-light" data-dz-remove="" href="#!"><button class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel Upload</button></a>        -->

<?php
}
else if ($_SESSION['newfile'] == $_SESSION['lastId']){
if(isset($_SESSION["email"])) {
       
       ?>
               <a class="btn-floating ph red white-text waves-effect waves-light"  onclick="view_drive()"><button class="btn btn-success"><i class="fa fa-link"></i> View Drive</button></a> 
               <a class="btn-floating ph red white-text waves-effect waves-light" data-dz-remove="" href=""><button class="btn btn-warning"><i class="fa fa-times-circle"></i> Cancel Upload</button></a>
       <?php 
       }
           else {
       ?>
               <a class="btn-floating ph red white-text waves-effect waves-light"  onclick="insert_exp()"  class="normal"><button class="btn btn-success"><i class="fa fa-link"></i> Get File Link</button></a> 
               <a class="btn-floating ph red white-text waves-effect waves-light" data-dz-remove="" href=""><button class="btn btn-warning"><i class="fa fa-times-circle"></i> Cancel Upload</button></a>
       
       <?php
           }    
}

?>