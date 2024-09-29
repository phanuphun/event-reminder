<?php
    session_start();
    require('datacon.php');
    $Uid = $_SESSION["Uid"]; //รับ Uid 

    $sql = "SELECT * FROM user WHERE U_id = $Uid"; // ใช้ U_id ในการอ้างอิงจาก user 
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);

    //ไม่ให้แสดงหมวดหมู่ "ไม่มีหมวดหมู่เพื่อ" ไม่ให้สามารถลบค่านี้ได้เนื่องจากตั้งเป็น Default
    $sql_cetagory = "SELECT * FROM category WHERE U_id = '$Uid' AND C_name NOT IN ('ไม่มีหมวดหมู่') ";
    $result_cetagory = mysqli_query($conn,$sql_cetagory);
    //สำหรับเช็คจำนวนหมวดหมู่ทั้งหมดของเเต่ละ user
    $sql_cetagory_check = "SELECT * FROM category WHERE U_id = '$Uid' ";
    $result_cetagory_check = mysqli_query($conn,$sql_cetagory_check);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/FormEdit.css" class="">
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
    <!-- Form -->
        <div class="header">
            <h2> <i class="bi bi-person"> </i>แก้ไขข้อมูล</h2>
        </div>
        <form action="updateProfileDb.php" method="POST">
            
        <?php if(isset($_SESSION["error_category"])) {?>
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION["error_category"]; ?>
                            <?php  unset($_SESSION["error_category"]);?> <!-- ลบข้อความหลัง reflesh brownser -->
                        </div>
                    </div>
            <?php }?>   

        <input type="hidden" class="form-control" value="<?php echo $row["U_id"];?>" name="Uid">
            <!-- <label for="">Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $row["Password"]; ?>" required ><br> -->
            
            <label for="">Prefix</label>
            <select class="form-control" name="prefix" id="" >
                <!-- ให้แสดงค่าที่เคยสมัครไว้โดยใช้ if  -->
                <?php   if($row["U_prefix"] == "นาย"){
                            echo "<option value='นาย' selected='นาย'>นาย</option>" ;
                            echo "<option value='นาง'>นาง</option>" ;
                            echo "<option value='นางสาว'>นางสาว</option>" ;
                        }else if ($row["U_prefix"] == "นาง"){
                            echo "<option value='นาย'>นาย</option>" ;
                            echo "<option value='นาง' selected='นาง'>นาง</option>" ;
                            echo "<option value='นางสาว'>นางสาว</option>" ;
                        }else {
                            echo "<option value='นาย'>นาย</option>" ;
                            echo "<option value='นาง'>นาง</option>" ;
                            echo "<option value='นางสาว' selected='นางสาว'>นางสาว</option>" ;
                        }
                ?>
            </select><br>
            <label for="">First Name</label>
            <input type="text" name="fname" class="form-control" value="<?php echo $row["U_fname"]; ?>" required><br>
            <label for="">Last Name</label>
            <input type="text" name="lname" class="form-control" value="<?php echo $row["U_lname"]; ?>" required><br>
            <label for="">Email</label>
            <input type="Email" name="email" class="form-control" value="<?php echo $row["U_email"]; ?>" required><br>
            
            <!-- จัดการหมวดหมู่ -->
            <div class="row">
                            <div class="col"><label for="">เลือกหมวดหมู่</label></div>
                            <div class="col"><label for="">เพิ่มหมวดหมู่</label></div>
            </div>

            <!-- ใช้ if check จากฐานข้อมูลว่าจำนวน Category > 1 แสดงว่าเราสามารถเลือกที่จะจัดการ Category ได้ -->
            <?php if(mysqli_num_rows($result_cetagory_check) > 1) { ?>
                    <!-- การเพิ่มหมวดหมู่ กรณีมีหมวดหมู่มากกว่าค่า default-->
                    
                    <div class="row">
                        <div class="col">
                        <!-- ดึงข้อมูลจาก databases มาทีละตัวเเล้ว loop  -->
                            <div class="input-group mb-3">
                                <select name="activitycategory" id="CnameDelete" class="form-control" id="ex2" required>
                                    <!-- <option value="1">ไม่มีหมวดหมู่</option> -->
                                    <?php while($row = mysqli_fetch_assoc($result_cetagory)) { ?>
                                                <option value="<?php echo $row["C_id"]?>"><?php echo $row["C_name"]?></option>
                                    <?php }?> 
                                </select>
                                <a onclick="this.href='Delete_Db.php?categoryName='+document.getElementById('CnameDelete').value" class="btn btn-danger"> ลบ</a>
                            </div>
                        </div>
                        <!-- เพิ่มหมวดหมู่ -->
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" id="Cname"class="form-control" name="categoryName" placeholder="เพิ่มหมวดหมู่ใหม่" >
                                <!-- ใช้ js เพื่อมารับค่าหมวดหมู่ที่กรอกจาก text เเล้วส่งผ่าน tag a โดยส่งเป็น GET ไป -->
                                <a onclick="this.href='add_categoryDb.php?page=editprofile&state=2&categoryName='+document.getElementById('Cname').value" class="btn btn-primary"> เพิ่ม</a>
                            </div>
                        </div>
                    </div>
            <!-- ในกรณีที่ Category = 1 หมายความว่ามีเเค่ค่า Default ที่ตั้งไว้ -->
            <?php }else if(mysqli_num_rows($result_cetagory_check) == 1) {?>
                    <!-- การเพิ่มหมวดหมู่ -->
                    <div class="row">
                        <div class="col">
                            <!-- ดึงข้อมูลจาก databases มาทีละตัวเเล้ว loop  -->
                            <div class="input-group mb-3">
                                <!-- ให้ disabled ไว้เพื่อไม่ให้แก้ไขค่า default ได้ -->
                                <select name="activitycategory" id="CnameDelete" class="form-control" id="ex2" required disabled>
                                </select>
                                <a onclick="this.href='Delete_Db.php?categoryName='+document.getElementById('CnameDelete').value" class="btn btn-danger" disabled> ลบ</a>
                            </div>
                        </div>
                        <!-- เพิ่มหมวดหมู่ -->
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" id="Cname"class="form-control" name="categoryName" placeholder="เพิ่มหมวดหมู่ใหม่" >
                                <!-- ใช้ js เพื่อมารับค่าหมวดหมู่ที่กรอกจาก text เเล้วส่งผ่าน tag a โดยส่งเป็น GET ไป -->
                                <a onclick="this.href='add_categoryDb.php?page=editprofile&categoryName='+document.getElementById('Cname').value" class="btn btn-primary"> เพิ่ม</a>
                            </div>
                        </div>
                    </div>
            <?php }?>
            <!-- Button -->
            <button type="submit" value="Register" class="btn btn-success" name="update_btn_profile"><i class="bi bi-save"> </i>บันทึก</button>
            <a href="index.php" class="btn btn-danger"><i class="bi bi-x-circle"></i>  ยกเลิก</a><br><br>
        </form>


</body>
</html>