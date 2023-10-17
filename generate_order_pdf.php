<?php
require_once __DIR__ . '/vendor/autoload.php';


$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [__DIR__ . '/tmp']),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'Sarabun-Regular.ttf',
            'I' => 'Sarabun-Italic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);

ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานใบสั่งซื้อ</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php
    require 'database.php';

    // ดึงรายการ order_id จาก URL ที่ถูกส่งมา
    $order_id = $_GET['order_id'];

    // ดึงข้อมูลคำสั่งซื้อจาก order_history โดยอิงจาก order_id แค่ครั้งเดียว
    $sql_select_order = "SELECT customer_name, customer_address, customer_phone, order_datetime FROM order_history WHERE order_id = $order_id LIMIT 1";
    $result_order = $conn->query($sql_select_order);
    $row_order = $result_order->fetch_assoc();
    ?>
    <h1>บริษัท สเตเวีย เทคนิว(ประเทศไทย) จำกัด</h1> 
     <h1>ใบรายงานการสั่งซื้อ คำสั่งซื้อที่: <?php echo $order_id; ?></h1><br />
    <p>ชื่อผู้สั่งซื้อ: <?php echo $row_order['customer_name']; ?></p>
    <p>ที่อยู่จัดส่งสินค้า: <?php echo $row_order['customer_address']; ?></p>
    <p>เบอร์โทรศัพท์ติดต่อ: <?php echo $row_order['customer_phone']; ?></p>
    <p>เวลาที่สั่งซื้อ: <?php echo $row_order['order_datetime']; ?></p> <br /><br /><br /><br />
    <table>
        <tr>
            <th>รายการที่</th>
            <th>สินค้า</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย</th>
            <th>ราคารวม</th>
        </tr>
        

        <?php
        // ดึงข้อมูลรายการคำสั่งซื้อจาก order_history โดยอิงจาก order_id
        $sql_select_order_items = "SELECT product_name, quantity, price_per_item, total_price FROM order_history WHERE order_id = $order_id";
        $result_order_items = $conn->query($sql_select_order_items);

        $total_order_price = 0; // สร้างตัวแปรสำหรับเก็บราคารวม
        $item_count = 1; // สร้างตัวแปรสำหรับลำดับรายการสินค้า

        while ($row = $result_order_items->fetch_assoc()):
        $total_order_price += $row['total_price']; // เพิ่มราคารวมของรายการนี้ในราคารวมทั้งหมด
        ?>

        <tr>
            <td><?php echo $item_count; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['price_per_item']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
        </tr>

        <?php     $item_count++; endwhile; ?>

        <tr>
            <th colspan="3">รวมทุกรายการ</th>
            <td><?php echo $total_order_price; ?></td>
        </tr>
    </table><br>
    <p>© 141/2 ซอยสุขุมวิท 55 แยก 7 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110<br></p>

</body>
</html>

<?php

$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output();
ob_end_flush();
?>
