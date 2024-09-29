<?php
session_start();
require('datacon.php');

// ถ้ามีการกดปุ่ม login 
if (isset($_POST["login_btn"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // เตรียม code sql สำหรรับการเช็ค username password 
    $sql = "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);

    //ถ้า == 1 แสดงว่ามี username password นี้
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result); //ดึงข้อมูลจากตาราง user
        // เก็บ session ไว้เวลาไปหน้าอื่น
        $_SESSION["username"] = $username;
        $_SESSION["state"] = $row["U_state"]; //นำข้อมูลจากตาราง user column U_state หรือสถานะ user มาเก็บใน SESSION
        $_SESSION["Uid"] = $row["U_id"];

        if ($_SESSION["state"] == "admin") { //ถ้า SESSION = admin ให้ไปหลังบ้าน
            header("location:index.php");
        } else if ($_SESSION["state"] == "user") { //ถ้า SESSION = user ให้ไปหน้าหลัก
            header("location:index.php");
        }
    } else { // หาก username หรือ password ไม่มีในฐานข้อมูลให้แสเงข้อความเเจ้ง error โดยส่งไปที่ Form login
        $_SESSION["error"] = "Username หรือ password ไม่ถูกต้อง";
        header("location:login.php");
    }
}
