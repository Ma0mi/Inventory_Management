<?php
include 'database.php';

// รับข้อมูลจากคำขอ POST
$item_id = $_POST['item_id']; // เพิ่มการรับค่า item_id
// ดำเนินการ DELETE ข้อมูลในฐานข้อมูล
$sql = "DELETE FROM inventory WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id); // เพิ่ม item_id

if ($stmt->execute()) {
    // การลบสำเร็จ
    echo json_encode(['status' => 'success', 'message' => 'ลบสินค้าออกเรียบร้อย']);
} else {
    // เกิดข้อผิดพลาด
    echo json_encode(['status' => 'error', 'message' => 'การลบสินค้าล้มเหลว']);
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$stmt->close();
$conn->close();
?>
