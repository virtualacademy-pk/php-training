<?php
session_start();
if (!isset($_SESSION['userInfo'])) {
    header("Location: login.php");
}
?>

