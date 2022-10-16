<?php
    class BiClass{
        function __construct(){
            
        }

        function init(){
            if(isset($_POST['action'])){
                if($_POST['action'] == "Approve"){
                    $response = $this->updateDailyAllowances($_POST['action']);
                }else if($_POST['action'] == "Deny"){
                    $response = $this->updateDailyAllowances($_POST['action']);
                }
            }

            if(isset($response)){
                if($response){
                    echo "<div class='alert alert-success'>Done</div>";
                }
            }

            cardStart("","",false,"","","","auto");
            $this->getTabs();
            cardEnd();
            
        }

        function getTabs(){
            $active = "";
            $link = "?";
            $tabs = array(
                            "Over View"=>"overview",
                            "Daily Approval"=>"dailyApproval"
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
                    if($var == "dailyApproval"){
                        $this->getSubTabs();
                    }else if($var == "overview"){
                        $this->getOverView();
                    }
                    // $this->getEmployeeInformation($id,$var);
                }
            }
        }

        function getSubTabs(){
            $active = "";
            $link = "?&tab=dailyApproval";
            $tabs = array(
                "Pending"=>"pending",
                "Approved"=>"approved",
                "Denied"=>"denied"
            );

            if(!isset($_GET['subTab'])){
                $_GET['subTab'] = "pending";
            }

            echo "<ul class='nav nav-tabs' style='margin-top:15px;'>";foreach($tabs as $tab=>$var){
                if($_GET['subTab'] == $var){
                    $active = "active";
                }

                echo "<li class='nav-item'>
                        <a class='nav-link $active' href='$link&subTab=$var'>$tab</a>
                     </li>";

                $active = "";
            }

            echo "</ul>";

            foreach($tabs as $tab=>$var){
                if($_GET['subTab'] == $var){
                    if($var == "pending"){
                        $this->getdailyApproval("Pending");
                    }else if($var == "approved"){
                        $this->getdailyApproval("Approve");
                    }else if($var == "denied"){
                        $this->getdailyApproval("Deny");
                    }
                }
            }

            
        }

        function getOverView(){
            $listClass = "";
            $gridClass = "";
            if(isset($_POST['listView'])){
                $listClass = "blu";
                $_SESSION['dataView'] = "listView";                       
            }else if(isset($_POST['gridView'])){
                $gridClass = "blu"; 
                $_SESSION['dataView'] = "gridView";             
            }else if($_SESSION['dataView'] == "listView"){
                $listClass = "blu";
            }else if($_SESSION['dataView'] == "gridView"){
                $gridClass = "blu";
            }else{
                $_SESSION['dataView'] = "gridView"; 
            }

            echo "<div style='margin-left:15px; margin-top:20px;'>
                    <form method='post' style='display:inline-block;'>
                        <button type='submit' class='button $gridClass' name='gridView' id='gridView' ><i class='fa fa-th-large'></i> Grid</button>
                        <button type='submit' class='button $listClass' name='listView' id='listView' ><i class='fa fa-bars'></i> List</button>
                    </form>
                    <form method='post' action='components/export.php' enctype='multipart/form-data' style='display:inline-block;'>
                        <button id='exportTable' name='exportTable' id='exportTable' class='button go drop'>Export</button>&nbsp
                        <input type='hidden' name='db' id='id' value='employees'>
                    </form>
                  </div>";
                  
            if(isset($_SESSION['dataView'])){
                if($_SESSION['dataView'] == "gridView"){
                    $this->getIndividualCompensation();
                }else if($_SESSION['dataView'] == "listView"){
                    $this->getCompensation();
                }
            }else if(isset($_POST['listView'])){
                $this->getCompensation();
            }else if(isset($_POST['gridView'])){
                $this->getIndividualCompensation();
            }else{
                $gridClass = "blu";
            }
        }

        function getdailyApproval($status){
            $response = false;
            $headings = array("employee"=>"Name",
                        "transport_type"=>"Transport",
                        "date"=>"Date",
                        "distance"=>"Distance(km)",
                        "daily_allowance"=>"Allowance(€)",
                        "to_from_work"=>"To/From Work",
                        "status"=>"Status"
                    );

            $sql = "SELECT * FROM employees WHERE travel_allowance = '1'";
            $results = exeSQL($sql);

            foreach($results as $result){
                $response = $this->insertDailyTravelAllowance($result);
            }

            if($response){
                echo "<div class='alert alert-success'>Data Added, Please Apporve/Decline</div>";
            }
            
            echo "<table class='table table-striped'>";
            echo "<thead>";
            foreach($headings as $key=>$heading){
                echo "<th>$heading</th>";
            }
            echo "<th>Action</th>";
            echo "</thead>";

            $currentDate = date("Y-m-d");
            $sql = "SELECT * FROM daily_travel_allowance WHERE date = '$currentDate' AND status = '$status'";
            $results = exeSQL($sql);
            foreach($results as $result){
                echo "<tr>";
                foreach($headings as $key=>$heading){
                    echo "<td>";
                    if($key == "employee"){
                        echo $result[$key];
                        // echo getColumnValues("employees","first_name,last_name","id='{$result['id']}'",true);
                    }else if($key == "transport_type"){
                        echo getColumnValues("transport_types","name","id='{$result['transport_type']}'",true);
                    }else if($key == "status"){
                        $badge = "warning";
                        if($result[$key] == "Approve"){
                            $badge = "success";
                        }else if($result[$key] == "Deny"){
                            $badge = "danger";
                        }
                        echo "<span class='badge text-bg-$badge'>{$result[$key]}<span>";
                    }else{
                        echo $result[$key];
                    }
                    echo "</td>";
                }
                echo "<td>";
                echo "<form method='post'>
                        <input type='submit' class='button go-outline drop' name='action' id='action' value='Approve'>
                        <input type='submit' class='button no-outline drop' name='action' id='action' value='Deny'>
                        <input type='hidden' id='id' name='id' value='{$result['id']}'>
                      </form>";
                echo "</td>";
                echo "</tr>";

            }
            echo "</table>";

        }

        function updateDailyAllowances($action){
            $sql = "UPDATE daily_travel_allowance SET status = '$action' WHERE id = '{$_POST['id']}'";
            $response = exeSQL($sql);

            if($response ){
                return true;
            }else{
                return false;
            }
        }

        function insertDailyTravelAllowance($data){
            $currentDate = date("Y-m-d");
            $currentDay = date("D");
            $empWorkDays = array();
            // echo $currentDay;
            $sql = "SELECT * FROM daily_travel_allowance WHERE employee = '{$data['id']}' AND date = '$currentDate'";
            $results = exeSQL($sql);

            $dailyCompensation = $this->getCompensationDays($data);
            $dailyCompensation = $dailyCompensation['maxCompPerDay']/2;

            $workdays = array_filter(explode(",",$data['workdays']));
            foreach($workdays as $workday){
                $empWorkDays[] = getColumnValues("workdays","abreviation","id='$workday'",true);
            }

            if(empty($results)){
                if(in_array($currentDay,$empWorkDays)){
                    $sql = "INSERT INTO daily_travel_allowance(employee,transport_type,date,distance,status,daily_allowance,to_from_work) VALUES('{$data['id']}','{$data['defualt_transport_method']}','$currentDate','{$data['default_distance']}','Pending','$dailyCompensation','To')";
                    $response = exeSQL($sql);

                    $sql = "INSERT INTO daily_travel_allowance(employee,transport_type,date,distance,status,daily_allowance,to_from_work) VALUES('{$data['id']}','{$data['defualt_transport_method']}','$currentDate','{$data['default_distance']}','Pending','$dailyCompensation','From')";
                    $response = exeSQL($sql);

                    if($response){
                        return true;
                    }
                } 
            }
        }

        function getCompensation(){
            $headings = array("name"=>"Name",
                        "transport"=>"Transport",
                        "totalDaysTravelled"=>"Days to date",
                        "totalDistance"=>"Distance to date",
                        "compensation"=>"Compensation to date",
                        "paymentDate"=>"Next Payment date"
                    );
            $sql = "SELECT * FROM employees";
            $result = exeSQL($sql);
            // foreach($result as $key=>$value){        
            //     $data[$value['id']] = $this->getCompensationDays($value); 
                
            // }

            foreach($result as $result){        
                // $data[$value['id']] = $this->getCompensationDays($value); 
                $data[$result['id']] = $this->getCompensationData($result['id']); 
            }


            foreach($data as $key=>$value){        
                
            }
            
            echo "<table class='table table-striped'>";
            echo "<thead>";
            foreach($headings as $key=>$heading){
                echo "<th>$heading</th>";
            }
            echo "</thead>";

            foreach($data as $key=>$value){     
                echo "<tr>";   
                foreach($headings as $key=>$heading){
                    echo "<td>{$value[$key]}</td>"; 
                }
                echo "<tr>"; 
            }
            echo "</table>";
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

                // $data = $this->getCompensationDays($value);
                $data = $this->getCompensationData($value['id']);

                $this->displayData($data);

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

        function getCompensationData($id){
            $sql = "SELECT CONCAT(e.first_name,' ',e.last_name) as employee, dta.transport_type, SUM(dta.daily_allowance) as compensation, SUM(dta.distance) as totalDistance, 
                    COUNT(dta.id) as totalDaysTravelled FROM employees e
                    LEFT JOIN daily_travel_allowance dta ON dta.employee = e.id
                    WHERE e.id='$id'";
            $results = exeSQL($sql);

            $currentMonth = date("m");
            $currentYear = date("Y");

            if($currentMonth < 12){
                $nextMonth = $currentMonth+1;
            }else if($currentMonth == 12){
                $nextMonth = 1;
                $currentYear = $currentYear+1; 
            }
            $paymentDate = date("d-M-Y", strtotime("first monday $currentYear-$nextMonth"));
            $compensationData = array();
            foreach($results as $result){
                $compensationData['name'] = $result['employee'];
                $compensationData['transport'] = getColumnValues("transport_types","name","id='{$result['transport_type']}'",true);
                $compensationData['totalDaysTravelled'] = $result['totalDaysTravelled']/2;
                $compensationData['totalDistance'] = $result['totalDistance'];
                $compensationData['paymentDate'] = $paymentDate;
                $compensationData['compensation'] = $result['compensation'];
            }

            return $compensationData;
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

            $compensationData['name'] = $data['first_name']." ".$data['last_name'];
            $compensationData['transport'] = $transport;
            $compensationData['totalDaysTravelled'] = $totalDaysTravelled;
            $compensationData['totalDistance'] = $totalDistance;
            $compensationData['compensation'] = $compensation;
            $compensationData['paymentDate'] = $paymentDate;
            $compensationData['maxCompPerDay'] = $maxCompPerDay;

            return $compensationData;
        }

        function displayData($data){
            $headings = array(
                "Transport"=>$data['transport'],
                "Days to date"=>$data['totalDaysTravelled']." days",
                "Distance to date"=>$data['totalDistance']." km",
                "Compensation to date"=>"€ ".$data['compensation'],
                "Next Payment date"=>$data['paymentDate']
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