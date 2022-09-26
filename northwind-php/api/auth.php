<?php
include_once '../vendors/jwt/src/JWT.php';
include_once '../vendors/jwt/src/Key.php';
include_once '../vendors/jwt/src/ExpiredException.php';

    // https://github.com/firebase/php-jwt
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyUser($userName, $password) {
    $error = null;
        if (strlen(trim($userName)) > 0 && strlen(trim($userName)) > 0 ) {
            $sql = "select u.user_id userId, u.user_name userName,
       concat(e.FirstName,' ', e.LastName) employeeName
    from users u
         inner join employees e on u.employeeId = e.EmployeeID
    where user_name = ? and user_password = ?";

            require_once '../common/connect.php';
            $conn = get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $userName, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                if($row = $result->fetch_assoc()) {
                    $_SESSION["userInfo"] = $row;
                    echo  json_encode(
                        array("token" => generateToken($row))
                    );

                }

            } else {
                header('HTTP/1.1 401 Invalid Credentials');
                $error =  json_encode(
                    array("error" => "Invalid Username of Password")
                );
            }


        } else {

            $error = json_encode(
                array("error" => "Both Username and Password are mandatory fields")
            );
        }
        $conn->close();
        echo $error;

}
function generateToken($user) {
    $iat = time();
    $exp = $iat + 60 * 60;
   // $exp = $iat;
    $payload = array(
            'iss' => 'virtualacademy.com.pk', // Issuer
            'aud' => 'virtualacademy.com.pk', //auidence
            'iat' => $iat, // Issue time
            'exp' => $exp, // Expirly time
        'data' => [
            'userName' => $user["userName"],
            'employeeName' => $user["employeeName"]]
     );
    $jwt = JWT::encode($payload, 'mykey', 'HS512');
    return $jwt;
}

function verify() {
     $header = apache_request_headers();
     $token = str_replace('Bearer ', '', $header['Authorization']);
     try {

         $token = JWT::decode($token, new Key('mykey', 'HS512'));
         /*echo json_encode(
             array("message" => $token->data)
         );*/
         echo $token->data->userName;
     }catch(Exception $e) {
         echo $e->getMessage();
     }
}

?>
