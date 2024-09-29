<?php 
    session_start();
    require('datacon.php');
     
    //ลบ user จาก admin
    if(isset($_GET["Uid"])){
        $Uid=$_GET["Uid"];
        $sql_user = "DELETE FROM user WHERE U_id = $Uid";
        $result_user = mysqli_query($conn,$sql_user);
        if($result_user){
               header("location:backend_userDb.php");
                exit(0);
        }else{
            echo "error";
        } 
    }
    // ลบกิจกรรมจากทั้ง 2 สถานะ 1.ลบจาก user เอง 2.ลบโดย admin
    if(isset($_GET["Aid"])){
        // ลบจากหน้า admin
        if($_GET["state"]=="admin"){
            $Aid=$_GET["Aid"];
            $sql_activity = "DELETE FROM activity WHERE A_id = $Aid";
            $result_activity = mysqli_query($conn,$sql_activity);
            if($result_activity){
                header("location:backend_activityDb.php");
                exit(0);
            }else{
                echo "error";
            }
        }
        //ลบจากหน้า index & history
        if($_GET["state"]=="user"){
            $Aid=$_GET["Aid"];
            $sql_activity = "DELETE FROM activity WHERE A_id = $Aid";
            $result_activity = mysqli_query($conn,$sql_activity);
            if($result_activity){
                if($_GET["page"]=="history"){
                    header("location:history.php");
                }else{
                    header("location:index.php");
                }
            }else{
                echo "error";
            }
        }
        
    }
    // ลบ Category โดย User
    if(isset($_GET["categoryName"])){
        $Cid = $_GET["categoryName"];
        $page = $_GET["page"];
        $Uid = $_SESSION["Uid"];
    
        //เช็คชื่อ category ที่เป็น default หา C_id ค่าเริ่มต้น มาเก็บไว้
        $sql_check_category_name = " SELECT * FROM category WHERE C_name = 'ไม่มีหมวดหมู่' AND U_id = '$Uid' ";
        $result_check_category_name = mysqli_query($conn,$sql_check_category_name);
        //เก็บ C_id ค่าเริ่มต้น
        $row = mysqli_fetch_assoc($result_check_category_name);
        $Cid_default = $row["C_id"];
        
        //ถ้าต้องการลบ category ให้ย้าย category ไปที่ค่า default ก่อนในตาราง activity
         $sql_update = " UPDATE activity SET C_id = '$Cid_default' WHERE U_id = '$Uid' AND C_id = '$Cid';";
         $result_update = mysqli_query($conn,$sql_update);
    
         echo "Uid : ".$Uid."<br>";
         echo "Cid_old : ".$Cid."<br>";
         echo "Cid_default : ".$Cid_default."<br>";
     
        //เมื่อเปลี่ยนหมวดหมู่ให้อัตโนมัติเสร็จเเล้วให้ทำการ Delete ได้จากตาราง category
        $sql_delete_category = "DELETE FROM category WHERE C_id = '$Cid' ";
        $result_delete_category = mysqli_query($conn,$sql_delete_category); 
        header("location:editprofile.php");
    }
