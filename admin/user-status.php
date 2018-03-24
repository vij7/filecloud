<?php 
include("../db.php");
if(isset($_GET["b"]) && isset($_GET["u"]))
{
    $userid = $_GET["u"];
    $block = $_GET["b"];
    $update = "UPDATE users SET blocked='$block' WHERE `user_id`='$userid'";
    $rslt = $conn->query($update);
    if($conn->query($update)) {
        header("location:/filecloud/admin/users.php?b=success");  
    }
    else {
        header("location:/filecloud/admin/users.php?b=error");  
    }

}?>