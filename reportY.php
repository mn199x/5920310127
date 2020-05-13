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

	$sql = "SELECT SUBSTRING(bkdate,1,7) as yyyy, SUM(numpgr) as nb ,sum(numpgr*timeslot.price) as pr
			FROM book,timeslot
			WHERE timeslot.slotid=book.slotid AND book.bstatus='1'
			GROUP BY yyyy";
	
	$result = $conn->query($sql);
	
	// $sexs = array();
	// $sexs[0]="ไม่ระบุ";$sexs[1]="ชาย";$sexs[2]="หญิง";
		
	//the beginning of summary table 	
	echo "<div>";
    echo "<h2 style='color: #001a4d'>สรุปแต่ละปี</h2>";
    echo "<h3 style='color: #001a4d'>จำแนกตาม ปีและคนใช้บริการใน</h3>";
	echo "<table class='table'>";
	echo "<tr style='background-color:#DCDCDC'><th>ปี</th><th>จำนวนคนที่จอง</th><th>จำนวนเงินที่ได้</th></tr>";
	
	$sum=0;
	$sum1=0;
	$sum2=0;
	//loop to read each record and then add to array data
	while($rw = $result->fetch_assoc()){ 
		$yyyy = $rw['yyyy'];
		$nb = $rw['nb'];
		$pr = $rw['pr'];	
		echo "<tr>";
			echo "<td>".$yyyy."</td>";
			echo "<td>".number_format($nb)."</td>";
			echo "<td>".number_format($pr)."</td>";
			// echo "<td>".number_format($cid)."</td>";
			// echo "<td>".number_format($pr)."</td>";
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