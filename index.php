<?php
    /* Incluir aqui la conexión a la base de datos */
    if (isset($_GET["page"])) {
        $page = $_GET["page"];

        switch ($page) {
            case 'inicio':
                include 'vistas/inicio.php';
                break;
            
            case 'probar-bd':
                include 'vistas/probar-bd.php';
                break;
            
            case 'login':
                include 'vistas/login.php';
                break;

            case 'registro_empleados':
                include 'vistas/registro_empleados.php';
                break;
            
            case 'registro_direccion':
                include 'vistas/registro_direccion.php';
                break;

            case 'registro_cargos':
                include 'vistas/registro_cargos.php';
                break;

            default:
                echo "<h1>Error 404</h1>";
                break;
        }
        
    }else{
        include 'vistas/inicio.php';
    }
?>