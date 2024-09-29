<?php
// $con=mysqli_init(); [mysqli_ssl_set($con, NULL, NULL, {ca-cert filename}, NULL, NULL);] 
// mysqli_real_connect($con, {eventreminders.database.windows.net}, {parnuphun5555}, {parnuphun@1598}, {EventReminders}, {1433});
// $host = 'eventreminders.mysql.database.azure.com';
// $username = 'parnuphun5555';
// $password = 'parnuphun@1598';
// $db_name = 'EventReminders';

// //Initializes MySQLi
// $conn = mysqli_init();

// // Establish the connection
// mysqli_real_connect($conn, $host, $username, $password, $db_name, 1433, NULL, MYSQLI_CLIENT_SSL);

//If connection failed, show the error
// if (mysqli_connect_errno())
// {
//     die(' (ﾉ≧∇≦)ﾉ !! ไม่สามารถเชื่อมต่อฐานข้อมูลได้ !! ヽ(´▽｀)ノ'.mysqli_connect_error());
// }
     //$conn = mysqli_connect("eventreminders.mysql.database.azure.com","parnuphun5555","parnuphun@1598","EventReminders") 
     $conn = mysqli_connect("localhost","root","","eventreminders") 
          or die(" (ﾉ≧∇≦)ﾉ  ไม่สามารถเชื่อมต่อฐานข้อมูลได้ !! ヽ(´▽｀)ノ");
?>
