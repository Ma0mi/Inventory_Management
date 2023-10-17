<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการสั่งซื้อ</title>
    <link rel="stylesheet" href="order.css">
    <!-- เพิ่ม CSS หรือข้อมูลสไตล์อื่น ๆ ตามความเหมาะสม -->
</head>
<body>
    <h1>ยืนยันการสั่งซื้อ</h1>

    <!-- แสดงข้อมูลผู้ซื้อ -->
    <?php
    if (isset($_POST['buyerName']) && isset($_POST['buyerAddress']) && isset($_POST['buyerPhone'])) {
        $buyerName = $_POST['buyerName'];
        $buyerAddress = $_POST['buyerAddress'];
        $buyerPhone = $_POST['buyerPhone'];

        echo '<h2>ข้อมูลผู้ซื้อ</h2>';
        echo '<p>ชื่อผู้ซื้อ: ' . $buyerName . '</p>';
        echo '<p>ที่อยู่: ' . $buyerAddress . '</p>';
        echo '<p>เบอร์โทร: ' . $buyerPhone . '</p>';
    }
    ?>

    <!-- แสดงรายละเอียดของสินค้าที่ถูกเลือก -->
    <?php
    include 'database.php';

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT id, name, quantity, price FROM inventory";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h2>รายการสินค้าที่สั่งซื้อ</h2>';
        echo '<table>';
        echo '<tr><th>ID</th><th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคาต่อหน่วย</th><th>จำนวนที่สั่งซื้อ</th><th>ราคารวม</th></tr>';
        while ($row = $result->fetch_assoc()) {
            $inputName = 'order_quantity_' . $row['id'];
            if (isset($_POST[$inputName])) {
                $orderQuantity = (int)$_POST[$inputName];
                if ($orderQuantity > 0) {
                    $totalPrice = $orderQuantity * $row['price'];
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>' . $orderQuantity . '</td>';
                    echo '<td>' . $totalPrice . '</td>';
                    echo '</tr>';
                }
            }
        }
        echo '</table>';
    } else {
        echo 'ไม่พบรายการสินค้าในฐานข้อมูล';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>

    <!-- เพิ่มปุ่มกลับไปที่หน้ารายการสั่งซื้อหรือหน้าหลัก ตามความเหมาะสม -->
    <a href="order.php">กลับไปที่หน้ารายการสั่งซื้อ</a>

    <!-- เพิ่ม CSS หรือข้อมูลสไตล์อื่น 
