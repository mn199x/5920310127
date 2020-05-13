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
      <h2>Register Driver Form</h2>
      <form action="operation.php" method="post">
        <!-- <div class="form-group">
            <label for="user">ID:</label>
            <input type="text" class="form-control" placeholder="Enter " name="id" value='<?php echo $dno; ?>' >
        </div> -->
        
        <div class="form-group">
            <label for="user">Name:</label>
            <input type="text" class="form-control" placeholder="Enter your name" name="nme" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
            <label for="user">Surname:</label>
            <input type="text" class="form-control" placeholder="Enter your surname" name="snme" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
            <label for="user">Gender:</label>
            <input type="radio" name="sex" value="male" checked> Male
            <input type="radio" name="sex" value="female"> Female<br>
        </div>
        <div class="form-group">
            <label for="user">ID card:</label>
            <input type="text" class="form-control" placeholder="Enter your ID card" name="idcard" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
            <label for="user">Tel:</label>
            <input type="text" class="form-control" placeholder="Enter your telephone" name="tel" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" placeholder="Enter your email" name="email" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="user">Address:</label>
          <input type="text" class="form-control" placeholder="Enter your Address" name="add" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="user">Driver's license:</label>
          <input type="text" class="form-control" placeholder="Enter your Driver's license" name="drl" required> <!-- "required" means this field is required -->
        </div>
        <div class="form-group">
          <label for="user">Driver's expiration date:</label>
          <input type="date" class="form-control" placeholder="Enter your Driver's expiration date" name="exp" required> <!-- "required" means this field is required -->
        </div>
        
        <input type="submit" name="insertDRV" class="btn btn-primary" value="Submit">
    </form>
    </div>

    <div class="col-sm-4" ></div>
</div>

</body>
</html>