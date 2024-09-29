<?php 
    session_start();
    require('datacon.php');

    $Aid = $_SESSION["Aid"]; //รับ session aid มาอ้างอิง
    $Cid = $_POST["activitycategory"];
    $Aname = $_POST["activityname"];
    $Adetail = $_POST["activitydetail"];
    $Astate = $_POST["Astate"];
    $A_Date_End = $_POST["date_End"];

    //ประเภท วัน , ชม. ที่ส่งมา
    $DayType = $_POST["DayType"];
    $Day = $_POST["Day"];

    
    //อัพเดทวันที่กำหนดใหม่ก่อนเเล้วค่อยไปคำนวณหาวันเเจ้งล่วงหน้า
    $sql = "UPDATE activity SET A_name = '$Aname' , A_detail = '$Adetail' , A_state = '$Astate' , C_id = '$Cid' , A_Date_End = '$A_Date_End' WHERE A_id = '$Aid'";
    $result = mysqli_query($conn,$sql);

    //update วันเวลเเจ้งล่วงหน้า ใช้ วัน หรือ ชม ในการคำนวณ
    if($_POST["DayType"]=="วัน"){
        $sql_Bf_End = "UPDATE activity
                       SET A_Date_Bf_End = DATE_ADD(A_Date_End, INTERVAL -$Day day)
                       WHERE A_id = '$Aid'";
        $result_Bf_End = mysqli_query($conn,$sql_Bf_End);
        header("location:index.php");
    }else if($_POST["DayType"]=="ชั่วโมง"){
        $sql_Bf_End = "UPDATE activity
                       SET A_Date_Bf_End = DATE_ADD(A_Date_End, INTERVAL -$Day hour)
                       WHERE A_id = '$Aid'";
        $result_Bf_End = mysqli_query($conn,$sql_Bf_End);
        echo "hour" ;
        header("location:index.php");
   }
?>