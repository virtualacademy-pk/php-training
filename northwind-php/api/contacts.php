<?php
include_once '../common/connect.php';
$conn = get_connection();
function add_contact($contact_type, $data)
{
    global $conn;
    $json = json_decode($data, true);
    $contactId = $json['contactId'];
    $companyName = $json['companyName'];
    $contactName = $json['contactName'];
    $contactTitle = $json['contactTitle'];
    $address = $json['address'];
    $city = $json['city'];
    $regionId = $json['regionId'];
    $postalCode = $json['postalCode'];
    $country = $json['country'];
    $phone = $json['phone'];
    $fax = $json['fax'];


    $sql = "INSERT INTO northwind.contacts (contactID, CompanyName, ContactName, ContactTitle, Address, City, Regionid, PostalCode, Country, Phone, Fax, contact_type_id)
VALUES ($contactId, '$companyName', '$contactName', '$contactTitle', '$address', '$city', $regionId, '$postalCode', '$country','$phone', '$fax', $contact_type);";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => $sql)
        );
    }

}

function update_contact($contact_type, $data)
{
    global $conn;
    $json = json_decode($data, true);

    $contactId = $json['contactId'];
    $companyName = $json['companyName'];
    $contactName = $json['contactName'];
    $contactTitle = $json['contactTitle'];
    $address = $json['address'];
    $city = $json['city'];
    $regionId = $json['regionId'];

    $postalCode = $json['postalCode'];
    $country = $json['country'];
    $phone = $json['phone'];
    $fax = $json['fax'];


    $sql = "UPDATE contacts set ";
    $sql .= "CompanyName = '$companyName', ContactName = '$contactName', ContactTitle = '$contactTitle',
     Address = '$address', City = '$city', RegionId =  $regionId, PostalCode = '$postalCode', Country = '$country', Phone = '$phone', Fax = '$fax'";
    $sql .= " WHERE contact_type_id = $contact_type and  contactID = $contactId";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to Delete Contact")
        );
    }
}

function get_contact_data($contact_type)
{
    $sql = "SELECT contactID, CompanyName, ContactName, ContactTitle, Address, City, Region, PostalCode, Country, Phone, Fax,
       contacts.contact_type_id contactTypeId, ct.contact_type_name contactTypeName
FROM contacts left join contact_types ct on contacts.contact_type_id = ct.contact_type_id  where contacts.contact_type_id = $contact_type";
    $sortBy = $_GET['sortby'] ?? '';
    $sortOrder = $_GET['sortorder'] ?? '';
    if (empty($sortOrder)) {
        $sortOrder = 'asc';
    }
    if (empty($sortBy)) {
        $sql = "SELECT contactID, CompanyName, ContactName, ContactTitle, Address, City, contacts.Regionid regionId, Region.RegionDescription regionName, PostalCode, Country, Phone, Fax,
       contacts.contact_type_id contactTypeId, ct.contact_type_name contactTypeName
FROM contacts
    left join contact_types ct on contacts.contact_type_id = ct.contact_type_id
left join region on region.RegionID = contacts.Regionid
  where contacts.contact_type_id = $contact_type order by contactID";
    } else {
        $sql = "SELECT contactID, CompanyName, ContactName, ContactTitle, Address, City, contacts.Regionid regionId, Region.RegionDescription regionName, PostalCode, Country, Phone, Fax,
       contacts.contact_type_id contactTypeId, ct.contact_type_name contactTypeName
FROM contacts
    left join contact_types ct on contacts.contact_type_id = ct.contact_type_id
left join region on region.RegionID = contacts.Regionid
  where contacts.contact_type_id = $contact_type order by e." . $sortBy . ' ' . $sortOrder;

    }
    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['contactId'] = $row['contactID'];
            $data['companyName'] = $row['CompanyName'];
            $data['contactName'] = $row['ContactName'];
            $data['contactTitle'] = $row['ContactTitle'];
            $data['address'] = $row['Address'];
            $data['city'] = $row['City'];
            $data['regionId'] = $row['regionId'];
            $data['regionName'] = $row['regionName'];
            $data['postalCode'] = $row['PostalCode'];
            $data['country'] = $row['Country'];
            $data['phone'] = $row['Phone'];
            $data['fax'] = $row['Fax'];


           
            $response[] = $data;

        }
		
        $conn->close();


    } else {
        $conn->close();
        $response = $sql;
    }
    return $response;
}

function get_contact($contact_type, $id)
{

    $sql = "SELECT contactID, CompanyName, ContactName, ContactTitle, Address, City, contacts.Regionid regionId, Region.RegionDescription regionName, PostalCode, Country, Phone, Fax,
       contacts.contact_type_id contactTypeId, ct.contact_type_name contactTypeName
FROM contacts
    left join contact_types ct on contacts.contact_type_id = ct.contact_type_id
 left join region on region.RegionID = contacts.Regionid
    where contacts.contact_type_id = $contact_type and  contactId=  $id ";

    global $conn;
    $response = '' ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['contactId'] = $row['contactID'];
            $data['companyName'] = $row['CompanyName'];
            $data['contactName'] = $row['ContactName'];
            $data['contactTitle'] = $row['ContactTitle'];
            $data['address'] = $row['Address'];
            $data['city'] = $row['City'];
            $data['regionId'] = $row['regionId'];
            $data['regionName'] = $row['regionName'];
            $data['postalCode'] = $row['PostalCode'];
            $data['country'] = $row['Country'];
            $data['phone'] = $row['Phone'];
            $data['fax'] = $row['Fax'];

            $response = $data;

        }
        $conn->close();


    } else {
        $conn->close();
        $response =  "{}";
    }
    return $response;
}

function filter_contact($contact_type, $name)
{

    $sql = "SELECT contactID, CompanyName, ContactName, ContactTitle, Address, City, contacts.Regionid regionId, Region.RegionDescription regionName, PostalCode, Country, Phone, Fax,
       contacts.contact_type_id contactTypeId, ct.contact_type_name contactTypeName
FROM contacts
    left join contact_types ct on contacts.contact_type_id = ct.contact_type_id
 left join region on region.RegionID = contacts.Regionid
where contacts.contact_type_id = $contact_type ";

    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['contactId'] = $row['contactId'];
            $data['companyName'] = $row['companyName'];
            $data['contactName'] = $row['contactName'];
            $data['contactTitle'] = $row['contactTitle'];
            $data['address'] = $row['address'];
            $data['city'] = $row['city'];
            $data['regionId'] = $row['regionId'];
            $data['regionName'] = $row['regionName'];
            $data['postalCode'] = $row['postalCode'];
            $data['country'] = $row['Country'];
            $data['phone'] = $row['phone'];
            $data['fax'] = $row['fax'];
            $data['contactTypeId'] = $row['contactTypeId'];
            $data['contactTypeName'] = $row['contactTypeName'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}


function delete_contact($contact_type, $id)
{
    global $conn;
    $sql = "DELETE FROM  contacts where contact_tpe_id = $contact_type and  contactId = " . $id;
    $response = "";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $response =  json_encode(
            array("message" => "Product delete with id " . $id)
        );
    } else {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        $response =  json_encode(
            array("message" => $conn->error)
        );
    }
    return $response;


}

?>