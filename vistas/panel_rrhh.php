<?php include "includes/header.php"; ?>

<h4>Acciones de RRHH</h4>
<hr>
<a href="index.php?page=registro_empleados">Registro empleados</a>
<hr>
<br>

<?php
    if (isset($_SESSION['mensaje'])){

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

<?php include 'includes/footer.php'; ?>

<script src="js/tabla-rrhh.js"></script>