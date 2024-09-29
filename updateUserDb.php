<?php
    // จากหลังบ้านมา *adminไม่ได้แก้ไขเเล้ว
    require('datacon.php');

    $id = $_POST["Uid"]; // ใช้ Uid ในการอ้างอิงจาก input type
    $username = $_POST["username"];
    $password = $_POST["password"];
    $prefix = $_POST["prefix"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];

    $sql = "UPDATE user SET U_prefix = '$prefix' , U_fname ='$fname' , U_lname = '$lname' , U_email = '$email' WHERE U_id = $id "; 
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("location:backend_userDb.php");
        exit(0);
    }else{
        echo "error";
    }
?>