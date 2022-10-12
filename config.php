<?php
     /*=====[DB Parameters]=====*/
     define("DB_HOST", "localhost");
     define("DB_USER", "root");
     define("DB_PASS", "");
     define("DB_NAME", "travel_calculator");
     /*==========*/
 
     // App Root
     define("APPROOT", dirname(__FILE__));
     // URL Root
     define("URLROOT", "http://localhost/Travel_Calculator");
     //Admin Root
     define("ADMIN_DIR", APPROOT."/admin");
     //Modules Root
     define("MOD_DIR", ADMIN_DIR."/Modules");
     //Includes Root
     define("INC_DIR", ADMIN_DIR."/Includes");
     //Libraries Root
     define("LIB_DIR", ADMIN_DIR."/Libraries");

     // Site Name
     define("SITENAME", "Travel Calculator");
 
     // App Version
     define("APPVERSION", "1.0.0");

     function getLogo(){
          // return URLROOT."/admin/AppImages/logo.png";
          echo "<h1 style='margin-top: 0.8rem;'><a id='logoFont' href='".URLROOT."/admin/home'>T Calc</a></h1>";
     }
?>