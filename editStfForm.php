<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Staff Form</title>
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
		$stfid = $id;
	else 
		$stfid = $_POST['stfid']; //get ptid from showPatients, in case of admin/staff used

	$sql = "SELECT * FROM staff WHERE stfid = '$stfid'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง cust ที่มี stfid = $stfid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>

<div class="container">
	<div class="row">

	<div class="col-sm-4" ></div>
	<div class="col-sm-4">

	<h2>Edit Staff Form</h2>
	<!-- this enctype="multipart/form-data" is necessary for uploading file -->
	<form action="operation.php" method="post" enctype="multipart/form-data">
		
	<div class="form-group">
		<label for="user">ID:</label>
		<input type="text" class="form-control" name="id" value="<?php echo $row["stfid"] ?>" disabled>
		<input type='hidden'  class="form-control" name="id" value="<?php echo $row["stfid"] ?>" >
	</div>

	<div class="form-group">
		<label for="user">Name:</label>
		<input type="text" class="form-control" name="nme" value="<?php echo $row["stfnme"] ?>">
	</div>

	<div class="form-group">
        <label for="user">Surname:</label>
        <input type="text" class="form-control" name="snme" value="<?php echo $row["stfsurnme"] ?>"> 
    </div>

	<div class="form-group">
        <label for="user">Gender:</label>
        <input type="radio" name="sex" value="male" <?php if ($row["stfsex"]==male) echo "checked" ?> > Male
        <input type="radio" name="sex" value="female"> Female<br>
    </div>

	<div class="form-group">
        <label for="user">Tel:</label>
        <input type="text" class="form-control" name="tel" value="<?php echo $row["stftel"] ?>"> 
    </div>

	<div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" name="email" value="<?php echo $row["s_email"] ?>">
    </div>


    <input type="submit" class="btn btn-primary" name="updateStf" value="Update" >
</form>
</div>
<div class="col-sm-4" ></div>
 
</div>

</body>
</html>
