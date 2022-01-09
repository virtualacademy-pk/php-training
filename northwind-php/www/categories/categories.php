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

            include 'category-list-sort.php';

            ?>
        </main>

    </div>
</div>
<footer>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>
