<?php
session_start();
session_destroy();
header("Location: /northwind-php/login.php");
?>