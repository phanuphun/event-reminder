<?php
    session_start();
    require('datacon.php');
    $Aname = $_GET["Aname"];

    $sql = "SELECT activity.* ,user.* , category.* FROM activity 
    INNER JOIN user ON user.U_id = activity.U_id 
    INNER JOIN category ON category.C_id = activity.C_id 
    WHERE activity.A_name LIKE '%$Aname%' ORDER BY activity.A_Date_Create DESC" ;


    
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $order = 1 ;
    
    if(isset($_GET['logout'])){
        session_destroy();
        header("location:index.php");
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลกิจกรรม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/navbar_v.css">

    <style>
    *{
        margin: 0 ;
        padding: 0 ;
    }
    body{
        background-image: url('img/wallpaper3.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;    }
    </style>
</head>
<body>
    
     <ul>
        <li><p class="h4"><a href="index.php"><i class="bi bi-house-door"></i> หน้าแรก</a></p></li>
        <li><p class="h4"><a href="backend_userDb.php"><i class="bi bi-person"></i> ข้อมูลผู้ใช้งาน</a></p></li>
        <li><p class="h4"><a href="backend_activityDb.php"><i class="bi bi-card-checklist"></i> กิจกรรมทั้งหมด</a></p></li>
        <li><p class="h4"><a href="index.php?logout='1'"><i class="bi bi-door-open"></i> ออกจากระบบ</a></p></li>
    </ul>   
    
     
    <!-- header -->
    <br>
    <div class="container" style="float: right; max-width:85%;">
        <div class="alert alert-primary" role="alert">
            <h2 class="text-center"><i class="bi bi-calendar-check"></i>  ข้อมูลกิจกรรม</h2>
        </div>
    </div>

    <!-- ค้นหา -->
    <div class="container" style="float: right; max-width:85%;">
        <form action="backend_activityDb_Search.php" method="GET">
            <div class="input-group mb-1">
                <input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้งาน" name="Aname">
                <button class="btn btn-primary"  name="search_Btn"> <i class="bi bi-search"></i> ค้นหา</button>
            </div>
        </form>
    </div>

    <!-- table -->
    <div class="container" style="float: right; max-width:85%;">
        <table border="3" class="table table-dark table-striped table-hover ">
            <thead class="table-light">
                <tr>
                    <th>ลำดับ</th>
                    <th>ผู้ใช้งาน</th>
                    <th>ชื่อกิจกรรม</th>
                    <!-- <th>รายละเอียด</th> -->
                    <!-- <th>หมวดหมู่</th> -->
                    <th>สถานะ</th>
                    <th>การแจ้งเตือน</th>
                    <th>เวลาที่แจ้งล่วงหน้า</th>
                    <th>ระยะเวลาที่กำหนด</th>
                    <th>ลบ</th>
                </tr>   
            </thead>
            <tbody class="table-light" style="">
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $order++?></td>
                    <td><?php echo $row["Username"]?></td>
                    <td><?php echo $row["A_name"]?></td>
                    <!-- <td><?php echo $row["A_detail"]?></td> -->
                    <!-- <td><?php echo $row["C_name"]?></td> -->
                    <td><?php echo $row["A_state"]?></td>
                    <td><?php echo $row["A_Notification_state"]?></td>
                    <td><?php if($row["A_Date_Bf_End"]=="0000-00-00 00:00:00"){
                                echo "ไม่มีการเเจ้งล่วงหน้า";
                              }else if($row["A_Date_Bf_End"]!="0000-00-00 00:00:00"){
                                echo $row["A_Date_Bf_End"];
                              } ?></td>
                    <td><?php echo $row["A_Date_End"]?></td>
                    <td>
                        <a href="Delete_Db.php?state=admin&Aid=<?php echo $row["A_id"]?>"  class="btn btn-danger"
                        onclick="return confirm('ต้องการลบใช่หรือไม่');"><i class="bi bi-trash"> </i>ลบ</a>
                    </td>
                </tr>   
            <?php } ?>
            </tbody>
            
        </table>
    </div> 

    
    
</body>
</html>