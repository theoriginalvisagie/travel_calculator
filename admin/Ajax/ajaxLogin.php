<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("../../config.php");
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(LIB_DIR."/GlobalOperations/GlobalOperations.php");

    if($_POST['action']=="checkUsernameAvailabiltiy"){
        $sql = "SELECT username FROM users WHERE username = '{$_POST['username']}'";

        $result = exeSQL($sql);

        if($result){
            echo "found";
        }else{
            echo "notFound";
        }

    }else if($_POST['action']=="checkEmailAvailabiltiy"){
        $sql = "SELECT email FROM users WHERE email = '{$_POST['email']}'";

        $result = exeSQL($sql);

        if($result){
            echo "found";
        }else{
            echo "notFound";
        }

    }else if($_POST['action']=="createNewUser"){
        $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username, password, email) VALUES('{$_POST['username']}','{$_POST['password']}','{$_POST['email']}')";
        $response = exeSQL($sql);

        if($response){
            echo "true";
        }else{
            echo "false";
        }

    }else if($_POST['action']=="checkLoginCredentials"){

        $sql = "SELECT username,password,id FROM users WHERE username = '{$_POST['username']}'";

        $result = exeSQL($sql);

        $password = $_POST["password"];
        $hashed_password = $result[0]['password'];

        $passwordCheck = password_verify($password, $hashed_password);

        if($passwordCheck){
            if(isset($_SESSION['username']) && $_SESSION['username'] == $_POST['username']){
                session_destroy();
                session_start();
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['userID'] = $result[0]['id'];
                $_SESSION['dateLogedIn'] = date("Y-m-d H:i:s");
                $_SESSION['guid'] = createGUID();
            }else{
                session_start();              
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['userID'] = $result[0]['id'];
                $_SESSION['dateLogedIn'] = date("Y-m-d H:i:s");
                $_SESSION['guid'] = createGUID();
            }
            echo "true";
        }else{
            echo "false";
        }
        
    }else if($_POST['action']=="checkUserDetailsExists"){
        $sql = "SELECT username,email FROM users WHERE username = '{$_POST['username']}' AND email = '{$_POST['email']}'";

        $result = exeSQL($sql);

        if($result){
            echo "true";
        }else{
            echo "false";
        }
    }else if($_POST['action']=="resetUserPassword"){

        $formData = explode("&",$_POST['formData']);
        foreach($formData as $data){
            $key = substr($data,0,strpos($data,"="));
            $value = substr($data,strpos($data,"=")+1);

            $dataArr[$key] = $value;
        }

        foreach($dataArr as $key=>$value){
            if($value != "" && ($key == "usernameCheck" || $key == "emailCheck" || $key == "passwordCheck")){
                $res = true;
            }else if($value != "" && ($key == "confirmNewUserPassword" || $key == "emailForgot" || $key == "usernameForgot")){
                $res = true;
            }else{
                $res = false;
            }
        }

        if($res){
            $email = str_replace("%40","@",$dataArr['emailForgot']);
            $sql = "SELECT id FROM users WHERE username = '{$dataArr['usernameForgot']}' AND email = '$email'";
            $result = exeSQL($sql);
            $userID = $result[0]['id'];

            $dataArr['confirmNewUserPassword'] = password_hash($dataArr["confirmNewUserPassword"], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = '{$dataArr['confirmNewUserPassword']}' WHERE id = '$userID'";
            $result = exeSQL($sql);

            if($result){
                echo "true";
            }else{
                echo "false";
            }
        }
    }
?>
