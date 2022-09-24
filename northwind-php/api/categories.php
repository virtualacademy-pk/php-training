<?php
include_once '../common/connect.php';
$conn = get_connection();
function add_categories($data)
{
    global $conn;
    $json = json_decode($data, true);
    $categoryId = $json["categoryId"];
    $categoryName = $json["categoryName"];
    $description = $json["description"];
    $sql = "INSERT INTO Categories (CategoryID, CategoryName, Description)
    VALUES (" . $categoryId . ", '" . $categoryName . "','" . $description . "')";
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

function update_category($data)
{
    global $conn;
    $json = json_decode($data, true);
    $categoryId = $json["categoryId"];
    $categoryName = $json["categoryName"];
    $description = $json["description"];
    $sql = "UPDATE Categories set CategoryName =  " . "'" . $categoryName . "',description = '" . $description . "'";
    $sql .= " WHERE categoryId = " . $categoryId;
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

function get_categories()
{
    global $conn;
    $sql = "SELECT categoryId, categoryName,picture From Categories order by CategoryID";
    $sortBy = $_GET['sortby'] ?? '';
    $sortOrder = $_GET['sortorder'] ?? '';
    if (empty($sortOrder)) {
        $sortOrder = 'asc';
    }
    if (empty($sortBy)) {
        $sql = "SELECT categoryId, categoryName,description,Picture From Categories order by CategoryId";
    } else {
        $sql = "SELECT categoryId, categoryName,description,Picture From Categories order by " . $sortBy . ' ' . $sortOrder;

    }
    
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

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_category($id)
{
    global $conn;
    $sql = "SELECT categoryId, categoryName,picture ,description From categories where CategoryId = " . $id;

    
    $response = "{}" ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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

function filter_category($name)
{
    global $conn;

    $sql = "SELECT CategoryID, CategoryName,Picture From Categories where CategoryName like  '%" . $name . "%'";
    $response = array();
    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['categoryId'] = $row['CategoryID'];
            $data['categoryName'] = $row['CategoryName'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}


function delete_category($id)
{
    global $conn;
    $sql = "DELETE FROM  Categories where  CategoryID = " . $id;
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            array("message" => "Category delete with id " . $id)
        );
    } else {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        echo json_encode(
            array("message" => "Can not delete category, its in use.")
        );
    }


}

?>