<?php

require_once("db.php");
$title = "Upload Complete! Share your file now!";
require_once("header.php");
session_start();
?>
  <body class="bg-green">
    <div class="container">
    <?php
      include("nav.php");
    ?>
      <div class="share-container">
        <h2>Upload Complete!</h2>
        <div class="row">
          <div class="col-md-6">
          <h3 class="greencol">Share your file</h3>
          <br/>
          <input type="text" value="<?php echo "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['file']; ?>" id="myInput">
          <button onclick="myFunction()">
            <i class="fa fa-copy"></i> Click to Copy</button>
<?php 
                $filename= $_GET['file'];
                $sql = "SELECT * FROM files where filename='$filename'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $expiry = $row["expire"];
                        $upload_time = $row["uploadtime"];
                        $once = $row["once"];
                    }
                }
                $expiry_time =  array("+5 minutes","+10 minutes","+1 hour","+1 day","+30 day","+1 minutes");
                $expires_on = date('d M Y h:i:sa',strtotime($expiry_time[$expiry],strtotime($upload_time)));
                echo "<br/><br/><h6>Valid Till: $expires_on</h6>";
                $time_now = date('Y-m-d H:i:s');
                $start = strtotime($time_now);
                $end   = strtotime($expires_on);
                $diff  = $end - $start;
                $temp = $diff/86400;
                $days=floor($temp);  $temp=24*($temp-$days); 
                // hours 
                $hours=floor($temp);  $temp=60*($temp-$hours); 
                // minutes 
                $minutes=floor($temp);  $temp=60*($temp-$minutes); 
                // seconds 
                $seconds=floor($temp); 
                $sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['file'];
                include('qr/qrlib.php');
                $qrimage= "qrcodes/".$_GET['file'].".png";
                // outputs image directly into browser, as PNG stream
                QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
?> 
                
          <?php 
                  if ($once==1) {
                    echo "<div class='alert alert-warning'> This file is set <strong>Download Once</strong>. So it will be deleted from cloud after first download.</div>";
                  }
          ?>
          </div>
          <div class="col-md-6">
            <h5 class="greencol">Scan QR Code to view/share URL</h5>
            <img src="<?php echo $qrimage; ?>
            " />
          </div>
        </div>
<?php 
        if ($days <0) {
          echo "File Expired";
        }
        elseif ($days>0 )  {
          echo "<div class='alert alert-success'>This files expires in  {$days} days  {$hours} hour {$minutes} minutes {$seconds} seconds<br/></div>\n";
        }
        elseif ($days==0 && $hours>0)  {
          echo "This files expires in  {$hours} hour {$minutes} minutes {$seconds} seconds<br/>\n"; 
        }
        elseif ($days==0 && $hours==0 && $minutes>0)  {
          echo "This files expires in  {$minutes} minutes {$seconds} seconds<br/>\n"; 
        }
        elseif ($days==0 && $hours==0 && $minutes==0 && $seconds>0)  {
          echo "This files expires in  {$seconds} seconds<br/>\n"; 
        }
        else {
          echo "File Expired";
        }
?>
      </div>
    </div>
    <script src="vendor/jquery/jquery.min.js">
    </script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <script src="vendor/jquery-easing/jquery.easing.min.js">
    </script>
    <script src='js/dropzone.js'>
    </script>
    <script src="js/index.js">
    </script>
  </body>

  </html>
  