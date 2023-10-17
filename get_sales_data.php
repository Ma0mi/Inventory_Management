<?php
include 'database.php';

$sql = "SELECT product_name, SUM(quantity) as total_quantity FROM order_history GROUP BY product_name";
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
