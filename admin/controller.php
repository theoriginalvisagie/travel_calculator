<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("includes.php");
?>

    <div class="box mainContent" id='mainContentInner'> 
        <script>
            var rootDirectory = "<?php echo str_replace('\\', '/',URLROOT);?>";
        </script>

        <?php
            $module = "";
            $url = $_SERVER['REQUEST_URI'];
            $url = explode("/",$url);
            if(isset($url[4])){
                $module = $url[4];
            }

            if(isset($url[3]) && $url[3]=="home"){
                $sql = "SELECT object FROM modules WHERE name='Home'";
                $result = exeSQL($sql);

                $module = $result[0]['object'];

                ob_start();
                include("Modules/".$module."/index.php");
                $content = ob_get_contents();
                ob_end_clean();

                echo $content;
            }else{
                if(file_exists("Modules/".$module."/".$module.".php")){
                    ob_start();
                    include("Modules/".$module."/index.php");
                    $content = ob_get_contents();
                    ob_end_clean();
                    echo $content;
                }else{
                    // header("Location: admin/home");
                    echo "Nope";
                    
                }
            }

            

            if(isset($_POST['logOutUser']) && $_POST['logOutUser']=="Logout"){
                session_destroy();
                echo "<script type='text/javascript'> 
                         window.location.href = '".URLROOT."/login.php';
                      </script>";
            }

            // echo '<pre>HERE'.print_r($_SESSION,true).'</pre>';
            // echo '<pre>HERE'.print_r($_POST,true).'</pre>';

        ?>
    </div>
<!-- Opening div in headr.php -->
</div>
    
</body>
</html>