<?php
session_start();

session_unset(); //remove all session variables

session_destroy(); //ทำลายเซสชัน

// Logged out, return to login page
Header("Location: index.php"); //เปิดหน้า index
?>