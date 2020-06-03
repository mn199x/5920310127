<!DOCTYPE html>
<html>
<head>
<title>Report of years</title>
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

	$sql = "SELECT SUBSTRING(bkdate,1,4) as yyyy, SUBSTRING(bkdate,6,2) as mm, SUM(numpgr) as nb ,sum(numpgr*timeslot.price) as pr
			FROM book,timeslot
			WHERE timeslot.slotid=book.slotid AND book.bstatus='1'
			GROUP BY yyyy,mm";
	// echo $sql;
	$result = $conn->query($sql);
	
	// $sexs = array();
	// $sexs[0]="ไม่ระบุ";$sexs[1]="ชาย";$sexs[2]="หญิง";
		
	//the beginning of summary table 	
	echo "<div>";
    echo "<h2 style='color: #001a4d'>สรุปแต่ละปี</h2>";
    echo "<h3 style='color: #001a4d'>จำแนกตาม คนใช้บริการในแต่ละเที่ยวรถและเงินที่ได้</h3>";
	echo "<table class='table'>";
	echo "<tr style='background-color:#DCDCDC'><th>ปี</th><th>จำนวนคนที่จอง</th><th>จำนวนเงินที่ได้</th></tr>";
	
	$sum=0;
	$sum1=0;
	$sum2=0;
	//loop to read each record and then add to array data
	while($rw = $result->fetch_assoc()){ 
		$yyyy = $rw['yyyy'];
		$mm = $rw['mm'];
		$nb = $rw['nb'];
		$pr = $rw['pr'];	
		echo "<tr>";
			if($mm=='01'){
				echo "<td> ".$yyyy." มกราคม </td>";
			}else if($mm=='02'){
				echo "<td>  ".$yyyy." กุมภาพันธ์ </td>";
			}else if($mm=='03'){
				echo "<td> ".$yyyy." มีนาคม </td>";
			}else if($mm=='04'){
				echo "<td> ".$yyyy." เมษายน </td>";
			}else if($mm=='05'){
				echo "<td> ".$yyyy." พฤษภาคม </td>";
			}else if($mm=='06'){
				echo "<td> ".$yyyy." มิถุนายน </td>";
			}else if($mm=='07'){
				echo "<td> ".$yyyy." กรกฎาคม </td>";
			}else if($mm=='08'){
				echo "<td> ".$yyyy." สิงหาคม </td>";
			}else if($mm=='09'){
				echo "<td> ".$yyyy." กันยายน </td>";
			}else if($mm=='10'){
				echo "<td> ".$yyyy." ตุลาคม </td>";
			}else if($mm=='11'){
				echo "<td> ".$yyyy." พฤษจิกายน </td>";
			}else{
				echo "<td> ".$yyyy." ธันวาคม </td>";
			}
			// echo "<td>".$yyyy." ".$mm."</td>";
			echo "<td>".number_format($nb)."</td>";
			echo "<td>".number_format($pr)."</td>";
			// echo "<td>".number_format($cid)."</td>";
			// echo "<td>".number_format($pr)."</td>";
			echo "</tr>";
			
			$sum1=$sum1+($nb);
			$sum2=$sum2+($pr);
	}
	echo "<tr style='background-color:#DCDCDC'><th colspan='4'>จำนวนผู้ใช้บริการทั้งหมด ".$sum1." และผลรวมเงินทั้งหมด ".number_format($sum2)." บาท</th></tr>";
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