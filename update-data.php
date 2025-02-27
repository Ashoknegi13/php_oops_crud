<?php
require "database.php";
$obj = new database();

$user_id  = $_POST['sid'];
$user_name  = $_POST['sname'];
$user_age = $_POST['sage'];
$user_city  = $_POST['scity'];

$value = ['student_name'=>$user_name,'age'=>$user_age,'citys'=>$user_city];
if($obj->update("student",$value,"id = $user_id")){
    header("Location: show-data.php");
}else{
    echo " ......./...ERROR...../......";
}
?>