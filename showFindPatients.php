<!doctype html>

<html>
<head>
<title>Health Care System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="hospital-icon.png">
<style>
	table {
		border-collapse: collapse;
		width: 100%;
	}

	th, td {
		text-align: left;
		padding: 8px;
		height: 40px;
	}

	tr:nth-child(even){background-color: #f2f2f2}

	th {
		background-color: #333333;
		color: white;
	}
</style>
<script>
function clr() {
	  document.forms["searchfrm"]["ptid"].value="";
      document.forms["searchfrm"]["ptnme"].value="";
      document.forms["searchfrm"]["ptsnme"].value="";
	  document.forms["searchfrm"]["gender"].value="";
	  document.forms["searchfrm"]["dob"].value="";
	  document.forms["searchfrm"]["email"].value="";
	  document.forms["searchfrm"]["nat"].value="";
	  document.forms["searchfrm"]["bldgrp"].value="";
	}
</script>	
</head>
<body>

<?php
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
//constant value of genders
$genders= array();
$genders[0]="ไม่ระบุ"; $genders[1]="ชาย"; $genders[2]="หญิง";
function getAge($dte) { //the function used for computing age, based on the birthdate
		return intval(date('Y', time() - strtotime($dte))) - 1970;
}
function shwThaiDate($dte) { //where $dte is a Date format
	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
}
//get all data for searching
	$ptid	=$_POST['ptid'];
	$ptnme	=$_POST['ptnme'];
	$ptsnme	=$_POST['ptsnme'];
	$gender	=$_POST['gender'];
	$dob	=$_POST['dob'];
	$email 	=$_POST['email'];
	$nat	=$_POST['nat'];
	$bldgrp	=$_POST['bldgrp'];

//count all patients from database
	$sql = "SELECT ptid, ptnme, ptsnme, email, gender, dob, nation_thai, bldgrp
			FROM patients, nationalities 
			WHERE patients.natid = nationalities.natid";
	if($ptid !="")
		$sql = $sql." AND ptid LIKE '%$ptid%' ";
	if($ptnme !="")
		$sql = $sql." AND ptnme LIKE '%$ptnme%' ";
	if($ptsnme !="")
		$sql = $sql." AND ptsnme LIKE '%$ptsnme%' ";
	if($gender !="")
		$sql = $sql." AND gender = '$gender'";
	if($email !="")
		$sql = $sql." AND email LIKE '%$email%' ";
	if($nat !="")
		$sql = $sql." AND nation_thai LIKE '%$nat%' ";
	if($bldgrp !="")
		$sql = $sql." AND bldgrp LIKE '%$bldgrp%' ";
	
//run the query $sql
	$result = $conn->query($sql);
	
	$numfound = $result->num_rows; //return the number of records
		
	if($_POST['showPage'] || $_POST['nextPage'] ||$_POST['firstPage'] || $_POST['lastPage'] || $_POST['prePage']){
		$p_size =  $_POST['nrec']; 
	}else{
		$p_size = 10; //กำหนดจำนวน record เริ่มต้นที่จะแสดงผลต่อ 1 เพจ
	}
	$total_page=(int)($numfound/$p_size); 
	//ทำการหารหาจำนวนหน้าทั้งหมดของข้อมูล ในที่นี้ให้หารออกมาเป็นเลขจำนวนเต็ม 
	if(($numfound % $p_size)!=0){ //ถ้าข้อมูลมีเศษให้ทำการบวกเพิ่มจำนวนหน้าอีก 1 
	   $total_page++;
	}
	if($_POST[showPage]){
	/*
	หากมีการส่งค่ามาเพื่อเลือกดูหน้าข้อมูลหน้าใดให้ทำการคำนวน โดยใช้ จำนวนข้อมูลที่ต้องการแสดงต่อ 1 เพจ คูณกับ หน้าข้อมูลที่ต้องการเลือกชม ลบด้วย 1
	*/ 
		$page=$_POST['pageno'];
		$start=$p_size*($page-1);

	}else if($_POST[nextPage]){
		$p = $_POST['pageno'];
		if ( $p < $total_page)
			$page=$p + 1;
		else $page=$p;
		$start=$p_size*($page-1);

	}else if($_POST[firstPage]){
		$page=1;
		$start=$p_size*($page-1);

	}else if($_POST[lastPage]){
		$page=$total_page;
		$start=$p_size*($page-1);
	}else if($_POST[prePage]){
		$p= $_POST['pageno'];
		if($p >= 2)
			$page = $p - 1;
		else $page = $p;
		$start = $p_size*($page-1);
	}else{
	/*
	ถ้่ายังไม่มีการส่งค่ามาเพื่อทำการเลือกดูหน้าข้อมูลใด ๆ ให้กำหนดเป็นหน้าแรกของข้อมูลเป็นค่า Default และให้ Record แรกเริ่มที่ Record ที่ 0 หรือ Record แรก
	*/ 
	   $page=1;
	   $start=0;
	}
		
//redo select all patients' details from the database order by name
	$sql = "SELECT ptid, ptnme, ptsnme, email, gender, dob, nation_thai, bldgrp 
			FROM patients, nationalities 
			WHERE patients.natid = nationalities.natid";
	if($ptid !="")
		$sql = $sql." AND ptid LIKE '%$ptid%' ";
	if($ptnme !="")
		$sql = $sql." AND ptnme LIKE '%$ptnme%' ";
	if($ptsnme !="")
		$sql = $sql." AND ptsnme LIKE '%$ptsnme%' ";
	if($gender !="")
		$sql = $sql." AND gender = '$gender'";
	if($email !="")
		$sql = $sql." AND email LIKE '%$email%' ";
	if($nat !="")
		$sql = $sql." AND nation_thai LIKE '%$nat%' ";
	if($bldgrp !="")
		$sql = $sql." AND bldgrp LIKE '%$bldgrp%' ";
	
	$sql = $sql." ORDER BY ptnme, ptsnme LIMIT $start , $p_size";
	
//run the query $sql
	$result = $conn->query($sql);
	
//show all records satisfied	
echo "<h2>All Patients</h2>";
echo "<table>";
echo "<tr>";
echo "<th>NO</th>";
echo "<th>PatientID (HRNO)</th>";
echo "<th>First name</th>";
echo "<th>Last name</th>";
echo "<th>E-mail</th>";
echo "<th>Gender</th>";
echo "<th>Birth Date</th>";
echo "<th>Nationality</th>";
echo "<th>Blood</th>";
echo "<th colspan=2>ดำเนินการ</th>";
echo "</tr>";
//row of searching 
echo "<tr>";
echo "<form name='searchfrm' action = 'showFindPatients.php' method ='post'> ";
		echo "<td></td>";		
		echo "<td><input type='text' name ='ptid' value=".$ptid."></td>";
        echo "<td><input type='text' name ='ptnme' value=".$ptnme."></td>";
		echo "<td><input type='text' name ='ptsnme' value=".$ptsnme."></td>";
		echo "<td><input type='text' name ='email' value=".$email."></td>";
		echo "<td><input type='text' name ='gender' value=".$gender."></td>";
		echo "<td><input type='text' name ='dob' value=".$dob."></td>";
		echo "<td><input type='text' name ='nat' value=".$nat."></td>";
		echo "<td><input type='text' name ='bldgrp' value=".$bldgrp."></td>";
		echo "<td><input type='submit' name ='btnsrch' value='ค้นหา'></td>";
		echo "<td><input type='submit' name ='btnclr' value='ล้างคำค้น' onclick='clr()'></td>";
echo "</form>";
echo "</tr>";
//end row of searching	
	
if ($result->num_rows > 0) { //if existing some rows from the query $sql
    //loop to show the details of each record
	$n = ($page-1)*$p_size;//setting the start record no of each page
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".++$n."</td>";
        echo "<td>".$row["ptid"]."</td>";
		echo "<td>".$row["ptnme"]."</td>";
		echo "<td>".$row["ptsnme"]."</td>";
		echo "<td>".$row["email"]."</td>";
		echo "<td>".$genders[$row["gender"]]."</td>"; //convert gender id to string
		echo "<td>".shwThaiDate($row["dob"])."</td>"; //call a method to show date
		echo "<td>".$row["nation_thai"]."</td>"; //call a method to compute and get age from dob
		echo "<td>".$row["bldgrp"]."</td>";
		//edit button
		echo "<td>";
		echo "<form action = 'editPatientForm.php' method ='post'> ";
		echo "<input type='hidden' name ='ptid'  value = '".$row["ptid"]."'/>";		
		echo "<input name = 'editPatient' type='submit' value='edit' />";
		echo "</form>";
		echo "</td>";
		//del button
		echo "<td>";
		echo "<form action = 'operations.php' method ='post'> ";
		echo "<input type='hidden' name ='ptid'  value = '".$row["ptid"]."'/>";
		echo "<input name = 'delPatient' type='submit' value='del' />";
		echo "</form>";
		echo "</td>";
		echo "</tr>";	
    }
	echo "<tr><th colspan='11'>Total ".$numfound." records </th></tr>";
} else {
    echo "0 results";
}

//show navigation bar
echo "<tr><td colspan='13'><center>";
	echo"<form action = 'showFindPatients2.php' method ='post'> ";
	echo "<input type='hidden' name ='ptid'  value = '$ptid'/>";		
	echo "<input type='hidden' name ='ptnme'  value = '$ptnme'/>";		
	echo "<input type='hidden' name ='ptsnme' value = '$ptsnme'/>";
	echo "<input type='hidden' name ='email' value = '$email'/>";
	echo "<input type='hidden' name ='gender'  value = '$gender'/>";
	echo "<input type='hidden' name ='dob'  value = '$dob'/>";
	echo "<input type='hidden' name ='nat'  value = '$nat'/>";
	echo "<input type='hidden' name ='bldgrp'  value = '$bldgrp'/>";
	echo "แสดงหน้าที่ : <select name = pageno value =$page>";

		for($i=1;$i<=$total_page;$i++){ //สร้าง list เพื่อให้ผู้ใช้งานเลือกชมหน้าข้อมูล
			echo "<option ";
			 if($page==$i)
				     echo "selected='selected'";
			echo "value=",$i, ">",$i;
		}
	
	echo "</select>  จากทั้งหมด ".$total_page." หน้า";
	echo " จำนวนรายการต่อหน้า <input name = 'nrec' type='text' value = $p_size size = 3/>";
	echo "<input name = 'showPage' type='submit' value='show' />";
	echo "<input name = 'firstPage' type='submit' value='<<first' />";
	echo "<input name = 'prePage' type='submit' value='<previous' />";
	echo "<input name = 'nextPage' type='submit' value='next>' />";
	echo "<input name = 'lastPage' type='submit' value='last>>' />";
	echo "</form>";
echo "</td></tr>";
	
	
echo "<tr><td colspan='11'><a href='insertPatientForm.php'>Add New Patient</a></td></tr>";
$conn->close();
?>
</body>
</html>