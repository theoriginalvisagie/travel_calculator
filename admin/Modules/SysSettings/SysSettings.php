<?php
    class SysSettings {
        function __construct(){}

        function init(){
            cardStart("","",false,"","");
            $this->getTabs();
            
            cardEnd();
        }

        function getTabs(){
            $sql = "SELECT * FROM system_settings_tabs WHERE is_active = 'Yes'";
            $results = exeSQL($sql);
            $link = URLROOT."/admin/Modules/SysSettings/View";

            if(!isset($_GET['tab']) && $_GET['tab'] == ""){
                $_GET['tab'] = 1;
            }

            echo "<ul class='nav nav-tabs'>";
            foreach($results as $result){
                $active = "";
                if($result['id'] == $_GET['tab']){
                    $active = "active";
                }
                echo "<li class='nav-item'>
                        <a class='nav-link $active' href='$link?tab={$result['id']}'>{$result['name']}</a>
                      </li>";

                $active = "";
            }
            echo"</ul>";
        }
    }
?>

