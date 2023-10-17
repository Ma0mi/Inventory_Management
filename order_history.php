<!DOCTYPE html>
<html>
<head>
    <title>ประวัติการสั่งซื้อ</title> 
    <link rel="icon" href="/project/pictures/SteviaCircle.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="process_order.css">                             
    <link rel="stylesheet" type="text/css" href="order_history.css">
</head>
<body>
    <h1>ประวัติการสั่งซื้อ</h1>

    <?php
    include 'database.php';

    // ดึงรายการ order_id ที่มีในฐานข้อมูล
    $sql_select_order_ids = "SELECT DISTINCT order_id FROM order_history";
    $result_order_ids = $conn->query($sql_select_order_ids);
    ?>

    <?php while ($row_order_id = $result_order_ids->fetch_assoc()): ?>
        <h2>Order ID: <?php echo $row_order_id['order_id']; ?></h2>
        <table>
            <tr>
                <th>ชื่อลูกค้า</th>
                <th>ที่อยู่จัดส่งสินค้า</th>
                <th>เบอร์โทรศัพท์ติดต่อ</th>
                <th>สินค้า</th>
                <th>จำนวน</th>
                <th>ราคาต่อหน่วย</th>
                <th>ราคารวม</th>
                <th>เวลาที่สั่งซื้อ</th>
            </tr>

            <?php
            $current_order_id = $row_order_id['order_id'];
            $sql_select_order_items = "SELECT customer_name, customer_address, customer_phone, product_name, quantity, price_per_item, total_price, order_datetime FROM order_history WHERE order_id = $current_order_id";
            $result_order_items = $conn->query($sql_select_order_items);

            $total_order_price = 0; // สร้างตัวแปรสำหรับเก็บราคารวม

            while ($row = $result_order_items->fetch_assoc()):
            $total_order_price += $row['total_price']; // เพิ่มราคารวมของรายการนี้ในราคารวมทั้งหมด
            ?>
            
            <tr>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_address']; ?></td>
                <td><?php echo $row['customer_phone']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['price_per_item']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td><?php echo $row['order_datetime']; ?></td>
            </tr>
            
            <?php endwhile; ?>
            
            <tr>
                <th colspan="6">ราคารวมทุกรายการ</th>
                <td><?php echo $total_order_price; ?></td>
            </tr>
            <td>
            <a href="generate_order_pdf.php?order_id=<?php echo $current_order_id; ?>" target="_blank">ใบรายงานสั่งซื้อ.pdf</a>
            </td>

        </table>
    <?php endwhile; ?>
</body>
</html>
