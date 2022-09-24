<?php
require_once '../common/connect.php';
$conn = get_connection();
$sql = "INSERT INTO Categories (CategoryID, CategoryName, Description) VALUES (10, 'cat 10', 'cat 10')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>