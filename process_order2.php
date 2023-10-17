<?php
// เชื่อมต่อฐานข้อมูล
include 'database.php';

// รับข้อมูลผู้ซื้อจากฟอร์ม
$customer_name = $_POST['customer_name'];
$customer_address = $_POST['customer_address'];

// บันทึกข้อมูลผู้ซื้อลงในฐานข้อมูล (customers table)

// ดึงรายการสินค้าจากฐานข้อมูล
$sql = "SELECT id, name, price FROM inventory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
        $order_quantity = $_POST['order_quantity_' . $product_id];

        // บันทึกข้อมูลการสั่งซื้อลงในฐานข้อมูล (orders table)

        // ลดจำนวนสินค้าในตาราง inventory ตามจำนวนที่สั่งซื้อ

        // คำนวณราคารวมของรายการสินค้า

    }
}

// สร้างหน้าแสดงรายละเอียดการสั่งซื้อและข้อมูลผู้ซื้อ

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
