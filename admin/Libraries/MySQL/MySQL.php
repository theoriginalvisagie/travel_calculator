<?php
    
    /**
     * Connects to database
     * @param string $sql SQL statment to execute.
     * @return array if SQL stament has data.
     * @return boolean if SQL statement doesn't return data
     */
    function dbConnect($sql){
        $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if($conn->prepare($sql)){
            $result = $conn->query($sql);
            if(isset($result->num_rows)){
                $rows = $result->num_rows;
                if ($rows > 0) {
                    $data = array();
                    for($i=0; $i<$rows; $i++){
                        $data[$i] = $result->fetch_assoc();
                    }
                    return $data;
                }else{
                    return false;
                }
            } else if($result){
                return true;
            }else {
                if(!$result){
                    die($conn->error);
                }
            }
        }else{
            die($conn->error);
        }
        
        $conn->close();
    }

    /**
     * @param string $sql SQL statment to execute.
     * @return stirng from dbConnect.
     */
    function exeSQL($sql){
        return dbConnect($sql);
    }

    // function getArrayDB($results){
    //     // $arrayobject = new ArrayObject($results);
    //     // $iterator = $arrayobject->getIterator();
    //     // if($iterator->valid()){
    //     //     $result = $iterator->current();
    //     //     $iterator->next();
    //     //     return $result;
    //     // }else{
    //     //     return null;
    //     // }
    //     // foreach($results as $result=>$data){
    //     //     return $data;     
    //     //     // echo "<pre>".print_r($result,true)."</pre>";       
    //     // }
    //     // echo "<pre>".print_r($arrayobject,true)."</pre>";   
    //     // return $arrayobject;
    // }

    /**
     * Save new record to table
     * @param array $post data array that needs to be saved
     * @param string $additional additional fields that need to be saved
     * @return boolean if succesful
     */
    function saveNewItem($post, $addtional=""){
        $addColumn = "";
        $addValue = "";
        if(!empty($addtional) && $addtional == "userID"){
            $addColumn = $addtional.",";
            $addValue = "'".$_SESSION['userID']."',";
        }

        $sql = "INSERT INTO {$post['table']}( $addColumn";
        foreach($post as $p=>$value){
            if($p != "addNew" && $p != "table"){
                $sql .= $p.",";
            }           
        }
        $sql = rtrim($sql, ",");
        $sql .= ") VALUES ($addValue ";

        foreach($post as $p=>$value){
            if($p != "addNew" && $p != "table"){
                $sql .= "'".$value."',";
            }           
        }
        $sql = rtrim($sql, ",");
        $sql .= ")";

        $res = exeSQL($sql);

        if($res){
            return true;
        }
    }

    /**
     * Fetches specified columns from table
     * @param string $table Table it needs to get columns from.
     * @param string [optional] $hidden columns to not return.
     * @return array of column names and types.
     */
    function getTableColumns($table,$hidden=""){
        if($hidden != ""){
            $hidden = explode(",",$hidden);

            foreach($hidden as $h){
                $restrict[] = "'".$h."',";
            }

            $restrict = trim(implode($restrict),",");

            $where = "WHERE FIELD NOT IN ($restrict)";
        }

        $sql = "SHOW COLUMNS FROM $table $where";

        $result = exeSQL($sql);
        foreach($result as $key=>$value){
            $columns[$value['Field']]['Column'] = $value['Field'];
            $columns[$value['Field']]['Type'] = $value['Type'];
            $columns[$value['Field']]['Key'] = $value['Key'];  
        }
        return $columns;
        
    }

    /**
     * @param string $table table it needs to get data from.
     * @param string $columns that data needs to come from.
     * @param string $where WHERE statement that needs to be executed.
     * @param boolean [optional] if true returns a string if false returns an array.
     * @return string returns array or string.
     */
    function getColumnValues($table,$columns,$where,$concat=false){
        $resultString = "";
        if($where != ""){
            $where = " WHERE ".$where;
        }

        $sql = "SELECT $columns FROM $table $where";
        $result = exeSQL($sql);
        if($concat){
            foreach($result as $r){
                foreach($r as $value){
                    $resultString .= $value.",";
                }
            }
            $result = trim($resultString,",");
        }else{
            $result = $result;
        }

        return $result;
    }

    /**
     * @param string $table table to pull data from
     * @param string $column column to get data from
     * @param string [optional] $where WHERE statement to execute
     * @return string Min Value found
     */
    function getMin($table,$column,$where=""){
        if($where != ""){
            $where = " WHERE ".$where;
        }

        $sql = "SELECT Min($column) FROM $table $where";
        $result = exeSQL($sql);

        foreach($result as $r){
            foreach($r as $value){
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * @param string $table table to pull data from
     * @param string $column column to get data from
     * @param string $where WHERE statement to execute
     * @return string Max Value found
     */
    function getMax($table,$column,$where=""){
        if($where != ""){
            $where = " WHERE ".$where;
        }

        $sql = "SELECT Max($column) FROM $table $where";
        $result = exeSQL($sql);

        foreach($result as $r){
            foreach($r as $value){
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * @param string $table table to pull data from
     * @param string $column column to get data from
     * @param string $where WHERE statement to execute
     * @return string Count found
     */
    function getCount($table,$column,$where=""){
        if($where != ""){
            $where = " WHERE ".$where;
        }

        $sql = "SELECT COUNT($column) FROM $table $where";
        $result = exeSQL($sql);

        foreach($result as $r){
            foreach($r as $value){
                $result = $value;
            }
        }

        return $result;
    }
?>