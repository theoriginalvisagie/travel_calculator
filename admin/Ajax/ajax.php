<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);

    require_once("../../config.php");
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(LIB_DIR."/GlobalOperations/GlobalOperations.php");
    require_once(LIB_DIR."/InterfaceComponents/InterfaceComponents.php");


    if($_POST['action']=="getModalContent"){
        $url = str_replace(URLROOT,"",$_SERVER['HTTP_REFERER']);
        if(strpos($url,"/admin/Modules") !== false){
            $url = explode("/",$url);
            if(isset($url[3])){
                $module = $url[3];
            }

            include(MOD_DIR."/".$module."/$module.php");

            if(method_exists($module,"getModalContent")){
                $object = new $module;
                echo $object->getModalContent($_POST['id'],$_POST['table']);
            }else{
                echo getModalContent($_POST['id'],$_POST['table']);
            }
        }else{
            echo getModalContent($_POST['id'],$_POST['table']);
        }
    }else if($_POST['action']=="removeEntry"){
        $sql = "DELETE FROM {$_POST['table']} WHERE id='{$_POST['id']}'";

        $result = exeSQL($sql);

        if($result){
            echo "true";
        }else{
            echo "Deletion Error!";
        }
    }else if($_POST['action']=="Add"){
        $url = str_replace(URLROOT,"",$_SERVER['HTTP_REFERER']);
        if(strpos($url,"/admin/Modules") !== false){
            $url = explode("/",$url);
            if(isset($url[3])){
                $module = $url[3];
            }

            include(MOD_DIR."/".$module."/$module.php");

            if(method_exists($module,"getAddEditEntry")){
                $object = new $module;
                echo $object->getAddEditEntry("",$_POST['table']);
            }else{
                echo getAddEditEntry("",$_POST['table']);
            }
        }else{
            echo getAddEditEntry("",$_POST['table']);
        }
    }else if($_POST['action']=="saveNewEntry"){
        $formData = explode("&",$_POST['formData']);
        foreach($formData as $data){
            $key = substr($data,0,strpos($data,"="));
            $value = substr($data,strpos($data,"=")+1);

            $dataArr[$key] = $value;
        }

        $sql = "INSERT INTO {$_POST['table']}(";
        foreach($dataArr as $field=>$value){
            $columns .= "$field,";
            $dataValue = str_replace("%20"," ",$value);
            $dataValue = str_replace("%40","@",$dataValue);
            $dataValue = str_replace("%2C",",",$dataValue);
            $values .= "'$dataValue',";
        }
        $columns = rtrim($columns,",");
        $columns .= ") VALUES (";

        $values = rtrim($values,",");
        $values .= ")";

        $sql .= $columns . $values;
        // echo $sql;
        $result = exeSQL($sql);
        if($result){
            echo "true";
        }else{
            echo "false";
        }

    }else if($_POST['action']=="Edit"){
        $url = str_replace(URLROOT,"",$_SERVER['HTTP_REFERER']);
        if(strpos($url,"/admin/Modules") !== false){
            $url = explode("/",$url);
            if(isset($url[3])){
                $module = $url[3];
            }

            include(MOD_DIR."/".$module."/$module.php");

            if(method_exists($module,"getAddEditEntry")){
                $object = new $module;
                echo $object->getAddEditEntry($_POST['id'],$_POST['table']);
            }else{
                echo getAddEditEntry($_POST['id'],$_POST['table']);
            }
        }else{
            echo getAddEditEntry($_POST['id'],$_POST['table']);
        }
        
    }else if($_POST['action']=="updateEntry"){
        $formData = explode("&",$_POST['formData']);
        foreach($formData as $data){
            $key = substr($data,0,strpos($data,"="));
            $value = substr($data,strpos($data,"=")+1);

            $dataArr[$key] = $value;
        }

        $sql = "UPDATE {$_POST['table']} SET ";

        foreach($dataArr as $field=>$value){
            if($field == "id"){
                $id = $value;
            }else{
                $dataValue = str_replace("%20"," ",$value);
                $dataValue = str_replace("%40","@",$dataValue);
                $dataValue = str_replace("%2C",",",$dataValue);
                $sql .= $field ."='$dataValue',";
            }
        }

        $sql = rtrim($sql,",");

        $sql .= " WHERE id='{$_POST['id']}' ";
        // echo $sql;
        $result = exeSQL($sql);
        if($result){
            echo "true";
        }else{
            echo "false";
        }
    }else if($_POST['action']=="getnextTablePage"){
        session_start();
        $_SESSION[$_POST['table']]['page_no'] = $_POST['pageNo'];
    }
?>