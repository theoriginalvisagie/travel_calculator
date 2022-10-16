<?php
    class TravelApi extends EmployeesClass{
        function __construct(){
            
        }

        function init(){
            $lastSynched = getColumnValues("transport_types","last_synced","id!='' ORDER BY last_synced ASC LIMIT 1",true);
            echo "<form method='post' style='margin-left:15px;'>
                    <input type='submit' name='checkData' id='checkData' value='Sync' class='button shadow maybe'>
                    Last Synced: $lastSynched
                 </form>";

            if(isset($_POST['checkData']) && $_POST['checkData'] == "Sync"){
                $this->checkData();
            }
        }

        function checkData(){
            $sql = "SELECT * FROM transport_types";
            $result = exeSQL($sql);

            $apiData = $this->getAPIData();
            if(empty($result)){
                $columns = getTableColumns("transport_types");               
                $values = "";
                $value = "";

                foreach($apiData as $data){
                    $sql = "INSERT INTO transport_types(";
                    foreach($columns as $column){
                        $sql .= "{$column['Column']},";
                    
                        if($column['Column'] == "name"){
                            $value = ucwords($data[$column['Column']]);
                        }else if($column['Column'] == "last_synced"){
                            $value = date("Y-m-d");
                        }else{
                            $value = $data[$column['Column']];
                        }
                        $values .= "'$value',";
                    }

                    $sql = rtrim($sql,",").") VALUES(".rtrim($values,",").")";
                    $result = exeSQL($sql);

                    $sql = "";
                    $values = "";
                }   
            }else if(!empty($result)){
                foreach($result as $key=>$value){
                    if($value['last_synced'] != date("Y-m-d")){
                        $upToDate = $this->getLatestData($value);
                        if($upToDate){
                            echo "<script>
                                    eval('getSwalMessage()');
                                  </script>";
                        }
                    }else{
                        echo "<script>
                                eval('getSwalMessage()');
                              </script>";
                    }
                }
            }
        }

        function getLatestData($data){
            $arr = array("name","base_compensation_per_km","min_km","max_km","factor");
            $apiData = $this->getAPIData();
            $uptoDate = false;
            foreach($apiData as $key=>$value){
                if($value['id'] == $data['id']){
                    foreach($arr as $name){
                        $value[$name] = ucwords($value[$name]);
                        if($data[$name] != $value[$name]){                            
                            $sql = "UPDATE transport_types SET $name = '{$value[$name]}', last_synced = '".date('Y-m-d')."' WHERE id='{$data['id']}'";
                            $response = exeSQL($sql);
                            $uptoDate = true; 
                        }else{
                            $sql = "UPDATE transport_types SET last_synced = '".date('Y-m-d')."' WHERE id='{$data['id']}'";
                            $response = exeSQL($sql);
                            $uptoDate = true; 
                        }
                    }
                } 
            }
            return $uptoDate;
        }

        function getAPIData(){
            $apiData = file_get_contents("https://api.staging.yeshugo.com/applicant/travel_types");
            $apiData = json_decode($apiData,true);
            $cnt = 0;
            foreach($apiData as $data){
                if(empty($data['exceptions'])){
                    unset($apiData[$cnt]['exceptions']);
                    $apiData[$cnt]['min_km'] = "0.0";
                    $apiData[$cnt]['max_km'] = "0.0";
                    $apiData[$cnt]['factor'] = "0.0";
                }else{
                    foreach($data['exceptions'] as $exception=>$arr){
                        foreach($arr as $key=>$value){
                            $apiData[$cnt][$key] = $value;
                        }
                    }
                    unset($apiData[$cnt]['exceptions']);
                }
                $cnt ++;
            }
            return $apiData;
        }
    }
?>