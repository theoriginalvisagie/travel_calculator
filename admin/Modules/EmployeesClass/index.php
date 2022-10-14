<script src="<?php echo URLROOT?>/admin/Modules/EmployeesClass/script/js.js"></script>
<?php
    require_once(ADMIN_DIR."/includes.php");
    require_once("EmployeesClass.php");
    require_once(MOD_DIR."/EmployeesClass/includes.php");

    $emp = new EmployeesClass();

    if(isset($_POST['uploadPic']) && $_POST['uploadPic']=="Upload"){
        uploadImg();
        $emp->saveEmployeeImage($_POST['id']);
    }

    echo $emp->init();
?>