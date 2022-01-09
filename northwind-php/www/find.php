
<?php
$id = $_GET['id'];
if (isset($id)) {
    require_once '../common/connect.php';

    $sql = "select CategoryID, CategoryName, Description from Categories  where CategoryID = " . $id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {?>
    <table border="1" >


        <tbody>
    <?php
         if($row = $result->fetch_assoc()) {?>

             <tr>
                 <td>Id</td> <td><?php echo $row['CategoryID'] ?></td>
             </tr>
             <tr>
                 <td>Name</td>  <td><?php echo $row['CategoryName'] ?></td>
             </tr>
             <tr>
                 <td>Category</td> <td><?php echo $row['Description'] ?></td>
             </tr>



         <?php } ?>
        </tbody>
    </table>
    <?php
    } else {
        echo "No record found";
    }


    $conn->close();
} else {
    echo "There is no Id to search";
}
?>

