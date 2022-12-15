<?php
include_once("user.php");
class _Parent implements user{
    public $id;
    public $email;
    public $passwd;
    public $fname;
    public $lname;
    public $conn;
    public $childs_ids;
    function __construct($conn) {
        $this->conn = $conn;
        $childs_ids = array();
    }
    public function login($row){
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->passwd = $row['passwd'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $sql = "SELECT c_id FROM parents WHERE p_id=".$this->id." ;";
        $res = mysqli_query($this->conn,$sql);
        if($res->num_rows > 0){
            while($row = mysqli_fetch_assoc($res)){
                array_push($this->childs_ids,$row['c_id']);
            }
        }
    }
    public function add_child($id,$fname,$lname,$pic){
        $sql = "INSERT INTO child(id,fname,lname,pic) VALUES(".$id.",'".$fname."','".$lname."','".$pic."');";
        // echo $sql;
        // mysqli_query($this->conn,$sql) or die(mysqli_error($this->conn));
        if(mysqli_query($this->conn,$sql)){
            $sql2 = "INSERT INTO parents(p_id,c_id) VALUES(".$this->id.",".$id.");";
            if(mysqli_query($this->conn,$sql2)){
                array_push($this->childs_ids,$id);
                return true;
            }
        }
        return false;
    }
    public function edit_child($id,$fname,$lname){
        $sql = "UPDATE child SET fname='".$fname."',lname='".$lname."' WHERE id=".$id." ;";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function edit_pic($c_id,$pic){
        $sql = "UPDATE child SET pic='".$pic."' WHERE id=".$c_id." ;";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function request_meeting($t_id){
        $sql = "INSERT INTO requests(p_id,t_id) VALUES(".$this->id.",".$t_id.");";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function send_message($to,$text){
        $sql = "INSERT INTO messages(from_user,to_user,text) VALUES(".$this->id.",".$to.",'".$text."');";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
}