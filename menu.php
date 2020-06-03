<!DOCTYPE html>
<html lang="en">
<head>
  <title>C-Saim System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="image/1.jpg">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
.body{
  background-color:#FAF0E6;
}
.header {
  background-color: #F0F8FF;
  padding: 20px;
  text-align: center;
  color: #001a4d;
}
.navbar-inverse{
  background-color: #001a4d;
  color:#ffffff;
  border-color:#001a4d;
}
.navbar-header{
  color:#ffffff;
}
/* .navbar{
    background: #001a4d;
    position: relative;
    min-height: 50px;
    margin-bottom: 20px;
    border: 1px solid transparent;
  }
  .navbar-default{
    border-color: #7e7e7e;
  }
  .container{
    height: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto; 
    margin-left: auto;
    
  }
  .narbar-header {
    margin-right: -15px; 
    margin-left: -15px;
  }
  .navbar-inverse .navbar-collaose,{
    border-color: #ddd;
  }
  .navbar-default .navbar-toggle {
    border-color: #ddd;
  } */
</style>
<body style="background-color:#F0F8FF">
<?php 
  session_start();//start session
	$id = $_SESSION['valid_id'];	
	$fnme = $_SESSION['valid_fnme'];
	$lnme = $_SESSION['valid_lnme'];
	$utype = $_SESSION['valid_utype'];
?>

<div class="header">
  <h1>C-SIAM PATTANI</h1>
</div>

<nav class="navbar navbar-inverse" >
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php" style="color:#ffffff">หน้าแรก</a>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <!-- <li><a href="#" style="color:#ffffff">About</a></li> -->
        
        <?php
          if($utype==1) { //if the login user is staff/admin
            echo" 
                <li><a href='bookForSTF.php' style='color:#ffffff' >จอง</a></li>
                <li class='dropdown'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff' >จัดตารางเที่ยวรถ<span class='caret'></span></a>
                <ul class='dropdown-menu' style='color:#ffffff'>
                  <li><a href='dayschedule.php'>เพิ่ม</a></li>
                  <li><a href='showDaySch.php'>ข้อมูลเดินรถ</a></li>
                </ul>
                </li>

                <li class='dropdown'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff'>พนักงาน <span class='caret'></span></a>
                <ul class='dropdown-menu' style='color:#ffffff'>
                  <li><a href='insertSTF.php'>เพิ่ม</a></li>
                  <li><a href='showSTF.php'>ข้อมูลพนักงาน</a></li>
                  <li><a href='showBooking.php'>แสดงรายการจอง</a></li>
                </ul>
                </li>

                <li class='dropdown'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff'>คนขับรถ <span class='caret'></span></a>
                <ul class='dropdown-menu' >
                  <li><a href='insertDRV.php'>เพิ่ม</a></li>
                  <li><a href='showDRV.php'>ข้อมูลคนขับรถ</a></li>
                </ul>
                </li> 

                <li class='dropdown' >
                <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff'>ลูกค้า <span class='caret'></span></a>
                <ul class='dropdown-menu' >
                  <li><a href='showCust.php'>ข้อมูลลูกค้า</a></li>
                </ul>
                </li>

                <li class='dropdown' >
                <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff'>รายการสรุป<span class='caret'></span></a>
                <ul class='dropdown-menu' >
                  <li><a href='report.php'>ทั้งหมด</a></li>
                  <li><a href='reportY.php'>ปี</a></li>
                  <li><a href='reportM.php'>เดือน</a></li>
                  <li><a href='find.php'>ค้นหา</a></li>
                </ul>
                </li>
                
              ";
          }
          else if($utype==2){//driver
            echo" <li><a href='detail.php' style='color:#ffffff'>ตารางขับรถ</a></li>";
                
          }
          else if($utype==3){ //customer
            echo" <li><a href='showCBook.php' style='color:#ffffff'>รายการจอง</a></li>
                  <li><a href='book.php' style='color:#ffffff'>จอง</a></li>";    
          }
          else {
            echo" <li class='dropdown'>
                  <a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color:#ffffff'>ลงทะเบียน <span class='caret'></span></a>
                  <ul class='dropdown-menu'>
                  <li><a href='register.php'>ลูกค้า </a></li>
                  <li><a href='insertSTF.php'>พนักงาน</a></li>
                </ul>
                </li>
                ";
          }
        ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php
          if($id=="") { //no login
               echo "<li><a href='login.php' style='color:#ffffff'><span class='glyphicon glyphicon-log-in'></span> เข้าสู่ระบบ</a></li>";
          } else {  //logined staff
              if($utype==1)
                  echo "<li><a href='editStfForm.php?id=".$id."' style='color:#ffffff'><span class='glyphicon glyphicon-user'></span> ".$fnme."</a></li>";
                  else if($utype==2)//logined customer
                    echo "<li><a href='editDRVForm.php?id=".$id."' style='color:#ffffff'><span class='glyphicon glyphicon-user'></span> ".$fnme."</a></li>";
                      else if($utype==3)//logined customer
                          echo "<li><a href='editCustForm.php?id=".$id."' style='color:#ffffff'><span class='glyphicon glyphicon-user'></span> ".$fnme."</a></li>";
                          // echo "<li><a href='book.php?id=".$id."'><span class='glyphicon glyphicon-user'></span> ""</a></li>";
              
              echo "<li><a href='logout.php' style='color:#ffffff' ><span class='glyphicon glyphicon-log-out'></span> ออกจากระบบ</a></li>";
          }
        ?>
      </ul>

    </div>
  </div>
</nav>
  
<div class="container">

</div>

</body>
</html>