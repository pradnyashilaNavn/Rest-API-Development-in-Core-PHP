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
    $data = $student->get_all_data();
    //print_r($data);
    if($data->num_rows > 0){
        //we have some data inside table
        $students["records"] = array();
        while($row = $data->fetch_assoc()){
            array_push($students["records"], array(
                "id" => $row['id'],
                "name" => $row['name'],
                "email" => $row['email'],
                "mobile" => $row['mobile'],
                "status" => $row['status'],
                "created_at" => date("y-m-d", strtotime($row['created_at'])),
            ));
        }
        http_response_code(200);
        echo json_encode(array(
            "status" => 200,
            "data" => $students["records"]
        ));
    }


}else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 503,
        "message" => "Access Denied"
    ));
}