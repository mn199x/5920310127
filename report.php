<!DOCTYPE html>
<html>
<head>
<title>All</title>
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

	$sql = "SELECT SUM(book.numpgr) as nb ,timeslot.slotid,frm_to ,t_start,SUM(book.numpgr*price) as pr
	FROM book,timeslot
	WHERE timeslot.slotid=book.slotid AND book.bstatus='1'
	GROUP BY slotid ORDER BY timeslot.t_start ASC";
	
	
	$result = $conn->query($sql);
	
	// $sexs = array();
	// $sexs[0]="ไม่ระบุ";$sexs[1]="ชาย";$sexs[2]="หญิง";
		
	//the beginning of summary table 	
	echo "<div>";
    echo "<h2 style='color: #001a4d'>สรุปจำนวนทั้งหมด</h2>";
    echo "<h3 style='color: #001a4d'>จำแนกตาม คนใช้บริการในแต่ละเที่ยวรถและเงินที่ได้</h3>";
	echo "<table class='table'>";
	echo "<tr style='background-color:#DCDCDC'><th>From-to</th><th>Time Slot</th><th>จำนวนคนใช้บริการ</th><th>จำนวนเงินที่ได้</th></tr>";
	
	$sum=0;
	//loop to read each record and then add to array data
	while($rw = $result->fetch_assoc()){ 
		$sid = $rw['slotid'];
		$ft = $rw['frm_to'];
		$ts = $rw['t_start'];
		$pr = $rw['pr'];
		$nb = $rw['nb'];		
		echo "<tr>";
			echo "<td>".$ft."</td>";
			echo "<td>".$ts."</td>";
			echo "<td>".number_format($nb)."</td>";
			echo "<td>".number_format($pr)."</td>";
			echo "</tr>";
		// $pnt = $nt;
		$sum=$sum+$pr;
	}
	echo "<tr style='background-color:#DCDCDC'><th colspan='4'>ผลรวมเงินทั้งหมด ".$sum." บาท </th></tr>";
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