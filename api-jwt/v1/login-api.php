<?php
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin: *");
header("Access-control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

include_once("../config/database.php");
include_once("../classes/Users.php");

$db = new Database();
$connection = $db->connect();

$user_obj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $data = json_decode(file_get_contents("php://input"));// formdata
    if(!empty($data->email) && !empty($data->password)){
        $user_obj->email = $data->email;
        //$user_obj->password = $data->password;

        $user_data = $user_obj->check_login();
        if(!empty($user_data)){
            $name = $user_data['name'];
            $email = $user_data['email'];
            $password = $user_data['password'];

            if(password_verify($data->password, $password)){//normal password, hashed password
                http_response_code(200);
                echo json_encode(array(
                    "status" => 1,
                    "message" => "User logged in successfully"
                ));
            }else{
                http_response_code(404);
                echo json_encode(array(
                    "status" => 0,
                    "message" => "Invalid credentials123"
                ));
            }
        }else{
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => "Invalid credentials"
            ));
        }

    }else{
        http_response_code(405);
        echo json_encode(array(
            "status" => 0,
            "message" => "All data needed"
        ));
    }
}


?>