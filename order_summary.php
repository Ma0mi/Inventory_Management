<?php
// สร้างหน้าแสดงรายการสั่งซื้อหลังจากกดสั่งซื้อ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีรายการสั่งซื้อที่ถูกส่งมาหรือไม่
    if (!empty($_POST['order_quantity'])) {
        echo '<h1>รายการสั่งซื้อของคุณ</h1>';

        // นำเข้าไฟล์คอนฟิกสำหรับการเชื่อมต่อฐานข้อมูล
        include 'database.php';

        // นับจำนวนรายการที่ถูกสั่งซื้อ
        $totalItems = 0;

        // คำนวณราคารวมของรายการสั่งซื้อ
        $totalPrice = 0;

        // วนลูปรายการสินค้าที่ถูกสั่งซื้อ
        foreach ($_POST['order_quantity'] as $itemId => $quantity) {
            // ตรวจสอบว่าจำนวนที่สั่งซื้อมากกว่า 0 หรือไม่
            if ($quantity > 0) {
                // ส่งคำสั่ง SQL เพื่อดึงข้อมูลสินค้าจากฐานข้อมูล
                $sql = "SELECT id, name, price FROM inventory WHERE id = " . $itemId;
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $itemTotalPrice = $row['price'] * $quantity;

                    echo '<p>สินค้า: ' . $row['name'] . ', จำนวน: ' . $quantity . ', ราคาต่อหน่วย: ' . $row['price'] . ', ราคารวม: ' . $itemTotalPrice . '</p>';

                    $totalItems += $quantity;
                    $totalPrice += $itemTotalPrice;
                }
            }
        }

        echo '<p>จำนวนรายการที่สั่งซื้อ: ' . $totalItems . '</p>';
        echo '<p>ราคารวมทั้งหมด: ' . $totalPrice . '</p>';

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
    } else {
        echo 'ไม่มีรายการสั่งซื้อ';
    }
}
?>

<!-- เพิ่มฟอร์มสำหรับกรอกจำนวนสินค้าที่ต้องการสั่งซื้อ -->
<form method="post" action="">
    <!-- สร้างรายการสินค้าจากฐานข้อมูล -->
    <?php
    // นำเข้าไฟล์คอนฟิกสำหรับการเชื่อมต่อฐานข้อมูล
    include 'database.php';

    // เรียกดึงรายการสินค้าจากฐานข้อมูล
    $sql = "SELECT id, name, price FROM inventory";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>สินค้าที่มีในคลัง</h1>';
        echo '<table>';
        echo '<tr><th>รหัส</th><th>ชื่อสินค้า</th><th>ราคาต่อหน่วย</th><th>จำนวนที่สั่งซื้อ</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td><input type="number" name="order_quantity[' . $row['id'] . ']" min="0" value="0"></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<button type="submit">สั่งซื้อ</button>';
    } else {
        echo 'ไม่พบรายการสินค้าในคลัง';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>
</form>
