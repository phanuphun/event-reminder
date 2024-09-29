<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <!-- login form -->
        <div class="header">
            <h2><i class="bi bi-box-arrow-in-right"> </i>เข้าสู่ระบบ</h2>
        </div>
        
        <form action="logindb.php" method="post">
                <!-- แสดงข้อความแจ้งเตือนจาก SESSION error  -->
                <?php if(isset($_SESSION["error"])) {?>
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION["error"]; ?>
                            <?php  unset($_SESSION["error"]);?> <!-- ลบข้อความหลัง reflesh brownser -->
                        </div>
                    </div>
                <?php }?>

                <label for="">Username</label>
                <input type="text" name="username" class="form-control" required minlength="5"><br>
                <label for="">Password</label>
                <input type="password" name="password"  class="form-control" required minlength="5"><br>

                <a href="register.php" class="link-primary">ยังไม่มีบัญชี</a><br><br>
                <button type="submit" value="login" class="btn btn-success" name="login_btn"><i class="bi bi-box-arrow-in-right" > </i>Login</button>
                <a href="index.php" class="btn btn-primary"><i class="bi bi-house-door"> </i> Home</a><br><br>
        </form>

</body>
</html>