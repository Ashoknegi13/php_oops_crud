<?php
require "database.php";
$obj = new database();
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

        <form action="save-data.php" method="POST">
            <lable>Name : </lable>
            <input type="text" name="sname" placeholder="username" required><br><br>

            <lable>Age : </lable>
            <input type="number" name="sage" placeholder="age" required><br><br>
        
            <lable>City : </lable>
            <select name='scity'>
                    <?php 
                            $obj->select("city");
                            $data = $obj->getResult();
                            foreach($data as list("cid"=>$city_id , "city_name"=>$city_name)){
                                    echo "<option value='$city_id'>$city_name</option>";
                            }
                    
                    ?>
            </select><br><br>

            <button style='background-color:green;font-size:20px;margin-bottom:3px' ><a href='show-data.php' style='text-decoration:none;color:yellow'>back</a></button>
            <input type="submit" name="btn" value="save" id='btn'>    
        
        
         
        </form>
        </div>  
</body>
</html>