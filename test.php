<?php 
require('connection.php');
    session_start();
    $sql = "SELECT*FROM trades";
    $result = mysqli_query($conn,$sql);
    $ghi = "SELECT * FROM company ";
    $refet = mysqli_query($conn,$ghi);
    $company = mysqli_fetch_array($refet);
    $hio = $company['money'];
   $error=  $_SESSION["er"];
   echo $error;
    if (!$_SESSION['userid']) {

        header("Location: index.php");
        
    } else {
       

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
    <style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: ;
   font-size: 20px ;
   color: white;
   text-align: center;
}
</style>
</head>
    
<body>
        
            <br><br>
           <h1 style="text-align: center;">ตารางจ่ายเงินเดือนพนักงาน<?php echo "(ยอดเหลือ: ".$hio." บาท)"?></h1>
           
           
           <br><br>
           <div class= "container">
           <Table class ="table"> 
               <tr>
                   <td>id</td>
                   <td>ชื่อ</td>
                   <td>สกุล</td>
                   <td>ตำแหน่ง</td>
                   <td>เบอร์</td>
                   <td>เลขบัญชี</td>
                   <td>เงินเดือน</td>
                   <td>สถานะ</td>
                   <td>จ่ายเงินเดือน</td>
                   
                  </tr>
<?php while($show=mysqli_fetch_array($result)){?>
               <tr>
                   <td><?php echo $show["id"]?></td>
                   <td><?php echo $show["firstname"]?></td>
                   <td><?php echo $show["lastname"]?></td>
                   <td><?php echo $show["status"]?></td>
                   <td><?php echo $show["tell"]?></td>
                   <td><?php echo $show["bank"]?></td>
                   <td><?php echo $show["price"]?></td>
                   <td><?php echo $show["moneystatus"]?></td>

                   <td><a href="price.php?id=<?php echo $show["id"]?>">จ่ายเงินเดือน</a></td>
                  
               </tr>
<?php }?>
           </Table>
           </div>
           <div  style="text-align: center;"><a href="price.php?resetstate=1" class="btn btn-primary">reset</a></div>
           <div class="footer">
  <p><a href="logout.php"  class="btn btn-danger">Logout</a></p>
</div>
      
</body>
</html>


<?php } ?>