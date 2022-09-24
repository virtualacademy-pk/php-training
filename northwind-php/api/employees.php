<?php
include_once '../common/connect.php';
$conn = get_connection();
function add_employee($data)
{

    global $conn;
    $json = json_decode($data, true);

    $employeeId = $json['employeeId'];
    $lastName = $json['lastName'];
    $firstName = $json['firstName'];
    $title = $json['title'];
    $titleOfCourtesy = $json['titleOfCourtesy'];
    $birthDate = $json['birthDate'];
    $hireDate = $json['hireDate'];
    $address = $json['address'];
    $city = $json['city'];
    $region = $json['region'];
    $postalCode = $json['postalCode'];
    $country = $json['country'];
    $homePhone = $json['homePhone'];
    $extension = $json['extension'];
    $notes = $json['notes'];
    $reportsTo = $json['reportsTo'];
    $salary = $json['salary'];

    $sql = "INSERT INTO employees (EmployeeID, LastName, FirstName, Title, TitleOfCourtesy, BirthDate, HireDate, Address, City, Region, PostalCode, Country, HomePhone, Extension, Notes, ReportsTo, Salary)
    VALUES (" . $employeeId . ", '" . $lastName . "','" . $firstName . "','". $title . "','". $titleOfCourtesy . "','". $birthDate . "','". $hireDate . "','". $address . "','". $city . "','". $region . "','". $postalCode . "','". $country . "','". $homePhone . "','". $extension . "','". $notes. "','". $reportsTo. "',". $salary . ")";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create Employee")
        );
    }

}

function update_employee($data)
{
    global $conn;
    $json = json_decode($data, true);

    $employeeId = $json['employeeId'];
    $lastName = $json['lastName'];
    $firstName = $json['firstName'];
    $title = $json['title'];
    $titleOfCourtesy = $json['titleOfCourtesy'];
    $birthDate = $json['birthDate'];
    $hireDate = $json['hireDate'];
    $address = $json['address'];
    $city = $json['city'];
    $region = $json['region'];
    $postalCode = $json['postalCode'];
    $country = $json['country'];
    $homePhone = $json['homePhone'];
    $extension = $json['extension'];
    $notes = $json['notes'];
    $reportsTo = $json['reportsTo'];
    $salary = $json['salary'];


    $sql = "UPDATE employees set ";
    $sql .= " lastName = '$lastName', firstName = '$firstName', title = '$title', titleOfCourtesy = '$titleOfCourtesy', birthDate = '$birthDate', hireDate = '$hireDate', address = '$address', city = '$city', region = '$region', postalCode = '$postalCode', country = '$country', homePhone = '$homePhone', extension = '$extension', notes = '$notes', reportsTo = '$reportsTo', salary = $salary";
    $sql .= " WHERE EmployeeID = $employeeId";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to Delete Employee")
        );
    }
}

function get_employees()
{
    $sql = "select EmployeeID, LastName, FirstName, Title, TitleOfCourtesy, BirthDate, HireDate, Address, City, Region, PostalCode, Country, HomePhone, Extension, Photo, Notes, ReportsTo, PhotoPath, Salary from employees";
    $sortBy = $_GET['sortby'] ?? '';
    $sortOrder = $_GET['sortorder'] ?? '';
    if (empty($sortOrder)) {
        $sortOrder = 'asc';
    }
    if (empty($sortBy)) {
        $sql = "select e.EmployeeID, e.LastName, e.FirstName, e.Title, e.TitleOfCourtesy, e.BirthDate,
       e.HireDate, e.Address, e.City, e.Region, e.PostalCode, e.Country, e.HomePhone, e.Extension,
       e.Photo, e.Notes, e.ReportsTo, concat(r.FirstName, ' ', r.LastName) ReportsToName ,e.PhotoPath, e.Salary
from employees e LEFT JOIN employees r on e.ReportsTo = r.EmployeeID order by e.EmployeeID";
    } else {
        $sql = "select e.EmployeeID, e.LastName, e.FirstName, e.Title, e.TitleOfCourtesy, e.BirthDate,
       e.HireDate, e.Address, e.City, e.Region, e.PostalCode, e.Country, e.HomePhone, e.Extension,
       e.Photo, e.Notes, e.ReportsTo, concat(r.FirstName, ' ', r.LastName) ReportsToName ,e.PhotoPath, e.Salary
from employees e LEFT JOIN employees r on e.ReportsTo = r.EmployeeID  order by e." . $sortBy . ' ' . $sortOrder;

    }
    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['employeeId'] = $row['EmployeeID'];
            $data['lastName'] = $row['LastName'];
            $data['firstName'] = $row['FirstName'];
            $data['title'] = $row['Title'];
            $data['titleOfCourtesy'] = $row['TitleOfCourtesy'];
            $data['birthDate'] = $row['BirthDate'];
            $data['hireDate'] = $row['HireDate'];
            $data['address'] = $row['Address'];
            $data['city'] = $row['City'];
            $data['region'] = $row['Region'];
            $data['postalCode'] = $row['postalCode'];
            $data['country'] = $row['Country'];
            $data['homePhone'] = $row['HomePhone'];
            $data['extension'] = $row['Extension'];
            $data['notes'] = $row['Notes'];
            $data['reportsTo'] = $row['ReportsTo'];
            $data['reportsToName'] = $row['ReportsToName'];
            $data['photo'] =  base64_encode($row['Photo']);
            $data['salary'] = $row['Salary'];

           
            $response[] = $data;

        }
		
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_employee($id)
{

    $sql = "select e.EmployeeID, e.LastName, e.FirstName, e.Title, e.TitleOfCourtesy, e.BirthDate,
       e.HireDate, e.Address, e.City, e.Region, e.PostalCode, e.Country, e.HomePhone, e.Extension,
       e.Photo, e.Notes, e.ReportsTo, concat(r.FirstName, ' ', r.LastName) ReportsToName ,e.PhotoPath, e.Salary
from employees e LEFT JOIN employees r on e.ReportsTo = r.EmployeeID where e.employeeID = $id ";

    global $conn;
    $response ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['employeeId'] = $row['EmployeeID'];
            $data['lastName'] = $row['LastName'];
            $data['firstName'] = $row['FirstName'];
            $data['title'] = $row['Title'];
            $data['titleOfCourtesy'] = $row['TitleOfCourtesy'];
            $data['birthDate'] = $row['BirthDate'];
            $data['hireDate'] = $row['HireDate'];
            $data['address'] = $row['Address'];
            $data['city'] = $row['City'];
            $data['region'] = $row['Region'];
            $data['postalCode'] = $row['postalCode'];
            $data['country'] = $row['country'];
            $data['homePhone'] = $row['HomePhone'];
            $data['photo'] =  base64_encode($row['Photo']);
            $data['extension'] = $row['Extension'];
            $data['notes'] = $row['Notes'];
            $data['reportsTo'] = $row['ReportsTo'];
            $data['reportsToName'] = $row['ReportsToName'];
            $data['salary'] = $row['Salary'];
            $response = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}

function filter_employee($name)
{

    $sql = "select e.EmployeeID, e.LastName, e.FirstName, e.Title, e.TitleOfCourtesy, e.BirthDate,
       e.HireDate, e.Address, e.City, e.Region, e.PostalCode, e.Country, e.HomePhone, e.Extension,
       e.Photo, e.Notes, e.ReportsTo, concat(r.FirstName, ' ', r.LastName) ReportsToName ,e.PhotoPath, e.Salary
from employees e LEFT JOIN employees r on e.ReportsTo = r.EmployeeID  ";

    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['employeeId'] = $row['EmployeeID'];
            $data['lastName'] = $row['LastName'];
            $data['firstName'] = $row['FirstName'];
            $data['title'] = $row['Title'];
            $data['titleOfCourtesy'] = $row['TitleOfCourtesy'];
            $data['birthDate'] = $row['BirthDate'];
            $data['hireDate'] = $row['HireDate'];
            $data['address'] = $row['Address'];
            $data['city'] = $row['City'];
            $data['region'] = $row['Region'];
            $data['postalCode'] = $row['postalCode'];
            $data['country'] = $row['country'];
            $data['homePhone'] = $row['HomePhone'];
            $data['photo'] =  base64_encode($row['Photo']);
            $data['extension'] = $row['Extension'];
            $data['notes'] = $row['Notes'];
            $data['reportsTo'] = $row['ReportsTo'];
            $data['reportsToName'] = $row['ReportsToName'];
            $data['salary'] = $row['Salary'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}


function delete_employee($id)
{
    global $conn;
    $sql = "DELETE FROM  employees where  employeeId = " . $id;

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