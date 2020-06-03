<!DOCTYPE html>
<html lang="en">
<head>
  <title>Day Schedule</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
  
</head>


<?php

    session_start();
    include "dbconnect.php";
    include "menu.php";

    require_once("checkpermission.php");
    //add menu on the top of this insert form
    

    // //the aim of this part is to generate HNO automatically, 
    // //using year and number of person registered in that year
    // date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    
    // $sql = "SELECT count(*) as bk FROM book WHERE bkid LIKE '%".date("Y")."%'";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $b = $row['bk']; 
    // $bno = "BK".date("Y").($n+1);
    // $conn->close();
?> 

<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
  <h2>แบบฟอร์มการจัดเที่ยวรถ</h2>
  <form action="operation.php" method="post">
    <!-- <div class="form-group">
        <label for="user">ID:</label>
        <input type="text" class="form-control" placeholder="Enter " name="id" value='<?php echo $sno; ?>' >
    </div> -->
    
    <div class="form-group">
        <label for="user">วันที่:</label>
        <input type="date" class="form-control" name="dte" min ='<?php echo date('Y-m-d'); ?>' required> <!-- "required" means this field is required -->
    </div>
    <div class="form-group">
      <label for="user">ช่วงเวลาที่ต้องการ:</label>
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
    </div>
    <div class="form-group">
        <label for="user">รถ:</label> 
      <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM car ORDER BY carid";
        $result = $conn->query($sql);
        //echo "<option value='slotid'>โปรดเลือก";
        echo "<select class='form-control' name='carid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['carid'].">".$row['band']."  ".$row['carno']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
    </div>
    <div class="form-group">
        <label for="user">คนขับรถ:</label>
      <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM driver ORDER BY drvid";
        $result = $conn->query($sql);
        echo "<select class='form-control' name='drvid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['drvid'].">".$row['dnme']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
    </div>
    
    <input type="submit" name="schedule" class="btn btn-primary" value="ยืนยัน">
  </form>
  </div>

  <div class="col-sm-4" ></div>
</div>


</body>
</html>