<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="/project/pictures/SteviaCircle.png" type="image/x-icon">
    <link rel="stylesheet" href="stylehomepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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

    <header>
    <img src="\project\pictures\SteviaCircle.png" class="logo">
    <marquee>ยินดีต้อนรับสู่หน้า Dashboard</marquee>
        
    </header>
    
    <main>
        
        <section class="cards">
            <div class="card">
                <h1> จำนวนรายการสินค้าที่มี </h1>
                <p><?php include 'display_total_items.php'; ?></p>
                <img src="/project/pictures/homepage/1.png" alt="รูปภาพ" class="image1"> 
            </div>
            
            <div class="card">
                <h1>คำสั่งซื้อทั้งหมด</h1>
                <p><?php include 'display_total_orders.php'; ?></p>
                <img src="/project/pictures/homepage/2.png" alt="รูปภาพ" class="image2">
            </div>
        </section>

    <div class="menu-list">
    <table class="menu-table">
        <thead>
        <tbody>รายการสินค้าที่มี</tbody>
         <thead>
         <tr>
         <th>รหัสสินค้า</th>
         <th>ชื่อสินค้า</th>
         <th>จำนวน</th>
         <th>ราคา</th>
         <th>สถานที่เข้ามา</th>
         <th>เวลาและวันที่เข้า</th>
         </thead>
        <tr><?php include 'fetch_data_home.php'; ?></tr>
    </table>
    </div>

    <div class="chart-container">
    <canvas id="salesChart"></canvas>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ดึงข้อมูลจำนวนสินค้าที่ขายได้จากฐานข้อมูล
    fetch('get_sales_data.php') // เรียกไฟล์ PHP เพื่อดึงข้อมูลจากฐานข้อมูล
    .then(response => response.json())
    .then(data => {
        // ในกรณีนี้ data ควรจะเป็น JSON ที่มีข้อมูลขายสินค้า
        const labels = data.map(item => item.product_name);
        const sales = data.map(item => item.total_quantity);

        // สร้างกราฟ
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'จำนวนสินค้าที่ขายได้',
            data: sales,
            backgroundColor: 'rgb(0, 128, 128)', // สำหรับเลือกสี https://htmlcolorcodes.com/
            borderColor: '(0, 0, 128)',              
            borderWidth: 1
        }]
    },
    options: {
        responsive: true, // ทำให้กราฟตอบสนองกับขนาดหน้าต่างเบราวเซอร์
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'จำนวนสินค้า'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'ชื่อสินค้า'
                }
            }
        }
    }
});

    });
});
</script>
</div>

    </main>

    <div class="latest-product-card">
    <?php
    // Include the database connection script
    include 'database.php';

    // Query the database to fetch the latest product data (e.g., select data from inventory table)
    $sql = "SELECT * FROM inventory ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);

    // Display the latest product data in the Latest Product Card
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<h2>สินค้าล่าสุด</h2>';
        echo '<h2>รายการที่เพิ่มเข้ามา:</h2>';
        echo '<p>รหัสสินค้า: ' . $row['id'] . '</p>';
        echo '<p>ชื่อสินค้า: ' . $row['name'] . '</p>';
        echo '<p>จำนวน: ' . $row['quantity'] . '</p>';
        echo '<p>ราคา: ' . $row['price'] . '</p>';
        echo '<p>สถานที่จาก: ' . $row['from_location'] . '</p>';
        echo '<p>เข้ามาเมื่อ: ' . $row['timestamp'] . '</p>';
        // เพิ่มข้อมูลเพิ่มเติมตามความต้องการ
    } else {
        echo 'No latest product found.';
    }
    // Close the database connection
    $conn->close();
    ?>
</div>
</div>
    
</div>
<div class="container">
        <div class="latest-order-card">
            <?php
            include 'database.php';

            $sql = "SELECT * FROM order_history ORDER BY order_datetime DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h2>สินค้าที่ขายล่าสุด</h2>';
                echo '<h2>รหัสสั่งซื้อที่: ' . $row['order_id'] . '</h2>';
                echo '<p>ชื่อลูกค้า: ' . $row['customer_name'] . '</p>';
                echo '<p>ที่อยู่: ' . $row['customer_address'] . '</p>';
                echo '<p>เบอร์โทรศัพท์: ' . $row['customer_phone'] . '</p>';
                echo '<h3>รายการสินค้า</h3>';
                echo '<table>';
                echo '<tr>';
                echo '<th>ชื่อสินค้า</th>';
                echo '<th>จำนวน</th>';
                echo '<th>ราคาต่อหน่วย</th>';
                echo '<th>ราคารวม</th>';
                echo '</tr>';
                
                // รับ order_id จากการสั่งซื้อล่าสุด
                $order_id = $row['order_id'];
                $sql_items = "SELECT product_name, quantity, price_per_item, total_price FROM order_history WHERE order_id = $order_id";
                $items_result = $conn->query($sql_items);
                
                $total_price = 0; // เพิ่มตัวแปรเพื่อเก็บราคารวมทั้งหมด

                while ($item_row = $items_result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $item_row['product_name'] . '</td>';
                    echo '<td>' . $item_row['quantity'] . '</td>';
                    echo '<td>' . $item_row['price_per_item'] . '</td>';
                    echo '<td>' . $item_row['total_price'] . '</td>';
                    echo '</tr>';
                    
                    $total_price += $item_row['total_price']; // เพิ่มราคาของรายการสินค้านี้ในราคารวมทั้งหมด
                }

                // แสดงราคารวมทั้งหมด
                echo '<tr>';
                echo '<th colspan="3">ราคารวมทั้งหมด</th>';
                echo '<td>' . $total_price . '</td>';
                echo '</tr>';
                echo '</table>';
            } else {
                echo 'ไม่พบสินค้าล่าสุด';
            }
            ?>
        </div>
    </div>

    <footer>
    <div class="P-Banner">
        <p>&copy; STEVIA TECHNEW (THAILAND) COMPANY LIMITED</p>
        <p>&copy; 141/2 ซอยสุขุมวิท 55 แยก 7 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110</p>
    </div>
    </footer>

    <script src="javascript.js"></script>
    <script src="้homescript.js"></script>
</body>
</html>