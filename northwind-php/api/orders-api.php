<?php
header('Access-Control-Allow-Origin: *' );
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include 'orders.php';
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $json = file_get_contents('php://input');
    update_order($json);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    add_order($json);

}  else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
 
    if(!empty($_GET["id"]))
    {
       $id=intval($_GET["id"]);
       delete_order($id);
     
    }
} else {
    if(!empty($_GET["id"]))
    {
        $id=intval($_GET["id"]);
        get_order($id);
    } else if(!empty($_GET["name"])) {
        $name=$_GET["name"]; 
        filter_order($name);
    } else {
        get_orders();
    }
}
?>