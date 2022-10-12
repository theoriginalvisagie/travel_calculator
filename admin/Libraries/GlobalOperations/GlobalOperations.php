<?php
    function createGUID()
    {
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $set_charid = strtoupper(md5(uniqid(rand(), true)));
            $set_hyphen = chr(45);
            $set_uuid = chr(123)
            .substr($set_charid, 0, 8).$set_hyphen
            .substr($set_charid, 8, 4).$set_hyphen
            .substr($set_charid,12, 4).$set_hyphen
            .substr($set_charid,16, 4).$set_hyphen
            .substr($set_charid,20,12)
            .chr(125);
        
            return $set_uuid;
        }
    }

    function uploadImg(){
        $target_dir = ADMIN_DIR."/SYSTEMREC/User_Profile_Images/";
        foreach($_FILES as $key){
            if($key['type'] == "image/jpeg" || $key['type'] == "image/png"){
                $target_file = $target_dir.basename($key["name"]);
                if(file_exists($target_file)){
                    echo "<div class='alert alert-danger'>File ".basename($key["name"])." Exists, please choose a different file. </div>";
                }else if (move_uploaded_file($key["tmp_name"], $target_file)) {
                    echo "success";
                }
            }
        }
    }

    function fileExists($file){
        $dir = URLROOT."/admin/".$file;
        if(file_exists($dir)){
            $dir = $dir;
        }else{
            $dir = false;
        }

        return $dir;
    }
?>