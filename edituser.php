<?php
require('datacon.php');
$id = $_GET["Uid"]; //รับ Uid มาจากปุ่ม

$sql = "SELECT * FROM user WHERE U_id = $id"; // ใช้ U_id ในการอ้างอิงจาก user 
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
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
    <div class="header">
        <h2> <i class="bi bi-person"> </i>Edit User</h2>
    </div>
    <form action="updateUserDb.php" method="POST">
        <b><p class="text-center">ID USER : <?php echo $row["U_id"];?></p></b>
        <input type="hidden" class="form-control" value="<?php echo $row["U_id"];?>" name="Uid">

        <label for="">Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo $row["Username"]; ?>" required  readonly><br>
        <label for="">Email</label>
        <input type="Email" name="email" class="form-control" value="<?php echo $row["U_email"]; ?>" required  readonly><br>

        <label for="">Prefix</label>
        <select class="form-control" name="prefix" id="" disabled>
            <?php 
                if($row["U_prefix"] == "นาย"){
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
        <input type="text" name="fname" class="form-control" value="<?php echo $row["U_fname"]; ?>" required readonly><br>
        <label for="">Last Name</label>
        <input type="text" name="lname" class="form-control" value="<?php echo $row["U_lname"]; ?>" required readonly><br>

        
        
        <button type="submit" value="Register" class="btn btn-success"><i class="bi bi-save"> </i>บันทึก</button>
        <a href="javascript:history.back()" class="btn btn-danger"><i class="bi bi-x-circle"></i>  ยกเลิก</a><br><br>

    </form>
    
</body>
</html>