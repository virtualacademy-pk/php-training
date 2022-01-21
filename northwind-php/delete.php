<?php
require_once '../common/connect.php';

$sql = "DELETE FROM  Categories where  CategoryID = 10";

if ($conn->query($sql) === TRUE) {
    echo "record deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>