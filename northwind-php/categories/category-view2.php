
<?php
include '../common/alert.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action =  $_GET["action"];
    $categoryId = $_POST["categoryId"];
    $categoryName = $_POST["categoryName"];
    $description = $_POST["description"];

    if (empty($action)) {
        $action =   "/categories/category.php?action=add";
    }
    require_once '../common/connect.php';

    if ($action == "add") {
        $sql = "INSERT INTO Categories (CategoryID, CategoryName, Description)
VALUES (" . $categoryId . ", '" . $categoryName . "','" . $description . "')";
        if ($conn->query($sql) === TRUE) {
            $message = "New Category created successfully";
            $categoryId = "";
            $categoryName = "";
            $description = "";
        } else {
            $error = $conn->error;
        }
    } else if ($action == "edit") {
        $sql = "UPDATE Categories set CategoryName =  "."'" . $categoryName . "',description = '" . $description ."'" .
            " WHERE categoryId = " . $categoryId;

        if ($conn->query($sql) === TRUE) {
            $message = "Category updated successfully";
            $categoryId = "";
            $categoryName = "";
            $description = "";
        } else {
            $error = $conn->error;
        }
    }


    $conn->close();



} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../common/connect.php';
    $id =  $_GET["id"];
    $action =   "/categories/category.php?action=add";

    if ($id > 0 ) {
        $action =   "/categories/category.php?action=edit";
        $sql = "SELECT CategoryID, CategoryName, Description FROM Categories  where CategoryID = " . $id;

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {


            if ($row = $result->fetch_assoc()) {
                $categoryId = $row["CategoryID"];
                $categoryName = $row["CategoryName"];
                $description = $row["Description"];

            }

        }
        $conn->close();
    }
}

?>
<div class="container">

    <form method="post" action="<?php echo $action;?>">

        <?php
        if (!isset($id)) {
            $readonly = '';
            ?>
            <h1>Add New Category</h1>
            <?php
        }  else   if (isset($id)) {
            $readonly = 'readonly';
            ?>
            <h1>Edit Category</h1>
            <?php
        }
        ?>
        <?php
        if (!empty($error)) {
            ?>

            <div class="alert alert-danger" role="alert">
                <?php echo $error;?>
            </div>
            <?php
        }

        ?>
        <?php
        if (!empty($message)) {
            ?>

            <div class="alert alert-success" role="alert">
                <?php echo $message;?>
            </div>
            <?php
        }

        ?>

        <div class="mb-3">
            <label for="categoryId" class="form-label">Category Id</label>
            <input type="text" class="form-control" name="categoryId" id="categoryId"
                <?php echo $readonly;?>
                   value="<?php echo $categoryId;?>">

        </div>
        <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="categoryName" id="categoryName"  value="<?php echo $categoryName;?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description </label>
            <textarea   class="form-control" name="description" id="description"  ><?php echo $description;?></textarea>
        </div>
        <input type="hidden" name="action" value = "<?php echo $action?>">
        <button type="submit" class="btn btn-primary">Save</button>

    </form>

</div>



