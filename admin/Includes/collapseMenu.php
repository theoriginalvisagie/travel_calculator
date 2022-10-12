<?php
    function makeSubMenu($name){
        if($name == "BiClass"){
            echo "<div class='collapse multi-collapse' id='multiCollapse_$name'>
                    <div>
                        <ul>
                            <li>
                                <a href='' class=''>Settings</a>
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
?>

