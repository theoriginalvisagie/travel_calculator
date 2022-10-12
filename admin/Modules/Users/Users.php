<?php
    class Users{
        private $userID;

        function __construct(){
            if(isset($_SESSION['userID']) && $_SESSION['userID'] != ""){
                $this->userID = $_SESSION['userID'];
            }
           
        }

        function init(){
            $this->displayUserInfo();
        }

        function getUserInfo($userID){
            $sql = "SELECT us.id,first_name,middle_name,last_name,profile_pic,email,username FROM users_settings us
                    LEFT JOIN users u ON u.id = us.userID
                    WHERE userID = '$userID'";

            $result = exeSQL($sql);
            // echo '<pre>'.print_r($result,true).'</pre>';
                
            return $result;
        }

        function displayUserInfo(){
            $userData = $this->getUserInfo($this->userID);
            $profilePic = $userData[0]['profile_pic'];

            if(!empty($profilePic)){
                $userImg = URLROOT."/admin/".$profilePic;
            }else{
                $userImg = URLROOT."/admin/SYSTEMREC/Default_images/profile_defualt.jpg";
            }

            $width = "width: 100px;";
            cardStart("","",false,"","96px");
            echo "<h1>Edit Profile</h1>";
            cardEnd();

            cardStart("","",false);
            echo "<div class='row'>";
            echo "<div class='col-3 justify-content-center'>
                    <form method='post' enctype='multipart/form-data'>
                    <div class='circle'>
                        <img class='profile-pic' src='$userImg'>
                    </div>
                    <input type='hidden' name='db' id='db' value='users_settings'>
                    <input type='file' name='profilePic' id='profilePic' value=''><br>
                    <input type='submit' name='uploadPic' id='uploadPic' class='button blu-outline' value='Upload' style='margin-top:5px;'>
                    </form>";
            echo "</div>";
            
            echo "<div class='col-9'>";
            echo "<form id='userDetaislForm_{$userData[0]['id']}' name='userDetaislForm_{$userData[0]['id']}'>";
            echo "<table class='table'>";

            echo "<tr>";
            echo "<td style='$width'>First Name:</td>
                  <td><input type='text' class='textBox inner' id='first_name' name='first_name' value='{$userData[0]['first_name']}'></td>
                  <td style='$width'>Middle Name:</td>
                  <td><input type='text' class='textBox inner' id='middle_name' name='middle_name' value='{$userData[0]['middle_name']}'></td>
                  <td style='$width'>Last Name:</td>
                  <td><input type='text' class='textBox inner' id='last_name' name='last_name' value='{$userData[0]['last_name']}'></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td style='$width'>Email:</td>
                  <td><input type='text' class='textBox inner' id='email' name='email' value='{$userData[0]['email']}'></td>
                  <td style='$width'>Username:</td>
                  <td><input type='text' class='textBox inner' id='username' name='username' value='{$userData[0]['username']}'></td>";
            echo "</tr>";

            echo "</table>";
            echo "</form>";
            echo "<input type='button' class='button blu' name='updateUser' id='updateUser' value='Update' onclick='updateUserDetails(\"{$userData[0]['id']}\")'>";
            echo "</div>";
            cardEnd();
        }

        function saveUserImage(){
            $user = getColumnValues("users_settings","id","userID='{$_SESSION['userID']}'");
            $image = "SYSTEMREC/User_Profile_Images/".$_FILES['profilePic']['name'];
            if($user == ""){
                $sql = "INSERT INTO users_settings(profile_pic, userID) VALUES('$image', '{$_SESSION['userID']}')";
            }else{
                $sql = "UPDATE users_settings SET profile_pic = '$image' WHERE id='{$user[0]['id']}'";
            }
            exeSQL($sql);
        }

        function updateUserDetails($userInfo,$userSettingId){
            $userID = getColumnValues("users_settings ","userID","id='$userSettingId'",true);

            $userInfo = explode("&",$userInfo);

            $userFields = array("username","email");
            $userSettingsFields = array("first_name","middle_name","last_name");

            $sqlUser = "UPDATE users SET ";
            $sqlSettings = "UPDATE users_settings SET ";

            foreach($userInfo as $data){
                $key = substr($data,0,strpos($data,"="));
                $value = substr($data,strpos($data,"=")+1);
                $value = str_replace("%40","@",$value);

                if(in_array($key,$userFields)){
                    $sqlUser .= $key." = '$value',";
                }else if(in_array($key,$userSettingsFields)){
                    $sqlSettings .= $key." = '$value',";
                }
            }
            $sqlUser = rtrim($sqlUser,",");
            $sqlUser .= "WHERE id='{$userID[0]}'";   

            $sqlSettings = rtrim($sqlSettings,",");
            $sqlSettings .= "WHERE id='$userSettingId'";  

            $resSettins = exeSQL($sqlSettings);
            $resUser = exeSQL($sqlUser);

            if($resSettins && $resUser){
                echo "success";
            }
        }

    }
?>