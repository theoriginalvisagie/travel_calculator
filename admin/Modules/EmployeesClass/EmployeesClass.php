<?php
    class EmployeesClass{
        function __construct(){

        }

        function init(){
            cardStart("Employees","#FFF",true,"2");
            $this->displayEmployees();
            cardEnd();
        }

        function displayEmployees(){
            $sql = "SELECT * FROM employees";
            $table = "employees";
            $name = "employees_table";
            $dontShow = "id,userID";
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
            $s = "<td>";
    
            if($view){
                $s .= "<button id='view' name='view' class='button blu drop' onclick='openModal($id,\"$table\",\"View\")'>View</button>&nbsp";
            }
               
            $s .= "<button id='edit' name='edit' class='button def drop' onclick='openModal($id,\"$table\",\"Edit\")'>Edit</button>
                   <button id='remove' name='remove' class='button no-outline' onclick='removeEntry($id,\"$table\",\"Remove\")'>Remove</button>
                   </td>";

            return $s;
        }
    }
?>