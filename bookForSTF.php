<!DOCTYPE html>
<html lang="en">
<head>
  <title>Booking</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
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
    $n = $row['bk']; 
    $bno = "BK".date("Y").(1000+$n+1);
    $conn->close();
?> 

<p id="demo" type="hidden"></p>


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
      <input type="date" name="bdte" class="form-control" id="mydate" min='<?php echo date('Y-m-d'); ?>'>
    </div>
    
    <div class="form-group">
      <label for="user">ช่วงเวลาที่ต้องการจอง:</label>
      <!-- <select class="form-control" name="slotid"> -->
      <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM timeslot ORDER BY slotid";
        $result = $conn->query($sql);
        //echo "<option value='slotid'>โปรดเลือก";
        echo "<select class='form-control' name='slotid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['slotid'].">".$row['frm_to']."  ".$row['t_start']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
    <!-- </select> -->
    </div>
    
    <div class="form-group">
      <label for="user">จำนวนที่นั่ง: </label>
      <input type="number" name="num" class="form-control" placeholder="ระบุจำนวน" required >
    </div>    
    <div class="form-group">  
      <label for="user">รหัสพนักงานที่ทำการจอง: </label>
      <input type="text" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>' required>
    </div>
    <h2>ข้อมูลติดต่อ</h2>
    <div class="form-group">
      <label for="user">ชื่อผู้ติดต่อ: </label>
      <input type="text" name="nme" class="form-control" placeholder="กรุณากรอก" required>
    </div>

    <div class="form-group">
      <label for="user">เบอร์โทรที่สาสารถติดต่อได้: </label>
      <input type="number" name="tel" class="form-control" placeholder="กรุณากรอก" required>
    </div>

    <div class="form-group">
      <label for="user">ชื่อสถานที่: </label>
      <input type="text" name="place" class="form-control" placeholder="กรุณากรอก" required>
    </div>
    
    <center><input type="submit" class="btn btn-primary" name="bookSTF" value="จอง"></center>

  </form>


  <div class="col-sm-4" ></div>
  
</div>
</body>
