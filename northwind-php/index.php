<?php
session_start();
?>
<html>
<head>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-3 me-0 px-3" href="#">Company name</a>
    <ul class="nav col-md-9 col-md-auto mb-2 justify-content-start mb-md-0">

    </ul>


</header>
<div class="container-fluid">

    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
            <?php
            include 'left-panel.php';
             ?>
            </div>
        </nav>
         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

         </main>

    </div>
</div>
<footer>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>
<?php
