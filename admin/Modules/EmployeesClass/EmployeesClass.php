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

        function getAddNewEntry($table){
            $dontShow = "id,userID";
            $headings = getTableColumns($table, $dontShow);

            echo "<form id='newEntryForm'>";
            echo "<table class='table table-striped'>";    

            foreach($headings as $heading){
                $column = $heading['Column'];
                $type = $heading['Type'];

                echo "<tr>";
                echo "<td>".ucwords(str_replace("_"," ",$column))."</td>";
                echo "<td>";
                if($heading['Type'] == "bit(1)"){
                    echo "<select name='$column' id='$column' class='textBox corners'>
                            <option value=''></option>
                            <option value='1'>Yes</option>
                            <option value='0'>No</option>
                        </select>";
                }else if($heading['Column'] == "department"){
                    // echo dropDown();
                }else{
                    echo "<input type='text' class='textBox corners' id='$column' name='$column'>";
                }
                
                echo "</td>";
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