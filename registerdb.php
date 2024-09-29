<?php 
    session_start();
    require('datacon.php');
    $error = 0; // เก็บค่า error

    // ถ้ามีการกดปุ่ม Register จะเข้า if
    if(isset($_POST["register_btn"])){
        // นำข้อมูลจาก input type ที่ส่งจาก form เก็บในตัวแปร
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $email = $_POST["email"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $prefix = $_POST["prefix"];
        $state = "user"; // กำหนดสถานะ user ให้เป็นค่าเริ่มต้น

        //เช็ค username ในฐานข้อมูลที่ซ้ำ
        $sql_check_username ="SELECT * FROM user WHERE username = '$username'";
        $result_check_username = mysqli_query($conn,$sql_check_username);
        //เช็ค email ในฐานข้อมูลที่ซ้ำ
        $sql_check_email ="SELECT * FROM user WHERE U_email = '$email'";
        $result_check_email = mysqli_query($conn,$sql_check_email);


        // เช็ค username email ว่าอันไหนซ้ำและ password ไม่ตรงกัน ให้ส่ง $_SESSION error_register ไป 
        if(mysqli_num_rows($result_check_email) == 1 and mysqli_num_rows($result_check_username) == 1){
            $_SESSION["error_regis"] = "User และ Email นี้มีผู้ใช้ในระบบเเล้ว";
            header("location:register.php");
        } 
        else if(mysqli_num_rows($result_check_username) == 1){
            $_SESSION["error_regis"] = "username นี้มีผู้ใช้ในระบบเเล้ว";
            header("location:register.php");
        }else if(mysqli_num_rows($result_check_email) == 1){
            $_SESSION["error_regis"] = "Email นี้มีผู้ใช้ในระบบเเล้ว";
            header("location:register.php");
        }else if($password != $password2){
            $_SESSION["error_regis"] = "Password ทั้ง2ช่องไม่ตรงกันกรุณากรอกให้ตรงกัน";
            header("location:register.php");
        }
        else{ // หากไม่มีอะไรผิดพลาดให้บันทึกข้อมูลลงฐานข้อมูล
            $sql = "INSERT INTO user(Username,Password,U_prefix,U_fname,U_lname,U_email,U_state) VALUE('$username','$password','$prefix','$fname','$lname','$email','$state')";
            $result = mysqli_query($conn,$sql);
            //หลังจากสมัครเสร็จเเล้วให้สร้าง category สำหรับ user เเต่ละคนมา 1 อันเป็นค่าเริ่มต้น
            $sql_check_username_id ="SELECT * FROM user WHERE username = '$username'";
            $result_check_username_id = mysqli_query($conn,$sql_check_username_id);
            $row = mysqli_fetch_assoc($result_check_username_id);
            $Uid = $row["U_id"];
            $Cname_Default = "ไม่มีหมวดหมู่";
            
            $sql_insert_category_default = "INSERT INTO category(U_id,C_name) VALUE('$Uid','$Cname_Default')";
            $result_insert_category_default = mysqli_query($conn,$sql_insert_category_default);
            
            header("location:login.php");
        }
    }
    
?>