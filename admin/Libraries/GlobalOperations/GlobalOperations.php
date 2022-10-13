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
        $target_dir = ADMIN_DIR."/SYSTEMREC/{$_POST['dir']}/";
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
        $dir = APPROOT."/admin/".$file;

        if(file_exists($file)){
            $dir = $file;
        }else{
            $dir = false;
        }

        return $dir;
    }

    function calculateBusinessDays($startDate,$endDate) {

        if (strtotime($endDate) >= strtotime($startDate)){            
            $holidays = array("2020-12-24","2020-12-25","2020-12-26");
            $date = $startDate;
            $days = 0;
            
            while ($date != $endDate) {
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                $weekday = date("w", strtotime($date));
                if ($weekday != 6 AND $weekday != 0 AND !in_array($date, $holidays)){
                    $days++;  
                } 
            }
            
            return $days;
        }else {
            return "Please check the dates.";
        }  
    }
?>