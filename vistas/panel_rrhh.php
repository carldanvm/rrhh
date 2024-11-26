<?php include "includes/header.php"; ?>

<style>
    /* Ocultar el encabezado solo en esta vista */
    .encabezado h1{
        display: none;
    }
    .encabezado{
        background-color: white;
        box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2);
        position: relative;
    }
    .contenedor{
        box-shadow: none;
    }
</style>

<div class="row" style="margin: 0; min-height: 100%; min-width: 100%;">
    <!-- Barra lateral de opciones -->
    <div class="col-2 barra-lateral">
        <div class="barra-lateral-logo">Logo</div>
        <div class="barra-lateral-boton">
            <a href="index.php?page=registro_empleados" >Registro empleados</a>
        </div>
    </div>



    <!-- Contenido principal -->
    <div class="col-10 contenido-rrhh" >

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