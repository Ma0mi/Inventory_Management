<?php
include 'database.php';
$sql = "SELECT COUNT(DISTINCT order_id) AS order_id FROM order_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalOrders = $row['order_id'];
    echo $totalOrders;
} else {
    echo '0';
}

$conn->close();
?>
