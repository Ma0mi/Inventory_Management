<?php
$servername = "127.0.0.1"; // แทนที่ด้วยที่อยู่เซิร์ฟเวอร์ MySQL ของคุณ
$username = "root"; // แทนที่ด้วยชื่อผู้ใช้ MySQL ของคุณ
$password = ""; // แทนที่ด้วยรหัสผ่าน MySQL ของคุณ
$database = "inventory_management"; // แทนที่ด้วยชื่อฐานข้อมูล MySQL ของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
?>
