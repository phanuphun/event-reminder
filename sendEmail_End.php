<?php
    
    session_start();
    require('datacon.php');
    // ปรับ timezone ให้เป็นของ asia 
    date_default_timezone_set('Asia/Bangkok');
    use PHPMailer\PHPMailer\PHPMailer;

    //เอาสถานะที่ยังไม่เเจ้งเตือนเเล้วหรือเเล้งล่วงหน้ามาเเล้ว มา
    $sql_check_activity = "SELECT * FROM activity WHERE A_state = 'กำลังดำเนินการ' AND(A_Notification_state = 'ยังไม่เเจ้ง' OR A_Notification_state = 'เเจ้งล่วงหน้าเเล้ว')
                            ORDER BY A_Date_End ASC";
    $result_check_activity = mysqli_query($conn,$sql_check_activity);
    $row_activity=mysqli_fetch_assoc($result_check_activity);

    if($row_chec = mysqli_num_rows($result_check_activity) >= 1){
    //ดึง user ออกมา
    $Uid = $row_activity["U_id"]; //เอา Uid จาก activity เพื่อมาดึงข้อมูล user ต่อ
    $sql_user = "SELECT * FROM user WHERE U_id = '$Uid'";
    $result_user = mysqli_query($conn,$sql_user);
    $row_user = mysqli_fetch_assoc($result_user);


    // ข้อมูลที่จะส่งไป
    $Aid = $row_activity["A_id"]; // เอามาอ้างอิงเลาอัพเดตสถานะ
    $Uemail = $row_user["U_email"]; // email ที่จะส่งไป
    $Aname = $row_activity["A_name"]; // ชื่อกิจกรรม
    $Adetail = $row_activity["A_detail"]; // รายละเอียดกิจกรรม
    if($Adetail == "" or $Adetail == " "){
        $Adetail = "ไม่มีรายละเอียดที่บันทึกไว้";
    }

    //ข้อมูลวันเวลาที่กำหนด
    $End = $row_activity["A_Date_End"];
    $now = date("Y-m-d H:i:s");

    echo "เวลาปัจจุบัน".$now."<br>";
    // echo $Bf_End."<br>";
    echo "กำหนดเวลา".$End."<br>";
    echo "Aid ".$Aid."<br>";
    // echo "uname ".$Uname."<br>";
    echo "email ".$Uemail."<br>";
    echo "aname ".$Aname."<br>";
    echo "adetail ".$Adetail."<br>";
    if($row_activity["A_Notification_state"]=="ยังไม่เเจ้ง" or $row_activity["A_Notification_state"]=="เเจ้งล่วงหน้าเเล้ว"){
        if($now >= $End){
            $name = "EventReminders";
            $email = $Uemail;
            $header = "แจ้งเตือนกิจกรรม : ".$Aname;
            $detail = $Adetail."<br>กำหนดการวันที่ : ".$End."<br>ไปที่หน้ากิจกรรมเพื่อตรวจสอบ : <a href='http://localhost/EventReminders/index.php'>EventReminders</a>";
    
            require_once "PHPMailer/PHPMailer.php";
            require_once "PHPMailer/SMTP.php";
            require_once "PHPMailer/Exception.php";
    
            $mail = new PHPMailer();
    
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "eventreminder11@gmail.com"; // email ผู้ส่ง 
            $mail->Password = "eventreminder"; // รหัส
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";
            $mail->CharSet = "utf-8";// ให้แสดงภาษาไทยได้
    
            //Email Settings
            $mail->isHTML(true);
            $mail->setFrom($email, $name);
            $mail->addAddress($email); // Send to mail
            $mail->Subject = $header;
            $mail->Body = $detail;
    
            if($mail->send()) {
                $sql_update_state = "UPDATE activity SET A_Notification_state = 'แจ้งครบเเล้ว' ,A_state = 'ครบกำหนด' WHERE A_id = '$Aid'";
                $result_update_state = mysqli_query($conn,$sql_update_state);
            } else {
                echo "something Wrong". $mail->ErrorInfo;
            }
        }
        
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification End</title>
</head>
<body>
</body>
</html>


