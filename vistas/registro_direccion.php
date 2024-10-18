<?php include "includes/header.php"; ?>

<h1>Registro de nuevo empleado</h1>
<hr>
<h4>Ingrese todos los datos de direccion del nuevo empleado</h4>

<form action="index.php?page=registro_cargos" method="post">
    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" required><br><br>

    <label for="municipio">Municipio:</label>
    <input type="text" id="municipio" name="municipio" required><br><br>

    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" required><br><br>

    <label for="calle">Calle:</label>
    <input type="text" id="calle" name="calle" required><br><br>

    <label for="zip">Codigo postal:</label>
    <input type="text" id="zip" name="zip" required><br><br>

    <label for="vivienda">Referencia de la vivienda:</label>
    <input type="text" id="vivienda" name="vivienda" required><br><br>

    <input type="submit" name="siguiente" value="Siguiente"><br><br>
    <button type="button" onclick="window.location.href='index.php?page=inicio';">Cancelar</button>
</form>


<?php include 'includes/footer.php'; ?>