<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    require_once("../../../../config.php");   
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(LIB_DIR."/GlobalOperations/GlobalOperations.php");
    require_once(MOD_DIR."/BiClass/BiClass.php");    

    $bi = new BiClass();
    $sql = "SELECT * FROM employees";
    $results = exeSQL($sql);

    foreach($results as $result){        
        $data[$value['id']] = $bi->getCompensationData($result['id'],$_POST['startDate'],$_POST['startDate']); 
    }

    $headings = array('Name', 'Transport', 'Days to date', 'Distance to date', "Compensation to date","Next Payment date");
    $date = date("Y-m-d");
    header("Content-Type: text/csv; charset=utf-8");  
    header("Content-Disposition: attachment; filename=travel_allownce_$date.csv");  
    $output = fopen("php://output", "w");  
    fputcsv($output,$headings);  
    
    foreach($data as $key=>$value){
        fputcsv($output, $value);  
    }  
    fclose($output);

?>