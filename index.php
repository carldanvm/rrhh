<?php

    if (isset($_GET["page"])) {
        $page = $_GET["page"];

        switch ($page) {
            case 'ejemplo':
                include 'ejemplo.php';
                break;
            
            default:
                echo "<h1>Error 404</h1>";
                break;
        }
    }else{
        echo "<h1>Error 404</h1>";
    }
?>