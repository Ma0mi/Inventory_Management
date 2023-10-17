<?php
include 'database.php';

// รับข้อมูลจากคำขอ POST
$id = (int)($_POST['item_id']);
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$from = $_POST['from'];
$date = $_POST['date'];

// ดำเนินการ INSERT ในฐานข้อมูล
$sql = "INSERT INTO inventory ( id ,name, quantity, price, from_location, date) VALUES ( ? ,?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isiiss", $id , $name, $quantity, $price, $from, $date);

if ($stmt->execute()) {
    // การแทรกสำเร็จ
    echo json_encode(['status' => 'success', 'message' => 'เพิ่มสินค้าเรียบร้อย']);
} else {
    // เกิดข้อผิดพลาด
    echo json_encode(['status' => 'error', 'message' => 'การเพิ่มสินค้าล้มเหลว']);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$stmt->close();
$conn->close();
?>
