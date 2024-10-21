<?php include "includes/header.php"; ?>

<h2>Panel de RRHH</h2>

<h3>Acciones de RRHH</h3>
<a href="index.php?page=registro_empleados">Registro empleados</a>


<?php
    if (isset($_SESSION['mensaje'])){

        echo "<div style='color: green; font-size: 1.1rem; padding: 10px;'>";
        echo $_SESSION['mensaje'];
        echo "</div>";

        unset($_SESSION['mensaje']);
    }
?>

<?php include 'includes/footer.php'; ?>