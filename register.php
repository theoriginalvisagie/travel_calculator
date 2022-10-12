<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom JS and CSS -->
    <link rel ="stylesheet" href = "admin/style/style.css">
    <script src = "admin/script/js.js"></script>
    <script src = "admin/script/login.js"></script>
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

    <title>Sign Up</title>
</head>
<body class="loginBody" style="overflow: hidden;">
    <div class="row" style="margin:0px; width:100%; height:100vh; padding:0px;">
        <div class="col-7" id="leftSide">
            <div id="RegisterFormDiv">
                <form>
                    <h1 class="whiteText" style="text-align:center;">Register A New Account</h1>
                    <h5 class="whiteText" style="text-align:center;">We'll never share your details with anyone else.</h5>
                    <div class="mb-3">
                        <label for="usernameReg" class="form-label whiteText">Username: <span id="usernameRegMsg" style="display:none; color:red;">Username Exists!</span></label>
                        <input type="text" class="textBox" id="usernameReg" name="usernameReg" onkeyup="checkUsernameAvailabiltiy(this.value)" style="width: 504px; height: 45px;">
                    </div>
                    <div class="mb-3">
                        <label for="emailReg" class="form-label whiteText">Email: <span id="emailRegMsg" style="display:none; color:red;">Email Exists!</span></label>
                        <input type="email" class="textBox" id="emailReg" name="emailReg" onkeyup="checkEmailAvailabiltiy(this.value)" style="width: 504px; height: 45px;">
                        <div id="emailHelp" class="form-text"><span class="whiteText"></span></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordReg" class="form-label whiteText">Password:</label>
                        <input type="password" class="textBox" id="passwordReg" name="passwordReg" onkeyup="checkPasswordStrength(this.value)" style="width: 504px; height: 45px;">
                        <div style='display:none;' name='passwordStrength' id='passwordStrength'>
                            <p class="whiteText" style='font-size:10px; margin-bottom:0;'>Password must contain at least:</p>
                            <ul style="font-size:10px; list-style:none">                                               
                                <li><i class="fas fa-times" style="color:red;" id="upperCase"></i><span class="whiteText"> One Uppercase</span></li>
                                <li><i class="fas fa-times" style="color:red;" id="numberCount"></i><span class="whiteText">  One Number</span></li>
                                <li><i class="fas fa-times" style="color:red;" id="specialChar"></i><span class="whiteText">  One Special Character</span></li>
                                <li><i class="fas fa-times" style="color:red;" id="numberChar"></i><span class="whiteText">  8 Characters</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label whiteText">Confirm Password: <span id="confirmPasswordMsg" style="display:none; color:red;">Passwords Don't match!</span></label>
                        <input type="password" class="textBox" id="confirmPassword" name="confirmPassword" onkeyup="confirmPasswordMatch(this.value)" style="width: 504px; height: 45px;">
                    </div>
                    <div style="text-align:center;">
                        <button type="button" class="button blu drop" onclick="confirmDetailsCorrect()" style="width: 200px; height: 45px;">Sign Up</button>
                        <input type="hidden" name="usernameCheck" id="usernameCheck" value="false">
                        <input type="hidden" name="emailCheck" id="emailCheck" value="false">
                        <input type="hidden" name="passwordCheck" id="passwordCheck" value="false">
                        <br><br>
                        <span class="whiteText">Allready have an account? <a href="login.php" style="color:#00D1FF">Login</a></span>
                    </div>               
                </form>
            </div>
        </div>
        <div class="col-5" id="rightSide">
            <img src="admin/AppImages/coverImage.png" alt="" srcset="">
        </div>
    </div>
</body>
</html>