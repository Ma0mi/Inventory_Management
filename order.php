<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>
    <link rel="icon" href="/project/pictures/SteviaCircle.png" type="image/x-icon">
    <link rel="stylesheet" href="process.css"> 
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
<div class="datetime">
        <span id="current-time"></span>
        <span id="current-date"></span>
     </div>
           <div class="wrapper">
              <input type="checkbox" id="btn" hidden>
              <label for="btn" class="menu-btn">
              <i class="fas fa-bars"></i>
              <i class="fas fa-times"></i>
              </label>
              <nav id="sidebar">
                 <div class="title">
                    ตัวเลือกทำรายการ
                 </div>
                 <ul class="list-items">
                    <li><a href="http://localhost/project/Homepage.php"><i class="fas fa-home"></i>หน้าแรก</a></li>
                    <li><a href="http://localhost/project/index.php"><i class="fas fa-sliders-h"></i>จัดการคลังสินค้า</a></li>
                    <li><a href="http://localhost/project/order.php"><i class="fas fa-address-book"></i>Services</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i>Settings</a></li>
                    <li><a href="#"><i class="fas fa-stream"></i>Features</a></li>
                    <li><a href="#"><i class="fas fa-user"></i>About us</a></li>
                    <li><a href="#"><i class="fas fa-globe-asia"></i>เปลี่ยนภาษา</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i>ติดต่อผู้ดูแลระบบ</a></li>
                 
                 </ul>
              </nav>
            </div>
    </div> 

</head>
<body>
    <h1>รายการสั่งซื้อ</h1>
    <form action="process_order.php" method="post">
        <label for="customer_name">ชื่อผู้ซื้อ:</label>
        <input type="text" id="customer_name" name="customer_name" required><br>
        <label for="customer_address">ที่อยู่ผู้ซื้อ:</label>
        <textarea id="customer_address" name="customer_address" required></textarea><br>
        <label for="customer_name">เบอร์โทรศัพท์ติดต่อ:</label>
        <input type="text" id="customer_phone" name="customer_phone" required><br>
        
        <!-- รายการสินค้าจากฐานข้อมูล -->
        <table>
            <tr>
                <th>ID</th>
                <th>ชื่อสินค้า</th>
                <th>จำนวน</th>
                <th>ราคา</th>
                <th>สั่งซื้อ</th>
                <th>ราคารวม</th>
            </tr>
            <?php
            // เชื่อมต่อฐานข้อมูล
            include 'database.php';

            // ดึงรายการสินค้าจากฐานข้อมูล
            $sql = "SELECT id, name, quantity, price FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td><input type="number" name="order_quantity_' . $row['id'] . '" min="0" max="' . $row['quantity'] . '"></td>';
                    echo '<td><span id="subtotal_' . $row['id'] . '">0</span></td>';
                    echo '</tr>';
                    
                }
            } else {
                echo "ไม่พบรายการสินค้าในฐานข้อมูล";
            }
            ?>
        </table>
        
        <button type="submit">สั่งซื้อ</button>
    </form>
    <button><a href="order_history.php">ดูประวัติการสั่งซื้อ</a></button>


    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="process.js"></script>
    <script src="javascript.js"></script>
</body>
</html>