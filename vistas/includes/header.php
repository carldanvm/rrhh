<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <title>RRHH</title>

    <style>
        hr {
            margin: 5px 0;
            padding: 0;
            border: none;
            border-top: 1px solid #000;
        }
    </style>

</head>

<body>
    <div class="encabezado">
        <div style="margin-left: 20px;">
            <h1>Sistema de recursos humanos</h1>
        </div>

        <div class="menu-navegacion">
            
            <?php
            if (isset($_SESSION['logeado_id'])) {
                echo '<a href="index.php?page=inicio" class="boton-nav">Inicio</a>';
            }
            /* Si esta logeado mostrar el link del panel de RRHH */
            if (isset($_SESSION['logeado_id'])) {
                echo '<a href="index.php?page=panel_rrhh" class="boton-nav">Panel RRHH</a>';
            }
            /* Si no esta logeado mostrar el link de iniciar sesion */
            if (!isset($_SESSION['logeado_id'])) {
                echo '<a href="index.php?page=login" class="boton-nav">Iniciar sesión</a>';
            };

            /* Mostrar el link de cerrar sesion solo si la sesion fue iniciada */
            if (isset($_SESSION['logeado_id'])) {
                echo '<a href="index.php?page=logout" class="boton-nav">Cerrar sesión</a>';
            }
            ?>
        </div>
    </div>

    <div class="contenedor">