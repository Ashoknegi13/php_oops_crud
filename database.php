<?php
class database{
      private $db_host  = "localhost";
      private $db_user  = "root";
      private $db_pass  = "";
      private $db_name  = "test";

      private $conn = false;
      private $mysqli = "";
      private $result = array();

      public function __construct(){
        if(!$this->conn){
            $this->mysqli =  new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            $this->conn = true;

            if($this->mysqli->connect_error){
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }else{
                return true;
            }

        }
      }

      // this is for insrt the data 
      public function insert($table , $param = array()){
            if($this->tableExists($table)){
                    $columnInDb = implode(", ",array_keys($param));
                    $rowInDb = implode("', '", $param);
                     $sql = "INSERT INTO $table($columnInDb) VALUES ('$rowInDb')";
                    if($this->mysqli->query($sql)){
                        array_push($this->result , " data successfullly insert into databse");
                        return true ;
                    }else{
                        array_push($this->result , " query failed");
                        return false ;
                    }
                }
      }


      // this is for update the data
      public function update($table , $param=array(), $where=null){
            if($this->tableExists($table)){
                // echo "<pre>";
                // print_r($param);
                // echo "</pre>";
                
                $argu = array();

                foreach($param as $key => $value){
                    $argu[] = "$key = '$value'";
                }
                //  echo "<pre>";
                // print_r($argu);
                //  echo "</pre>";

               

               if($where != null){
                     echo  $sql = "UPDATE $table SET ". implode(", ",$argu) . " WHERE $where";
                        if($this->mysqli->query($sql)){
                            array_push($this->result, " data successfully update ");
                            return true;
                        }else{
                            array_push($this->result , " update query failed");
                            return false;
                        }
               }else{
                array_push($this->result, " data not matched enter correct condition ");
                return false;
               }
            }
      }

// this is fro delete the data 
      public function delete($table , $where = null){
            if($this->tableExists($table)){
                if($where != null){
                 echo    $sql = "DELETE FROM $table WHERE $where";
                        if($this->mysqli->query($sql)){
                            array_push($this->result , " Successfully delete data row effected : " . $this->mysqli->affected_rows);
                            return true;
                        }else{
                            array_push($this->result, " delete query failed error is : " . $this->mysqli->error);
                            return false;
                        }
                }else{
                       array_push($this->result, " data not matched enter valid data or id ");
                    return false;
                }
            }
      }


      // this is for fetch the data
      public function select($table,$row="*",$join=null,$where=null,$order=null,$limit=null){
            if($this->tableExists($table)){
                    $sql = "SELECT $row FROM $table ";

                    if($join != null){
                        $sql .= " JOIN $join";
                    }
                    if($where != null){
                        $sql .= " WHERE $where";
                    }
                    if($order != null){
                        $sql .= " ORDER BY $order";
                    }
                    if($limit != null){
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }
                        $start = ($page-1) * $limit;
                        $sql .= " LIMIT $start,$limit";
                    }

                    //echo $sql;
                    $query = $this->mysqli->query($sql);
                    if($query->num_rows > 0){
                        $this->result = $query->fetch_all(MYSQLI_ASSOC);
                        // array_push($this->result , " data starting from : " );
                        return true;
                    }else{
                            array_push($this->result , " Select query failed or query not match: " . $this->mysqli->error);
                            return false;
                    }

            }else{
                return false;
            }
      }


        // pagination code 
        public function pagination($table,$join=null,$where=null,$limit=null){
                if($this->tableExists($table)){
                    
                    if($limit != null){
                         $sql = "SELECT COUNT(*) FROM $table ";
                         if($join != null){
                            $sql .= " JOIN $join";
                         }
                         if($where != null){
                            $sql .= " WHERE $where ";
                         }
                         $query = $this->mysqli->query($sql);
                         if($query){
                            
                            $total_records = $query->fetch_array();  // fetch all data 
                           
                            // echo "<pre>";
                            // print_r($total_records);
                            // echo "</pre>";
                           
                            $total_records =  $total_records [0];  // asign all data number

                            $total_pages = ceil($total_records/$limit);
                            
                            $url = basename($_SERVER['PHP_SELF']);

                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = 1;
                            }

                            echo "<ul>";
                            if($page>1){
                             echo   "<a style='text-decoration:none;font-size:20px;color:black' href=$url?page=".($page-1)."><<<</a>";

                            }
                            for($i=1 ; $i<=$total_pages ;$i++){
                                echo " <a style='text-decoration:none;font-size:20px;color:black' href=$url?page=$i>$i</a>";
                            }

                            if( $page<$total_pages){
                                echo    " <a style='text-decoration:none;font-size:20px;color:black' href=$url?page=".($page+1).">>>></a>";
   
                               }
                               
                            echo "</ul>";

                        }else{
                            array_push($this->result , " Pagination query failed : ".$this->mysqli->error);
                            return false;
                         }
                    }
                }
        }





      // select data base on querys
      public function sql($table,$sql){
            if($this->tableExists($table)){
                $query = $this->mysqli->query($sql);
                if($query->num_rows >0){
                    $this->result = $query->fetch_all(MYSQLI_ASSOC);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }
      }


      // this is for check the table exists or not 
      private function tableExists($table){
            $sql = "SHOW TABLES FROM $this->db_name LIKE '$table' ";
            $tableInDb = $this->mysqli->query($sql);

            if($tableInDb){
                    if($tableInDb->num_rows == 1){
                         return true;
                    }else{
                        array_push($this->result , $table . " table does't exists in database");
                        return false;
                    }
            }else{
                array_push($this->result , $table . " query failed");
                return false;
            }
      }


      // this is for store our data and show the data/error
      public function getResult(){
        $var = $this->result;
        $this->result = array();
        return $var;
      }



      // this is for close the connection
      public function __destruct(){
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
                return true;
            }else{
                return false;
            }
        }
      }



} // database class

?>