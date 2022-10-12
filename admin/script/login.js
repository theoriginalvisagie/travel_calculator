// var rootDirectory = "localhost/Immortal/admin";

function checkUsernameAvailabiltiy(username){
    $.ajax({  
        type: 'POST',  
        url: 'admin/Ajax/ajaxLogin.php', 
        data: {action:'checkUsernameAvailabiltiy', username:username},
        success: function(response) {
            if(response == "notFound"){
                document.getElementById("usernameReg").style.color = "green";
                document.getElementById("usernameRegMsg").style.display = "none";
                document.getElementById("usernameCheck").value = "true";
            }else if(response == "found"){
                document.getElementById("usernameReg").style.color = "red";
                document.getElementById("usernameRegMsg").style.display = "inline";
                document.getElementById("usernameCheck").value = "false";
            }else{
                document.getElementById("usernameReg").style.color = "black";
                document.getElementById("usernameRegMsg").style.display = "none";
            }
        }
    });
}

function checkEmailAvailabiltiy(email){
    $.ajax({  
        type: 'POST',  
        url: 'admin/Ajax/ajaxLogin.php', 
        data: {action:'checkEmailAvailabiltiy', email:email},
        success: function(response) {
            if(response == "notFound"){
                document.getElementById("emailReg").style.color = "green";
                document.getElementById("emailRegMsg").style.display = "none";
                document.getElementById("emailCheck").value = "true";
            }else if(response == "found"){
                document.getElementById("emailReg").style.color = "red";
                document.getElementById("emailRegMsg").style.display = "inline";
                document.getElementById("emailCheck").value = "false";
            }else{
                document.getElementById("emailReg").style.color = "black";
                document.getElementById("emailRegMsg").style.display = "none";
            }
        }
    });
}

function checkPasswordStrength(password){
    var checkSpecial = /[*@!#%&()^~{}]+/.test(password),
        checkUpper = /[A-Z]+/.test(password),
        checkNumber = /[0-9]+/.test(password);

    if(checkSpecial){
        document.getElementById("specialChar").style.color = "green";
        document.getElementById("specialChar").className = "fas fa-check";
    }else{
        document.getElementById("specialChar").style.color = "red";
        document.getElementById("specialChar").className = "fas fa-times";
    }

    if(checkUpper){
        document.getElementById("upperCase").style.color = "green";
        document.getElementById("upperCase").className = "fas fa-check";
    }else{
        document.getElementById("upperCase").style.color = "red";
        document.getElementById("upperCase").className = "fas fa-times"; 
    }

    if(checkNumber){
        document.getElementById("numberCount").style.color = "green";
        document.getElementById("numberCount").className = "fas fa-check";
    }else{
        document.getElementById("numberCount").style.color = "red";
        document.getElementById("numberCount").className = "fas fa-times";
    }

    if(password.length>=8){
        document.getElementById("numberChar").style.color = "green";
        document.getElementById("numberChar").className = "fas fa-check";
    }else{
        document.getElementById("numberChar").style.color = "red";
        document.getElementById("numberChar").className = "fas fa-times";
    }

    if(checkSpecial && checkUpper && checkNumber && password.length>=8){
        return true;
    }else{
        document.getElementById("passwordStrength").style.display = "block";
    }
}

function confirmPasswordMatch(confirmPassword){
    var password = document.getElementById("passwordReg").value;

    if(password === confirmPassword){
        document.getElementById("confirmPasswordMsg").style.display = "inline";
        document.getElementById("confirmPasswordMsg").style.color = "green";
        document.getElementById("confirmPasswordMsg").innerHTML = "Passwords Match!";
        document.getElementById("passwordCheck").value = "true";
    }else{
        document.getElementById("confirmPasswordMsg").style.display = "inline";
        document.getElementById("confirmPasswordMsg").style.color = "red";
        document.getElementById("confirmPasswordMsg").innerHTML = "Passwords Don't Match!";
        document.getElementById("passwordCheck").value = "false";
    }
}

function confirmDetailsCorrect(){
    var email = document.getElementById("emailCheck").value;
    var username = document.getElementById("usernameCheck").value;
    var password = document.getElementById("passwordCheck").value;

    if(email == "true" && username == "true" && password == "true"){
        createNewUser();
    }else{
        alert("Please confirm everything entered is correct");
    }
}

function createNewUser(){
    var email = document.getElementById("emailReg").value;
    var username = document.getElementById("usernameReg").value;
    var password = document.getElementById("passwordReg").value;

    $.ajax({  
        type: 'POST',  
        url: 'admin/Ajax/ajaxLogin.php', 
        data: {action:'createNewUser', email:email, username:username, password:password},
        success: function(response) {            
            if(response == "true"){
                alert("Welcome " +username);
            }else{
                alert("Try Again");
            }
        }
    });
}

function checkLoginCredentials(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var welcome = document.getElementById("WelcomeMessage");
    $.ajax({  
        type: 'POST',  
        url: 'admin/Ajax/ajaxLogin.php', 
        data: {action:'checkLoginCredentials', username:username, password:password},
        success: function(response) {
            // console.log(response);
            if(response == "true"){
                document.getElementById("loginFormDiv").style.display = "none";
                welcome.style.display = "block";
                welcome.innerHTML = "<h1 class='whiteText'>Welcome "+username+"</h1>"; 
                welcome.innerHTML += "<h3 class='whiteText'>You will be redirected momentarilty.</h3>";
                setTimeout(function () {
                    window.location.href = "admin/home";
                 }, 2000);
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Incorrect Credentials.',
                    text: 'Please try again or reset your password.',
                })
            }

            console.log(response);
        }
    });
}

function checkUserDetailsExists(){
    var username = document.getElementById("usernameForgot").value;
    var email = document.getElementById("emailForgot").value;

    $.ajax({  
        type: 'POST',  
        url: 'admin/Ajax/ajaxLogin.php', 
        data: {action:'checkUserDetailsExists', username:username, email:email},
        success: function(response) {
            // console.log(response);
            if(response == "true"){
                document.getElementById("userErrMsg").style.display = "none";
                document.getElementById("newPassword").style.display = "block";
                document.getElementById("checkDetails").style.display = "none";
                document.getElementById("resetUserPasswordBtn").style.display = "block";
                document.getElementById("confirmNewPassword").style.display = "block";
               
                document.getElementById("emailCheck").value = "true";
                document.getElementById("usernameCheck").value = "true";
            }else{
                document.getElementById("userErrMsg").style.display = "block";
                document.getElementById("usernameForgot").value = "";
                document.getElementById("emailForgot").value = "";
            }
        }
    });
}

function resetUserPassword(){
    var formData = $('#resetuserPassword').serialize();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to reset your password?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00D1FF',
        cancelButtonColor: '#F52323',
        confirmButtonText: 'Yes, reset it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({  
                type: 'POST',  
                url: 'admin/Ajax/ajaxLogin.php', 
                data: {action:'resetUserPassword', formData:formData},
                success: function(response) {
                    if(response == "true"){
                        Swal.fire({
                            title: 'Password Updated',
                            text: 'Please log back into your account',
                            icon: 'success',
                            confirmButtonColor: '#00D1FF',
                            confirmButtonText: 'Return to login.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "http://localhost/Immortal/login.php";
                            }
                        });
                    }
                }
            });
        }else{
            window.location.href="http://localhost/Immortal/login.php";
        }
      })

    
}
