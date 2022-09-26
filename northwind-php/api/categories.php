<?php
    include_once '../common/connect.php';
    $conn = get_connection();

function add_categories($data)
{
    header('Content-Type: application/json');
    global $conn;
    $json = json_decode($data, true);
    $categoryId = $json["categoryId"];
    $categoryName = $json["categoryName"];
    $description = $json["description"];
    $sql = "INSERT INTO Categories (CategoryID, CategoryName, Description)
    VALUES (" . $categoryId . ", '" . $categoryName . "','" . $description . "')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('HTTP/1.1 200 OK');
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create category")
        );
    }

}


function update_category($data)
{
    header('Content-Type: application/json');
    global $conn;
    $json = json_decode($data, true);
    $categoryId = $json["categoryId"];
    $categoryName = $json["categoryName"];
    $description = $json["description"];
    $sql = "UPDATE Categories set CategoryName =  " . "'" . $categoryName . "',description = '" . $description . "'";
    $sql .= " WHERE categoryId = " . $categoryId;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('HTTP/1.1 200 OK');
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => $conn->error)
        );
    }
}

function get_categories()
{
    global $conn;
    $sql = "SELECT categoryId, categoryName,description,Picture From Categories order by CategoryId";


    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['categoryId'] = $row['categoryId'];
            $data['categoryName'] = $row['categoryName'];
            $data['description'] = $row['description'];
            $data['picture'] =  base64_encode($row['Picture']);
            $response[] = $data;

        }
        $conn->close();
        header('HTTP/1.1 200 OK');
        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_category($id)
{
    global $conn;
    $sql = "SELECT categoryId, categoryName,description,Picture From Categories where  CategoryId = $id";


    $response = '{}';

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            $data['categoryId'] = $row['categoryId'];
            $data['categoryName'] = $row['categoryName'];
            $data['description'] = $row['description'];
            $data['picture'] =  base64_encode($row['Picture']);
            $response = $data;


        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}


function delete_category($id)
{
    header('Content-Type: application/json');

    global $conn;
    $sql = "DELETE FROM  Categories where  CategoryID = " . $id;
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('HTTP/1.1 200 OK');
        echo json_encode(
            array("message" => "Category delete with id " . $id)
        );
    } else {
        $conn->close();

        header('HTTP/1.1 500 Internal Server Error');

        echo json_encode(
            array("message" => "Can not delete category, its in use.")
        );
    }


}
?>