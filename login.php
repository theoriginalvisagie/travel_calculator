<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom JS and CSS -->
    <link rel ="stylesheet" href = "admin/style/style.css">
    <script src = "admin/script/js.js"></script>
    <script src = "admin/script/login.js?v=<?php echo date("Y-m-d H:i:s")?>"></script>
    <!-- ========== -->

    <!-- Bootsrap v5.2 -->
    <link href = "admin/Libraries/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src = "admin/Libraries/Bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ========== -->

    <!-- ImmosrtalCSS V1.0.0 -->
    <link href = "admin/Libraries/ImmortalCSS/css/immortal.css" rel="stylesheet"></script>
    <!-- ========== -->

    <!-- jQuery v3.6.0 -->
    <script src = "admin/Libraries/jQuery/jQuery.js"></script>
    <!-- ========== -->
    
    <!-- FontAwesome v6.1.1-->
    <link href="admin/Libraries/FontAwesome/css/all.css" rel="stylesheet">
    <!-- ========== -->

    <!-- SweetAlert2 v11 -->
    <script src="admin/Libraries/SweetAlert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- ========== -->

    <title>Login | Travel Calculator</title>
</head>
<body class="loginBody" style="overflow: hidden;">
    <div class="row" style="margin:0px; width:100%; height:100vh; padding:0px;">
        <div class="col-7" id="leftSide">
            <div id="loginFormDiv">
                <form>
                    <h1 class="whiteText" style="text-align:center;">Login To Your Account</h1>
                    <h5 class="whiteText" style="text-align:center;">We'll never share your details with anyone else.</h5>
                    <div class="mb-3">
                        <label for="username" class="form-label whiteText">Username:</label>
                        <input type="text" class="textBox lightBg inner" id="username" style="width: 504px; height: 45px;">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label whiteText">Password:</label>
                        <input type="password" class="textBox lightBg inner" id="password" style="width: 504px; height: 45px;">
                    </div>
                    <div style="text-align:center;">
                        <button type="button" class="button blu drop" onclick="checkLoginCredentials()" style="width: 200px; height: 45px;">Login</button>
                        <br><br>
                        <span class="whiteText">Don't have an account? <a href="register.php" style="color:#00D1FF">Sign Up</a></span>
                        <br>
                        <span class="whiteText">Forgot your password? <a href="forgot_password.php" style="color:#00D1FF">Click Here</a></span>
                    </div>
                </form>
            </div>

            <div class="loginFormDiv" id="WelcomeMessage" style="display:none; text-align:center; margin-top:35%;">
            </div>
        </div>
        <div class="col-5" id="rightSide">
            <img src="admin/AppImages/coverImage.png" alt="" srcset="">
        </div>
    </div>
</body>
</html>