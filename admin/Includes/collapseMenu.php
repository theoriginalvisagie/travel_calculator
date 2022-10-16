<?php
    function makeSubMenu($name){
        $icon = "<span><i class='fa-solid fa-chevron-circle-right blu-text'></i></span>";
        $liStyle = "style='background-color:transparent; margin-left:15px; text-decoration:none;'";
        $aStyle = "style='text-decoration:none; color:#FFF !important;'";
    
        if($name == "EmployeesClass"){
            $link = getLink("EmployeesClass");
            echo "<div class='collapse multi-collapse' id='multiCollapse_$name'>
            <div>
                <ul class='fa-ul'>
                    <li $liStyle>
                        $icon
                        <a href='$link?subMenu=departments' class='' $aStyle>Departments</a>
                    </li>
                    <li $liStyle>
                        $icon
                        <a href='$link?subMenu=transport_types' class='' $aStyle>Transport Types</a>
                    </li>
                </ul>
            </div>
          </div>";
        }else{
            echo "<div class='collapse multi-collapse' id='multiCollapse_$name'>
                <div>
                    
                </div>
            </div>";
        }
        
    }

    function getLink($object){
        $link = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"Modules"));
        return $link."Modules/".$object."/View";
    }
?>

