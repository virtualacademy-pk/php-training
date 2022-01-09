<?php

include_once '../common/connect.php';
$sortBy =  $_GET['sortby'];
$sortOrder =  $_GET['sortorder'];
if (empty($sortOrder)) {
    $sortOrder = 'asc';
}
if (empty($sortBy)) {
$sql = "SELECT CategoryID, CategoryName,Picture From Categories order by CategoryID";
} else {
        $sql = "SELECT CategoryID, CategoryName,Picture From Categories order by " . $sortBy .' ' . $sortOrder;
        
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {?>
    <div class="table-responsive">
        <?php echo 'sort by ' . $_GET['sortby']; ?>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>
                <a href="">    
                Category Id
                </a>
            </th>
                <th>
                <a href="">    
                Category Name
                </a>
                </th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($row = $result->fetch_assoc()) {?>
                <tr>
                    <td>
                        <?php echo $row["CategoryID"] ;?>
                    </td>
                    <td>
                    
                        <?php echo $row["CategoryName"] ;?>
                       
                    </td>
                    <td>
                        <?php
                        if (!empty($row['Picture'])) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Picture']) . '"/>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="category-edit.php?id=<?php echo  $row["CategoryID"]; ?>">Edit</a>
                        <a href="category-delete.php?id=<?php echo  $row["CategoryID"]; ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
    $conn->close();
}
?>