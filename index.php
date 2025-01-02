<?php
/* Incluir aqui la conexión a la base de datos y el session start, esto lo aplica para todas las paginas */
include 'backend/db.php';
session_start();

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    switch ($page) {
        case 'inicio':
            include 'vistas/inicio.php';
            break;

        case 'probar-bd':
            include 'vistas/probar-bd.php';
            break;

        ///////////////////////////////////// Login y logout /////////////////////////////////////
        case 'login':
            include 'vistas/login.php';
            break;

        case 'logear':
            include 'backend/logear.php';
            break;

        case 'logout':
            session_destroy();
            header("location: index.php?page=login");
            exit();
            break;
        ///////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////// Rutas de RRHH (Solo se puede acceder si se inicio sesion) ////////////////////////////////////////
        case 'registro_empleados':
            // Verificar que la sesion este iniciada para acceder a esta vista
            if (isset($_SESSION['logeado_id'])) {
                include 'vistas/registro_empleados.php';
            } else {
                // Redirigir a la vista de login si la sesion no ha sido iniciada
                header("location: index.php?page=login");
                exit();
            }
            break;

        case 'registrar':
            if (isset($_SESSION['logeado_id'])) {
                include 'backend/registrar.php';
            } else {
                header("location: index.php?page=login");
                exit();
            };
            break;

        case 'panel_rrhh':
            if (isset($_SESSION['logeado_id'])) {
                unset($_SESSION['datos_form']);
                include 'vistas/panel_rrhh.php';
            } else {
                header("location: index.php?page=login");
                exit();
            }
            break;

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////// TEST DE RECONOCIMIENTO FACIAL //////////////////////////////
        case 'test':
            include 'vistas/test.php';
            break;

        default:
            echo "<h1>Error 404</h1>";
            break;
    }
} else {
    header("location: index.php?page=inicio");
    exit();
}
