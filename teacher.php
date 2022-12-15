<?php
include_once("user.php");
class Teacher implements user{
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
    public function add_grade($c_id,$course_name,$grade){
        $sql = "INSERT INTO grades(c_id,course_name,grade,teacher_id) VALUES(".$c_id.",'".$course_name."',".$grade.",".$this->id.");";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function edit_grade($id,$grade){
        $sql = "UPDATE grades SET grade=".$grade." WHERE id=".$id." and approved=0 ;";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function make_meeting($date){
        $sql = "INSERT INTO meeting(t_id,date) VALUES(".$this->id.",'".$date."');";
        if(mysqli_query($this->conn,$sql)){
            return mysqli_insert_id($this->conn);
        }
        return -1;
    }
    public function schedule_meeting($m_id,$parents_id){
        foreach($parents_id as $p_id){
            $sql = "INSERT INTO send_meeting(m_id,p_id) VALUES(".$m_id.",".$p_id.");";
            mysqli_query($this->conn,$sql);
        }
    }
    public function send_message($to,$text){
        $sql = "INSERT INTO messages(from_user,to_user,text) VALUES(".$this->id.",".$to.",'".$text."');";
        echo $sql;
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function write_comment($c_id,$comment){
        $sql = "INSERT INTO comment(t_id,c_id,comment) VALUES(".$this->id.",".$c_id.",'".$comment."');";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
}