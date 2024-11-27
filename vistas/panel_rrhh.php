<?php include "includes/header.php"; ?>

<style>
    /* Ocultar el encabezado solo en esta vista */
    .encabezado h1 {
        display: none;
    }

    .encabezado {
        background-color: white;
        color: #1282a2;
        box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2);
        position: relative;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-top: 1px solid black;
        border-right: 1px solid black;
    }

    .barra-lateral{
        border-top-left-radius: 10px;
        border-top: 1px solid black;
        border-left: 1px solid black;
    }

    .contenido-rrhh{
        border-right: 1px solid black;
    }

    .footer{
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        box-shadow: 0px 5px 5px #a5a5a5;
    }

    .boton-nav {
        color: #1282a2;
    }

    .boton-nav:hover {
        opacity: 1;
        color: #0a1128;
    }

    .contenedor {
        box-shadow: none;
    }
    body{
        padding: 30px;
        background-color: gainsboro;
    }
</style>

<div class="row" style="margin: 0; width: 100%; height: calc(100vh - 128px);">
    <!-- Barra lateral de opciones -->
    <div class="col-2 barra-lateral">
        <div class="barra-lateral-logo">Logo</div>
        <div class="barra-lateral-boton">
            <a href="index.php?page=registro_empleados">Registro empleados</a>
        </div>
    </div>



    <!-- Contenido principal -->
    <div class="col-10 contenido-rrhh">

        <!-- Mensaje de exito al registrar empleado -->
        <?php
        if (isset($_SESSION['mensaje'])) {

            echo "<div style='color: green; font-size: 1.1rem; padding: 10px;'>";
            echo $_SESSION['mensaje'];
            echo "</div>";

            unset($_SESSION['mensaje']);
        }
        ?>

        <div id="tabla-empleados-container">
            <table id="tabla-empleados">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Tipo de usuario
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Apellido
                        </th>
                        <th>
                            Cedula
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Fecha de ingreso
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los demas registros se agregan dinamicamente con JS -->
                </tbody>
            </table>

        </div>



    </div>
</div>



<?php include 'includes/footer.php'; ?>

<script src="js/tabla-rrhh.js"></script>