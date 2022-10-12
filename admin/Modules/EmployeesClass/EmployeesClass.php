<?php
    class EmployeesClass{
        function __construct(){

        }

        function init(){
            cardStart("Employees","#FFF",true,"2");
            if(isset($_GET['employee'])){
                $this->showEmployeeDetails($_GET['employee']);
            }else{
                $this->displayEmployees();
            }
            cardEnd();
        }

        function displayEmployees(){
            $sql = "SELECT * FROM employees";
            $table = "employees";
            $name = "employees_table";
            $dontShow = "id,userID,profile_pic";
            $actions = $this->getTableActions($table,true);
            createTable($sql, $table, $name, $dontShow, $actions, $view=true);
        }

        function getAddEditEntry($id,$table,$dontShow=""){
            $dontShow = "id,userID";
            $headings = getTableColumns($table, $dontShow);
            $sql = "SELECT * FROM $table WHERE id='$id'";
            $results = exeSQL($sql);

            echo "<form id='editEntryForm'>";
            echo "<table class='table table-striped'>";
                
            foreach($headings as $heading){
                $column = $heading['Column'];
                $type = $heading['Type'];
                
                echo "<tr>";
                echo "<td>".ucwords(str_replace("_"," ",$column))."</td>";

                
                $value = $results[0][$column];
                
                echo "<td>";

                if($type == "bit(1)"){
                    if($value == 1){
                        $yesSelect = "selected";
                    }else if($value == 0){
                        $noSelect = "selected";
                    }
                    echo "<select name='$column' id='$column' class='textBox corners'>
                            <option value=''></option>
                            <option value='1' $yesSelect >Yes</option>
                            <option value='0' $noSelect >No</option>
                        </select>";
                }else{
                    echo "<input type='text' name='$column' id='$column' class='textBox corners' value='$value'>";
                }

                echo"</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</form>";
        }

        function getTableActions($table,$view,$id=""){
            $link = "?employee=$id";
            $s = "<td>";
    
            if($view){
                $s .= "<a href='$link' class='button-link blu drop'>View</a>&nbsp";
            }
               
            $s .= "<button id='edit' name='edit' class='button def drop' onclick='openModal($id,\"$table\",\"Edit\")'>Edit</button>
                   <button id='remove' name='remove' class='button no-outline' onclick='removeEntry($id,\"$table\",\"Remove\")'>Remove</button>
                   </td>";

            return $s;
        }

        function showEmployeeDetails($id){
            $empData = $this->getEmployeeDetails($id);

            $profilePic = $empData[0]['profile_pic'];

            if(!empty($profilePic)){
                $empImg = URLROOT."/admin/".$profilePic;

                if(fileExists($profilePic)){
                    $empImg = URLROOT."/admin/".$profilePic;
                }else{
                    $empImg = URLROOT."/admin/SYSTEMREC/Default_images/profile_defualt.jpg";
                }
            }else{
                $empImg = URLROOT."/admin/SYSTEMREC/Default_images/profile_defualt.jpg";
            }

            echo "<h2>{$empData[0]['first_name']} {$empData[0]['last_name']}</h2>";

            echo "<div class='row'>";

            echo "<div class='col-3'>
                    <form method='post' enctype='multipart/form-data'>
                    <div class='circle'>
                        <img class='profile-pic' src='$empImg' >
                    </div>
                    <input type='hidden' name='db' id='db' value='employees'>
                    <input type='hidden' name='id' id='id' value='{$empData[0]['id']}'>
                    <input type='hidden' name='dir' id='dir' value='Employee_Profile_Images'>
                    <input type='file' name='profilePic' id='profilePic' value=''><br>
                    <input type='submit' name='uploadPic' id='uploadPic' class='button blu-outline' value='Upload' style='margin-top:5px;'>
                    </form>";
            echo "</div>";

            echo "<div class='col-9'>";
            echo "</div>";

            echo "</div>";
        }

        function getEmployeeDetails($id){
            $sql = "SELECT * FROM employees WHERE id = '$id'";

            $result = exeSQL($sql);
                
            return $result;
        }

        function saveEmployeeImage($id){
            $employee = getColumnValues("employees","id","id='$id'");
            $image = "SYSTEMREC/Employee_Profile_Images/".$_FILES['profilePic']['name'];
            if($employee == ""){
                $sql = "INSERT INTO employees(profile_pic) VALUES('$image')";
            }else{
                $sql = "UPDATE employees SET profile_pic = '$image' WHERE id='$id'";
            }
            exeSQL($sql);
        }
    }
?>