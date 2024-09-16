<?php
header("Access-control-Allow-origin: *");
header("Access-control-Allow-Methods: GET");

include_once ("../config/database.php");
include_once ("../classes/student.php");

$db = new Database();

$connection = $db->connect();

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

    $student_id = isset($_GET['id']) ? intval($_GET['id']) : "";
    if(!empty($student_id)){
        $student->id = $student_id;
        $student_data = $student->get_single_data();
        if(!empty($student_data)){
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "data" => $student_data
            ));
        }else{
            http_response_code(404);
            echo json_encode(array(
                "status" => 404,
                "message" => "Student not found"
            ));           
        }

    }

}else{
    http_response_code(503);
    echo json_encode(array(
        "status" => 503,
        "message" => "Access Denined"
    ));     
}