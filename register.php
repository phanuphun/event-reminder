<?php
    session_start(); // ประกาศเพื่อรับ $_SESSION error_regis มา
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <h2><i class="bi bi-person-plus"></i> สมัครสมาชิก</h2>
    </div>
    
    <form action="registerdb.php" method="POST">
        <!-- แสดงข้อความแจ้งเตือนจาก $_SESSION error_regis -->
        <?php if(isset($_SESSION["error_regis"])) {?>
            <div class="container">
                <div class="alert alert-danger" role="alert">
                     <?php echo $_SESSION["error_regis"]; ?>
                     <?php  unset($_SESSION["error_regis"]);?> <!-- ลบข้อความหลัง reflesh brownser -->
                </div>
            </div>
        <?php }?>
 
        <label for="">Username</label>
        <input type="text" name="username" class="form-control"  minlength="5" required  ><br>
        <label for="">Password</label>
        <input type="password" name="password" class="form-control"  required minlength="5" ><br>
        <label for="">Confirm Password</label>
        <input type="password" name="password2" class="form-control" required ><br>
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" required  ><br>
        <label for="">Prefix</label>
        <select class="form-control" name="prefix" >
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
        </select><br>
        <label for="">First Name</label>
        <input type="text" name="fname" class="form-control"  required minlength="1" ><br>
        <label for="">Last Name</label>
        <input type="text" name="lname" class="form-control" required minlength="1" ><br>  
        
        <a href="login.php">มีบัญชีเเล้ว</a><br><br>
        <button type="submit" value="Register" name="register_btn"class="btn btn-success"><i class="bi bi-plus-circle"> </i>Register</button>
        <button type="reset" value="Reset" class="btn btn-danger"><i class="bi bi-x-circle"> </i>Clear</button>
        <a href="index.php" class="btn btn-primary"><i class="bi bi-house-door"> </i> Home</a><br><br>
    </form>
</body>
</html>