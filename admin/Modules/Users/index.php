
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT?>/admin/Modules/Users/style/style.css">
    <script src="<?php echo URLROOT?>/admin/Modules/Users/script/js.js"></script>
</head>
<body>
    

<?php   
    require_once("includes.php");
    require_once("Users.php");

    $user = new Users();

    if(isset($_POST['uploadPic']) && $_POST['uploadPic']=="Upload"){
        uploadImg();
        $user->saveUserImage();
    }   

    echo $user->init();
?>

</body>
</html>