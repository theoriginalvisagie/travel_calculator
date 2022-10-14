<?php
    class TravelApi extends EmployeesClass{
        function __construct(){
            
        }

        function init(){
            echo "<form method='post' style='margin-left:15px;'>
                    <input type='submit' name='checkData' id='checkData' value='Sync' class='button shadow maybe'>
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
                        $this->getLatestData($value);
                    }else{
                        echo "<script>
                                eval('getSwalMessage()');
                              </script>";
                    }
                }
            }
        }

        function getLatestData($data){

        }

        function getAPIData(){
            $apiData = file_get_contents("https://api.staging.yeshugo.com/applicant/travel_types");
            $apiData = json_decode($apiData,true);
            $cnt = 0;
            foreach($apiData as $data){
                if(empty($data['exceptions'])){
                    unset($apiData[$cnt]['exceptions']);
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