<?php
    include_once("../config.php");
    require_once(LIB_DIR."/MySQL/MySQL.php");

    function createTable($sql, $table, $name, $dontShow, $actions,$showAdd = true,$view=true){
        $total_records_per_page = 10;
        if(isset($_SESSION[$table]['page_no']) && $_SESSION[$table]['page_no']!=""){
            $page_no = $_SESSION[$table]['page_no'];
        }else{
            $page_no = 1;
        }
        $offset = ($page_no-1) * $total_records_per_page;

        $headings = getTableColumns($table, $dontShow);

        echo "<div id='$table' class='m-3'>";

        echo "<div class='card'>
                <div class='card-header'>
                    ".ucwords(str_replace("_"," ",$table))."
                </div>";

        echo "<div class='card-body'>";

        if($showAdd){
            echo "<button id='addEntry' name='addEntry' class='button go drop floatRight' onclick='openModal(\"\",\"$table\",\"Add\")' >Add Entry</button>&nbsp";
        }

        echo "<table class='table table-striped table-hover'>
                <thead>";
            foreach($headings as $column=>$data){
                $heading = ucwords(str_replace("_"," ",$data['Column']));
                echo "<th>
                        $heading
                      </th>";
            }
            if($actions != "None"){
                echo "<th>Actions</th>";
            }
            
        echo "</thead>";

        $sql .= " LIMIT $offset, $total_records_per_page ";
        $results = exeSQL($sql);

        echo "<tbody>";
        foreach($results as $result){
            echo "<tr>";
            foreach($headings as $column=>$data){

                $value = $result[$data['Column']];
                $type = $data['Type'];

                if($type=="bit(1)"){
                    if($value == "1"){
                        $value = "Yes";
                    }else if($value == "0"){
                        $value = "No";
                    }
                }

                echo"<td>$value</td>";
            }

            if($actions == ""){
                echo getTableActions($result['id'],$table,$view);
            }else if($actions == "None"){

            }else{
                echo getObjectActions($table,$view,$result['id']);
            }
            echo "</tr>";
            echo "</tbody>";
        }

        echo "</table>";
        getTablePagnation($table,$total_records_per_page,$offset,$page_no);
        echo "</div></div>";//Card Divs
        echo "</div>";
        createModal($table);
    }

    function createModal($table){
        echo "<div class='modal hide fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
                    <div class='modal-content' style='width:700px;'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='modalHeader'>Modal title</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' onclick='closeModal(\"$table\")'></button>
                        </div>
                        <div class='modal-body' id='modalBody'>
                            Content Goes Here!!!
                        </div>
                        <div class='modal-footer' id='modalFooter'>
                            <span id='actionButton'></span>
                            <button class='button def' id='closeModal' onclick='closeModal(\"$table\")'>Close</button> 
                        </div>
                    </div>
                </div>
            </div>";
    }

    function getObjectActions($table,$view,$id){
        
        $url = str_replace(URLROOT,"",$_SERVER['REQUEST_URI']);
        if(strpos($url,"/admin/Modules") !== false){
            $url = explode("/",$url);
            if(isset($url[3])){
                $module = $url[4];
            }

            if(method_exists($module,"getTableActions")){
                $object = new $module;
                echo $object->getTableActions($table,$view,$id);
            }
        }
    }

    function getTableActions($id,$table,$view=true){
        echo "<td>";

        if($view){
            echo"<button id='view' name='view' class='button blu drop' onclick='openModal($id,\"$table\",\"View\")'>View</button>&nbsp";
        }
           
        echo"<button id='edit' name='edit' class='button def drop' onclick='openModal($id,\"$table\",\"Edit\")'>Edit</button>
             <button id='remove' name='remove' class='button no-outline' onclick='removeEntry($id,\"$table\",\"Remove\")'>Remove</button>
             </td>";
    }

    function getTablePagnation($table,$total_records_per_page,$offset,$page_no){
        $style="style='background-color:#00D1FF; color:black;'";
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
        $adjacents = "2";
        $total_records = getCount($table,"id");
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        echo "<nav aria-label='Page navigation example'>";
        echo "<ul class='pagination'>";
        if($page_no > 1){
            echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(1,\"$table\")' $style>First Page</a></li>";
        } 
            
        echo "<li class='page-item ";
        if($page_no <= 1){
             echo "disabled "; 
        } 
        echo"' >";

        echo "<a class='page-link' ";
        if($page_no > 1){
            echo "href='javascript:getnextTablePage(\"$previous_page\",\"$table\")' ";
        } 
        echo " $style>Previous</a>
        </li>";
            
        echo "<li class='page-item "; 
        if($page_no >= $total_no_of_pages){
            echo "disabled";
        }  
        echo"' >";

        if ($total_no_of_pages <= 10){  	 
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                if ($counter == $page_no) {
                    echo "<li class='page-item active'><a class='page-link' style='background-color:#00aed5; border:0.2px solid #FFF;'>$counter</a></li>";	
                }else{
                    echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$counter\",\"$table\")' $style>$counter</a></li>";
                }
            }
        }elseif ($total_no_of_pages > 10){
            if($page_no <= 4) {			
                for ($counter = 1; $counter < 8; $counter++){		 
                    if ($counter == $page_no) {
                        echo "<li class='page-item active'><a class='page-link' style='background-color:#00aed5; border:0.2px solid #FFF; border:none;'>$counter</a></li>";	
                    }else{
                        echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$counter\",\"$table\")' $style>$counter</a></li>";
                    }
               }
               echo "<li class='page-item'><a class='page-link' $style>...</a></li>";
               echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$second_last\",\"$table\")' $style>$second_last</a></li>";
               echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$total_no_of_pages\",\"$table\")' $style>$total_no_of_pages</a></li>";
            }elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"1\",\"$table\")' $style>1</a></li>";
                echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"2\",\"$table\")' $style>2</a></li>";
                echo "<li class='page-item'><a class='page-link' $style>...</a></li>";
                for ($counter = $page_no - $adjacents;$counter <= $page_no + $adjacents;$counter++){		
                    if ($counter == $page_no) {
                        echo "<li class='page-item active'><a class='page-link' style='background-color:#00aed5; border:0.2px solid #FFF;' color:black;'>$counter</a></li>";	
                    }else{
                        echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$counter\",\"$table\")' $style>$counter</a></li>";
                    }                  
                }
                echo "<li class='page-item'><a class='page-link' $style>...</a></li>";
                echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$second_last\",\"$table\")' $style>$second_last</a></li>";
                echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$total_no_of_pages\",\"$table\")' $style>$total_no_of_pages</a></li>";
            }
        }

        echo "<li class='page-item' ><a class='page-link'"; 
        if($page_no < $total_no_of_pages) {
            echo "href='javascript:getnextTablePage(\"$next_page\",\"$table\")'";
        } 
        echo " $style>Next</a>
        </li>";

        if($page_no < $total_no_of_pages){
            echo "<li class='page-item'><a class='page-link' href='javascript:getnextTablePage(\"$total_no_of_pages\",\"$table\")' $style>Last &rsaquo;&rsaquo;</a></li>";
        } 
        echo"</ul></nav>";
    }

    function getModalContent($id,$table,$dontShow=""){
        $headings = getTableColumns($table, $dontShow);
        $sql = "SELECT * FROM $table WHERE id='$id'";
        $results = exeSQL($sql);
        echo "<table class='table table-striped'>";           
        foreach($headings as $heading){
            echo "<tr>";
            foreach($results as $data=>$result){
                echo "<td>".ucwords(str_replace("_"," ",$heading['Column']))."</td>";
                echo "<td>{$result[$heading['Column']]}</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
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
            }else if($type == "date"){
                echo "<input type='date' name='$column' id='$column' class='textBox corners' value='$value'>";
            }else{
                echo "<input type='text' name='$column' id='$column' class='textBox corners' value='$value'>";
            }

            echo"</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</form>";
    }

    function cardStart($name,$headerColor="",$displayHeader = true, $headingSize = "",$height="",$widht="",$overflow=""){
        if($headerColor == ""){
            $headerColor = '#00D1FF';
        }

        if($height == ""){
            $height = '96%';
        }

        if($headingSize == ""){
            $headingStart = "";
            $headingEnd = "";
        }else{
            $headingStart = "<h$headingSize>";
            $headingEnd = "</h$headingSize>";
        }

        echo "<div class='card m-3' style='height:$height;width:$widht; overflow:$overflow;'>";
       
        if($displayHeader){   
            echo"<div class='card-header' style='background-color:$headerColor'>
                    $headingStart".ucwords(str_replace("_"," ",$name))."$headingEnd
                 </div>";
        }

        echo "<div class='card-body'>";
    }

    function cardEnd(){
        echo "</div></div>";
    }

    function dropDown($table,$column,$name,$result,$js=''){
        if(strpos($column,",",0) > 0){
            $columns = explode(",",$column);
        }

        $dd = exeSQL("SELECT * FROM $table");
        $selected = "";
        echo "<select name='$name' id='$name' $js class='textBox inner'>";
        echo "<option></option>";

        foreach($dd as $key=>$value){
            if($result == $value['id']){
                $selected = "selected";
            }

            if(!empty($columns)){
                echo "<option value='{$value['id']}' $selected>";
                foreach($columns as $key){
                    echo $value[$key]." ";
                }
                echo "</option>";
                
            }else{
                echo "<option value='{$value['id']}' $selected>{$value[$column]}</option>";
            }
           
            $selected = "";
        }

        echo "</select>";
    }

    function checkBox($table,$column,$name,$value){
        $values = array_filter(explode(",",$value));
        $checked = "";
        $checkbox = exeSQL("SELECT * FROM $table");
        foreach($checkbox as $key=>$value){
            if(in_array($value['id'],$values)){
                $checked = "checked";
            }
            echo "<input type='checkbox' class='checkBoxClass_$table' value='{$value['id']}' $checked onchange='addRemoveValueCheckBox(this.value,\"$table\")'>
                    <label for='vehicle1'>$value[$column]</label><br>";

            $checked = "";
        }

        echo "<input type='hidden' name='$name' id='checkBoxList_$table' value='' >";
    }
?>