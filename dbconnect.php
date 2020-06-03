
<?php
    /*    
     header("Access-Control-Allow-Origin: *");
     $conn = mysqli_connect("localhost","user33","877w294r","user33_healthcare") or die ("could not connect database");
    
    */
	// $servername = "localhost";
    // $servername = "127.0.0.1";
    // $username = "root";
    // $password = "5920310127";
    // $dbname = "csiam";
    //server ภาค
    $servername = "172.18.111.41";
    $username = "5920310127";
    $password = "5920310127";
    $dbname = "5920310127";
    // Create connection object
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // echo "Connected successfully";
    mysqli_set_charset($conn, "utf8");//is to make Thai readable
?>
