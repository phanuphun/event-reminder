<?php
    session_start();
    require('datacon.php');

        if($_GET["categoryS"]=="ทั้งหมด"){
            header("location:index.php");
        }
        $Uid = $_SESSION["Uid"];
        $Cid = $_GET["categoryS"];
        $sql = "SELECT activity.* ,user.* , category.* FROM activity 
                INNER JOIN user ON user.U_id = activity.U_id 
                INNER JOIN category ON category.C_id = activity.C_id
                WHERE activity.U_id = '$Uid' AND activity.A_state = 'กำลังดำเนินการ' AND activity.C_id = $Cid ORDER BY A_id DESC";

        $result = mysqli_query($conn,$sql);
        $order = 1 ;

    //เมื่อรับค่าจาก logout = 1 มาจะทำลาย SESSION ที่ส่งมา
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION["username"]);
        header("location:index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/navbar.css">

<style>
    *{
        margin: 0 ;
        padding: 0 ;
    }
    body{
        background-image: url('img/wallpaper3.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

</style>
<body>
    <!-- navbar top -->
    <ul class="top">
        <li><a class="left" href="index.php">EventReminders</a></li>
            <?php if(isset($_SESSION["username"])) { ?>
                  <li><a href="add_activity.php" class="left" ><i class="bi bi-clipboard-plus"></i> เพิ่มกิจกรรม</a> </li>
            <?php } ?> 

        
        <!-- หากยังไม่มีการ login จะแสเง menu สมัคร ล็อคอิน -->
        <?php if(!isset($_SESSION["username"])){ ?>
                <li>
                    <a class="login" href="register.php" ><i class="bi bi-person-plus"></i> สมัคร</a>
                    <a class="login" href="login.php" ><i class="bi bi-box-arrow-in-right"> </i> </i>เข้าสู่ระบบ</a>
                </li>
        <?php }?>
        
        <!-- หากมีการ login จะแสดง menu และเเสดง SESSION username ที่ส่งมาจากหน้า login -->
        <?php if(isset($_SESSION["username"])) { ?>
                <!-- หากกด logout จะส่งค่า logout = 1 ไปที่หน้า index(หน้านี้) เพื่อออกจากระบบ -->
                <li><a href="index.php?logout" class="login" ><i class="bi bi-door-open"> </i>ออกจากระบบ</a> </li>
                <!-- ถ้า Login มาในสถานะ Admin -->
                <?php if(($_SESSION["state"]) == "admin"){ ?>
                        <li><a href="backend_userDb.php" class="login"><i class="bi bi-bar-chart"></i> ระบบหลังบ้าน </a></li>    
                <?php } ?>
                <li><a href="history.php" class="login" ><i class="bi bi-card-checklist"> </i>ประวัติกิจกรรม</a> </li>
                <li><a href="editprofile.php?Uid=<?php echo $_SESSION["Uid"]; ?>" class="login" ><i class="bi bi-pencil-square"> </i>ข้อมูล</a> </li>
                <li><a href="javascript:void(0)" class="login"><i class="bi bi-person"> </i><?php echo $_SESSION["username"]; ?></a></li>                     
        <?php } ?> 
    </ul>

   
    <!-- Content -->
        <?php if(isset($_SESSION["username"])){ 
            $sql_cetagory = "SELECT * FROM category WHERE U_id = '$Uid' ";
            $result_cetagory = mysqli_query($conn,$sql_cetagory);
            $count = mysqli_num_rows($result_cetagory); ?>
            <br>
            <div class="container" style="max-width: 20%;">
                <form action="index_search.php" method="GET">
                    <div class="input-group mb-1">
                        <select name="categoryS" class="form-select" id="">
                            <!-- ให้แสดงสถานะ ทั้งหมดถ้าหมวดหมู่เป็นค่าเริ่มต้น -->
                            <?php while($row = mysqli_fetch_assoc($result_cetagory)) { 
                                if($row["C_name"]=="ไม่มีหมวดหมู่"){?>
                                    <option value="ทั้งหมด">ทั้งหมด</option>
                                <?php }else {?>
                                    <option value="<?php echo $row["C_id"]?>"><?php echo $row["C_name"]?></option>
                            <?php }}?> 
                        </select>
                        <button class="btn"  name="search_Btn" style="background-color: #9bf6ff; "> <b><i class="bi bi-search"></i> ค้นหา</b></button>
                    </div>
                </form>
            </div>
        <?php }?>


        <!-- table -->
        <table class="table table-dark table-striped table-hover ">
            <tbody class="table-light">
                <tr>
                    <div class="container" style="max-width: 90%;">
                        <div class="my-5 "> <!-- จัด margin -->
                            <div class="row row-cols-1 row-cols-md-5 g-5"> <!-- จัดกรแถว คอลัมน์ -->
                                <?php if(isset($_SESSION["Uid"])){ while($row = mysqli_fetch_assoc($result)){ ?>
                                    <div class="col">
                                        <div class="card text-black " style="width: 20rem; ">
                                            <!-- ส่วนหัว -->
                                            <div class="card-header " style="background-color: #48cae4; color:black;  text-align: center;">
                                                <!-- ตัดข้อความที่ส่วน Header -->
                                                <h5 class="card-title "><b><?php if(mb_strlen($row["A_name"]) > 20){
                                                                                $Aname = mb_substr($row["A_name"],0,20)."...";
                                                                                echo $Aname;
                                                                                }else{
                                                                                echo $row["A_name"];
                                                                                }?></b>
                                                </h5>
                                             </div>

                                            <!--ส่วน body -->
                                            <div class="card-body" style="background-color: #feeafa; ">
                                                <b>หมวดหมู่ : <?php echo $row["C_name"]; ?></b>
                                                <!-- ตัด Detail -->
                                                <p class="card-text"><?php if(mb_strlen($row["A_detail"]) > 100){
                                                                            $Adetail = mb_substr($row["A_detail"],0,100)."...";
                                                                            echo $Adetail;
                                                                            }else if($row["A_detail"]==""){
                                                                            echo"ไม่มีรายละเอียด<br><br><br>";
                                                                            }else if(strlen($row["A_detail"]) < 100){
                                                                            echo $row["A_detail"]."<br>"."<br>"."<br>";}?>
                                                </p>
                                                <b>วันที่สร้าง : <?php echo $row["A_Date_Create"]; ?></b><br>
                                                <b>วันที่กำหนด : <?php echo $row["A_Date_End"]; ?></b>
                                                    
                                                <!-- ปุ่มจัดการ -->
                                                <div class="container text-center" >
                                                    <br><a href="update_a_state.php?state=เสร็จสิ้น&Aid=<?php  echo $row["A_id"] ?>" class="btn btn-success "
                                                    onclick="return confirm('ต้องการยืนยันว่ากิจกรรมนี้เสร็จสิ้นเเล้วใช่หรือไม่');"><i class="bi bi-check-square"></i></i></a>
                                                    <a href="update_a_state.php?state=ยกเลิก&Aid=<?php echo $row["A_id"] ?>" class="btn btn-dark "
                                                    onclick="return confirm('ต้องการยืนยันว่ากิจกรรมนี้ถูกยกเลิกเเล้วใช่หรือไม่');"><i class="bi bi-x-square"></i></a>
                                                    <a href="edit_activity.php?Aid=<?php echo $row["A_id"]?>" class="btn btn-primary "><i class="bi bi-pencil-square"></i></a> 
                                                    <a href="Delete_Db.php?state=user&Aid=<?php echo $row["A_id"]?> " 
                                                    onclick="return confirm('ต้องการลบใช่หรือไม่');" class="btn btn-danger "><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } } ?>
                                        
                            </div>
                        </div> 
                    </div>
                </tr>
            </tbody>
        </table>    
        
                    
</body>
</html>