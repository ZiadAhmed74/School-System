<?php
$conn = mysqli_connect('localhost','root','','school');
if($conn==false){
    die("connection error");
}