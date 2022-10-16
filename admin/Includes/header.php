<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom JS and CSS -->
    <link rel ="stylesheet" href = "<?php echo URLROOT;?>/admin/style/style.css">
    <script src = "<?php echo URLROOT;?>/admin/script/js.js"></script>
    <!-- ========== -->

    <!-- Bootsrap v5.2 -->
    <link href = "<?php echo URLROOT;?>/admin/Libraries/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src = "<?php echo URLROOT;?>/admin/Libraries/Bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ========== -->

    <!-- jQuery v3.6.0 -->
    <script src = "<?php echo URLROOT;?>/admin/Libraries/jQuery/jQuery.js"></script>
    <!-- ========== -->

    <!-- ImmosrtalCSS v1.0.0 -->
    <link href = "<?php echo URLROOT;?>/admin/Libraries/ImmortalCSS/css/immortal.css" rel="stylesheet"></script>
    <!-- ========== -->

    <!-- FontAwesome v6.1.1-->
    <link href="<?php echo URLROOT;?>/admin/Libraries/FontAwesome/css/all.css" rel="stylesheet">
    <!-- ========== -->

     <!-- SweetAlert2 v11 -->
     <script src="<?php echo URLROOT;?>/admin/Libraries/SweetAlert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
     <!-- ========== -->

    <title><?php echo SITENAME;?></title>

</head>
<body style='margin:0px; background-color: #5C677D;'>
    <div class="themeContainer" style="margin:0px; padding:0px;">
        <div class="box mainToolbar">
            <div class="row" style="height:100%; width:100%;">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4" style="float:right; display: flex; align-items:center; justify-content: flex-end;">
                    <span class="userInfo">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropDownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user" ></i>
                            <?php echo $_SESSION['username'];?>
                        </a>
                        <ul class="dropdown-menu blu" aria-labelledby="userDropDownMenu">
                            <li><a class="dropdown-item" href="<?php echo URLROOT.'/admin/Modules/Users/View'?>">Account</a></li>
                            <!-- <li><hr class="dropdown-divider"></li> -->
                            <li>
                                <form method="post">
                                    <input type="submit" class="dropdown-item" value="Logout" id="logOutUser" name="logOutUser">
                                </form>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>
        </div>
        <div class="box sideNav"> 
            <div id="logoDiv">
                <?php echo getLogo();?>
            </div>
           
            <?php
                require_once(INC_DIR."/collapseMenu.php");
                require_once(LIB_DIR."/MySQL/MySQL.php");

                $sql = "SELECT * FROM modules WHERE is_active=1";
                $results = exeSQL($sql);
                $url = URLROOT."/admin/Modules/";
                echo "<ul class='nav flex-column'>";
                foreach($results as $result=>$row){
                    echo "<li class='nav-item'>
                             <a class='nav-link menuItem' href='".$url."{$row['object']}/View' style='align-self: flex-end; display:inline;'>
                                <i class='{$row['icon']}' style='width:22px; height:22px;'></i>
                                {$row['name']}
                             </a>
                             <span class='userInfoLight' style='float:right; display:inline; margin-right:15px;'>
                                <a data-bs-toggle='collapse' data-bs-target='#multiCollapse_{$row['object']}' aria-expanded='false' aria-controls='multiCollapse_{$row['id']}'>
                                    <i class='fa-solid fa-arrows-up-down'></i>
                                </a>
                            </span>";
                            makeSubMenu($row['object']);

                         echo"</li>
                         <hr style='color:#FFF;'>";
                }
                echo "</ul>";
            ?>
        </div>