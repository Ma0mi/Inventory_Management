<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="process_order.css">
    <link rel="icon" href="/project/pictures/SteviaCircle.png" type="image/x-icon">
</head>
<body>

<?php

include 'database.php';

$customer_name = $_POST['customer_name'];
$customer_address = $_POST['customer_address'];
$customer_phone = $_POST['customer_phone'];

$sql_insert_customer = "INSERT INTO customers (customer_name, customer_address, customer_phone) VALUES ('$customer_name', '$customer_address', '$customer_phone')";

if ($conn->query($sql_insert_customer) === TRUE) {
    echo "บันทึกข้อมูลลูกค้าเรียบร้อยแล้ว<br>";

    $order_id = $conn->insert_id;

    $sql_select_inventory = "SELECT id, name, price, quantity FROM inventory";
    $result_inventory = $conn->query($sql_select_inventory);

    $total_order_price = 0;
    $selected_items = array(); // สร้างอาร์เรย์เพื่อเก็บรายการที่ถูกเลือก

    while ($row_inventory = $result_inventory->fetch_assoc()) {
        $id = $row_inventory['id'];
        $name = $row_inventory['name'];
        $price = $row_inventory['price'];
        $available_quantity = $row_inventory['quantity'];

        if (isset($_POST['order_quantity_' . $id])) {
            $order_quantity = (int)$_POST['order_quantity_' . $id];
            if ($order_quantity > 0) {
                if ($order_quantity <= $available_quantity) {
                    $total_price = $order_quantity * $price;
                    $total_order_price += $total_price;

                    // เก็บข้อมูลรายการที่ถูกเลือกในอาร์เรย์
                    $selected_items[] = array(
                        'name' => $name,
                        'quantity' => $order_quantity,
                        'price' => $price,
                        'total_price' => $total_price
                    );

                    echo "ผู้สั่งซื้อ: $customer_name ได้ทำรายการสั่งซื้อสินค้า '$name' จำนวน $order_quantity ชิ้น ราคารวม $total_price บาท<br>";

                    $sql_update_inventory = "UPDATE inventory SET quantity = quantity - $order_quantity WHERE id = $id AND quantity >= $order_quantity";
                    if ($conn->query($sql_update_inventory) !== TRUE) {
                        echo "เกิดข้อผิดพลาดในการอัปเดตสต็อกสินค้า: " . $conn->error;
                    }

                    $sql_insert_order_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$id', '$order_quantity', '$price')";
                    if ($conn->query($sql_insert_order_item) !== TRUE) {
                        echo "เกิดข้อผิดพลาดในการบันทึกรายการสั่งซื้อในตาราง 'order_items': " . $conn->error;
                    }


                    
                } else {
                    echo "เกิดข้อผิดพลาด: สินค้า '$name' มีจำนวนไม่เพียงพอสำหรับการสั่งซื้อ $order_quantity ชิ้น<br>";
                }
            }
        }
    }

    $sql_update_total_price = "UPDATE orders SET total_price = '$total_order_price' WHERE order_id = '$order_id'";
    if ($conn->query($sql_update_total_price) !== TRUE) {
        echo "เกิดข้อผิดพลาดในการบันทึกราคารวมในคำสั่งซื้อ: " . $conn->error;
    }

    if (!empty($selected_items)) {
        echo "<h2>รายการที่สั่งซื้อ:</h2>";
        echo "<table>";
        echo "<tr><th>รายการ</th><th>จำนวน</th><th>ราคา</th><th>ราคารวม</th></tr>";
        foreach ($selected_items as $item) {
            echo "<tr>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>" . $item['quantity'] . " ชิ้น</td>";
            echo "<td>" . $item['price'] . " บาท</td>";
            echo "<td>" . $item['total_price'] . " บาท</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<h3>ราคารวมทั้งหมด: $total_order_price บาท</h3>";
    }
} else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลูกค้า: " . $conn->error;
}

 // เพิ่มข้อมูลในตาราง "order_history"
foreach ($selected_items as $item) {
    $product_name = $item['name'];
    $quantity = $item['quantity'];
    $price_per_item = $item['price'];
    $total_price = $item['total_price'];

    $sql_insert_order_history = "INSERT INTO order_history (order_id, customer_name, customer_address, customer_phone, product_name, quantity, price_per_item, total_price, order_datetime) VALUES ('$order_id', '$customer_name', '$customer_address', '$customer_phone', '$product_name', '$quantity', '$price_per_item', '$total_price', NOW())";

    if ($conn->query($sql_insert_order_history) !== TRUE) {
        echo "เกิดข้อผิดพลาดในการบันทึกรายการสั่งซื้อในประวัติ: " . $conn->error;
    }
}


$conn->close();
?>
    <div id="countdown" style="font-size: 18px; font-weight: bold;"></div>

<script src="process_order.js"></script> 
</body>
</html>