<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RRHH</title>
</head>

<body>
    <div style="background-color: lightblue; padding: 5px; padding-inline: 30px">
        <h1>Sistema de recursos humanos</h1>

        <!-- Variables de sesion para depurar -->
        <div style="background-color: lightcoral;">
            <?php 
            echo "Variables de sesion guardadas para depurar: ";
            if (isset($_SESSION)) {
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
            } 
            ?>
        </div>

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
            <a href="index.php?page=inicio">Inicio</a> /
            <a href="index.php?page=login">Iniciar sesión</a> /
            <a href="index.php?page=logout">Cerrar sesión</a> /
        </div>
    </div>