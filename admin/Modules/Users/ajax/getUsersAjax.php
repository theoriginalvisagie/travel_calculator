<?php
    require_once("../../../../config.php");
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(MOD_DIR."/Users/Users.php");

    if(isset($_POST['action'])){
        $user = new Users();
        if($_POST['action'] == "updateUserDetails"){
            $user->updateUserDetails($_POST['formData'],$_POST['value']);
        }
    }
?>