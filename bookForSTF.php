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
    $bno = "BK".date("Y").($n+1);
    $conn->close();
?> 

<p id="demo" type="hidden"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  // x.innerHTML = "Latitude: " + position.coords.latitude + 
  // "<br>Longitude: " + position.coords.longitude;
  
  document.getElementById("lat").value = position.coords.latitude;
  document.getElementById("lng").value = position.coords.longitude;
}

let nowdte = new Date();
let m = nowdte.getMonth()+1;
let d = nowdte.getDate();
let mm = (m<10)?"0"+m:m;
let dd = (d<10)"0"+d:d;
let mindte = nowdte.getFullYear()+"-"+mm+"-"+dd;
  document.getElementById("mydate").min=""+mindte;
</script> 


<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
  <h2>Booking Form</h2>
  <form action="operation.php" method="post">
    <div class="form-group">  
      <label for="user">รหัสการจอง/Booking ID: </label>
      <input type="text" name="bid" class="form-control" value='<?php echo $bno; ?>' disabled>
      <input type="hidden" name="bid" class="form-control" value='<?php echo $bno; ?>'>
    </div>

    <div class="form-group">
      <label for="user">วันที่ต้องการจอง: </label>
      <input type="date" name="bdte" class="form-control" id="mydate">
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
      <label for="user">จำนวนคนที่จอง: </label>
      <input type="text" name="num" class="form-control" placeholder="Enter number " required >
    </div>    
    <div class="form-group">  
      <label for="user">รหัสพนักงานที่ทำการจอง/Staff ID: </label>
      <input type="text" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>' required>
    </div>
    <h2>Contact</h2>
    <div class="form-group">
      <label for="user">ชื่อผู้ติดต่อ: </label>
      <input type="text" name="nme" class="form-control" placeholder="Enter Name" required>
    </div>

    <div class="form-group">
      <label for="user">เบอร์โทรที่สาสารถติดต่อได้: </label>
      <input type="text" name="tel" class="form-control" placeholder="Enter Tel" required>
    </div>

    <div class="form-group">
      <label for="user">ชื่อสถานที่/Places: </label>
      <input type="text" name="place" class="form-control" placeholder="Enter Places" required>
    </div>
<!--   
   <div class="form-group">
       <label for="user">Your Latitude: </label> 
      <input type="hidden" id='lat' name="lat" class="form-control" >
    </div>
    
    <div class="form-group">
       <label for="user">Your Longitude: </label> 
      <input type="hidden"  id='lng' name="lng" class="form-control">
    </div> -->
    
    <center><input type="submit" class="btn btn-primary" name="bookSTF" value="book"></center>
    <!-- <button class="btn btn-primary" onclick="getLocation()">Try It</button> -->
  </form>

  <!-- <div class="form-group">
  <button onclick="getLocation()">Try It</button>
  </div>
  </div> -->


  <div class="col-sm-4" ></div>
  
</div>
</body>
