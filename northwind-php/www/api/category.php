<?php
function add_categories($data)
{

    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $categoryId = $json["CategoryId"];
    $categoryName = $json["CategoryName"];
    $description = $json["Description"];
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
    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $categoryId = $json["CategoryId"];
    $categoryName = $json["CategoryName"];
    $description = $json["Description"];

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
    $sql = "SELECT CategoryID, CategoryName,Picture From Categories order by CategoryID";
    $sortBy = $_GET['sortby'] ?? '';
    $sortOrder = $_GET['sortorder'] ?? '';
    if (empty($sortOrder)) {
        $sortOrder = 'asc';
    }
    if (empty($sortBy)) {
        $sql = "SELECT CategoryID, CategoryName,Picture From Categories order by CategoryID";
    } else {
        $sql = "SELECT CategoryID, CategoryName,Picture From Categories order by " . $sortBy . ' ' . $sortOrder;

    }
    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['CategoryID'] = $row['CategoryID'];
            $data['CategoryName'] = $row['CategoryName'];
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

    $sql = "SELECT CategoryID, CategoryName,Picture From Categories where CategoryId = " . $id;

    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['CategoryID'] = $row['CategoryID'];
            $data['CategoryName'] = $row['CategoryName'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function filter_category($name)
{

    $sql = "SELECT CategoryID, CategoryName,Picture From Categories where CategoryName like  '%" . $name . "%'";

    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['CategoryID'] = $row['CategoryID'];
            $data['CategoryName'] = $row['CategoryName'];
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
    include_once '../common/connect.php';
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
            array("message" => $conn->error)
        );
    }


}

?>