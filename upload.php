<?php
session_start();
$_SESSION["buffer"]= "waiting";
require_once("db.php");
require_once("functions.php");
if(!empty($_FILES)){
	
	
	$file_name = generateUrl();
	$targetDir = "upload/";
	$fileName = $_FILES['file']['name'];
	$targetFile = $targetDir.$fileName;

	include "aes.php";

	$passphrase = "thisismypassphrase12345678900987";
	$iv = substr(md5('thisismyiv123456'.$passphrase, true), 0, 16);
	$key = md5($passphrase, true);

	$crypt = new aes_encryption($key, $iv);

	// $crypt->key = $crypt->rand_key();
	// $crypt->iv = $crypt->rand_iv();

	$file = $targetFile;
	 $filesize = getSize($_FILES['file']['size']);
 	$link = generateUrl();
	//$crypt->decrypt_file($file.'.enc', $file);
	if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
		$path_parts = pathinfo($_FILES["file"]["name"]);
		$extension = $path_parts['extension'];
		$crypt->encrypt_file($file, $targetDir.$file_name.".".$extension.'.enc');
		//insert file information into db table
		if (isset($_SESSION["userid"])) {
			$uploader = $_SESSION["userid"];
		}
		else {
			$uploader = getHostByName(getHostName());
		}
		$conn->query("INSERT INTO files(`name`,`filename`,`filetype`,`filesize`,`uploadtime`,`uploader`,`filepath`) VALUES('".$fileName."','".$file_name."','".$extension."','".$filesize."','".date("Y-m-d H:i:s")."','".$uploader."','".$targetDir.$file_name.".".$extension."')");

		$last = mysqli_insert_id($conn);
		$_SESSION["lastId"] = $last;	
		$sql = "SELECT * FROM files where id='$last'";
    	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo $_SESSION["current_file"] = $targetDir.$row["name"];
				echo $_SESSION["current_enc"] = $row["filepath"].".enc";
			}
		}
		if(unlink($targetFile)) {
			$_SESSION["buffer"]= "success";	
		}
	}
	
}
?>