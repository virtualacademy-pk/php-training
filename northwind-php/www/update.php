<?php
require_once '../common/connect.php';
$sql = "UPDATE Categories set CategoryName = 'Category Na 10', Description = 'Cat 10 Des ' where  CategoryID = 10";

if ($conn->query($sql) === TRUE) {
    echo "record updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>