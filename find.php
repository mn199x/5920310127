<!doctype html>

<html>
<head>
<title>Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="hospital-icon.png">
<style>
	/* table {
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
	} */
</style>
<script>
function clr() {
	  document.forms["search"]["bkdate"].value="";
    //   document.forms["searchfrm"]["ptnme"].value="";
    //   document.forms["searchfrm"]["ptsnme"].value="";
	//   document.forms["searchfrm"]["gender"].value="";
	//   document.forms["searchfrm"]["dob"].value="";
	//   document.forms["searchfrm"]["email"].value="";
	//   document.forms["searchfrm"]["nat"].value="";
	//   document.forms["searchfrm"]["bldgrp"].value="";
	}
</script>	
</head>
<body>

<?php
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
//constant value of genders
// s
function getAge($dte) { //the function used for computing age, based on the birthdate
		return intval(date('Y', time() - strtotime($dte))) - 1970;
}
function shwThaiDate($dte) { //where $dte is a Date format
	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
}
$bldgrp	=$_POST['bldgrp'];

//count all patients from database
	$sql = "SELECT SUBSTRING(bkdate,1,7) as yyyy , timeslot.slotid,frm_to ,t_start,SUM(book.numpgr*price) as pr 
			FROM book,timeslot 
			WHERE bkdate LIKE '%$search%' AND book.bstatus='1' AND timeslot.slotid=book.slotid ";
	// echo $sql;
	if($yyyy !="")
		$sql = $sql." AND bkdate LIKE '%$yyyy%' ";

		$result = $conn->query($sql);
	
		$numfound = $result->num_rows; //return the number of records

	echo "<center>";
	
	echo "<form action='find.php' method='post' name='search'>";
	echo "<label for='search'>ค้นหาปีหรือเดือน: </label>";
	echo "<input type='text' size='50%'  name='search' placeholder='กรุณาป้อนเดือนหรือปี' />";
	echo "<input type='submit' value='ค้นหา' />";
	echo "</form>";
	echo "</center>";

	// $search = $_POST[search];
	// 	if(isset($search) ) {
	// 		echo "<font size='-1' color='#FF0000'>ผลลัพธ์ของคำว่า [ $search ] </font><br />";
	
// show all records satisfied	
echo "<h2 style='color: #001a4d'>ค้นหา</h2>";
echo "<table class='table'>";
echo "<tr style='background-color:#DCDCDC'>";
echo "<th>วันที่</th>";
// echo "<th>From-To</th>";
// echo "<th>Time slot</th>";
echo "<th>จำนวนคนใช้บริการ</th>";
echo "<th>จำนวนเงินที่ได้</th>";
echo "</tr>";

$search = $_POST[search];
		if(isset($search) ) {
			echo "<font size='-1' color='#FF0000'>ผลลัพธ์ของคำว่า [ $search ] </font><br />";
			echo "<font size='-1' color='green'>ค้นพบทั้งหมด :: [ $numfound ] </font><br/>";

	$sql = "SELECT SUBSTRING(bkdate,1,7) as yyyy, SUM(book.numpgr) as nb , timeslot.slotid,frm_to ,t_start,SUM(book.numpgr*price) as pr 
			FROM book,timeslot 
			WHERE bkdate LIKE '%$search%' AND book.bstatus='1' AND timeslot.slotid=book.slotid";
			// echo $sql;
			$sum1=0;
			$sum2=0;
	//run the query $sql
	$result = $conn->query($sql);
	while ($rw = $result->fetch_assoc()) {
		$sid = $rw['slotid'];
		$yyyy = $rw['yyyy'];
		$ft = $rw['frm_to'];
		$ts = $rw['t_start'];
		$pr = $rw['pr'];
		$nb = $rw['nb'];	

		echo "<tr>";
		echo "<td>".$yyyy."</td>";
		// echo "<td>".$ft."</td>";
		// echo "<td>".$ts."</td>";
		echo "<td>".number_format($nb)."</td>";
		echo "<td>".number_format($pr)."</td>";
		echo "</tr>";
		$sum1=$sum1+($nb);
		$sum2=$sum2+($pr);
	} 
	echo "<tr style='background-color:#DCDCDC'><th colspan='4'>จำนวนผู้ใช้บริการทั้งหมด ".number_format($sum1)." และผลรวมเงินทั้งหมด ".number_format($sum2)." บาท</th></tr>";
}else {
	echo "กรุณากรอกคำค้นของคุณ";
	}
echo "</table>";
$conn->close();
echo "<div>";
	echo "<br>Generated: ".date('d-m')."-".(date('Y'));
	echo "<br>C-SIAM System @ 2020 ";
	echo "<br>by mn199x";
	echo "</div>";
?>

</body>
</html>