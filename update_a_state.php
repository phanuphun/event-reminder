<?php 
    // อัพเดตสถานะจากหน้า index หรือ history
    require('datacon.php');
    $state = $_GET["state"]; // รับค่าสถานะมาจากปุ่ม ถูก , กากบาท
    $Aid = $_GET["Aid"]; // เอา Aid มาอ้างอิงกิจกรรมที่จะอัพเดท

    $sql_check = "SELECT * FROM activity WHERE A_id = '$Aid'";
    $result_check = mysqli_query($conn,$sql_check);
    $row = mysqli_fetch_assoc($result_check);

    //กรณีที่สถานะเเจ้งเตือน = ยังไม่เเจ้ง ให้สถานะเปลี่ยนเป็นยกเลิกเนื่องจากไม่ได้ต้องการการเเจ้งเตือนเเล้ว
    if($row["A_Notification_state"]=="ยังไม่เเจ้ง"){
        $sql = "UPDATE activity SET A_state = '$state' , A_Notification_state = 'ยกเลิก' WHERE A_id = '$Aid'";
        $result = mysqli_query($conn,$sql);
    }//กรณีเเจ้งล่วงหน้าเเล้ว หรือ เเจ้งครบเเล้วให้คงค่าสถานะนั้นไว้
    else if($row["A_Notification_state"]=="เเจ้งล่วงหน้าเเล้ว" or $row["A_Notification_state"]=="แจ้งครบเเล้ว"){
        $sql = "UPDATE activity SET A_state = '$state' WHERE A_id = '$Aid'";
        $result = mysqli_query($conn,$sql);
    }

    //รับค่า GET ที่ชื่อว่า page มาเพื่อส่งกลับไปยังหน้สเดิม
    if($_GET["page"]=="history"){
        header("location:history.php");
    }else if($_GET["page"]=="history_search"){
        header("location:history_search.php");
    }else if($result){
        header("location:index.php");
    }else{
        echo "someting wrong !";
    }
?>