<?php
session_start(); 
//ถ้ายังมี valid_id ยังคงเก็บอยู่ใน sesssion แสดงว่ายังเข้าใช้ระบบอยู่ปกติ
//ถ้าไม่มีแสดงว่ายังไม่ได้ล็อกอิน ให้ไปเปิดหน้า loogin
if (!$_SESSION["valid_id"]) {
        // User not logged in, redirect to login page
        Header("Location: login.php");
}

?>