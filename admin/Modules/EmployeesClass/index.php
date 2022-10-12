<?php
    require_once("includes.php");
    require_once("EmployeesClass.php");

    $emp = new EmployeesClass();

    // echo '<pre>'.print_r($_POST,true).'</pre>';
    if(isset($_POST['uploadPic']) && $_POST['uploadPic']=="Upload"){
        uploadImg();
        $emp->saveEmployeeImage($_POST['id']);
    }

    echo $emp->init();
?>