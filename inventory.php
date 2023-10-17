<?php
// Include the database connection script
include 'database.php';

// Query the database to fetch data (e.g., select data from inventory table)
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

// Display HTML content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management</title>
    <!-- Add your CSS and JavaScript links here -->
</head>
<body>
    <h1>Inventory Management System</h1>
    <!-- Display database data here, e.g., using PHP loop -->
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<p>ID: ' . $row['id'] . '</p>';
            echo '<p>Name: ' . $row['name'] . '</p>';
            echo '<p>Quantity: ' . $row['quantity'] . '</p>';
            // Add more fields as needed
        }
    } else {
        echo 'No items found in the inventory.';
    }
    ?>
</body>
</html>
