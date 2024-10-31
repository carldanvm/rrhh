<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RRHH</title>

    <style>
        h1 {
            margin: 10px 0;
        }
        h2 {
            margin: 5px 0;
        }
        hr {
            margin: 0;
            padding: 0; 
            border: none;
            border-top: 2px solid #000;
        }
    </style>
</head>

<body>
    <div style="background-color: lightblue; padding: 5px; padding-inline: 30px">
        <h1>Sistema de recursos humanos</h1>

        <!-- Mensaje para revisar si la sesion fue iniciada correctamente -->
        <div style="font-weight: bold;">
        <?php 
            if (isset($_SESSION['logeado_id'])) {
                echo "Bienvenido: " . $_SESSION['logeado_nombre'];
            }else{
                echo "No ha iniciado sesión";
            }
        ?>
        </div>

        <br>

        <div class="menu-navegacion">
            <a href="index.php?page=inicio">Inicio</a>
            <?php
            if (isset($_SESSION['logeado_id'])) {
                echo '/ <a href="index.php?page=panel_rrhh">Panel RRHH</a>';
            }
            /* Si no esta logeado mostrar el link de iniciar sesion */
            if (!isset($_SESSION['logeado_id'])) {
                echo '/ <a href="index.php?page=login">Iniciar sesión</a>';
            };

            /* Mostrar el link de cerrar sesion solo si la sesion fue iniciada */
            if (isset($_SESSION['logeado_id'])) {
                echo '/ <a href="index.php?page=logout">Cerrar sesión</a>'; 
            }
            ?>
        </div>
    </div>