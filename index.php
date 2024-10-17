<?php
    /* Incluir aqui la conexión a la base de datos */

    if (isset($_GET["page"])) {
        $page = $_GET["page"];

        switch ($page) {
            case 'inicio':
                include 'vistas/inicio.php';
                break;

            default:
                echo "<h1>Error 404</h1>";
                break;
        }
        
    }else{
        include 'vistas/inicio.php';
    }
?>