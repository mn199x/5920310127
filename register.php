<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register Customer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  
</head>


<?php

session_start();
  include "dbconnect.php";
  include "menu.php";

    // date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    // $sql = "SELECT count(*) as np FROM cust WHERE cusid LIKE '%".date("Y")."%'";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $n = $row['np']; 
    // $custno = "CID".date("Y").($n+1);
    // $conn->close();
?>  

<body>
<div class="container">
<div class="row">
 
      <div class="col-sm-4" ></div>
    <!-- <div class="form-group">
        <label for="user">ID:</label>
        <input type="text" class="form-control" name="id" value='<?php echo $custno; ?>'>
    </div> -->
    <div class="col-sm-4" > 
      <h2>ลงทะเบียนลูกค้า</h2>
      <form action="operation.php" method="post">
    
      <div class="form-group">
          <label for="user">ชื่อ:</label>
          <input type="text" class="form-control" placeholder="กรุณากรอก" name="nme" required> <!-- "required" means this field is required -->
      </div>
      <div class="form-group">
          <label for="user">นามสกุล:</label>
          <input type="text" class="form-control" placeholder="กรุณากรอก" name="snme" required> <!-- "required" means this field is required -->
      </div>
      <div class="form-group">
          <label for="user">เพศ:</label>
          <input type="radio" name="sex" value="male" checked> ชาย
          <input type="radio" name="sex" value="female"> หญิง<br>
      </div>
      <div class="form-group">
          <label for="user">เบอร์โทรศัพท์:</label>
          <input type="number" class="form-control" placeholder="กรุณากรอก" name="tel" required> <!-- "required" means this field is required -->
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" placeholder="กรุณากรอก" name="email" required> <!-- "required" means this field is required -->
      </div>
      <div class="form-group">
        <label for="pwd">รหัสผ่าน:</label>
        <input type="password" class="form-control" placeholder="กรุณากรอก" name="pwd" required>
      </div>
      <div class="form-group">
        <label for="pwd">ยืนยันรหัสผ่าน:</label>
        <input type="password" class="form-control" placeholder="กรุณากรอก" name="conpwd" required>
      </div>
      <input type="submit" name="register" class="btn btn-primary" value="ยืนยัน">
    </form>
    </div>
    
  <div class="col-sm-4" ></div>
</div>

</body>
</html>