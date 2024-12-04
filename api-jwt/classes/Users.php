<?php 
class Users{
    public $name;
    public $email;
    public $password;
    public $user_id;
    public $project_name;
    public $description;
    public $status;

    private $conn;
    private $users_tbl;
    private $projects_tbl;

    public function __construct($db){
        $this->conn = $db;
        $this->users_tbl = 'tbl_users';
        $this->projects_tbl = 'tbl_projects';
    }

    public function create_user(){
        $user_query = "INSERT INTO ".$this->users_tbl." SET name = ?, email = ?, password = ?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param('sss', $this->name, $this->email, $this->password);
        if($user_obj->execute()){
            return true;
        }
        return false;
    }

    public function check_email(){
        $email_query = "SELECT * FROM ".$this->users_tbl." WHERE email = ?";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param('s', $this->email);
        if($usr_obj->execute()){
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
            return array();
    }

    public function check_login(){
        $login_query = "SELECT * FROM ".$this->users_tbl." WHERE email = ? ";
        $login_obj = $this->conn->prepare($login_query);
        $login_obj->bind_param('s', $this->email);
        if($login_obj->execute()){
            $login_data = $login_obj->get_result();
            return $login_data->fetch_assoc();
        }
        return array();
    }

}