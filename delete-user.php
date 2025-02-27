<?php
require "database.php";
$obj = new database();

$user_id = $_GET['id'];


if($obj->delete("student","id = $user_id")){
    header("Location: show-data.php");
}else{
    echo "/........error ::::";
}


?>