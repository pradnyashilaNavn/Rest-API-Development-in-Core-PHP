<?php
class Student{
    //declare variables
    public $name; 
    public $email;
    public $mobile;
    public $id;

    private $conn;
    private $table_name;

    public function __construct($db){
        $this->conn = $db;
        $this->table_name = "tbl_students";
    }

    public function create_data(){
        $query = "INSERT INTO " . $this->table_name . " SET name = ?, email = ?, mobile = ?";

        //prepare the sql
        $obj = $this->conn->prepare($query);

        //sanitize input variable => basically removes the extra characters like 
        //some special symbols as well as if some tags available in input values.
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        //binding parameters with prepare statement
        $obj->bind_param("sss", $this->name, $this->email, $this->mobile);

        if($obj->execute()){
            return true;
        }
        return false;
    }

    public function get_all_data(){
        $sql_query = "SELECT * FROM " . $this->table_name;
        $std_obj = $this->conn->prepare($sql_query);
        $std_obj->execute();
        return $std_obj->get_result();
    }

    public function get_single_data(){
        $sql_query = "SELECT * FROM ".$this->table_name." WHERE id = ?";
        $obj = $this->conn->prepare($sql_query);
        $obj->bind_param("i", $this->id);
        $obj->execute();
        $data = $obj->get_result();
        return $data->fetch_assoc();
    }

    public function update_student(){

        $update_query = "UPDATE " . $this->table_name . " SET name = ?, email = ?, mobile = ? WHERE id = ?";

        $query_object = $this->conn->prepare($update_query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

        if($query_object->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function delete_student(){
        $delete_query = "DELETE FROM ".$this->table_name." WHERE id = ?";

        $delete_obj = $this->conn->prepare($delete_query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $delete_obj->bind_param("i", $this->id);

        if($delete_obj->execute()){
            return true;
        }else{
            return false;
        }

    }
}
?>