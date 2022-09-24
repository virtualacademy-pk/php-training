<?php
include_once '../common/connect.php';
$conn = get_connection();
function add_territory($data)
{

    global $conn;
    $json = json_decode($data, true);

    $territoryId = $json["territoryId"];
    $territoryName = $json["territoryName"];
    $regionId = $json["regionId"];

    $sql = "INSERT INTO territories (territoryId, territoryName, regionId)
    VALUES (  $territoryId, '$territoryName', $regionId)";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create Territory")
        );
    }

}

function update_territory($data)
{
    global $conn;
    $json = json_decode($data, true);

    $territoryId = $json["territoryId"];
    $territoryName = $json["territoryName"];
    $regionId = $json["regionId"];


    $sql = "UPDATE territories set territoryName = '$territoryName', regionId = $regionId";
    $sql .= " WHERE territoryId = $territoryId";
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

function get_territories()
{
    $sql = "SELECT t.TerritoryID territoryId, t.TerritoryName territoryName, t.regionId , r.RegionDescription regionName
from territories t inner join region r on t.RegionID = r.RegionID";

    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['territoryId'] = $row['territoryId'];
            $data['territoryName'] = $row['territoryName'];
            $data['regionId'] = $row['regionId'];
            $data['regionName'] = $row['regionName'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_territory($id)
{

    $sql = "SELECT t.TerritoryID territoryId, t.TerritoryName territoryName, t.regionId , r.RegionDescription regionName
from territories t inner join region r on t.RegionID = r.RegionID  where territoryId = $id";

    global $conn;
    $response ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['territoryId'] = $row['territoryId'];
            $data['territoryName'] = $row['territoryName'];
            $data['regionId'] = $row['regionId'];
            $data['regionName'] = $row['regionName'];
            $response = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}


function delete_territory($id)
{
    global $conn;
    $sql = "DELETE FROM  territories where  territoryId = " . $id;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            array("message" => "Territory deleted with id " . $id)
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