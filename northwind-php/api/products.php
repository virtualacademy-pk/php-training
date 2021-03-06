<?php
function add_product($data)
{

    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $productId = $json["productId"];
    $productName = $json["productName"];
    $categoryId = $json["categoryId"];
    $unitPrice = $json["unitPrice"];

    $sql = "INSERT INTO products (productId, productName, categoryId, unitPrice)
    VALUES (" . $productId . ", '" . $productName . "'," . $categoryId . ",". $unitPrice. ")";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create category")
        );
    }

}

function update_product($data)
{
    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $productId = $json["productId"];
    $productName = $json["productName"];
    $categoryId = $json["categoryId"];
    $unitPrice = $json["unitPrice"];


    $sql = "UPDATE products set productName =  " . "'" . $productName . "',categoryId = " . $categoryId . ",unitPrice=" . $unitPrice;
    $sql .= " WHERE productId = " . $productId;
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => $conn->error)
        );
    }
}

function get_products()
{
    $sql = "select productId, productName, categoryId, categoryName,  unitPrice from products";
    $sortBy = $_GET['sortby'] ?? '';
    $sortOrder = $_GET['sortorder'] ?? '';
    if (empty($sortOrder)) {
        $sortOrder = 'asc';
    }
    if (empty($sortBy)) {
        $sql = "select productId, productName, products.categoryId,  categoryName, unitPrice from products inner join categories on products.categoryId = categories.categoryId order by productId";
    } else {
        $sql = "select productId, productName, products.categoryId,  categoryName, unitPrice from products inner join categories on products.categoryId = categories.categoryId  order by " . $sortBy . ' ' . $sortOrder;

    }
    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['productId'] = $row['productId'];
            $data['productName'] = $row['productName'];
            $data['categoryName'] = $row['categoryName'];
            $data['categoryId'] = $row['categoryId'];
            $data['unitPrice'] = $row['unitPrice'];

           
            $response[] = $data;

        }
		
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_product($id)
{

    $sql = "select productId, productName, products.categoryId,  categoryName, unitPrice from products inner join categories on products.categoryId = categories.categoryId where productId = " . $id;

    include_once '../common/connect.php';
    $response ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['productId'] = $row['productId'];
            $data['productName'] = $row['productName'];
            $data['categoryName'] = $row['categoryName'];
            $data['categoryId'] = $row['categoryId'];
            $data['unitPrice'] = $row['unitPrice'];
            $response = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}

function filter_product($name)
{

    $sql = "select productId, productName, categoryId,  unitPrice from products where productName like  '%" . $name . "%'";

    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['productId'] = $row['productId'];
            $data['productName'] = $row['productName'];
  
            $data['categoryId'] = $row['categoryId'];
            $data['unitPrice'] = $row['unitPrice'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}


function delete_product($id)
{
    include_once '../common/connect.php';
    $sql = "DELETE FROM  products where  product = " . $id;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            array("message" => "Product delete with id " . $id)
        );
    } else {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        echo json_encode(
            array("message" => $conn->error)
        );
    }


}

?>