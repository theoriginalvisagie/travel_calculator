<?php
    class BiClass{
        function __construct(){
            
        }

        function init(){
            cardStart("","",false,"","","","auto");
            $this->getTabs();
            cardEnd();

            
        }

        function getTabs(){
            $active = "";
            $link = "?";
            $tabs = array(
                            "OverView"=>"overview",
                            "Individual"=>"individual"
                        );
            if(!isset($_GET['tab'])){
                $_GET['tab'] = "overview";
            }
            
            echo "<ul class='nav nav-tabs'>";
            foreach($tabs as $tab=>$var){
                if($_GET['tab'] == $var){
                    $active = "active";
                }

                echo "<li class='nav-item'>
                        <a class='nav-link $active' href='$link&tab=$var'>$tab</a>
                     </li>";

                $active = "";
            }

            echo "</ul>";

            foreach($tabs as $tab=>$var){
                if($_GET['tab'] == $var){
                    if($var == "individual"){
                        $this->getIndividualCompensation();
                    }
                    // $this->getEmployeeInformation($id,$var);
                }
            }
        }

        function getIndividualCompensation(){
            $sql = "SELECT * FROM employees";
            $result = exeSQL($sql);
            $count = 0;
            echo "<table>";
            echo "<tr>";
            foreach($result as $key=>$value){                
                echo "<td>";

                cardStart("","","","","290px","290px");
                echo $value['first_name']."<br>";
                $this->getCompensationDays($value);
                cardEnd();

                echo "</td>";

                $count ++;
                if($count == 5){
                    echo "</tr><tr>";
                }  
            }
            echo "</tr>";
        }

        function getCompensationDays($data){
            $firstOfMonth = date("Y")."/".date("m")."/01";
            $transport = getColumnValues("transport_types","name","id='{$data['defualt_transport_method']}'",true);
            $pricePK = getColumnValues("transport_types","base_compensation_per_km","id='{$data['defualt_transport_method']}'",true);
            $maxDistance = getColumnValues("transport_types","max_km","id='{$data['defualt_transport_method']}'",true);
            $minDistance = getColumnValues("transport_types","min_km","id='{$data['defualt_transport_method']}'",true);
            $workDaysPerWeek = $data['workdays_per_week'];
            $distanceOeWay = $data['default_distance'];
            $totalDisatancePerDay = $distanceOeWay*2;

            $bussinessDays =  calculateBusinessDays($firstOfMonth,date("Y-m-d"));
            $weeks = $bussinessDays/5;
            $daysTraveld = $weeks*$workDaysPerWeek;
            $totalDaysTravelled = ceil($daysTraveld);
            $totalDistance = $totalDaysTravelled*$totalDisatancePerDay;
            $factor = getColumnValues("transport_types","factor","id='{$data['defualt_transport_method']}'",true);
            $maxCompPerDay = $totalDisatancePerDay*$pricePK;

            $currentMonth = date("m");
            $currentYear = date("Y");

            if($currentMonth < 12){
                $nextMonth = $currentMonth+1;
            }else if($currentMonth == 12){
                $nextMonth = 1;
                $currentYear = $currentYear+1; 
            }

            echo "Work Days: $workDaysPerWeek <br>";
            echo "Transport: $transport | € $pricePK p/km<br>";
            echo "Total Distance p/d: $totalDisatancePerDay km <br>";
            
            // echo "Bussiness Days: ".$bussinessDays."<br>";
            // echo "Weeks: ".$weeks."<br>";
            echo "Days traveld: ".$totalDaysTravelled."<br>";

            // echo "Distance traveld: ".$totalDistance." km<br>";

            // if($maxDistance > 0 && $maxDistance != "N/A"){
            //     echo "Max Distance: ". $daysTraveld*$maxDistance." km<br>";
            // }else{
            //     echo "Max Distance: N/A"."<br>";
            // }
            

            if($factor != "0.0" && $distanceOeWay >= 5){
                if($distanceOeWay > 10){
                    $maxDoubleCompensation = $maxDistance-$minDistance;
                    $mod = $maxDoubleCompensation;
                }else if($distanceOeWay >= 5 && $distanceOeWay <= 10){
                    $maxDoubleCompensation = $maxDistance-$minDistance;
                    $mod = $distanceOeWay%$maxDoubleCompensation;
                }
                $boubleCompensation = $distanceOeWay-$mod;
                $totalFactorPerDay = ($boubleCompensation*$pricePK) + ($mod*$factor*$pricePK);
                //$boubleCompensation (€ ".$boubleCompensation*$pricePK.") | $mod (€ ".$mod*$factor*$pricePK.")
                $maxCompPerDay = $totalFactorPerDay*2;
                echo "MaxCompPerDay: € $maxCompPerDay<br>";
            }else{
                echo "MaxCompPerDay: € $maxCompPerDay<br>";
            }

            // if($daysTraveld*$maxDistance < $totalDistance){
            //     echo "Compensation: € ".($pricePK*$daysTraveld*$maxDistance)." (€ ".$pricePK*$totalDistance.")<br>";
            // }else{
            //     echo "Compensation: € ".$pricePK*$totalDistance." <br>";
            // }

            echo "Compensation: € ".($maxCompPerDay*$totalDaysTravelled)." <br>";

            echo "Payment Date: " . date("j, d-M-Y", strtotime("first monday $currentYear-$nextMonth"));
        }

        
    }
?>