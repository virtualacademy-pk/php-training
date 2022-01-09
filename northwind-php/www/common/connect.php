<?php

    $conn = new mysqli(
        'localhost',
        'root',
        'pakistan',
        'northwind',
        3306
    );

    if($conn->connect_error) {
        echo 'Error in Connecting database';
        echo '<br>';
        echo $conn->connect_error;
        exit();
    }

?>