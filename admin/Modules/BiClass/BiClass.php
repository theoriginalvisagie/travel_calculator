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

                cardStart("","","","","290px","370px");
                $userImg = $this->getProfilePhoto($value['profile_pic']);
                echo "<div style='display:table;'>";
                echo "<img class='circle' src='$userImg' style='height:55px; width:auto; display:inline-block;'>&nbsp";
                echo "<h3 style='display:table-cell; vertical-align:middle'>{$value['first_name']} {$value['last_name']}</h3>";
                echo "</div>";
                $this->getCompensationDays($value);
                cardEnd();

                echo "</td>";

                $count ++;
                if($count == 4){
                    echo "</tr><tr>";
                }  
            }
            echo "</tr>";
        }

        function getProfilePhoto($photo){
            if(!empty($photo)){
                $userImg = URLROOT."/admin/".$photo;
                if(fileExists($photo)){
                    $userImg = URLROOT."/admin/".$photo;
                }else{
                    $userImg = URLROOT."/admin/SYSTEMREC/Default_images/profile_defualt.jpg";
                }
            }else{
                $userImg = URLROOT."/admin/SYSTEMREC/Default_images/profile_defualt.jpg";
            }

            return $userImg;
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
                $maxCompPerDay = $totalFactorPerDay*2;
            }

            $transport = "$transport @ € $pricePK p/km";
            $compensation =  number_format($maxCompPerDay*$totalDaysTravelled,2);
            $paymentDate = date("d-M-Y", strtotime("first monday $currentYear-$nextMonth"));
            $this->displayData($transport,$totalDaysTravelled,$totalDistance,$compensation,$paymentDate);
        }

        function displayData($transport,$daysTraveld,$distanceTraveld,$compensation,$paymentDate){
            $headings = array(
                "Transport"=>$transport,
                "Days to date"=>$daysTraveld." days",
                "Distance to date"=>$distanceTraveld." km",
                "Compensation to date"=>"€ ".$compensation,
                "Next Payment date"=>$paymentDate
            );

            echo "<table class='table'>";
            foreach($headings as $heading=>$data){
                echo "<tr>";
                echo "<td>$heading</td>";
                echo "<td>$data</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    }
?>