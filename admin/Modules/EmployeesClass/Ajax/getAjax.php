<?php
    require_once("../../../../config.php");
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(MOD_DIR."/EmployeesClass/EmployeesClass.php");

    if(isset($_POST['action'])){
        $emp = new EmployeesClass();
        if($_POST['action'] == "updateValue"){
            $emp->updateEmployeeDetails($_POST['value'],$_POST['table'],$_POST['id'],$_POST['column']);
        }
    }
?>