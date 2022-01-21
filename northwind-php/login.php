<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["userInfo"] = "Virtual Academy";
    header("Location: /northwind-php/index.php");

}
?>
<html>
<head>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-3 me-0 px-3" href="#">Company name</a>
    <ul class="nav col-md-9 col-md-auto mb-2 justify-content-start mb-md-0">

        <li><a  class="nav-link px-2 link-secondary"  >
                Welcome, <?php echo $_SESSION["userInfo"]; ?>
            </a>
        </li>
    </ul>


</header>
<div class="container-fluid">
    <div class="row">

         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
             <div class="container">

                 <form method="post" action="login.php">

                     <div class="mb-3">
                         <label for="userName" class="form-label">Username</label>
                         <input type="text" class="form-control" name="userName" id="userName"

                         >

                     </div>
                     <div class="mb-3">
                         <label for="password" class="form-label">Password</label>
                         <input type="text" class="form-control" name="password" id="password"  >
                     </div>


                     <button type="submit" class="btn btn-primary">Login</button>

                 </form>

             </div>

         </main>

    </div>
</div>
<footer>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>
<?php
