<?php
// Include the database connection script
include 'database.php';

// Query the database to fetch the latest product data (e.g., select data from order_history table)
$sql = "SELECT * FROM order_history ORDER BY order_datetime DESC LIMIT 1";
$result = $conn->query($sql);

// Prepare the HTML output
$htmlOutput = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $htmlOutput .= '<p>ID: ' . $row['product_id'] . '</p>';
    $htmlOutput .= '<p>Name: ' . $row['product_name'] . '</p>';
    $htmlOutput .= '<p>Quantity: ' . $row['quantity'] . '</p>';
    $htmlOutput .= '<p>Price: ' . $row['total_price'] . '</p>';
    $htmlOutput .= '<p>From: ' . $row['customer_name'] . '</p>';
    $htmlOutput .= '<p>Date&Time: ' . $row['order_datetime'] . '</p>';
    // เพิ่มข้อมูลเพิ่มเติมตามความต้องการ
} else {
    $htmlOutput = 'No latest product found.';
}

// Output the HTML
echo $htmlOutput;

// Close the database connection
$conn->close();
?>
