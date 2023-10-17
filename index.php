<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Inventory Management</title>
      <link rel="icon" href="/project/pictures/SteviaCircle.png" type="image/x-icon">
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
        <div id="mode-switch">
    <span id="sun-icon">&#9728;</span>
    <label class="switch">
        <input type="checkbox" id="mode-toggle">
        <span class="slider round"></span>
    </label>
    <span id="moon-icon">&#9790;</span>
</div>
    <div class="container">
        <h1>หน้าการจัดการสินค้า</h1>
        <div id="form-container">
            <form id="item-form">
                <input type="hidden" id="item-id">
                <input type="text" id="item-name" placeholder="ชื่อสินค้า" required>
                <input type="number" id="item-quantity" placeholder="จำนวน" required>
                <input type="number" id="item-price" placeholder="ราคา" required>
                <input type="text" id="item-from" placeholder="สถานที่มา" required>
                <input type="date" id="item-date" required>
                <button type="submit" id="submit-btn">Add Item</button>
            </form>
        </div>
        <div id="items-container">

            <p>  <p>
        </div>
    </div>
    <script src="javascript.js"></script>
      <div class="content">
   
         <div class="header">
            
         </div>
   
      </div>
   </body>
</html>