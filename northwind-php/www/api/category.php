<?php

include_once '../common/connect.php';

$sql = "SELECT CategoryID, CategoryName,Picture From Categories order by CategoryID";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data['CategoryID'] = $row['CategoryID'];
                $data['CategoryName'] = $row['CategoryName'];
            }
    $conn->close();
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    header('Content-Type: application/json');
    echo null;
}



?>