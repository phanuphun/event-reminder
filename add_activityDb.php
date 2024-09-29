<?php 
    session_start();
    require('datacon.php');

    $Uid = $_SESSION["Uid"];
    $Cid = $_POST["activitycategory"];
    $Aname = $_POST["activityname"];
    $Adetail = $_POST["activitydetail"];
    $Astate = "กำลังดำเนินการ";
    $NotificationState = "ยังไม่เเจ้ง";
    $A_Date_Create = $_POST["date_Create"];
    $A_Date_End = $_POST["date_End"];

    //ตัวแปรเกี่ยวกับเเจ้งเตือนล่วงหน้า
    $DayType = $_POST["DayType"];
    $Day = $_POST["Day"];

    // ?ลืมเเล้วไว้ทำอะไร . . .
    $sql_check_category = "SELECT * FROM activity WHERE U_id = '$Uid' AND C_id = '$Cid'  ";
    $result_check_category = mysqli_query($conn,$sql_check_category);

    

    if($A_Date_End < $A_Date_Create){
        $_SESSION["error_add_activity"] = "เลือกวันไม่ถูกต้อง";
        header("location:add_activity.php");
    }else if($A_Date_End >= $A_Date_Create){
        // บันทึกกิจกรรมลง activity
        $sql_insert_activity = "INSERT INTO activity(U_id,C_id,A_name,A_detail,A_state,A_Notification_state,A_Date_create,A_Date_End)
                                VALUE('$Uid','$Cid','$Aname','$Adetail','$Astate','$NotificationState','$A_Date_Create','$A_Date_End')";
        $result_insert_activity = mysqli_query($conn,$sql_insert_activity);
        
        //ดึง Aid ที่พึ่งเพิ่มออกมาเพื่ออ้างอิงในคอลัมน์ Date_Bf_End
        $sql_Aid = "SELECT * FROM activity WHERE A_name = '$Aname' AND  C_id = '$Cid' AND U_id = '$Uid' ";
        $result_Aid = mysqli_query($conn,$sql_Aid);
        $row = mysqli_fetch_assoc($result_Aid);
        $Aid = $row["A_id"];

        // หลังจากบันทึกกิจกกรรมเเล้วให้ UPDATE วันที่จะแจ้งล่วงหน้า
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
        
    }

    // echo "<br>Day : ".$Day." ".$DayType."<br>";
    // echo "Aid : ".$Aid."<br>";
    // echo "Cid : ".$Cid."<br>";
    // echo "Uid : ".$Uid."<br>";
    // echo "Aname : ".$Aname."<br>";
    // echo "Adetail : ".$Adetail."<br>";
    // echo "Astate : ".$Astate."<br>";
    // echo "N_Date_Create : ".$A_Date_Create."<br>";
    // echo "N_Date_End : ".$A_Date_End."<br>";

?>