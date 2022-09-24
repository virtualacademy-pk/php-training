<?php
session_start();
?>
<html>
<head>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include 'category-header.php';

?>
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <?php
                include '../left-panel.php';
                ?>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (isset($_FILES['picture']) && $_FILES['picture']['size'] > 0)
                {


                    $picture = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
                } else {

                    echo "not uploaded";
                }
                //
                $categoryId = $_POST["categoryId"];
                $categoryName = $_POST["categoryName"];
                $description = $_POST["description"];
                require_once '../common/connect.php';
                $conn = get_connection();
                $sql = "UPDATE Categories set CategoryName =  "."'" . $categoryName . "',description = '" . $description ."'";
                if (isset($picture)) {
                    $sql .= ", Picture = '$picture' ";
                }
                $sql .=   " WHERE categoryId = " . $categoryId;

                if ($conn->query($sql) === TRUE) {
                    $message = "Category updated successfully";
                    $categoryId = "";
                    $categoryName = "";
                    $description = "";
                    $picture = null;
                } else {
                    $error = $conn->error;
                }
                $conn->close();
            } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
                require_once '../common/connect.php';
                $conn = get_connection();
                $id =  $_GET["id"];
                if ($id > 0 ) {

                    $sql = "SELECT CategoryID, CategoryName, Description, Picture FROM Categories  where CategoryID = " . $id;

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {


                        if ($row = $result->fetch_assoc()) {
                            $categoryId = $row["CategoryID"];
                            $categoryName = $row["CategoryName"];
                            $description = $row["Description"];
                            $picture = 'data:image/jpeg;base64,'.base64_encode( $row['Picture'] );

                        }

                    }
                    $conn->close();
                }

            }



            ?>


            <div class="container">
                <?php
                if (!empty($error)) {?>
                    <div class="alert alert-danger">
                        <?php echo $error;?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (!empty($message)) {?>
                    <div class="alert alert-success">
                        <?php echo $message;?>
                    </div>
                    <?php
                }
                ?>

                <form method="post" action="category-edit.php"  enctype="multipart/form-data">

                    <h1>Add New Category</h1>

                    <div class="mb-3">
                        <label for="categoryId" class="form-label">Category Id</label>
                        <input type="text" class="form-control" name="categoryId" id="categoryId" value="<?php echo $categoryId;?>">

                    </div>
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="categoryName" id="categoryName" value="<?php echo $categoryName;?>" >
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description </label>
                        <textarea   class="form-control" name="description" id="description"  ><?php echo $description;?></textarea>
                    </div>
                    <div class="mb-3">
                        <?php if (isset($picture)) {?>
                            <img src="<?php echo $picture; ?>"/>';
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Picture</label>
                        <input type="file" class="form-control" name="picture" id="picture">

                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>

                </form>

            </div>
        </main>

    </div>
</div>
<footer>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>