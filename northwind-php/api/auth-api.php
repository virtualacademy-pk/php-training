<?php
include "auth.php";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = file_get_contents('php://input');
    $json = json_decode($user, true);
    $userName = $json["userName"];
    $password = $json["password"];
    if (strlen(trim($userName)) > 0 && strlen(trim($userName)) > 0 ) {

       verifyUser($userName, $password);
    } else {
        echo json_encode(
            array("error" => "Both Username and Password are mandatory fields")
        );
    }

}
?>
