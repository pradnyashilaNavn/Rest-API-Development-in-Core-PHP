<?php
//ini_set("display_errors", 200); // to show error 
header("Access-control-Allow-origin: *");
header("Access-control-Allow-Methods: GET");

include_once ("../config/database.php");
include_once ("../classes/student.php");

$db = new Database();

$connection = $db->connect();

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

    $student_id = isset($_GET['id']) ? $_GET['id'] : "";
    if(!empty($student_id)){
        $student->id = $student_id;
        if($student->delete_student()){
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "message" => "Student deleted successfully"
            ));
        }else{
            http_response_code(404);
            echo json_encode(array(
                "status" => 404,
                "message" => "Failed to delete student"
            ));           
        }

    }

}else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 503,
        "message" => "Access Denied"
    ));
}