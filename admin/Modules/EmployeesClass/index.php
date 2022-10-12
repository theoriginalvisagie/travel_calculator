<?php
    require_once("includes.php");
    require_once("EmployeesClass.php");

    $emp = new EmployeesClass();

    // if(isset($_POST['uploadPic']) && $_POST['uploadPic']=="Upload"){
    //     uploadImg();
    //     $user->saveUserImage();
    // }   

    echo $emp->init();
?>