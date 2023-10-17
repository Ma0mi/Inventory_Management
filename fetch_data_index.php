<?php
include 'database.php';

// Query the database to fetch data (select data from the inventory table)
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<table class="item-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Quantity</th>';
        echo '<th>Price</th>';
        echo '<th>From</th>';
        echo '<th>Date&Time</th>';
        // Add more table headers as needed
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . $row['from_location'] . '</td>';
        echo '<td>' . $row['timestamp'] . '</td>';
        // Add more table data cells for additional fields as needed
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }
} else {
    echo 'No items found in the inventory.';
}

// Close the database connection
$conn->close();
?>
