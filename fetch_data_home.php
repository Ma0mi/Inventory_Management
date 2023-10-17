<?php
include 'database.php';

// Query the database to fetch data (e.g., select data from the inventory table)
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

// Generate HTML content for items
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Check if quantity is less than 50
        if ($row['quantity'] < 50) {
            echo '<tr style="background-color: red;">';
        } else {
            echo '<tr>';
        }

        // Add more table headers as needed
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . $row['from_location'] . '</td>';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '</tr>';
    }
} else {
    echo 'No items found in the inventory.';
}

// Close the database connection
$conn->close();
?>
