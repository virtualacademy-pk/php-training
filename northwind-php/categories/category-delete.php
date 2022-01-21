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
$page = $_GET['page'];
if (empty($page)) {
    $page = 'list';
}
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
            $categoryId = $_GET['id'];
            error_reporting(0);
            if ( $categoryId > 0) {
                require_once '../common/connect.php';
                $sql = "DELETE FROM  Categories where  CategoryID = " . $categoryId;

                if ($conn->query($sql) === TRUE) {?>
                    <div class="alert alert-success">
                        Record deleted successfully
                    </div>
               <?php } else {

                    ?>
                    <div class="alert alert-danger">
                       Record in Use
                    </div>
                <?php
                }


            } else {?>


                <div class="alert alert-danger">
                    No Id available to delete
                </div>
           <?php }

            include 'category-list.php';
            ?>
        </main>

    </div>
</div>
<footer>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>


