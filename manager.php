<?php
include_once("user.php");
class Manager implements user{
    public $id;
    public $email;
    public $passwd;
    public $fname;
    public $lname;
    public $conn;
    function __construct($conn) {
        $this->conn = $conn;
    }
    public function login($row){
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->passwd = $row['passwd'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
    }
    public function make_invitation($message){
        $sql = "INSERT INTO invitation(message) VALUES('".$message."');";
        if(mysqli_query($this->conn,$sql)){
            return mysqli_insert_id($this->conn);
        }
        return -1;
    }
    public function send_invitation($parents_id,$inv_id){
        foreach ($parents_id as $p_id) {
            $sql = "INSERT INTO send_invitation(inv_id,p_id) VALUES(".$inv_id.",".$p_id.");";
            mysqli_query($this->conn,$sql);
        }
    }
    public function approve_grades($grade_id){
        $sql = "UPDATE grades SET approved=1 WHERE id=".$grade_id.";";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function show_messages_from($from){
        $sql = "SELECT * FROM messages WHERE from_user=".$from." ORDER BY time;";
        return mysqli_query($this->conn,$sql);
    }
    public function show_messages_to($to){
        $sql = "SELECT * FROM messages WHERE to_user=".$to." ORDER BY time;";
        return mysqli_query($this->conn,$sql);
    }
    public function show_messages($from,$to){
        $sql = "SELECT * FROM messages WHERE from_user=".$from." and to_user=".$to." ORDER BY time;";
        return mysqli_query($this->conn,$sql);
    }
}