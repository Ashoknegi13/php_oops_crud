
<?php
require "database.php";
$obj = new database();
$join = "city ON student.citys=city.cid";
$order = "id DESC ";
$obj->select("student","student.id , student.student_name,student.age,city.city_name",$join,null,$order,null);
// echo "<pre>";
 $data = $obj->getResult();
// echo "</pre>";
 
echo "<div style='margin-left:30%;margin-top:4%'><button style='background-color:green;font-size:20px;margin-bottom:3px' ><a href='form-data.php' style='text-decoration:none;color:yellow'>Add User</a></button>";

echo "<table cellspacing='0px' cellpadding='10px' border='2px solid black'>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Student Age</th>
                <th>Student City</th>
                <th>Operations</th>
            </tr>";

foreach($data as list("id"=>$id , "student_name"=>$name,"age"=>$age,"city_name"=>$cname)){
   echo "<tr>
            <td>$id</td>
            <td>$name</td>
            <td>$age</td>
            <td>$cname</td>
            <td>  <button style='background-color:green'><a href='edit-user.php?id=$id' style='color:white;text-decoration:none;cursor:pointer'>Edit</a></button> 
                   <button style='background-color:red'><a href='delete-user.php?id=$id' style='color:white;text-decoration:none;cursor:pointer'>delete</a></button>
            </td>
        </tr>";
}
echo "</table></div>";


$obj->pagination("student",$join,null,null);

?>