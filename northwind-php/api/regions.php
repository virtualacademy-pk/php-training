<?php
function add_region($data)
{

    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $regionId = $json["regionId"];
    $regionDescription = $json["regionDescription"];

    $sql = "INSERT INTO region (RegionID, RegionDescription)
    VALUES (  $regionId, '$regionDescription')";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create region")
        );
    }

}

function update_region($data)
{
    include_once '../common/connect.php';
    $json = json_decode($data, true);

    $regionId = $json["regionId"];
    $regionDescription = $json["regionDescription"];


    $sql = "UPDATE region set regionDescription = '$regionDescription'";
    $sql .= " WHERE regionId = $regionId";
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

function get_regions()
{
    $sql = "SELECT regionId, regionDescription From region order by regionId";

    include_once '../common/connect.php';
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['regionId'] = $row['regionId'];
            $data['regionDescription'] = $row['regionDescription'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_region($id)
{

    $sql = "SELECT regionId, regionDescription From region where regionId = $id";

    include_once '../common/connect.php';
    $response ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['regionId'] = $row['regionId'];
            $data['regionDescription'] = $row['regionDescription'];
            $response = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}


function delete_region($id)
{
    include_once '../common/connect.php';
    $sql = "DELETE FROM  region where  regionId = " . $id;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            array("message" => "Region delete with id " . $id)
        );
    } else {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        echo json_encode(
            array("message" => "Can not delete region, its in use.")
        );
    }


}

?>