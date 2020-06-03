<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Customer Form</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
</head>

<body>
<?php
	// //check permission before doing updating
	require_once("checkpermission.php");
	// //add menu on the top of this insert form
	include "menu.php";
	// //เชื่อมต่อฐานข้อมูลและ select ข้อมูลผู้ป่วยจากตาราง patients ตาม ptid ที่ส่งมาจากฟอร์ม
	include "dbconnect.php"; //connect the database, this returns a connection ชื่อ $conn
	$id = $_GET["id"]; //get id from login user, in case of editing data themselves
	if($id != "")
		$cusid = $id;
	else 
		$cusid = $_POST['cusid']; //get ptid from showPatients, in case of admin/staff used

	$sql = "SELECT * FROM cust WHERE cusid = '$cusid'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง cust ที่มี cusid = $ptid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>

<div class="container">
<div class="row">

  <div class="col-sm-4" ></div>
  <div class="col-sm-4" >
	<h2>แก้ไขข้อมูลลูกค้า</h2>
	<!-- this enctype="multipart/form-data" is necessary for uploading file -->
	<form action="operation.php" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<label for="user">ID:</label>
		<input type="text" class="form-control" name="id" value="<?php echo $row["cusid"] ?>" disabled>
		<input type='hidden'  class="form-control" name="id" value="<?php echo $row["cusid"] ?>" >
	</div>

	<div class="form-group">
		<label for="user">ชื่อ:</label>
		<input type="text" class="form-control" name="nme" value="<?php echo $row["cnme"] ?>">
	</div>

	<div class="form-group">
        <label for="user">นามสกุล:</label>
        <input type="text" class="form-control" name="snme" value="<?php echo $row["csurnme"] ?>"> 
    </div>

	<div class="form-group">
        <label for="user">เพศ:</label>
        <input type="radio" name="sex" value="male" <?php if ($row["csex"]=='male') echo "checked" ?> > Male
        <input type="radio" name="sex" value="female" <?php if ($row["csex"]=='female') echo "checked" ?>> Female<br>
    </div>

	<div class="form-group">
        <label for="user">เบอร์โทรศัพท์:</label>
        <input type="number" class="form-control" name="tel" value="<?php echo $row["ctel"] ?>"> 
    </div>

	<div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" name="email" value="<?php echo $row["c_email"] ?>">
    </div>
<!-- <tr><td>Gender:</td>
	<td><input type="radio" name="gender" value="1" <?php if ($row["gender"]==1) echo "checked" ?> > Male</td></tr>
<tr><td></td>
	<td><input type="radio" name="gender" value="2" <?php if ($row["gender"]==2) echo "checked" ?> > Female</td></tr> -->
	


	<input type="submit" class="btn btn-primary" name="updateCust" value="อัพเดต">
	</form>
	</div>

  <div class="col-sm-4" ></div>

</div>

</body>
</html>
