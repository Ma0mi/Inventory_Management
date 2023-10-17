<?php
// Include the database connection script
include 'database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the buyer information from the form
    $buyerName = $_POST['buyerName'];
    $buyerAddress = $_POST['buyerAddress'];
    $buyerPhone = $_POST['buyerPhone'];

    // Insert the buyer information into the 'customers' table
    $insertSql = "INSERT INTO customers (name, address, phone) VALUES ('$buyerName', '$buyerAddress', '$buyerPhone')";
    if ($conn->query($insertSql) === TRUE) {
        echo "บันทึกข้อมูลผู้ซื้อสำเร็จ!";
    } else {
        echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
