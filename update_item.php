<?php
include 'database.php';

// รับข้อมูลจากคำขอ POST
$item_id = $_POST['item_id']; // เพิ่มการรับค่า item_id

$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$from = $_POST['from'];
$date = $_POST['date'];

print_r($_POST);

// ดำเนินการ UPDATE ข้อมูลในฐานข้อมูล
$sql = "UPDATE inventory SET name=?, quantity=?, price=?, from_location=?, date=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siissi", $name, $quantity, $price, $from, $date, $item_id); // เพิ่ม item_id

print_r($stmt);

if ($stmt->execute()) {
    // การแก้ไขสำเร็จ
    echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลสินค้าเรียบร้อย']);
} else {
    // เกิดข้อผิดพลาด
    echo json_encode(['status' => 'error', 'message' => 'การแก้ไขข้อมูลสินค้าล้มเหลว']);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$stmt->close();
$conn->close();
?>
