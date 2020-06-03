<!DOCTYPE html>
<html>
<head>
<title>Show Driver</title>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="hospital-icon.png"> -->
  
</head>

<body>

<?php
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
// //constant value of genders
// // $genders= array();
// $genders[0]="ไม่ระบุ"; $genders[1]="ชาย"; $genders[2]="หญิง";
// // function getAge($dte) { //the function used for computing age, based on the birthdate
// 		// return intval(date('Y', time() - strtotime($dte))) - 1970;
// // }
// function shwThaiDate($dte) { //where $dte is a Date format
// 	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
// }

//count all patients from database order by name, this is used for caculate the numbers of pages
	$sql = "SELECT count(*) np FROM driver";
	$result = $conn->query($sql);
	$rw = $result->fetch_assoc(); 
	$numfound = $rw['np']; //return the number of records
	
	if($_POST['showPage'] || $_POST['nextPage'] ||$_POST['firstPage'] || $_POST['lastPage'] || $_POST['prePage']){
		$p_size =  $_POST['nrec']; //กำหนดจำนวน record ที่จะแสดงผลต่อ 1 เพจ ให้เท่ากับค่าที่จำนวนต่อเพจที่รับมา
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
	
//new sql for selecting all patients details
$sql = "SELECT drvid, dnme, dsurnme, d_email, dsex, dtel
			FROM driver 
			ORDER BY drvid LIMIT $start , $p_size";
			
$result = $conn->query($sql);
	
echo "<h2 style='color: #001a4d'>ข้อมูลคนขับรถ</h2>";
echo "<table class='table'>";
echo "<tr style='background-color:#DCDCDC'>";
echo "<th><center>ลำดับที่</center></th>";
// echo "<th>ID</th>";
echo "<th>ชื่อ</th>";
echo "<th>นามสกุล</th>";
echo "<th>E-mail</th>";
echo "<th>เพศ</th>";
echo "<th>เบอร์โทรศัพท์</th>";
echo "<th colspan=2>ดำเนินการ</th>";
echo "</tr>";
if ($result->num_rows > 0) {
    //loop to show the details of each record
	$n=($page-1)*$p_size;
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td><center>".++$n."</center></td>";
        // echo "<td>".$row["drvid"]."</td>";
		echo "<td>".$row["dnme"]."</td>";
		echo "<td>".$row["dsurnme"]."</td>";
		echo "<td>".$row["d_email"]."</td>";
		echo "<td>".$row["dsex"]."</td>"; //convert gender id to string
		echo "<td>".$row["dtel"]."</td>";
		echo "<td>";
		echo "<form action = 'editDRVForm.php' method ='post'> ";
		echo "<input type='hidden' name ='drvid'  value = '".$row["drvid"]."'/>";		
		echo "<input name = 'updateCust' type='submit' value='แก้ไข' />";
		echo "</form>";
		echo "</td>";
		// echo "<td>";
		// echo "<form action = 'operation.php' method ='post'> ";
		// echo "<input type='hidden' name ='ptid'  value = '".$row["ptid"]."'/>";
		// echo "<input name = 'delDRV' type='submit' value='del' />";
		// echo "</form>";
		// echo "</td>";
		echo "</tr>";	
    }
	echo "<tr style='background-color:#DCDCDC'><th colspan='11'>ทั้งหมด ".$numfound." แถว </th></tr>";
} else {
    echo "0 results";
}
//show navigation bar
echo "<tr><td colspan='13'><center>";
	echo"<form action = 'showDRV.php' method ='post'> ";
	echo "<input type='hidden' name ='drvid'  value = '$drvid'/>";		
	echo "<input type='hidden' name ='dnme'  value = '$dnme'/>";		
	echo "<input type='hidden' name ='dsurnme' value = '$dsurnme'/>";
	echo "<input type='hidden' name ='d_email' value = '$d_email'/>";
	echo "<input type='hidden' name ='dsex'  value = '$dsex'/>";
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
//end navigation bar	

// echo "<tr><td colspan='11'><a href='insertPatientForm.php'>Add New Patient</a></td></tr>";
$conn->close();
?>
</body>
</html>