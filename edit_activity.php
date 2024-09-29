<?php 
    session_start();
    require('datacon.php');

        $Aid = $_GET["Aid"];
        $_SESSION["Aid"] = $Aid;
        $sql_activity = "SELECT * FROM activity WHERE A_id = '$Aid' ";
        $result_activity = mysqli_query($conn,$sql_activity);
        $row_activity = mysqli_fetch_assoc($result_activity);
        $Uid = $_SESSION["Uid"];

        $sql_cetagory_check = "SELECT * FROM category WHERE U_id = '$Uid' ";
        $result_cetagory_check = mysqli_query($conn,$sql_cetagory_check);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มกิจกรรม</title>
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
</head>
<body>
    
        <div class="header">
            <h2><i class="bi bi-clipboard"></i> แก้ไขกิจกรรม</h2>
        </div>
    
        <form action="update_activityDb.php?" method="post">
            <!-- แสดงข้อความแจ้งเตือนจาก SESSION error  -->
            <?php if(isset($_SESSION["error_add_activity"])) {?>
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION["error_add_activity"]; ?>
                            <?php  unset($_SESSION["error_add_activity"]);?> <!-- ลบข้อความหลัง reflesh brownser -->
                        </div>
                    </div>
            <?php }?>     
            <?php if(isset($_SESSION["error_category"])) {?>
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION["error_category"]; ?>
                            <?php  unset($_SESSION["error_category"]);?> <!-- ลบข้อความหลัง reflesh brownser -->
                        </div>
                    </div>
            <?php }?>      

                <label for="">ชื่อกิจกรรม</label>
                <input type="text" name="activityname" class="form-control" value="<?php echo $row_activity["A_name"]?>"required ><br>
                <label for="">รายละเอียด</label>
                <textarea name="activitydetail" class="form-control" rows="4" id="Adetail"></textarea><br>
                <script>
                    document.getElementById("Adetail").value = "<?php echo $row_activity["A_detail"]?>";
                </script>
                <!-- การเพิ่มหมวดหมู่ -->
                <div class="row">
                        <div class="col">
                            <label for="">เลือกหมวดหมู่</label>
                        </div>
                        <div class="col">
                            <label for="">เพิ่มหมวดหมู่</label>
                        </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- ดึงข้อมูลจาก databases มาทีละตัวเเล้ว loop  -->
                            <select name="activitycategory" id="mySelect" class="form-control" id="ex2" required>
                            <!-- <option value="1">ไม่มีหมวดหมู่</option> -->
                                <?php while($row = mysqli_fetch_assoc($result_cetagory_check)) { ?>
                                    <?php if($row["C_name"]=="ไม่มีหมวดหมู่"){ ?>
                                            <option value="<?php echo $row["C_id"]?>">ค่าเริ่มต้น</option>
                                    <?php }else { ?>
                                            <option value="<?php echo $row["C_id"]?>"><?php echo $row["C_name"]?></option>
                                <?php }}?> 
                            </select>
                    </div>
                     <!-- เพิ่มหมวดหมู่ -->
                     <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" id="Cname"class="form-control" name="categoryName" placeholder="" >
                            <a onclick="this.href='add_categoryDb.php?page=edit_activity&Aid=<?php echo $Aid;?>&categoryName='+document.getElementById('Cname').value" class="btn btn-primary"> เพิ่ม</a>
                        </div>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="date_Create" id="dt" >
                <!-- set ค่าเริ่มต้นของ date create คือเวลาปัจจุบัน js -->
                <script>
                    var now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    document.getElementById('dt').value = now.toISOString().slice(0,16);
                </script> 

                

                <!-- แจ้งงล่วงหน้า -->
                <div class="row">
                        <div class="col">
                            <label for="">กำหนดการ</label>
                        </div>
                        <div class="col">
                            <label for="">แจ้งล่วงหน้า</label></div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-lg-6" >  
                        <!-- แปลง datetime ลงใน datetime-local -->
                        <input type="datetime-local" class="form-control" name="date_End" value="<?php  echo date('Y-m-d\TH:i', strtotime($row_activity["A_Date_End"]))   ?>">
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="Day" placeholder="ป้อนเวลา" >
                            <select name="DayType" id="" class="btn btn-outline-secondary">
                                <option value="วัน">วัน</option>
                                <option value="ชั่วโมง">ชั่วโมง</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- กำหนดสถานะ -->
                <div class="row">
                    <label for=""> สถานะ</label>
                </div>
                <div class="container">
                    <div class="row">
                        <select name="Astate" id="" class="form-control">
                            <option value="กำลังดำเนินการ" >กำลังดำเนินการ</option>
                            <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                            <option value="ยกเลิก">ยกเลิก</option>
                        </select>
                    </div>
                </div>
                


                <br>
                <button type="submit" value="login" class="btn btn-success" name=""><i class="bi bi-save"></i> บันทึก</button>
                <a href="index.php" class="btn btn-danger"><i class="bi bi-x-circle"></i> ยกเลิก</a><br><br>
                    
                   

        </form>
        
                       
</body>
</html>