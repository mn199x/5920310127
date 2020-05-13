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

?>  


<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
  <h2>Check Booking </h2>
  <form action="operations.php" method="post">
    <div class="form-group">  
    <label for="user">รหัสการจอง/Booking ID: </label>
    <input type="text" name="id" class="form-control" placeholder="Enter ID" >
    </div>

    <center><input type="submit" class="btn btn-primary" name="check" value="Check"></center>
    </form>
    </div>


    <div class="col-sm-4" ></div>

    <div>
</body>