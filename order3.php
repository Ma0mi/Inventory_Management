<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="order.css">
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

    <h1>รายการสั่งซื้อ</h1>

<!-- เพิ่มฟอร์มสำหรับข้อมูลผู้ซื้อ -->
<form action="confirm_order.php" method="post">
    <label for="buyerName">ผู้สั่งซื้อ:</label>
    <input type="text" id="buyerName" name="buyerName" required>

    <label for="buyerAddress">ที่อยู่:</label>
    <textarea id="buyerAddress" name="buyerAddress" required></textarea>

    <label for="buyerName">เบอร์โทรศัพท์ติดต่อ:</label>
    <input type="text" id="buyerPhone" name="buyerName" required>


    <?php
   include 'database.php';

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT id, name, quantity, price FROM inventory";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคา</th><th>จำนวนที่สั่งซื้อ</th><th>ราคารวม</th></tr>';
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
        echo '</table>';
    } else {
        echo "ไม่พบรายการสินค้าในฐานข้อมูล";
    }
    ?>

    <!-- เพิ่มส่วนคำนวณราคารวมรายการทั้งหมดด้วย JavaScript -->
    <script>
    const table = document.querySelector('table');
    table.addEventListener('input', function(e) {
        if (e.target.nodeName === 'INPUT') {
            const input = e.target;
            const id = input.name.split('_')[2];
            const quantity = input.value;
            const price = parseFloat(input.parentElement.previousElementSibling.textContent);
            const subtotal = quantity * price;
            document.getElementById('subtotal_' + id).textContent = subtotal.toFixed(2);
            calculateTotal();
        }
    });

    function calculateTotal() {
        const subtotals = document.querySelectorAll('span[id^="subtotal_"]');
        let total = 0;
        subtotals.forEach(subtotal => {
            total += parseFloat(subtotal.textContent);
        });
        // แสดงราคารวมทั้งหมดไปยังอิลิเมนต์ที่คุณต้องการ
        // เช่น document.getElementById('total').textContent = total.toFixed(2);
    }
    </script>



   <button type="submit">สั่งซื้อ</button>
</form>
     



    <?php
    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>

    <script src="javascript.js"></script>
    
</body>
</html>
