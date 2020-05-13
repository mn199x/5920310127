<?php
	//including file connection
    include "dbconnect.php"; //return connection $conn
	//include "menu.php"; //including menu

    if(isset($_POST['register'])){ //in case of insertion
   
		$cnme		=$_POST['nme'];
		$csurnme	=$_POST['snme'];
		$c_email 	=$_POST['email'];
		$pswd 		=$_POST['pwd'];
		$conpswd 	=$_POST['conpwd'];
		$csex 		=$_POST['sex'];
		$ctel 		=$_POST['tel'];

		if($pswd!=$conpswd){
			echo "<script>
				  alert('Passwords do not match !');
				  window.history.back();
				  </script>";
		}

		//$passwd	= "123456";	//set default password, instead of getting from the register form //$_POST['passwd'];
		//auto-generated email instead of fixing as above, however this password must be sent to the user via the email given, see sending mail in insertPatient
		//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		//$passwd = substr( str_shuffle( $chars ), 0, 8 ); //8 คือความยาวของพาสเวิร์ด str_shuffle คือ ฟังก์ชันในการซุ่มสลับค่าอักขระใน chars แล้วตัดมา 8 อักขระ

		$enpwd = hash('sha256', $pswd);

		if($c_email==""){ //check empty email          		
			echo "<script>
				  alert('Invalid email: empty !');
				  window.history.back();
				  </script>";	
			return;			
	 	}
		//check repeated email
		$sql = "Select * From cust Where c_email='$c_email'";
		$rs = mysqli_query($conn,$sql);
		if($rs->num_rows>0){ //meaning repeated email          		
              echo "<script>
					alert('Repeated email address!');
					window.history.back();
					</script>";				
		}else{//not repeated, can insert 

			//the order of such field must be matched the order of each field in the database
			// $sql = "INSERT INTO patients (ptid, ptnme, ptsnme, tel, email, pid, addr, dob, gender, bldgrp, natid, passwd, pic) 
			// 					VALUES 	 ('$ptid','$fname','$lname','$tel','$email','$pid','$addr','$dob','$gender','$bldgrp','$natid','$enpwd','$pic')";
			$sql= "INSERT INTO cust (cusid, cnme, csurnme, c_email, pswd, csex,	ctel)
								VALUES 	 ('$cusid', '$cnme', '$csurnme', '$c_email', '$enpwd', '$csex',	'$ctel')";
			$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
			
			if($rs){ //กรณีสามารถรัน sql ผ่าน //หรือ if(mysqli_query($conn,$sql)) //meaning no error 
				//add sending confirmation email to the patient via the email given
				//จำเป็นต้อง download และติดตั้งโฟลเดอร์ PHPMailer ในโฟล์เดอร์เดียวกับไฟล์ operations.php นี้
				//และผู้พัฒนาหรือหน่วยงานจะต้องมี gmail ไว้สำหรับรับส่งเมล์ (แนะนำลงทะเบียนใหม่)
				///BEGIN send mail ****************************************************************
				require_once('PHPMailer/PHPMailerAutoload.php');
				$mail = new PHPMailer(); //สร้างอ็อบเจกต์สำหรับรับส่งเมล์
				$mail->IsHTML(true);	//กำหนดการส่งในรูปแบบไฟล์ HTML เป็นจริง
				$mail->IsSMTP();	//Protocal ที่ใช้ในการรับ-เมล์
				$mail->SMTPAuth = true; // enable SMTP authentication
				$mail->SMTPSecure = ""; // sets the prefix to the servier
				$mail->Host = "ssl://smtp.gmail.com"; // sets GMAIL as the SMTP server
				$mail->Port = 465; // set the SMTP port for the GMAIL server
				$mail->Username = "csiampattani2@gmail.com"; // GMAIL username, อีเมล์นี้ใช้เป็นต้นทางในการส่งผ่าน gmail ควรลงทะเบียนใหม่ และใช้พาสเวิร์ดเฉพาะ
				$mail->Password = "csiam1234"; // GMAIL password
				//$mail->From = "healthcare.register@gmail.com"; // "name@yourdomain.com"; อีเมล์นี้จะแสดงในช่อง from
				//$mail->AddReplyTo = "healthcare.register@gmail.com"; // Reply ที่อยู่เมล์ที่จะส่งกลับหาก ฝั่งรับต้องการตอบกลับ

				$mail->FromName = "C-saim System";  // set from Name
				$mail->Subject = "C-saim: Registration Confirm"; //email subject
				
				//formulate the body of email สร้างข้อความที่จะส่งไปกับอีเมล์ ในที่นี้คือ ต้องการส่ง username กับ password ที่ถูก generated
				//ไปให้กับ patient ผ่านทางอีเมล์ของผู้ป่วยที่ระบุ โดยผู้รับเมล์จะต้องคลิกลิงค์ที่ส่งไปด้วยเพื่อดำเนินการ activate 
				//อย่างไรก็ตามข้อจำกัดของระบบนี้ อยู่บนสมมติฐานที่ว่าการลงทะเบียน บังคับว่าจะต้องมี email ซึ่งในทางปฏิบัติเป็นไปไม่ได้ทั้งหมดกับระบบงานโรงพยาบาล
				//แต่ใช้งานได้ดีกับระบบอื่นที่ มีเงื่อนไขว่าสมาชิกที่จะลงทะเบียนได้ต้องมีอีเมล์ เช่น facebook หรือ webapp อื่น ๆ

				$mail->Body = "Dear $fname $lname
				
							<br>You have successfully registered for the C-saim System <br>
							    Your username and password are below
							   
							<br><br>username: $c_email
							<br><br>password: $pswd <br><br>
							
							<br><br>
							<b>*** This is an automatically generated email. please do not reply. *** <br><br></b>
						
							<b>If you have any inquiry, please contact.</b> <br>
							Phone : +66 082 822 1388 <br>
							<br><br>
						
							<b>More information</b> <br>
							Facebook : https://www.facebook.com/ซี-สยาม-แทรแวล-รถเช่ารายวันปัตตานี-350630588451804<br>";
				
				
				$mail->AddAddress($c_email); // to email address
				// $mail->AddBCC("muna.14474@gmail.com"); //add Bcc email, if required
				
				if($mail->Send()) //call the method to send this mail
				{
					//the script shown after sending mail completed
					echo 
						"<script>
							window.alert('You have successfully registered, please check your email box. ');
							window.location.href='login.php';
							</script>"; 
					
				}else{
					//delete the previous inserted rec if cannot send email
					$sql = "DELETE FROM  cust WHERE cusid = '$cusid'";
					$conn->query($sql);
					//show message: invalid email 
					"<script>".
							"window.alert('NOT successfully registered, invalid email address.');".
					"</script>"; 
				}
				///END send mail ***************************************************************

			}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
				
				echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
			}
		}
    }//end insertion
	else if(isset($_POST['updateCust'])){ //in case of update

		$cusid		=$_POST['id'];
        $cnme		=$_POST['nme'];
		$csurnme	=$_POST['snme'];
		$csex		=$_POST['sex'];
		$ctel 		=$_POST['tel'];
		$c_email 	=$_POST['email'];
		

		//incase of updating normally without updating pic
			$sql = "UPDATE cust SET cnme='$cnme', csurnme='$csurnme',csex ='$csex', ctel ='$ctel', c_email = '$c_email' WHERE cusid='$cusid'";
	
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
	
			if($utype==1) //staff/admin
				echo "<script>
							alert('Updated successful JA');
							window.location.href='showCust.php';
					</script>";
			else if($utype==3) //if patient
				echo "<script>
						alert('Updated successful JA');
						window.location.href='menu.php';
					</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}
	else if(isset($_POST['insertSTF'])){ //in case of insertion
			// $id	=$_POST['id'];
			$stfnme	=$_POST['nme'];
			$stfsurnme		=$_POST['snme'];
			$s_email 	=$_POST['email'];
			// $pswd 	=$_POST['pwd'];
			$stfsex 	=$_POST['sex'];
			$stftel 	=$_POST['tel'];
	
			//$passwd	= "123456";	//set default password, instead of getting from the register form //$_POST['passwd'];
			//auto-generated email instead of fixing as above, however this password must be sent to the user via the email given, see sending mail in insertPatient
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$passwd = substr( str_shuffle( $chars ), 0, 8 ); //8 คือความยาวของพาสเวิร์ด str_shuffle คือ ฟังก์ชันในการซุ่มสลับค่าอักขระใน chars แล้วตัดมา 8 อักขระ
	
			$enpwd = hash('sha256', $passwd);
	
			if($s_email==""){ //check empty email          		
				echo "<script>
					  alert('Invalid email: empty !');
					  window.history.back();
					  </script>";	
				return;			
			 }
			//check repeated email
			$sql = "Select * From staff Where s_email ='s_email '";
 			$rs = mysqli_query($conn,$sql);
			if($rs->num_rows>0){ //meaning repeated email          		
				  echo "<script>
						alert('Repeated email address!');
						window.history.back();
						</script>";				
			}else{//not repeated, can insert 
	
				//the order of such field must be matched the order of each field in the database
				// $sql = "INSERT INTO patients (ptid, ptnme, ptsnme, tel, email, pid, addr, dob, gender, bldgrp, natid, passwd, pic) 
				// 					VALUES 	 ('$ptid','$fname','$lname','$tel','$email','$pid','$addr','$dob','$gender','$bldgrp','$natid','$enpwd','$pic')";
				$sql= "INSERT INTO staff (stfnme, stfsurnme, s_email, pswd, stfsex, stftel)
									VALUES ('$stfnme', '$stfsurnme', '$s_email', '$enpwd', '$stfsex',	'$stftel')";
				$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
				if($rs){ //กรณีสามารถรัน sql ผ่าน //หรือ if(mysqli_query($conn,$sql)) //meaning no error 
					//add sending confirmation email to the patient via the email given
					//จำเป็นต้อง download และติดตั้งโฟลเดอร์ PHPMailer ในโฟล์เดอร์เดียวกับไฟล์ operations.php นี้
					//และผู้พัฒนาหรือหน่วยงานจะต้องมี gmail ไว้สำหรับรับส่งเมล์ (แนะนำลงทะเบียนใหม่)
					///BEGIN send mail ****************************************************************
					require_once('PHPMailer/PHPMailerAutoload.php');
					$mail = new PHPMailer(); //สร้างอ็อบเจกต์สำหรับรับส่งเมล์
					$mail->IsHTML(true);	//กำหนดการส่งในรูปแบบไฟล์ HTML เป็นจริง
					$mail->IsSMTP();	//Protocal ที่ใช้ในการรับ-เมล์
					$mail->SMTPAuth = true; // enable SMTP authentication
					$mail->SMTPSecure = ""; // sets the prefix to the servier
					$mail->Host = "ssl://smtp.gmail.com"; // sets GMAIL as the SMTP server
					$mail->Port = 465; // set the SMTP port for the GMAIL server
					$mail->Username = "csiampattani2@gmail.com"; // GMAIL username, อีเมล์นี้ใช้เป็นต้นทางในการส่งผ่าน gmail ควรลงทะเบียนใหม่ และใช้พาสเวิร์ดเฉพาะ
					$mail->Password = "csiam1234"; // GMAIL password
					//$mail->From = "healthcare.register@gmail.com"; // "name@yourdomain.com"; อีเมล์นี้จะแสดงในช่อง from
					//$mail->AddReplyTo = "healthcare.register@gmail.com"; // Reply ที่อยู่เมล์ที่จะส่งกลับหาก ฝั่งรับต้องการตอบกลับ
	
					$mail->FromName = "C-saim System";  // set from Name
					$mail->Subject = "C-saim: Registration Confirm"; //email subject
					
					//formulate the body of email สร้างข้อความที่จะส่งไปกับอีเมล์ ในที่นี้คือ ต้องการส่ง username กับ password ที่ถูก generated
					//ไปให้กับ patient ผ่านทางอีเมล์ของผู้ป่วยที่ระบุ โดยผู้รับเมล์จะต้องคลิกลิงค์ที่ส่งไปด้วยเพื่อดำเนินการ activate 
					//อย่างไรก็ตามข้อจำกัดของระบบนี้ อยู่บนสมมติฐานที่ว่าการลงทะเบียน บังคับว่าจะต้องมี email ซึ่งในทางปฏิบัติเป็นไปไม่ได้ทั้งหมดกับระบบงานโรงพยาบาล
					//แต่ใช้งานได้ดีกับระบบอื่นที่ มีเงื่อนไขว่าสมาชิกที่จะลงทะเบียนได้ต้องมีอีเมล์ เช่น facebook หรือ webapp อื่น ๆ
	
					$mail->Body = "Dear $stfnme $stfsurnme
					
								<br>You have successfully registered for the C-saim System <br>
									Your username and password are below
								   
								<br><br>username: $s_email
								<br><br>password: $passwd <br><br>
								
								<br><br>
								<b>*** This is an automatically generated email. please do not reply. *** <br><br></b>
						
								<b>If you have any inquiry, please contact.</b> <br>
								Phone : +66 082 822 1388 <br>
								<br><br>
						
								<b>More information</b> <br>
								Facebook : https://www.facebook.com/ซี-สยาม-แทรแวล-รถเช่ารายวันปัตตานี-350630588451804<br>";
					
					$mail->AddAddress($s_email); // to email address
					$mail->AddBCC("muna.14474@gmail.com"); //add Bcc email, if required
					
					if($mail->Send()) //call the method to send this mail
					{
						//the script shown after sending mail completed
						echo 
							"<script>
								window.alert('You have successfully registered, please check your email box. ');
								window.location.href='login.php';
							</script>"; 
					}else{
						//delete the previous inserted rec if cannot send email
						$sql = "DELETE FROM  staff WHERE stfid = '$stfid'";
						$conn->query($sql);
						//show message: invalid email 
						"<script>".
								"window.alert('NOT successfully registered, invalid email address.');".
						"</script>"; 
					}
					///END send mail ***************************************************************
	
				}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
					
					echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
				}
			}
		}else if(isset($_POST['updateStf'])){ //in case of update

			$stfid		=$_POST['id'];
			$stfnme		=$_POST['nme'];
			$stfsurnme	=$_POST['snme'];
			$stfsex		=$_POST['sex'];
			$stftel 	=$_POST['tel'];
			$s_email 	=$_POST['email'];
			
	
			//incase of updating normally without updating pic
				$sql = "UPDATE staff SET stfnme='$stfnme', stfsurnme='$stfsurnme',stfsex ='$stfsex', stftel ='$stftel', s_email = '$s_email' WHERE stfid='$stfid'";
		
			if ($conn->query($sql) === TRUE) {
				//"Record updated successfully" and redirect to the menu
				session_start();//start session
				$id = $_SESSION['valid_id'];	
				$utype = $_SESSION['valid_utype'];
		
				if($utype==1) //staff/admin
					echo "<script>
								alert('Updated successful JA');
								window.location.href='showSTF.php';
						</script>";
				
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}else if(isset($_POST['insertDRV'])){ //in case of insertion
			// $id	=$_POST['id'];
			$dnme		=$_POST['nme'];
			$dsurnme	=$_POST['snme'];
			$d_email 	=$_POST['email'];
			// $pswd 	=$_POST['pwd'];
			$dsex	 	=$_POST['sex'];
			$dtel	 	=$_POST['tel'];
			$d_add	 	=$_POST['add'];
			$drvlics 	=$_POST['drl'];
			$expdrv	 	=$_POST['exp'];
			$idcard	 	=$_POST['idcard'];

			//$passwd	= "123456";	//set default password, instead of getting from the register form //$_POST['passwd'];
			//auto-generated email instead of fixing as above, however this password must be sent to the user via the email given, see sending mail in insertPatient
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$passwd = substr( str_shuffle( $chars ), 0, 8 ); //8 คือความยาวของพาสเวิร์ด str_shuffle คือ ฟังก์ชันในการซุ่มสลับค่าอักขระใน chars แล้วตัดมา 8 อักขระ
	
			$enpwd = hash('sha256', $passwd);
	
			if($d_email==""){ //check empty email          		
				echo "<script>
					  alert('Invalid email: empty !');
					  window.history.back();
					  </script>";	
				return;			
			 }
			//check repeated email
			$sql = "Select * From driver Where d_email ='d_email '";
 			$rs = mysqli_query($conn,$sql);
			if($rs->num_rows>0){ //meaning repeated email          		
				  echo "<script>
						alert('Repeated email address!');
						window.history.back();
						</script>";				
			}else{//not repeated, can insert 
	
				//the order of such field must be matched the order of each field in the database
				// $sql = "INSERT INTO patients (ptid, ptnme, ptsnme, tel, email, pid, addr, dob, gender, bldgrp, natid, passwd, pic) 
				// 					VALUES 	 ('$ptid','$fname','$lname','$tel','$email','$pid','$addr','$dob','$gender','$bldgrp','$natid','$enpwd','$pic')";
				$sql= "INSERT INTO driver (dnme, dsurnme, d_email, pswd, dsex, dtel, d_add, drvlics, expdrv, idcard)
									VALUES ('$dnme', '$dsurnme', '$d_email', '$enpwd', '$dsex',	'$dtel', '$d_add', '$drvlics', '$expdrv','$idcard')";
				$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
				if($rs){ //กรณีสามารถรัน sql ผ่าน //หรือ if(mysqli_query($conn,$sql)) //meaning no error 
					//add sending confirmation email to the patient via the email given
					//จำเป็นต้อง download และติดตั้งโฟลเดอร์ PHPMailer ในโฟล์เดอร์เดียวกับไฟล์ operations.php นี้
					//และผู้พัฒนาหรือหน่วยงานจะต้องมี gmail ไว้สำหรับรับส่งเมล์ (แนะนำลงทะเบียนใหม่)
					///BEGIN send mail ****************************************************************
					require_once('PHPMailer/PHPMailerAutoload.php');
					$mail = new PHPMailer(); //สร้างอ็อบเจกต์สำหรับรับส่งเมล์
					$mail->IsHTML(true);	//กำหนดการส่งในรูปแบบไฟล์ HTML เป็นจริง
					$mail->IsSMTP();	//Protocal ที่ใช้ในการรับ-เมล์
					$mail->SMTPAuth = true; // enable SMTP authentication
					$mail->SMTPSecure = ""; // sets the prefix to the servier
					$mail->Host = "ssl://smtp.gmail.com"; // sets GMAIL as the SMTP server
					$mail->Port = 465; // set the SMTP port for the GMAIL server
					$mail->Username = "csiampattani2@gmail.com"; // GMAIL username, อีเมล์นี้ใช้เป็นต้นทางในการส่งผ่าน gmail ควรลงทะเบียนใหม่ และใช้พาสเวิร์ดเฉพาะ
					$mail->Password = "csiam1234"; // GMAIL password
					//$mail->From = "healthcare.register@gmail.com"; // "name@yourdomain.com"; อีเมล์นี้จะแสดงในช่อง from
					//$mail->AddReplyTo = "healthcare.register@gmail.com"; // Reply ที่อยู่เมล์ที่จะส่งกลับหาก ฝั่งรับต้องการตอบกลับ
	
					$mail->FromName = "C-saim System";  // set from Name
					$mail->Subject = "C-saim: Registration Confirm"; //email subject
					
					//formulate the body of email สร้างข้อความที่จะส่งไปกับอีเมล์ ในที่นี้คือ ต้องการส่ง username กับ password ที่ถูก generated
					//ไปให้กับ patient ผ่านทางอีเมล์ของผู้ป่วยที่ระบุ โดยผู้รับเมล์จะต้องคลิกลิงค์ที่ส่งไปด้วยเพื่อดำเนินการ activate 
					//อย่างไรก็ตามข้อจำกัดของระบบนี้ อยู่บนสมมติฐานที่ว่าการลงทะเบียน บังคับว่าจะต้องมี email ซึ่งในทางปฏิบัติเป็นไปไม่ได้ทั้งหมดกับระบบงานโรงพยาบาล
					//แต่ใช้งานได้ดีกับระบบอื่นที่ มีเงื่อนไขว่าสมาชิกที่จะลงทะเบียนได้ต้องมีอีเมล์ เช่น facebook หรือ webapp อื่น ๆ
	
					$mail->Body = "Dear $dnme $dsurnme
					
								<br>You have successfully registered for the C-saim System <br>
									Your username and password are below
								   
								<br><br>username: $d_email
								<br><br>password: $passwd <br><br>
								
								<br><br>
								<b>*** This is an automatically generated email. please do not reply. *** <br><br></b>
							
								<b>If you have any inquiry, please contact.</b> <br>
								Phone : +66 082 822 1388 <br>
								<br><br>
							
								<b>More information</b> <br>
								Facebook : https://www.facebook.com/ซี-สยาม-แทรแวล-รถเช่ารายวันปัตตานี-350630588451804<br>";
					
					
					$mail->AddAddress($s_email); // to email address
					$mail->AddBCC("muna.14474@gmail.com"); //add Bcc email, if required
					
					if($mail->Send()) //call the method to send this mail
					{
						//the script shown after sending mail completed
						echo 
							"<script>
								window.alert('You have successfully registered, please check your email box. ');
								window.location.href='showDRV.php';
							</script>"; 
							 
					}else{
						//delete the previous inserted rec if cannot send email
						$sql = "DELETE FROM driver WHERE drvid = '$drvid'";
						$conn->query($sql);
						//show message: invalid email 
						"<script>".
								"window.alert('NOT successfully registered, invalid email address.');".
						"</script>"; 
					}
					///END send mail ***************************************************************
	
				}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
					
					echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
				}
			}
		}else if(isset($_POST['updateDrv'])){ //in case of update

			$drvid		=$_POST['id'];
			$dnme		=$_POST['nme'];
			$dsurnme	=$_POST['snme'];
			$dsex		=$_POST['sex'];
			$dtel 		=$_POST['tel'];
			$d_email 	=$_POST['email'];
			$d_add 		=$_POST['add'];
			$drvlics 	=$_POST['drl'];
			$expdrv 	=$_POST['exp'];
			$idcard 	=$_POST['idcard'];
	
			//incase of updating normally without updating pic
				$sql = "UPDATE driver SET dnme='$dnme', dsurnme='$dsurnme',dsex ='$dsex', dtel ='$dtel', d_email = '$d_email', d_add = '$d_add', drvlics = '$drvlics', expdrv = '$expdrv', idcard = '$idcard' WHERE drvid='$drvid'";
		
			if ($conn->query($sql) === TRUE) {
				//"Record updated successfully" and redirect to the menu
				session_start();//start session
				$id = $_SESSION['valid_id'];	
				$utype = $_SESSION['valid_utype'];
		
				if($utype==1) //staff/admin
					echo "<script>
								alert('Updated successful JA');
								window.location.href='showDRV.php';
						</script>";
				else if($utype==2) //if driver
						echo "<script>
								alert('Updated successful JA');
								window.location.href='menu.php';
							</script>";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}else if(isset($_POST['book'])){ //in case of insertion
			// $id	=$_POST['id'];


			$bkid		=$_POST['bid'];
			$bkdate		=$_POST['bdte'];
			$slotid 	=$_POST['slotid'];
			$lik 	=$_POST['lnk'];
			$numpgr	 	=$_POST['num'];
			$cusid	 	=$_POST['id'];
			$plcnme	 	=$_POST['place'];
			$con_nme 	=$_POST['nme'];
			$con_tel	 =$_POST['tel'];
			// $lat	 	=$_POST['lat'];
			// $lng	 	=$_POST['lng'];

			//CHECK seat available
			$sql = "SELECT sum(maxnum) as mx, sum(numbook) as nbk FROM dayscheduled WHERE schdate = '$bkdate' AND slotid= '$slotid' GROUP BY schdate,slotid";
			//mx=10
			$result = $conn->query($sql);
    		$row = $result->fetch_assoc();
			$mx=$row['mx'];
			$nbk=$row['nbk'];
			if($mx-$nbk<$numpgr){//case not available

				echo "<script>
				  alert('Not available, now only has ".($mx-$nbk)."  seats');
				  window.history.back();
				  </script>";
				return;
			}
		
			$sql2= "INSERT INTO book (bkid, cusid, slotid, plcnme, lik, bkdate, numpgr, con_nme, con_tel,bstatus) 
						VALUES ('$bkid', '$cusid', '$slotid','$plcnme','$lik','$bkdate', '$numpgr', '$con_nme', '$con_tel','1')";
				echo $sql2;
				$rs2 = mysqli_query($conn,$sql2); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
				if($rs2){
					echo 
							"<script>
								window.alert('You have Successfully');
								window.location.href='index.php';
							</script>"; 
				}else{ //กรณี รัน sql ไม่ผ่าน
					
					echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
				}

			$sql3 = "SELECT sum(maxnum) as mx, sum(numbook) as nbk , carid FROM dayscheduled WHERE schdate = '$bkdate' AND slotid= '$slotid' GROUP BY carid ";
    		// $result = $conn->query($sql3);
    		// $row = $result->fetch_assoc();
			
			//$nbk=$row['nbk'];
			$result = mysqli_query($conn,$sql3);
			if($result->num_rows==1){ //me
				$row = $result->fetch_assoc();
				$carid=$row['carid'];
				$mx=$row['mx'];
				$nbk=$row['nbk'];
				$nbk = $nbk + $numpgr;
				$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
				$result = $conn->query($sql4);
			// }else if($result->num_rows>1){
			// 	$row = $result->fetch_assoc();
			// 	$carid=$row['carid'];
			// 	$mx=$row['mx'];
			// 	$nbk=$row['nbk'];
			// 	if($mx-$nbk>$numpgr){
			// 		$nbk = $nbk + $numpgr;
			// 		$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
			// 		$result = $conn->query($sql4);
			// 	}else{
			// 		$row = $result->fetch_assoc();
			// 		$carid=$row['carid'];
			// 		$mx=$row['mx'];
			// 		$nbk=$row['nbk'];
			// 		$nbk = $nbk + $numpgr;
			// 		$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
			// 		$result = $conn->query($sql4);
			// 	}

			}


			mysqli_close($conn);
				
		}else if(isset($_POST['bookSTF'])){ //in case of insertion
			// $id	=$_POST['id'];


			$bkid		=$_POST['bid'];
			$bkdate		=$_POST['bdte'];
			$slotid 	=$_POST['slotid'];
			// $pswd 	=$_POST['pwd'];
			$numpgr	 	=$_POST['num'];
			$cusid	 	=$_POST['id'];
			$plcnme	 	=$_POST['place'];
			$con_nme 	=$_POST['nme'];
			$con_tel	 =$_POST['tel'];
			// $lat	 	=$_POST['lat'];
			// $lng	 	=$_POST['lng'];

			//CHECK seat available
			$sql = "SELECT sum(maxnum) as mx, sum(numbook) as nbk FROM dayscheduled WHERE schdate = '$bkdate' AND slotid= '$slotid' GROUP BY schdate,slotid";
			// echo $sql;
			$result = $conn->query($sql);
    		$row = $result->fetch_assoc();
			$mx=$row['mx'];
			$nbk=$row['nbk'];
			if($mx-$nbk<$numpgr){//case not available

				echo "<script>
				  alert('Not available, now only has ".($mx-$nbk)."  seats');
				  window.history.back();
				  </script>";
				return;
			}
		
			$sql2= "INSERT INTO book (bkid, cusid, slotid, plcnme, bkdate, numpgr, con_nme, con_tel,bstatus) 
						VALUES ('$bkid', '$cusid', '$slotid', '$plcnme','$bkdate', '$numpgr', '$con_nme', '$con_tel','1')";
				// echo $sql;
				$rs2 = mysqli_query($conn,$sql2); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
				if($rs2){
					echo 
							"<script>
								window.alert('You have Successfully');
								window.location.href='index.php';
							</script>"; 
				}else{ //กรณี รัน sql ไม่ผ่าน
					
					echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
				}

			$sql3 = "SELECT sum(maxnum) as mx, sum(numbook) as nbk , carid FROM dayscheduled 
					WHERE schdate = '$bkdate' AND slotid= '$slotid' GROUP BY carid ";
    		// $result = $conn->query($sql3);
    		// $row = $result->fetch_assoc();
			
			//$nbk=$row['nbk'];
			$result = mysqli_query($conn,$sql3);
			if($result->num_rows==1){ //me
				$row = $result->fetch_assoc();
				$carid=$row['carid'];
				$mx=$row['mx'];
				$nbk=$row['nbk'];
				$nbk = $nbk + $numpgr;
				$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
				$result = $conn->query($sql4);
			// }else if($result->num_rows>1){
			// 	$row = $result->fetch_assoc();
			// 	$carid=$row['carid'];
			// 	$mx=$row['mx'];
			// 	$nbk=$row['nbk'];
			// 	if($mx-$nbk>$numpgr){
			// 		$nbk = $nbk + $numpgr;
			// 		$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
			// 		$result = $conn->query($sql4);
			// 	}else{
			// 		$row = $result->fetch_assoc();
			// 		$carid=$row['carid'];
			// 		$mx=$row['mx'];
			// 		$nbk=$row['nbk'];
			// 		$nbk = $nbk + $numpgr;
			// 		$sql4 = "UPDATE dayscheduled SET numbook='$nbk' WHERE schdate = '$bkdate' AND slotid= '$slotid' AND carid='$carid'";
			// 		$result = $conn->query($sql4);
			// 	}

			}


			mysqli_close($conn);
				
		}else if(isset($_POST['cancel'])){ //end cancel
			$bkid = $_POST['bkid']; 
			$sql = "UPDATE book SET bstatus='0'WHERE bkid='$bkid'";
			
			if($conn->query($sql)==TRUE){
				echo "<script>alert('Book ID = ".$bkid." is cancel successfully.'); window.location.href='showCBook.php';</script>";
		   } else{
				//echo "Deleting Error".$conn->error;
				echo "<script>alert('Cancel Error:".$conn->error."');</script>";
			}	
		}else if(isset($_POST['schedule'])){ //in case of insertion
			$schdate	=$_POST['dte'];
			$slotid		=$_POST['slotid'];
			$carid 		=$_POST['carid'];
			$drvid 		=$_POST['drvid'];
			
				$sql= "INSERT INTO dayscheduled (schdate, slotid, carid, drvid,maxnum)
									VALUES ('$schdate', '$slotid', '$carid', '$drvid','10')";
				// echo $sql;
				$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
				if($rs){
					echo 	"<script>
								window.alert('Successfully');
								window.location.href='showDaySch.php';
							</script>"; 
				}
				mysqli_close($conn);
		}

		

?>
