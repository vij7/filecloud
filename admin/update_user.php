<?php 
include("../db.php");
if(isset($_POST["edituser"]))
{
    $userid = $_POST["userid"];
    $email = $_POST["editemail"];
    $plan = $_POST["plan"];
    $quota = $_POST["quota"];
    $update = "UPDATE users SET premium='$plan', quota='$quota' WHERE `user_id`='$userid'";
    $rslt = $conn->query($update);
    if($conn->query($update)) {
        header("location:/filecloud/admin/users.php?m=success");  
    }
    else {
        header("location:/filecloud/admin/users.php?m=error");  
    }

}?>