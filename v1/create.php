<?php
//include headers 
header("Access-Control-Allow-Origin: *");
// It allow all origins like localhost, any domain or any subdomain
header("Content-type: application/json; charset=UTF-8");
// Data which we are getting inside request
header("Access-Control-Allow_Methods: POST"); //all method type

include_once ("../config/database.php");
include_once ("../classes/student.php");

$db = new Database();

$connection = $db->connect();

//create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $data = json_decode(file_get_contents("php://input"));
    /*    
        -> php://input is a read-only stream that allows you to read raw data from the request body.
            file_get_contents() reads the entire content of the input stream, which is typically used to handle JSON data
            sent via HTTP methods like POST or PUT.
        -> json_decode() is used to convert a JSON string into a PHP variable, usually an array or an object.
        -> json_encode() is the opposite of json_decode(). 
        It converts a PHP variable (array, object, etc.) into a JSON string.
        $array = [
            "name" => "John",
            "email" => "john@example.com"
        ];

        $json = json_encode($array);
        echo $json;  // Outputs: {"name":"John","email":"john@example.com"}
    */

    if(!empty($data->name) && !empty($data->email) && !empty($data->mobile)){
        //submit data
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile = $data->mobile;

        if($student->create_data()){
            http_response_code(200); //success
            echo json_encode(array(
                "status" =>200,
                "message" => "Student has been created"
            ));
        }else{
            http_response_code(500); //Internal server error
            echo json_encode(array(
                "status" =>500,
                "message" => "Failed to insert data"
            ));
        }
    }
}else{
    http_response_code(503); //service unavailable
    echo json_encode(array(
        "status" =>503,
        "message" => "Access denied"
    ));    
}

?>
