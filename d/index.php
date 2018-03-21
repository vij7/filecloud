<?php

require_once("../db.php");
require_once("../functions.php");
$title = "Download your file now!";
require_once("../header.php");

$filename= $_GET['id'];
    $sql = "SELECT * FROM files where filename='$filename'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $type = $row["filetype"];
            $path = $row["filepath"];
            $expiry = $row["expire"];
            $once = $row["once"];
            $size = $row["filesize"];
			$upload_time = $row["uploadtime"];
			$drive = $row["uploadtime"];
		}
		
	}
	else {
?>
		<body class="bg-green">
    		<div class="container">
			<?php
			include("../nav.php");
			?>
        		<div class="share-container">   
<?php
		echo "<h1 class='greencol'>We're Sorry!</h1><h6> This link has been expired and files deleted from cloud</h6><h1> <img src='../css/delete.gif' /> </h1>";
		exit;

	}
    // Decrypt file 
    include "../aes.php";
    $dir = "../";
	$encrypted_file = $dir.$path.'.enc';
	

	$passphrase = "thisismypassphrase12345678900987";
    $iv = substr(md5('thisismyiv123456'.$passphrase, true), 0, 16);
    $key = md5($passphrase, true);
    $decrypted_file= "file/".$name; 
    $crypt = new aes_encryption($key, $iv);
	$crypt->decrypt_file($encrypted_file, $decrypted_file);
	// $decrypted_file = " ";
	// }
    
?>

<body class="bg-green">
    <div class="container">
	<?php
			include("../nav.php");
			?>
        <div class="share-container">    

<?php    
    /* Set Expiry and show message */
    $url = "http://localhost/filecloud/d/".$decrypted_file;
    include('../qr/qrlib.php');
    $qrimage= "../qrcodes/".$_GET['id'].".png";
	$filename= $_GET['id'];
	$sql = "SELECT * FROM files where filename='$filename'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$expiry = $row["expire"];
			$upload_time = $row["uploadtime"];
			$drive = $row["drive"];
		}
	}
	/* testing tie function */
	$expiry_time =  array("+5 minutes","+10 minutes","+1 hour","+1 day","+30 day", "+1 minutes");
	//display the converted time
	$expires_on = date('Y-m-d H:i:s',strtotime($expiry_time[$expiry],strtotime($upload_time)));
	/* Testing time functin */
	$expired_time = date('h:ia, d F Y',strtotime($expiry_time[$expiry],strtotime($upload_time)));
	
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

	$downloads = downloads($_GET['id']);

	if ($drive=="1" && $seconds>0) { ?>

                            
        <div class="row">
			<div class="col-md-6">
				<h2>Download File</h2>
				<h5 class="greencol"><?php echo $name; ?></h5>
				<h5>Size: <?php echo $size; ?></h5><br>
				
				<a href="../functions.php?d_file=<?php echo $name."&u=".$_GET['id'];?>"><button class="btn btn-lg btn-success" style="width:100%"><i class="fa fa-copy"></i> Download File</button></a><br/><br/>
				
			</div>
			<div class="col-md-6">
				
				<?php 
				$sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['id'];
				
				// outputs image directly into browser, as PNG stream
				QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
				///hdljshljkdlkj
				?>
				<h4>Scan this QR Code</h4><img src="<?php echo $qrimage; ?>"> <h4>to download from mobile</h4>
			</div>
		</div> 
		<br/>
		
<?php
	exit;
	}
	
	elseif ($days<=-1 || $days<0) {
		echo "<h1 class='greencol'>We're Sorry!</h1><h6> This link has been expired and files deleted from cloud on $expired_time</h6><h1> <img src='../css/delete.gif' /> </h1>";
		if (file_exists($encrypted_file)) {
		unlink("$encrypted_file");
		unlink("$decrypted_file");
		unlink("$qrimage");
		}
	}
	elseif ($once==1 && $downloads>=1) {
		echo "<h1 class='greencol'>We're Sorry!</h1><h5 style='font-weight:normal'> This file can be downloaded only once.</h5> <h6>All the Files are deleted from cloud after the first download on $expired_time</h6><h1> <img src='../css/delete.gif' /> </h1>";
		if (file_exists($encrypted_file)) {
			unlink("$encrypted_file");
			unlink("$decrypted_file");
			unlink("$qrimage");
			}
	}
	elseif ($days>0) { ?>

                            
        <div class="row">
			<div class="col-md-6">
				<h2>Download File</h2>
				<h5 class="greencol"><?php echo $name; ?></h5>
				<h5>Size: <?php echo $size; ?></h5><br>
				
				<a href="../functions.php?d_file=<?php echo $name."&u=".$_GET['id'];?>"><button class="btn btn-lg btn-success" style="width:100%"><i class="fa fa-copy"></i> Download File</button></a><br/><br/>
				
			</div>
			<div class="col-md-6">
				
				<?php 
				$sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['id'];
				
				// outputs image directly into browser, as PNG stream
				QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
				///hdljshljkdlkj
				?>
				<h4>Scan this QR Code</h4><img src="<?php echo $qrimage; ?>"> <h4>to download from mobile</h4>
			</div>
		</div> 
		<br/>
		<?php 
                  if ($once==1) {
                    echo "<div class='alert alert-warning'> This file is set to <strong>Download Once</strong>. So it will be deleted from cloud after first download.</div>";
                  }
          ?>
		<div class="alert alert-success">
		<?php echo "Remaining time:  {$days} days  {$hours} hour {$minutes} minutes {$seconds} seconds<br/>\n"; ?>
		</div>
		
<?php
	}
	elseif ($days==0 && $hours>0) { ?>

                            
        <div class="row">
			<div class="col-md-6">
				<h2>Download File</h2>
				<h5 class="greencol"><?php echo $name; ?></h5>
				<h5>Size: <?php echo $size; ?></h5><br>
				
				<a href="../functions.php?d_file=<?php echo $name."&u=".$_GET['id'];?>"><button class="btn btn-lg btn-success" style="width:100%"><i class="fa fa-copy"></i> Download File</button></a>
			</div>
			<div class="col-md-6">
				<?php 
				$sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['id'];
				
				// outputs image directly into browser, as PNG stream
				QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
				///hdljshljkdlkj
				?>
				<h4>Scan this QR Code to download from mobile</h4><img src="<?php echo $qrimage; ?>"> <h4>to download from mobile</h4>
			</div>
		</div> 
		<br/>
		<?php 
                  if ($once==1) {
                    echo "<div class='alert alert-warning'> This file is set to <strong>Download Once</strong>. So it will be deleted from cloud after first download.</div>";
                  }
          ?>
		<div class="alert alert-sucess">
		<?php echo "Remaining time: {$hours} hour  {$minutes} minutes {$seconds} seconds<br/>\n"; ?>
		</div>
		
<?php
	}
	elseif ($days==0 && $hours==0 && $minutes>0) { ?>

                            
        <div class="row">
			<div class="col-md-6">
				<h2>Download File</h2>
				<h5 class="greencol"><?php echo $name; ?></h5>
				<h5>Size: <?php echo $size; ?></h5><br>
				<h6>Total <?php echo downloads($_GET['id']); ?> downloads so far</h6><br/>
				<a href="../functions.php?d_file=<?php echo $name."&u=".$_GET['id'];?>"><button class="btn btn-lg btn-success"><i class="fa fa-copy"></i> Download File</button></a>
				
			</div>
			<div class="col-md-6">
				<?php 
				$sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['id'];
				
				// outputs image directly into browser, as PNG stream
				QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
				///hdljshljkdlkj
				?>
				<h4>Scan this QR Code</h4><img src="<?php echo $qrimage; ?>"> <h4>to download from mobile</h4>
			</div>
		</div> 
		<br/>
		<?php 
                  if ($once==1) {
                    echo "<div class='alert alert-warning'> This file is set to <strong>Download Once</strong>. So it will be deleted from cloud after first download.</div>";
                  }
          ?>
		<div class="alert alert-success">
		<?php echo "Remaining time:  {$minutes} minutes {$seconds} seconds<br/>\n"; ?>
		</div>
<?php
	}
	elseif ($days==0 && $hours==0 && $minutes==0 && $seconds>0)  {
		
?>
                            
		<div class="row">
			<div class="col-md-6">
				<h2>Download File</h2>
				<h5 class="greencol"><?php echo $name; ?></h5>
				<h5>Size: <?php echo $size; ?></h5><br>
				<a href="../functions.php?d_file=<?php echo $name."&u=".$_GET['id'];?>"><button class="btn btn-lg btn-success"><i class="fa fa-copy"></i> Download File</button></a>
			</div>
			<div class="col-md-6">
				<?php 
				$sharelink = "http://".$_SERVER["HTTP_HOST"]."/filecloud/d/?id=".$_GET['id'];
				
				// outputs image directly into browser, as PNG stream
				QRcode::png("$sharelink", "$qrimage", "L", 4, 4);
				///hdljshljkdlkj
				?>
				<h4>Scan this QR Code</h4><img src="<?php echo $qrimage; ?>"> <h4>to download from mobile</h4>
			</div>
		</div> 
		<br/>
		<?php 
                  if ($once==1) {
                    echo "<div class='alert alert-warning'> This file is set to <strong>Download Once</strong>. So it will be deleted from cloud after first download.</div>";
                  }
          ?>
		<div class="alert alert-success">
		<?php echo "Remaining time:  {$minutes} minutes {$seconds} seconds<br/>\n"; ?>
		</div>
<?php
	}
	elseif ($days<=0 && $hours<=0 && $minutes<=0 && $seconds<=0) {
		
	}
?>

            
        </div>
    </div><!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js">
    </script> 
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js">
    </script> <!-- Core plugin JavaScript-->
     
    <script src="../vendor/jquery-easing/jquery.easing.min.js">
    </script> 
    <script src='../js/dropzone.js'>
    </script> 
    <script src="../js/index.js">
    </script>
</body>
</html>