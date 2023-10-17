<?php
include 'database.php';

// Query the database to fetch the total number of items
$sql = "SELECT COUNT(*) as total_items FROM inventory";
$result = $conn->query($sql);

$totalItems = 0; // Initialize a variable to store the total number of items

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalItems = $row['total_items'];
}

// Close the database connection
$conn->close();

// Display the total number of items
echo $totalItems;
?>
