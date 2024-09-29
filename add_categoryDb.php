<?php 

    session_start();
    require('datacon.php');
    $Uid = $_SESSION["Uid"];
    $category_name = $_GET["categoryName"]; 

    if($_GET["page"] == "editprofile" or $_GET["page"] =="edit_activity"){
        $Aid = $_GET["Aid"];
    }
    
    //เช็คชื่อซ้ำ
    $sql_check_category = "SELECT * FROM Category WHERE U_id = '$Uid' AND C_name = '$category_name'  " ;
    $result_check_category = mysqli_query($conn,$sql_check_category);


    if(mysqli_num_rows($result_check_category)==1){
        $_SESSION["error_category"] = "มีชื่อหมวดหมู่นี้เเล้ว";
        // echo "ซ้ำ";
        if($_GET["page"]=="add_activity"){
         header("location:add_activity.php");
        }else if($_GET["page"]=="editprofile"){
         header("location:editprofile.php");
        }else if($_GET["page"]=="edit_activity"){
         header("location:edit_activity.php?Aid=$Aid");
        }
    
    }else if($category_name == "" or $category_name == " "){
        $_SESSION["error_category"] = "กรุณาป้อนชื่อหมวดหมู่ให้ถูกต้อง";
        if($_GET["page"]=="add_activity"){
            header("location:add_activity.php");
        }else if($_GET["page"]=="editprofile"){
            header("location:editprofile.php");
        }else if($_GET["page"]=="edit_activity"){
            header("location:edit_activity.php?Aid=$Aid");
        }

    }else if(mysqli_num_rows($result_check_category)!=1){
        //เพิ่มหมวดหมู่
        $sql = "INSERT INTO category(C_name,U_id) VALUE('$category_name','$Uid')";
        $result = mysqli_query($conn,$sql);
        
        // echo "ไม่ซ้ำ";
        if($_GET["page"]=="add_activity"){
         header("location:add_activity.php");
        }else if($_GET["page"]=="editprofile"){
         header("location:editprofile.php");
        }else if($_GET["page"]=="edit_activity"){
         header("location:edit_activity.php?Aid=$Aid");
        }
    }
    
?>