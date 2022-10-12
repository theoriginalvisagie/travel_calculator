<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <script src="js.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body style='margin:0px; background-color: #868ba1;'>
    <div class="themeContainer" style="margin:0px; padding:0px;">
        <div class="box mainToolbar"> Main Toolbar </div>
        <div class="box topToolBar"> Top Toolbar </div>
        <div class="box sideNav"> 
            <?php
                echo "<ul>";
                for($i = 1; $i <= 10; $i++){
                    $page = urlencode("content$i");
                    // echo "<li><button onclick='loadContent($i)'>Item $i js</button></li>";
                    echo "<li><a href='?view=".htmlentities($page)."' >Item $i</a></li>";
                    // echo "<li><input type='submit' name='action' id='action' value='Content $i'></li>";

                }
                echo "</ul>";

                // echo '<pre>'.print_r($_POST,true).'</pre>';
            ?>
        </div>
        <div class="box mainContent" id='mainContentInner'>
             Main Content 
             <?php
             if(isset($_POST['action'])){
                $page = strtolower(str_replace(' ','',$_POST['action']));
                $content = file_get_contents($page.".php");
                echo $content;
             }

             if(isset($_GET['view'])){
                $page = strtolower($_GET['view']);
                $content = file_get_contents($page.".php");
                echo $content;
             }
             ?>
        </div>
    </div>
    
</body>
</html>