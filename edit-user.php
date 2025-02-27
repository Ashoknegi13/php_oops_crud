<?php
require "database.php";
$obj = new database();

$user_id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
    <style>
        lable{
            font-family : arial;
        }
        input{
            border-radius:20px;
            padding:10px
        }

    #btn{
        background-color:green;
        color:white;
        border-radius:5px;
        width:20%;
        margin-left:40%;
        cursor:pointer;
        font-size:15px;
    }
    </style>
</head>
<body>
 
<div style="font-size:25px;margin-left:40%; border: 1px solid black;width:20%;height:300px;padding:30px;padding-left:60px">

        <form action="update-data.php" method="POST">
            <?php
            $row = "student.student_name,student.age,city.cid,city.city_name";
            $obj->select("student",$row,"city ON student.citys=city.cid","id = $user_id");
            $data = $obj->getResult();
          
            foreach($data as list("cid"=>$cid,"student_name"=>$sname,"age"=>$age,"city_name"=>$cname)){
              ?>  <lable>Name : </lable>
                <input type="text" name="sname" placeholder="username" required value="<?php echo $sname ;?>"><br><br>
                <input type="hidden" name="sid"  value="<?php echo $user_id ;?>">
    
                <lable>Age : </lable>
                <input type="number" name="sage" placeholder="age" required  value="<?php echo $age ;?>"><br><br>
            
                <lable>City : </lable>
                <select name='scity'>
                        <option value="<?php  echo $cid ;?>"><?php echo $cname ;?></option>";
                        <?php
                            $obj->select("city");
                            $data1 = $obj->getResult();
                            foreach($data1 as list("cid"=>$city_id,"city_name"=>$city_name)){
                             echo "<option value='$city_id'>$city_name </option>";   
                            }
                        ?>
                      
                </select><br><br>
     <?php 
            }

            ?>
        

            <button style='background-color:green;font-size:20px;margin-bottom:3px' ><a href='show-data.php' style='text-decoration:none;color:yellow'>back</a></button>
            <input type="submit" name="btn" value="Update" id='btn'>    
        
        
         
        </form>
        </div>  
</body>
</html>