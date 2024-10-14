<?php

    if (isset($_GET["page"])) {
        $page = $_GET["page"];

        echo "<h1>$page</h1>";   
    }else{
        echo "<h1>404</h1>";
    }
?>