<?php
include_once '../common/connect.php';
$conn = get_connection();
function add_order($data)
{

    global $conn;
    $json = json_decode($data, true);

    $orderId = $json['orderId'];
    $customerId = $json['customerId'];
    $employeeId = $json['employeeId'];
    $orderDate = $json['orderDate'];
    $requiredDate = $json['requiredDate'];
    $shipDate = $json['shipDate'];
    $shipViaId = $json['customerId'];
    $freight = $json['freight'];
    $shipName = $json['shipName'];
    $shipAddress = $json['shipAddress'];
    $shipCity = $json['shipCity'];
    $shipRegionId = $json['shipRegionId'];
    $shipPostalCode = $json['shipPostalCode'];
    $shipCountry = $json['shipCountry'];
    $orderLines = $json['orderLines'];


    $sql = "INSERT INTO orders (OrderID, CustomerID, EmployeeID, OrderDate, RequiredDate, ShippedDate, ShipVia, Freight, ShipName, ShipAddress, ShipCity, ShipRegion, ShipPostalCode, ShipCountry)
    VALUES ($orderId, $customerId, $employeeId, '$orderDate', '$requiredDate', '$shipDate', $shipViaId, $freight, '$shipName', '$shipAddress', '$shipCity', '$shipRegionId', '$shipPostalCode', '$shipCountry')";
    header('Content-Type: application/json');

    if ($conn->query($sql) === TRUE) {
        foreach ($orderLines as $line) {
           add_order_details($line, $conn);
        }
        $conn->close();
        echo json_encode($json);
    } else {
        $conn->close();
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(
            array("message" => "Unable to create order")
        );
    }

}

function update_order($data)
{
    global $conn;
    $json = json_decode($data, true);

    $orderId = $json['orderId'];
    $customerId = $json['customerId'];
    $employeeId = $json['employeeId'];
    $orderDate = $json['orderDate'];
    $requiredDate = $json['requiredDate'];
    $shipDate = $json['shipDate'];
    $shipViaId = $json['customerId'];
    $freight = $json['freight'];
    $shipAddress = $json['shipAddress'];
    $shipCity = $json['shipCity'];
    $shipRegionId = $json['shipRegionId'];
    $shipPostalCode = $json['shipPostalCode'];
    $shipCountry = $json['shipCountry'];
    $orderLines = $json['orderLines'];
    $sql = "update orders set customerId = $customerId, employeeId = $employeeId, orderDate = '$orderDate', requiredDate = '$requiredDate', ShippedDate = '$shipDate',
                  shipVia = $shipViaId, freight =  $freight, shipAddress = '$shipAddress', shipCity = '$shipCity', shipRegion = '$shipRegionId',
                  shipPostalCode =  '$shipPostalCode', shipCountry = '$shipCountry'  WHERE orderId = $orderId";
    header('Content-Type: application/json');
    if ($conn->query($sql) === TRUE) {
        foreach ($orderLines as $line) {
            update_order_details($line, $conn);
        }
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

function get_orders()
{
    $sql = "SELECT o.OrderID orderId, o.CustomerID customerId, c.ContactName customerName, o.EmployeeID employeeId, concat(e.FirstName, ' ', e.LastName ) employeeName,
       o.OrderDate orderDate, o.RequiredDate requiredDate, o.ShipVia shipViaId, sh.CompanyName shipViaName, o.ShippedDate shipDate,
       o.Freight freight, o.shipName, o.ShipAddress shipAddress, o.ShipCity shipCity, o.ShipRegion shipRegionId, r.RegionDescription shipRegionName,
       o.ShipPostalCode shipPostalCode, o.ShipCountry shipCountry
from orders o
left join contacts c on o.CustomerID = c.contactID
left join employees e on o.EmployeeID = e.EmployeeID
left join contacts sh on o.ShipVia = sh.contactID
left join region r on o.ShipRegion = r.regionId";

    global $conn;
    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['orderId'] = $row['orderId'];
            $data['customerId'] = $row['customerId'];
            $data['customerName'] = $row['customerName'];
            $data['employeeId'] = $row['employeeId'];
            $data['employeeName'] = $row['employeeName'];
            $data['orderDate'] = $row['orderDate'];
            $data['requiredDate'] = $row['requiredDate'];
            $data['shipDate'] = $row['shipDate'];
            $data['shipViaId'] = $row['customerId'];
            $data['shipViaName'] = $row['shipViaName'];
            $data['freight'] = $row['freight'];
            $data['shipName'] = $row['shipName'];
            $data['shipAddress'] = $row['shipAddress'];
            $data['shipCity'] = $row['shipCity'];
            $data['shipRegionId'] = $row['shipRegionId'];
            $data['shipRegionName'] = $row['shipRegionName'];
            $data['shipPostalCode'] = $row['shipPostalCode'];
            $data['shipCountry'] = $row['shipCountry'];
            $response[] = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "[]";
    }
}

function get_order($id)
{

    $sql = "SELECT o.OrderID orderId, o.CustomerID customerId, c.ContactName customerName, o.EmployeeID employeeId, concat(e.FirstName, ' ', e.LastName ) employeeName,
       o.OrderDate orderDate, o.RequiredDate requiredDate, o.ShipVia shipViaId, sh.CompanyName shipViaName,o.ShippedDate shipDate ,
       o.Freight freight, o.shipName, o.ShipAddress shipAddress, o.ShipCity shipCity, o.ShipRegion shipRegionId, r.RegionDescription shipRegionName,
       o.ShipPostalCode shipPostalCode, o.ShipCountry shipCountry
from orders o
left join contacts c on o.CustomerID = c.contactID
left join employees e on o.EmployeeID = e.EmployeeID
left join contacts sh on o.ShipVia = sh.contactID
left join region r on o.ShipRegion = r.regionId where o.orderId = $id";

    global $conn;
    $response ;

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            $data['orderId'] = $row['orderId'];
            $data['customerId'] = $row['customerId'];
            $data['customerName'] = $row['customerName'];
            $data['employeeId'] = $row['employeeId'];
            $data['employeeName'] = $row['employeeName'];
            $data['orderDate'] = $row['orderDate'];
            $data['requiredDate'] = $row['requiredDate'];
            $data['shipDate'] = $row['shipDate'];
            $data['shipViaId'] = $row['customerId'];
            $data['shipViaName'] = $row['shipViaName'];
            $data['freight'] = $row['freight'];
            $data['shipName'] = $row['shipName'];
            $data['shipAddress'] = $row['shipAddress'];
            $data['shipCity'] = $row['shipCity'];
            $data['shipRegionId'] = $row['shipRegionId'];
            $data['shipRegionName'] = $row['shipRegionName'];
            $data['shipPostalCode'] = $row['shipPostalCode'];
            $data['shipCountry'] = $row['shipCountry'];
            $data['orderLines'] = get_order_detail($id, $conn);
            $response = $data;

        }
        $conn->close();

        echo json_encode($response);
    } else {
        $conn->close();
        echo "{}";
    }
}


function delete_order($id)
{
    global $conn;
    $sql = "DELETE FROM  orderdetails where  orderId = " . $id;

    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM  orders where  orderId = " . $id;
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            echo json_encode(
                array("message" => "order delete with id " . $id)
            );
        } else {
            $conn->close();
            header('Content-Type: application/json');
            header('HTTP/1.1 500 Internal Server Error');

            echo json_encode(
                array("message" => "Can not delete order, its in use.")
            );
        }
    } else {
        $conn->close();
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        echo json_encode(
            array("message" => "Can not delete order, its in use.")
        );
    }


}

function get_order_detail($order_id, $conn)
{
    $sql = "select d.OrderID orderId, d.ProductID productId, p.productName productName, d.UnitPrice unitPrice, d.Quantity quantity, d.Discount discount,
       (d.UnitPrice*d.Quantity) - d.Discount productPrice
from orderdetails d
inner join products p on d.ProductID = p.ProductID where OrderID = $order_id";

    $response = array();

    $result = $conn->query($sql);
    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['orderId'] = $row['orderId'];
            $data['productId'] = $row['productId'];
            $data['productName'] = $row['productName'];
            $data['unitPrice'] = $row['unitPrice'];
            $data['quantity'] = $row['quantity'];
            $data['discount'] = $row['discount'];
            $data['productPrice'] = $row['productPrice'];
            $response[] = $data;

        }
    } else {
        $response = "[]";
    }
    return $response;
}

function add_order_details($json, $conn)
{
    $orderId = $json['orderId'];
    $productId = $json['productId'];
    $unitPrice = $json['unitPrice'];
    $quantity = $json['quantity'];
    $discount = $json['discount'];
    $sql = "INSERT INTO orderdetails (OrderID, ProductID, UnitPrice, Quantity, Discount) VALUES ($orderId, $productId, $unitPrice, $quantity, $discount)";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

}

function update_order_details($json, $conn)
{
    $orderId = $json['orderId'];
    $productId = $json['productId'];
    $unitPrice = $json['unitPrice'];
    $quantity = $json['quantity'];
    $discount = $json['discount'];
    $sql = "UPDATE orderdetails  set unitPrice = $unitPrice, quantity = $quantity, discount = $discount where orderId = $orderId and productId = $productId";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

}
?>