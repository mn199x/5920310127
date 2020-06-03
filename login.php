<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<?php

include "dbconnect.php";
include "menu.php";

if($_POST["loginbtn"]) {
	$usrnme = $_POST['email']; //using email as usrname
	$pwd = $_POST['pwd'];
	$utype = $_POST["utype"];
	
	//hash password, encript the password ($pwd) using hash function with sha256 encription
	$enpwd = hash('sha256',$pwd); 

if($utype=="1")//in case of staff
		$sql = "SELECT stfid as id, stfnme as fnme, stfsurnme as lnme, s_email as email, pswd, stfsex as gender, stftel as tel 
				FROM staff 
				WHERE s_email = '$usrnme' AND (pswd = '$enpwd' OR pswd = '$pwd')";
	else if($utype=="2")//in case of driver
		$sql = "SELECT drvid as id, dnme as fnme, dsurnme as lnme, d_email as email, pswd, dsex as gender, dtel as tel, d_add, drvlics, expdrv, idcard
				FROM driver 
				WHERE d_email = '$usrnme' AND (pswd = '$enpwd' OR pswd = '$pwd')";
	else if ($utype=="3")//in case of customer
		$sql = "SELECT cusid as id, cnme as fnme, csurnme as lnme, c_email as email, pswd, 	csex as gender, ctel as tel 
				FROM cust
				WHERE c_email = '$usrnme' AND (pswd = '$enpwd' OR pswd = '$pwd')";
				
	$result = mysqli_query($conn, $sql);
		
	if(!$result) {
			//echo "เกิดข้อผิดพลาด กรุณาลองใหม่";
			echo "<script>alert('เกิดข้อผิดพลาด กรุณาลองใหม่');</script>";
	}
	else {
			if(mysqli_num_rows($result) == 1) {   
				$row = mysqli_fetch_array($result);
				//set all session values, could be more if necessary (can use object instead of array)
				$_SESSION['valid_id'] = $row["id"]; 
				$_SESSION['valid_fnme'] = $row["fnme"]; 
				$_SESSION['valid_lnme'] = $row["lnme"]; 
				$_SESSION['valid_tel'] = $row["tel"];
				$_SESSION['valid_utype'] = $utype; 
				//header("location: menu.php"); //set location to page menu.php
				echo "<script>alert('ล็อคอินสำเร็จ');</script>";
				echo "<script>window.location.href='index.php';</script>";
			}
			else {
				//echo "ท่านกำหนด Login หรือ Password ไม่ถูกต้อง";
				echo "<script>alert('ท่านกำหนด Login หรือ Password ไม่ถูกต้อง');</script>";
			}
	}	
	mysqli_close($conn);
}

?>

<body>
<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
  <h2>เข้าสู่ระบบ</h2>
  <form  method="post" >
    <div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    	<input type="email" class="form-control" id="email" placeholder="กรุณาใส่ email" name="email" required> <!-- "required" means this field is required -->
    </div>
	<br>
    <div class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input type="password" class="form-control" id="pwd" placeholder="กรุณาใส่รหัสผ่าน" name="pwd" required>
    </div>
	<br>
	<label for="tp">ประเภทผู้ใช้:</label>
	<div class="form-group form-check" id="tp">
      <label class="form-check-label">
				<input type="radio" name="utype" value="1" checked>พนักงาน
				<input type="radio" name="utype" value="2">คนขับรถ
				<input type="radio" name="utype" value="3">ลูกค้า
      </label>
    </div>

    <center><input type="submit" class="btn btn-primary " name="loginbtn" value="เข้าสู่ระบบ" ><center>
  </form>
  </div>

  <div class="col-sm-4" ></div>
  
</div>

</body>
</html>