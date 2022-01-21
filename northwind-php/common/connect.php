<?php

    $conn = new mysqli(
        '192.168.120.100',
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