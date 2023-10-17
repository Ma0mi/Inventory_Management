<?php
// Include the database connection script
include 'database.php';

// Query the database to fetch the latest product data (e.g., select data from inventory table)
$sql = "SELECT * FROM inventory ORDER BY date DESC LIMIT 1";
$result = $conn->query($sql);

// Display the latest product data in the Latest Product Card
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<div class="latest-product-card">';
    echo '<h2>สินค้าล่าสุด</h2>';
    echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . $row['from_location'] . '</td>';
        echo '<td>' . $row['timestamp'] . '</td>';
    // เพิ่มข้อมูลเพิ่มเติมตามความต้องการ
    echo '</div>';
} else {
    echo 'No latest product found.';
}

// Close the database connection
$conn->close();
?>
