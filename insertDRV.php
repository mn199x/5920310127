<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register dirver</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   -->
</head>


<?php

session_start();
include "dbconnect.php";
include "menu.php";
// date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
// $sql = "SELECT count(*) as np FROM driver WHERE drvid LIKE '%".date("Y")."%'";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();
// $n = $row['np']; 
// $dno = "DR".date("Y").($n+1);
// $conn->close();
?>  

<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
      <h2>ลงทะเบียนคนขับรถ</h2>
      <form action="operation.php" method="post">
        <!-- <div class="form-group">
            <label for="user">ID:</label>
            <input type="text" class="form-control" placeholder="Enter " name="id" value='<?php echo $dno; ?>' >
        </div> -->
        
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
            <label for="user">เลขบัตรประชาชน:</label>
            <input type="number" class="form-control" placeholder="กรุณากรอก" name="idcard" required> <!-- "required" means this field is required -->
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
          <label for="user">ที่อยู่:</label>
          <input type="text" class="form-control" placeholder="กรุณากรอก" name="add" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="user">เลขใบขับขี่:</label>
          <input type="number" class="form-control" placeholder="กรุณากรอก" name="drl" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="user">วันหมดอายุใบขับขี่:</label>
          <input type="date" class="form-control" placeholder="กรุณากรอก" name="exp" required> <!-- "required" means this field is required -->
        </div>
        
        <input type="submit" name="insertDRV" class="btn btn-primary" value="ยืนยัน">
    </form>
    </div>

    <div class="col-sm-4" ></div>
</div>

</body>
</html>