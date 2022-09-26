<?php

session_start();
$error = null;
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    if (strlen(trim($userName)) > 0 && strlen(trim($userName)) > 0 ) {
        $sql = "select u.user_id userId, u.user_name userName,
       concat(e.FirstName,' ', e.LastName) employeeName
    from users u
         inner join employees e on u.employeeId = e.EmployeeID
    where user_name = ? and user_password = ?";

        require_once 'common/connect.php';
        $conn = get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $userName, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                $_SESSION["userInfo"] = $row;
                header("Location: /northwind-php/index.php");

            }

        } else {
            $error = "Invalid Username or Password";
        }
        $conn->close();

    } else {
        $error = "Both Username and Password are mandatory fields";
    }
}
?>
<html>
<head>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    <a class="navbar-brand col-md-3 col-lg-3 me-0 px-3" href="#">Company name</a>


</header>
<div class="container-fluid">
    <div class="row">

         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
             <div class="container">
                 <?php
                 if($error != null) {
                    ?>
                     <div class="alert alert-danger"> <?php echo $error?> </div>
                         <?php
                 }
                 ?>


                 <form method="post" action="login.php">

                     <div class="mb-3">
                         <label for="userName" class="form-label">Username</label>
                         <input type="text" class="form-control" name="userName" id="userName"

                         >

                     </div>
                     <div class="mb-3">
                         <label for="password" class="form-label">Password</label>
                         <input type="password" class="form-control" name="password" id="password"  >
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
