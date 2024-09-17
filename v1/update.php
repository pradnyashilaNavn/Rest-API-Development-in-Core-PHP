<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 

include_once ("../config/database.php");
include_once ("../classes/student.php");

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->id) ){
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile = $data->mobile;
        $student->id = $data->id;

        if($student->update_student()){
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "message" => "Updated student data succesfully"
            ));
        }else{
            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "message" => "Failed to update data"
            ));
        }        
    }else{
        http_response_code(404);
        echo json_encode(array(
            "status" => 404,
            "message"=> "All data needed"
        ));
    }

}else{
    http_response_code(503);
    echo json_encode(array(
        "status" => 503,
        "message"=> "Access denied"
    ));
}
