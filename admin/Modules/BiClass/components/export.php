<?php
    require_once("../../../../config.php");   
    require_once(LIB_DIR."/MySQL/MySQL.php");
    require_once(LIB_DIR."/GlobalOperations/GlobalOperations.php");
    require_once(MOD_DIR."/BiClass/BiClass.php");    

    $bi = new BiClass();
    $sql = "SELECT * FROM employees";
    $result = exeSQL($sql);
    foreach($result as $key=>$value){        
        $data[$value['id']] = $bi->getCompensationDays($value); 
    }

    $headings = array('Name', 'Transport', 'Days to date', 'Distance to date', "Compensation to date","Next Payment date");

    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=data.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output,$headings);  
    
    foreach($data as $key=>$value){
        fputcsv($output, $value);  
    }  
    fclose($output);

?>