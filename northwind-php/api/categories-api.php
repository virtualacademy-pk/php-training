<?php
header('Access-Control-Allow-Origin: *' );
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include 'categories.php';
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    update_category(file_get_contents('php://input'));

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    add_categories(file_get_contents('php://input'));

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (!empty($_GET['id'])) {
        delete_category($_GET['id']);

    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['id'])) {
        get_category($_GET['id']);

    } else {
        get_categories();
    }
}

?>