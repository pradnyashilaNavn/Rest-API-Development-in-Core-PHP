<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST");
header("Content-type: application/json; charst=UTF-8");

include_once("../config/database.php");
include_once("../classes/Users.php");

$db = new Database();
$connection = $db->connect();
$user_obj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "POST" ){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->name) && !empty($data->email) && !empty($data->password)){

        $user_obj->name = $data->name;
        $user_obj->email = $data->email;
        $user_obj->password = password_hash($data->password, PASSWORD_DEFAULT );

        $email_data = $user_obj->check_email();

        if(!empty($email_data)){
            http_response_code(500);
            echo json_encode(array(
                "status" => 1,
                "message" => "User already exists, try another email address."
            ));
        }else{
            if($user_obj->create_user()){
                http_response_code(200);
                echo json_encode(array(
                    "message" => "User has been created",
                    "status" =>1
                ));
            }else{
                http_response_code(500);
                echo json_encode(array(
                    "message" => "Failed to save user",
                    "status" =>1
                ));            
            }
        }
    }else{
        http_response_code(400);  //400 Bad Request
        echo json_encode(array(
            "message" => "All data needed",
            "status" =>1
        ));
    }
}else{
    http_response_code(405);  //405 (Method Not Allowed).
    echo json_encode(array(
        "message" => "Access Denied",
        "status" =>  0
    ));
}

?>