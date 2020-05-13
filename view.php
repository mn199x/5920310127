<!DOCTYPE html>
<html>
<head>
<title>Detail</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="#">
</head>

<body>

<?php
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
//constant value of genders
// $genders= array();
// $genders[0]="ไม่ระบุ"; $genders[1]="ชาย"; $genders[2]="หญิง";
// function getAge($dte) { //the function used for computing age, based on the birthdate
// 		return intval(date('Y', time() - strtotime($dte))) - 1970;
// }
// function shwThaiDate($dte) { //where $dte is a Date format
// 	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
// }

//count all patients from database order by name, this is used for caculate the numbers of pages
$bkdate =$_POST["bkdate"];
$slotid	=$_POST["slotid"];

	$sql = "SELECT count(*) as np FROM book,dayscheduled 
			WHERE dayscheduled.slotid = book.slotid AND book.bkdate = dayscheduled.schdate AND bkdate='$bkdate' 
			AND book.slotid='$slotid' AND bstatus='1' AND drvid='".$_SESSION['valid_id']."'"  ; //FIXED this, as missing as
    // echo $sql; 
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
	if($_POST['showPage']){ //FIXED
	/*
	หากมีการส่งค่ามาเพื่อเลือกดูหน้าข้อมูลหน้าใดให้ทำการคำนวน โดยใช้ จำนวนข้อมูลที่ต้องการแสดงต่อ 1 เพจ คูณกับ หน้าข้อมูลที่ต้องการเลือกชม ลบด้วย 1
	*/ 
		$page=$_POST['pageno'];
		$start=$p_size*($page-1);

	}else if($_POST['nextPage']){
		$p = $_POST['pageno'];
		if ( $p < $total_page)
			$page=$p + 1;
		else $page=$p;
		$start=$p_size*($page-1);

	}else if($_POST['firstPage']){
		$page=1;
		$start=$p_size*($page-1);

	}else if($_POST['lastPage']){
		$page=$total_page;
		$start=$p_size*($page-1);
	}else if($_POST['prePage']){
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
$bkdate =$_POST["bkdate"];
$slotid	=$_POST["slotid"];
$drvid =$_POST["drvid"];

$sql = "SELECT bkid,con_nme,con_tel,plcnme,numpgr, 	lik ,lat,lng FROM book,dayscheduled 
		WHERE dayscheduled.slotid = book.slotid AND book.bkdate = dayscheduled.schdate AND bkdate='$bkdate' 
		AND book.slotid='$slotid' AND bstatus='1' AND drvid='$drvid'";
// echo $sql;		
$result = $conn->query($sql);
	
echo "<h2 style='color: #001a4d'>Details</h2>";
echo "<table class='table'>";
echo "<tr style='background-color:#DCDCDC'>";
echo "<th ><center>ลำดับที่</center></th>";
echo "<th>Book ID</th>";
echo "<th>Contact Name</th>";
echo "<th>Contact Tel.</th>";
echo "<th>Place</th>";
echo "<th>Number of people</th>";
echo "<th>Link to Map</th>";
// echo "<th>Gender</th>";
// echo "<th>Tel</th>";
// echo "<th colspan=2>ดำเนินการ</th>";
echo "</tr>";
if ($result->num_rows > 0) {
    //loop to show the details of each record
	$n=($page-1)*$p_size;
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td><center>".++$n."</center></td>";
		echo "<td>".$row["bkid"]."</td>";
        echo "<td>".$row["con_nme"]."</td>";
		echo "<td>".$row["con_tel"]."</td>";
		echo "<td>".$row["plcnme"]."</td>";
		echo "<td>".$row["numpgr"]."</td>";
		echo "<td><a href='".$row["lik"]."'target='_blank'>ดูแผนที่</td>";
		// echo "<td>".$row["csex"]."</td>"; //convert gender id to string
		// echo "<td>".$row["ctel"]."</td>";
		// echo "<td>";
		// echo "<form action = 'editCustForm.php' method ='post'> ";
		// echo "<input type='hidden' name ='cusid'  value = '".$row["cusid"]."'/>";		
		// echo "<input name = 'updateCust' type='submit' value='edit' />";
		// echo "</form>";
		// echo "</td>";
		// echo "<td>";
		// // echo "<form action = 'operation.php' method ='post'> ";
		// // echo "<input type='hidden' name ='cusid'  value = '".$row["cusid"]."'/>";
		// // echo "<input name = 'delCust' type='submit' value='del' />";
		// // echo "</form>";
		// echo "</td>";
		echo "</tr>";	
    }
	echo "<tr style='background-color:#DCDCDC'><th colspan='11'>Total ".$numfound." records </th></tr>";
} else {
    echo "0 results";
}
// //show navigation bar
// echo "<tr><td colspan='13'><center>";
// 	echo"<form action = 'showCust.php' method ='post'> ";
// 	echo "<input type='hidden' name ='cusid'  value = '$cusid'/>";		
// 	echo "<input type='hidden' name ='cnme'  value = '$cnme'/>";		
// 	echo "<input type='hidden' name ='csurnme' value = '$csurnme'/>";
// 	echo "<input type='hidden' name ='c_email' value = '$c_email'/>";
// 	echo "<input type='hidden' name ='csex'  value = '$csex'/>";
// 	echo "<input type='hidden' name ='ctel'  value = '$ctel'/>";

// 	echo "แสดงหน้าที่ : <select name = pageno value =$page>";

// 		for($i=1;$i<=$total_page;$i++){ //สร้าง list เพื่อให้ผู้ใช้งานเลือกชมหน้าข้อมูล
// 			echo "<option ";
// 			 if($page==$i)
// 				     echo "selected='selected'";
// 			echo "value=",$i, ">",$i;
// 		}
	
// 	echo "</select>  จากทั้งหมด ".$total_page." หน้า";
// 	echo " จำนวนรายการต่อหน้า <input name = 'nrec' type='text' value = $p_size size = 3/>";
// 	echo "<input name = 'showPage' type='submit' value='show' />";
// 	echo "<input name = 'firstPage' type='submit' value='<<first' />";
// 	echo "<input name = 'prePage' type='submit' value='<previous' />";
// 	echo "<input name = 'nextPage' type='submit' value='next>' />";
// 	echo "<input name = 'lastPage' type='submit' value='last>>' />";

// 	echo "</form>";
// echo "</td></tr>";
//end navigation bar	

// echo "<tr><td colspan='11'><a href='insertPatientForm.php'>Add New Patient</a></td></tr>";
$conn->close();
?>
</body>
</html>