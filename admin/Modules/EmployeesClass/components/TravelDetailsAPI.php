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
                    
                        if($column['Column'] == "max_km" || $column['Column'] == "min_km" || $column['Column'] == "factor"){
                            if(!empty($data['exceptions'][0])){
                                $value = $data['exceptions'][0][$column['Column']];
                            }else{
                                $value = "";
                            }
                            
                        }else if($column['Column'] == "name"){
                            $value = ucwords($data[$column['Column']]);
                        }else{
                            $value = $data[$column['Column']];
                        }
                        $values .= "'$value',";
                    }

                    $sql = rtrim($sql,",").") VALUES(".rtrim($values,",",).")";
                    $result = exeSQL($sql);
                    $sql = "";
                    $values = "";
                }
                
            }
        }

        function getAPIData(){
            $apiData = file_get_contents("https://api.staging.yeshugo.com/applicant/travel_types");
            $apiData = json_decode($apiData,true);

            return $apiData;
        }
    }
?>