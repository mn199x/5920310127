<!DOCTYPE html>
<html lang="en">
<head>
  <title>Booking</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
  <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 80%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
</head>


<?php

session_start();
include "dbconnect.php";
include "menu.php";

    require_once("checkpermission.php");
    //add menu on the top of this insert form
    

    // //the aim of this part is to generate HNO automatically, 
    // //using year and number of person registered in that year
    date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    
    $sql = "SELECT count(*) as bk FROM book WHERE bkid LIKE '%".date("Y")."%'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $b = $row['bk']; 
    $bno = "BK".date("Y").(1000+$b+1);
    $conn->close();
?> 

<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  
  <div class="col-sm-4" >
  
  <h2>แบบฟอร์มทำการจอง</h2>
  
  
  <form action="operation.php" method="post">
    <div class="form-group">  
      <label for="user">รหัสการจอง: </label>
      <input type="text" name="bid" class="form-control" value='<?php echo $bno; ?>' disabled>
      <input type="hidden" name="bid" class="form-control" value='<?php echo $bno; ?>'>
    </div>

    <div class="form-group">
      <label for="user">วันที่เดินทาง: </label>
      <input type="date" name="bdte" class="form-control" min='<?php echo date('Y-m-d'); ?>'>
    </div>
    
    <div class="form-group">
      <label for="user">ช่วงเวลาที่ต้องการจอง:</label>
      <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM timeslot ORDER BY slotid";
        $result = $conn->query($sql);
        echo "<select class='form-control' name='slotid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['slotid'].">".$row['frm_to']."  ".$row['t_start']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
    </div>
    
    <div class="form-group">
      <label for="user">จำนวนที่นั่ง: </label>
      <input type="number" name="num" class="form-control" placeholder="ระบุจำนวน" required>
    </div>    
    <h2>ข้อมูลติดต่อ</h2>
    <div class="form-group">  
      <label for="user">รหัสลูกค้า: </label>
      <input type="text" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>' disabled>
      <input type="hidden" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>'>
    </div>

    <div class="form-group">
      <label for="user">ชื่อผู้ติดต่อ: </label>
      <input type="text" name="nme" class="form-control" value='<?php echo $_SESSION['valid_fnme']; ?>' required>
    </div>

    <div class="form-group">
      <label for="user">เบอร์โทรที่สาสารถติดต่อได้: </label>
      <input type="number" name="tel" class="form-control" value='<?php echo $_SESSION['valid_tel']; ?>' required>
    </div>

    <div class="form-group">
      <label for="user">ชื่อสถานที่: </label>
      <input type="text" name="place" class="form-control" placeholder="กรุณากรอก" required>
      
    </div>

    <div class="form-group">
      <label for="user">Link (ตำแหน่งบนแผนที่): </label>
      <input title="คลิก เปิดแผนที่ แล้วคัดลอก link ตำแหน่งมาใส่" type="url" name="lnk" class="form-control" placeholder="กรุณากรอก URL" required>
      <a href="https://maps.google.co.th" target="_blank"> เปิดแผนที่</a>
    </div>
  
    
    <center><input type="submit" class="btn btn-primary" name="book" value="จอง"></center>
    <!-- <button class="btn btn-primary" onclick="getLocation()">Try It</button> -->
  </form>



  <div class="col-sm-4" ></div>
  
</div>
</body>
