<!DOCTYPE html>
<html>
<head>
<title>Report of month</title>
<meta http-equiv="content-type" content="text/html; charset=utf8"/>
<!-- <style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #002b80;
    color: white;
}
</style> -->
</head>
<body>
<?php
	session_start();
	include "menu.php";
	include "dbconnect.php";
	date_default_timezone_set("Asia/Bangkok");

	$sql = "SELECT SUBSTRING(bkdate,6,2) as mm, sum(numpgr) as nb ,sum(numpgr*timeslot.price) as pr
			FROM book,timeslot
			WHERE timeslot.slotid=book.slotid AND book.bstatus='1'
			GROUP BY mm";
	
	$result = $conn->query($sql);
	
		
	//the beginning of summary table 	
	echo "<div>";
    echo "<h2 style='color: #001a4d'>สรุปแต่ละเดือน</h2>";
    echo "<h3 style='color: #001a4d'>จำแนกตาม คนใช้บริการในแต่ละเที่ยวรถและเงินที่ได้</h3>";
	echo "<table class='table'>";
	echo "<tr style='background-color:#DCDCDC'><th>เดือน</th><th>จำนวนคนที่จอง</th><th>จำนวนเงินที่ได้</th></tr>";
	
	$sum1=0;
	$sum2=0;
	//loop to read each record and then add to array data
	while($rw = $result->fetch_assoc()){ 
		$mm = $rw['mm'];
		$nb = $rw['nb'];
		$pr = $rw['pr'];		
		echo "<tr>";
				if($mm=='01'){
					echo "<td> มกราคม </td>";
				}else if($mm=='02'){
					echo "<td> กุมภาพันธ์ </td>";
				}else if($mm=='03'){
					echo "<td> มีนาคม </td>";
				}else if($mm=='04'){
					echo "<td> เมษายน </td>";
				}else if($mm=='05'){
					echo "<td> พฤษภาคม </td>";
				}else if($mm=='06'){
					echo "<td> มิถุนายน </td>";
				}else if($mm=='07'){
					echo "<td> กรกฎาคม </td>";
				}else if($mm=='08'){
					echo "<td> สิงหาคม </td>";
				}else if($mm=='09'){
					echo "<td> กันยายน </td>";
				}else if($mm=='10'){
					echo "<td> ตุลาคม </td>";
				}else if($mm=='11'){
					echo "<td> พฤษจิกายน </td>";
				}else{
					echo "<td>ธันวาคม </td>";
				}
			echo "<td>".number_format($nb)."</td>";
			echo "<td>".number_format($pr)."</td>";
			echo "</tr>";
			$sum1=$sum1+($nb);
			$sum2=$sum2+($pr);
	}

	echo "<tr style='background-color:#DCDCDC'><th colspan='4'>จำนวนผู้ใช้บริการทั้งหมด ".$sum1." และผลรวมเงินทั้งหมด ".$sum2." บาท</th></tr>";
	// echo "<tr style='background-color:#DCDCDC'>";
	// while($rw = $result->fetch_assoc()){ 
	// 	$pr = $rw['pr'];
	// 	$totale=(sum)($pr); 		
	// 	echo "<tr>";
	// 		echo "<td colspan='4'>ผลรวมเงินทั้งหมด ".$totale." บาท</td>";
	// 		echo "</tr>";
	// 	// $pnt = $nt;
	// }
	echo "</table>";
    echo "</div>";
	
	//report footer
	echo "<div>";
	echo "<br>Generated: ".date('d-m')."-".(date('Y'));
	echo "<br>C-SIAM System @ 2020 ";
	echo "<br>by mn199x";
	echo "</div>";
	
?>
</body>
</html>