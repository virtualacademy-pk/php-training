
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_GET["action"];
    $categoryId = $_POST["categoryId"];
    $categoryName = $_POST["categoryName"];
    $description = $_POST["description"];
    if (isset($action)) {
        $action = "/categories/category.php?action=add";
    }
    echo $action;
    require_once '../common/connect.php';
    if ($action == "add") {
        $sql = "INSERT INTO Categories (CategoryID, CategoryName, Description)
        VALUES (" . $categoryId . ", '" . $categoryName . "','" . $description . "')";
        if ($conn->query($sql) ===  TRUE) {
            $message = "New Cateogry Created successfully";
            $categoryId = "";
            $categoryName = "";
            $description = "";
        }
    }
} else {

}

?>
<div class="container">

    <form method="post" action="<?php echo $action ;?>">

        <div class="mb-3">
            <label for="categoryId" class="form-label">Category Id</label>
            <input type="text" class="form-control" name="categoryId" id="categoryId"

                  >

        </div>
        <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="categoryName" id="categoryName"  >
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description </label>
            <textarea   class="form-control" name="description" id="description"  ></textarea>
        </div>
        <input type="hidden" name="action" >
        <button type="submit" class="btn btn-primary">Save</button>

    </form>

</div>



