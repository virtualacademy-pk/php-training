<html>
<head>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once '../common/connect.php';
$sql = "SELECT CategoryID, CategoryName, Picture FROM Categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {?>
<div class="container">
<table class="table">
    <thead>
    <tr>
        <th>Category Id</th>
        <th>Category Name</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php
    while($row = $result->fetch_assoc()) {?>
        <tr> <td><?php echo $row["CategoryID"] ?></td><td><?php echo $row["CategoryName"] ?></td>
        <td><?php
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['Picture'] ).'"/>';
            ?>
            </td>
        </tr>

        <?php
    }
    ?>
    </tbody>
</table>
</div>
<?php
} else {
    echo "0 results";
}

$conn->close();
?>
<footer>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>
<?php
