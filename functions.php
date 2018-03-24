<?php

	/*--------------------------*/
	//==========================//
	//////// Functions.php ///////
	//==========================//
    /*--------------------------*/
    session_start();
	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
    define('TB', 1099511627776);
    date_default_timezone_set('Asia/Kolkata');
	
	function getSize($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
function generateUrl($length = 8) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
if(isset($_GET["fn"])=="set_duration")
{
    //database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'filecloud';
    //connect with the database
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if($conn->connect_errno){
        $errpr ="Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $id = $_POST["id"];
        $time_id = $_POST["time_id"];
        $update = "UPDATE files SET expire=$time_id WHERE id=$id";
        $conn->query($sql);
    }
}
if(isset($_GET["fn"])=="get_link")
{
    $once = ($_GET["o"]=="undefined")?"0":$_GET["o"];
    $time_id = $_GET["time"];
    $id =  $_SESSION["lastId"];
    if(isset($_GET["d"]) && $_GET["d"]=="drive")  {
        $drive='1';
    }
    else {
        $drive='0';
    }
    require_once("db.php");

    $sql = "SELECT * FROM files where id='$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $url = $row["filename"];
        }
    }

    $update = "UPDATE files SET expire='$time_id',once='$once',drive='$drive' WHERE id=$id";
    $conn->query($update);
    header("location:get.php?file=".$url);
}

 if(isset($_GET["go"])=="my_drive")
{
    $once = ($_GET["o"]=="undefined")?"0":$_GET["o"];
    $time_id = $_GET["time"];
    $id =  $_SESSION["lastId"];
    if(isset($_GET["d"]) && $_GET["d"]=="drive")  {
        $drive='1';
    }
    else if(isset($_GET["d"]) && $_GET["d"]=="undefined")   {
        $drive='0';
    }
    require_once("db.php");

    $sql = "SELECT * FROM files where id='$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $url = $row["filename"];
        }
    }

    $update = "UPDATE files SET expire='$time_id',once='$once',drive='$drive' WHERE id=$id";
    $conn->query($update);
    if($drive==1) {
        header("location:user/drive.php");
    }
    else {
        header("location:user/dashboard.php");
    }
    
}


if(!empty($_GET['d_file'])){
    $downloading_file = basename($_GET['u']);
	$fileName = basename($_GET['d_file']);
	
	$filePath = 'http://localhost/filecloud/d/file/'.$fileName;
	//echo $filePath;die;
    if(!empty($fileName)){
		$file_extension = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
			//Set the Content-Type to the appropriate setting for the file
			switch( $file_extension )
				 {
					case "pdf": $ctype="application/pdf"; break;
					case "mp4": $ctype="video/mp4"; break;
					case "exe": $ctype="application/octet-stream"; break;
					case "zip": $ctype="application/zip"; break;
					case "doc": $ctype="application/msword"; break;
					case "xls": $ctype="application/vnd.ms-excel"; break;
					case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
					case "gif": $ctype="image/gif"; break;
					case "png": $ctype="image/png"; break;
					case "jpeg":
					case "jpg": $ctype="image/jpg"; break; 
					default: $ctype="application/force-download";
				}
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Type: $ctype");
		
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($filePath);
        //Insert to database after download
        include("db.php");
        $conn->query("INSERT INTO downloads(`file`,`date`) VALUES('".$downloading_file."','".date('Y-m-d H:i:s')."')");

        exit;
    }else{
        echo 'The file does not exist.';
    }
}
/* function for checking & deleting download-once files */
function downloads($url) {
    include("../db.php");
    $sql = "SELECT * FROM downloads where file='$url'";
    $result = $conn->query($sql);
    
    return $result->num_rows;

}

function userexists($email) {
    include("db.php");
    $sql = "SELECT * FROM users where email='$email'";
    $result = $conn->query($sql); 
    return $result->num_rows;
}


function walletexists() {
    include("../db.php");
    $user = $_SESSION['userid'];
    $amt = 0;
    $sql = "SELECT * FROM wallet where user='$user'";
    $result = $conn->query($sql); 
    $count = $result->num_rows;
    if ($count==0) {
        if($conn->query("INSERT INTO wallet(`user`,`amount`) VALUES('".$user."','".$amt."')")) {
            echo "Success";
        }
    }
    
    
}

function checklogin($email,$pass) {
    require("../db.php");
    $sql = "SELECT * FROM users where email='$email' AND password='$pass'";
    $result = $conn->query($sql); 
    return $result->num_rows;
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

if (isset($_GET['logout'])) {
    session_destroy();
    redirect("/filecloud");

}

function balance($user) {
    include("../db.php");
    $sql = "SELECT * FROM wallet where user='$user'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $balance = $row["amount"];

    }
    if($result->num_rows>0){
        return $balance;
    }
    else {
    return 0;}
}
function getname($user) {
    include("../db.php");
    $sql = "SELECT * FROM users where user_id='$user'";
    $result = $conn->query($sql); 
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $username = $row["username"];
        }
    }
    else {
        $username = "guest";
    }
    return $username;
}

function getguest($file) {
    include("../db.php");
    $sql = "SELECT * FROM files where id='$file'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $uploader = $row["uploader"];
    }
    return $uploader;
}


function getfilesof($user) {
    include("../db.php");
    $sql = "SELECT * FROM files where uploader='$user'";
    $result = $conn->query($sql); 
    $result->num_rows;
    return $result->num_rows;
}

function premiumplan() {
    include("../db.php");
    $user = $_SESSION['userid'];
    $sql = "SELECT * FROM users where user_id='$user'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $premium_id = $row["premium"];

    }
    if ($premium_id==0) {
        return "Free";
    }
    else {
        $sql = "SELECT * FROM plans where plan_id='$premium_id'";
        $result = $conn->query($sql); 
        while($row = $result->fetch_assoc()) {
        $premium_name = $row["plan_name"];
         }
        return $premium_name;
    }
    
    
}

function premiumexpiry() {
    include("../db.php");
    $user = $_SESSION['userid'];
    $sql = "SELECT * FROM users where user_id='$user'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $premium_expiry = $row["plan_expiry"];
        

    }
    if ($premium_expiry=="0000-00-00 00:00:00") {
        return "user upgrades to premium";
    }
    else {
        $premium_expiry = date('d F Y',strtotime($premium_expiry));
        return $premium_expiry;
    }
    
}

if(isset($_POST["payamount"]))
{
    $id =  $_SESSION["userid"];
    $amt = $_POST["payamount"];
    $plan = $_POST["forplan"];
    require_once("db.php");
    if($conn->query("INSERT INTO wallet(`user`,`amount`) VALUES('".$id."','".$amt."')")) {
        $update = "UPDATE user SET premium='$plan' WHERE `user_id`='$id'";
        $conn->query($update);
        header("location:payments.php?m=success");
    }
    
}

if(isset($_POST["cash"]))
{
    $id =  $_SESSION["userid"];
    $amt = $_POST["cash"];
    require_once("db.php");
    $sql = "SELECT * FROM wallet where user='$id'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $balance = $row["amount"];

    }
    $new_bal = $balance +  $amt;
    $update = "UPDATE wallet SET amount='$new_bal' WHERE `user`='$id'";
    $conn->query($update);
    header("location:user/wallet.php?m=success");
}

if(isset($_GET["delete_file"])) {
    require_once("db.php");
    if(isset($_GET['u'])) {
        $from="admin";
    }
    $file = $_GET['delete_file'];
    $sql = "SELECT * FROM files WHERE id='$file'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
           $path=$row['filepath'].".enc";
        $decryptedfile = "d/file/".$row['name'];
        }
    if(file_exists($path)) {
        echo "exists";
        unlink("$path");
        if(file_exists($decryptedfile)) {
            unlink("$decryptedfile");
        }   
    }
    $result = $conn->query("DELETE FROM files WHERE id='$file'");
        if($result && $from=="admin") {
            header("location:admin/dashboard.php?del=success");    
        }
        else if($result) {
            header("location:user/dashboard.php?del=success");    
        }
    }
}
if(isset($_POST["plan"]))
{
    $id =  $_SESSION["userid"];
    $plan = $_POST["plan"];
    require_once("db.php");
    $sql = "SELECT * FROM wallet where user='$id'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $balance = $row["amount"];

    }
    $sql = "SELECT * FROM plans where plan_id='$plan'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $plan_amt = $row["plan_amount"];
    }
    if($balance < $plan_amt){
        header("location:user/wallet.php?m=addfund");    
    }
    else {
    $premium_validity =  array("+21900 day","+30 day", "+90 day", "+365 day");
    $current_date = date('Y-m-d H:i:s');
	$current_plan_validity = date('Y-m-d H:i:s',strtotime($premium_validity[$plan],strtotime($current_date)));
	// $expired_time = date('h:ia, d F Y',strtotime($expiry_time[$expiry],strtotime($upload_time)));
    $update = "UPDATE users SET premium='$plan', plan_expiry='$current_plan_validity' WHERE `user_id`='$id'";
    $conn->query($update);
    $new_bal = $balance-$plan_amt;
    $update = "UPDATE wallet SET amount='$new_bal' WHERE `user`='$id'";
    $conn->query($update);
    header("location:user/wallet.php?m=success");
    }
    
}

function validitywallet ($user) {
    $sql = "SELECT * FROM wallet where user='$user'";
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
        $balance = $row["amount"];
    }
    if($balance<19) {
        $message = "<div class='alert alert-warning'>Your balance is below the minimum premium plan. PLease recharge soon.</div>";
    }
}




?>