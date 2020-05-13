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
    $bno = "BK".date("Y").($b+1);
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

 // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 6.8667693, lng: 101.2425756},
          zoom: 15,
          mapTypeId: 'roadmap'
        });

        // var marker = new google.maps.Marker({
        //   position: new google.maps.LatLng(6.8662474,101.2398827),
        //   map: map,
        //   title: 'ป้านะ'
        // });
        infoWindow = new google.maps.InfoWindow;


        // Try HTML5 geolocation.
        // if (navigator.geolocation) {
        //   navigator.geolocation.getCurrentPosition(function(position) {
        //   var pos = {
        //     lat: position.coords.latitude,
        //     lng: position.coords.longitude
        //   };

        //   infoWindow.setPosition(pos);
        //   infoWindow.setContent('Location found. lat: ' + position.coords.latitude + ', lng: ' + position.coords.longitude + ' ');
        //   infoWindow.open(maps);
        //   map.setCenter(pos);
        //   }, function() {
        //   handleLocationError(true, infoWindow, map.getCenter());
        //   });
        // } else {
        //   // Browser doesn't support Geolocation
        //   handleLocationError(false, infoWindow, map.getCenter());
        // }
			
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
// let nowdte = new Date();
// let m = nowdte.getMonth()+1;
// let d = nowdte.getDate();
// let mm = (m<10)?"0"+m:m;
// let dd = (d<10)"0"+d:d;
// let mindte = nowdte.getFullYear()+"-"+mm+"-"+dd;
//   document.getElementById("mydate").min=""+mindte;
</script> 

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwOxpPQ5Fro6gGiHhI4zk8RyPc4EhjLhM&callback=initMap">
    </script>

<body>
<!-- <div id="map"></div> -->
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
      <input type="date" name="bdte" id="mydate" class="form-control" >
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
      <input type="text" name="num" class="form-control" placeholder="Enter number " required>
    </div>    
    <h2>Contact</h2>
    <div class="form-group">  
      <label for="user">รหัสลูกค้า/Customer ID: </label>
      <input type="text" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>' disabled>
      <input type="hidden" name="id" class="form-control" placeholder="Enter Customer ID" value='<?php echo $_SESSION['valid_id']; ?>'>
    </div>

    <div class="form-group">
      <label for="user">ชื่อผู้ติดต่อ: </label>
      <input type="text" name="nme" class="form-control" value='<?php echo $_SESSION['valid_fnme']; ?>' required>
    </div>

    <div class="form-group">
      <label for="user">เบอร์โทรที่สาสารถติดต่อได้: </label>
      <input type="text" name="tel" class="form-control" value='<?php echo $_SESSION['valid_tel']; ?>' required>
    </div>

    <div class="form-group">
      <label for="user">ชื่อสถานที่/Places: </label>
      <input type="text" name="place" class="form-control" placeholder="Enter Places" required>
      
    </div>

    <div class="form-group">
      <label for="user">Link (ตำแหน่งบนแผนที่): </label>
      <input title="คลิก เปิดแผนที่ แล้วคัดลอก link ตำแหน่งมาใส่" type="url" name="lnk" class="form-control" placeholder="Enter URL" required>
      <a href="https://maps.google.co.th" target="_blank"> เปิดแผนที่</a>
    </div>
  
   <!-- <div class="form-group">
      <label for="user">Your Latitude: </label>
      <input type="text" id='lat' name="lat" class="form-control" >
    </div>
    
    <div class="form-group">
      <label for="user">Your Longitude: </label>
      <input type="text"  id='lng' name="lng" class="form-control">
    </div> -->
    
    <center><input type="submit" class="btn btn-primary" name="book" value="book"></center>
    <!-- <button class="btn btn-primary" onclick="getLocation()">Try It</button> -->
  </form>

  <!-- <div class="form-group">
  <button onclick="getLocation()">Try It</button>
  </div>
  </div> -->


  <div class="col-sm-4" ></div>
  
</div>
</body>
