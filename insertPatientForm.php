<!DOCTYPE html>
<html>
<head>
<title>Insert Patient</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    table {
        border-collapse: collapse;
        border: 1px;
    }
    th, td {
        text-align: left;
        padding: 10px;
        height: 40px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    th {
        background-color: #333333;
        color: white;
    }
</style>
</head>

<body>
<?php
    require_once("checkpermission.php");
    //add menu on the top of this insert form
    include "menu.php";

    // //the aim of this part is to generate HNO automatically, 
    // //using year and number of person registered in that year
    // date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    // include "dbconnect.php";
    // $sql = "SELECT count(*) as np FROM patients WHERE ptid LIKE '%".date("Y")."%'";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $n = $row['np']; 
    // $hno = "HN".date("Y").($n+1);
    // $conn->close();
?> 
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><h3>Insert Patient Form</h3><th></tr>
<tr><td>Patient ID: </td><td><input type="text" name="ptid" value='<?php echo $hno; ?>'></td></tr>
<tr><td>First Name: </td><td><input type="text" name="fname"></td></tr>
<tr><td>Last Name: </td><td><input type="text" name="lname"></td></tr>
<tr><td>Personal ID: </td><td><input type="text" name="pid"></td></tr>
<tr><td>E-mail: </td><td><input type="email" name="email"></td></tr>
<tr><td>Tel no: </td><td><input type="text" name="tel"></td></tr>
<tr><td>Blood Type:</td>
<td>
 <select name="bldgrp">
    <option value="">ไม่ระบุ</option>";
	<option value="A">A</option>";
	<option value="AB">AB</option>";
	<option value="B">B</option>";
	<option value="O">O</option>";
 </select>
</td></tr>

<tr><td>Gender:</td><td><input type="radio" name="gender" value="1" checked> Male</td></tr>
<tr><td></td><td><input type="radio" name="gender" value="2"> Female</td></tr>

<tr><td>Birth date :</td><td><input type="date" name="dob"></td></tr>

<tr><td> Nationality:</td>
<td>
    <?php
        include "dbconnect.php";
        $sql = "SELECT natid, nation_thai FROM nationalities ORDER BY nation_thai";
        $result = $conn->query($sql);
        echo "<select name='natid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['natid'].">".$row['nation_thai']."</option>";
        }
        echo"</select>";
        $conn->close();
    ?>
</td></tr>

<tr><td>Address: </td><td><input type="text" name="addr"></td></tr>

<!-- type="file" is used for uploading file, it is handled in file operations.php when click inspatient -->
<tr><td>Select patient image to upload:</td><td><input type="file" name="fileToUpload" id="fileToUpload"></td></tr>

<tr><td colspan=2><input type="submit" name="inspatient" value="Insert"></td></tr>
</table>
</form>
</center>

</body>
</html>
